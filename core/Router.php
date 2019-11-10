<?php
class Router {
  public static function route($url) {
    //controller
    $controller = (isset($url[0]) && $url[0] != '')? ucwords($url[0]) : DEFAULT_CONTROLLER;
    $controller_name = $controller;
    array_shift($url);

    //action or method
    $action = (isset($url[0]) && $url[0] != '')? $url[0] . 'Action' : 'indexAction';
    $action_name = (isset($url[0]) && $url[0] != '') ? $url[0]: 'index';
    array_shift($url);

    //acl check
    $grantAccess = self::hasAccess($controller_name, $action_name);

    if (!$grantAccess) {
      $controller_name = $controller = ACCESS_RESTRICTED;
      $action = 'indexAction';
    }

    //params to pass into the class method
    $queryParams = $url;

    if (class_exists($controller_name))
      $dispatch = new $controller($controller_name, $action);
    if (method_exists($controller, $action)) {
      call_user_func_array([$dispatch, $action], $queryParams);
    } else {
      die('That method does not exist in the controller\"' . $controller_name . '\"');
    }
  }

  public static function redirect($location) {
    if (!headers_sent()) {
      header('Location: '.PROOT.$location);
      exit();
    } else {
      echo '<script type="text/javascript">';
      echo 'window.location.href="'.PROOT.$location.'";';
      echo '</script>';
      echo '<noscript>';
      echo '<meta http-equiv="refresh" content="0;url='.$location.'"/>';
      echo '</noscript>';exit;
    }
  }

  public static function hasAccess($controller_name, $action_name='') {
    $aclFile = file_get_contents(ROOT . DS . 'app' . DS . 'acl.json');
    $acl = json_decode($aclFile, True);
    $current_user_acls = ["Guest"];
    $grantAccess = false;
    if (Session::exists(CURRENT_USER_SESSION_NAME)) {
      $current_user_acls[] = "LoggedIn";
      foreach(currentUser()->acls() as $a) {
        $current_user_acls[] = $a;
      }
    }
    //check for access
    foreach($current_user_acls as $level) {
      if (array_key_exists($level, $acl) && array_key_exists($controller_name, $acl[$level])) {
        if (in_array($action_name, $acl[$level][$controller_name]) || in_array("*", $acl[$level][$controller_name])) {
          $grantAccess = true;
          break ;
        }
      }
    }
    //check for denied
    foreach($current_user_acls as $level) {
      $denied = $acl[$level]['denied'];
      if (!empty($denied) && array_key_exists($controller_name, $denied) && in_array($action_name, $denied[$controller_name])) {
        $grantAccess = false;
      }
    }
    //
    return ($grantAccess);
  }

  public static function getMenu($menu) {
    $menuArr = [];
    $menuFile = file_get_contents(ROOT . DS . 'app' . DS . $menu . '.json');
    $acl = json_decode($menuFile, True);
    foreach($acl as $key => $value) {
      if (is_array($value)) {
        $sub = [];
        foreach($value as $k => $v) {
          if ($k == 'seperator' && !empty($v)) {
            $sub[$k] = '';
            continue;
          } else if ($finalVal = self::getLink($v)) {
            $sub[$k] = $finalVal;
          }
        }
        if (!empty($sub)) {
          $menuArr[$key] = $sub;
        }
      } else {
        if ($finalVal = self::getLink($value)) {
          $menuArr[$key] = $finalVal;
        }
      }
    }
    return ($menuArr);
  }

  private static function getLink($val) {
    //check if it is an external link.
    if (preg_match('/https?:\/\//', $val) == 1) {
      return ($val);
    } else {
      $uAry = explode(DS, $val);
      $controller_name = ucwords($uAry[0]);
      $action_name = (isset($uAry[1])) ? $uAry[1] : '';
      if (self::hasAccess($controller_name, $action_name)) {
        return (PROOT . $val);
      } else {
        return (false);
      }
    }
  }
}
