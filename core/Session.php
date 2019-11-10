<?php

class Session {
  public static function exists($name) {
    return ((isset($_SESSION[$name])) ? true: false);
  }

  public static function get($name) {
    if (isset($_SESSION[$name])) {
      return ($_SESSION[$name]);
    }
    return (null);
  }

  public static function set($name, $value) {
    return ($_SESSION[$name] = $value);
  }

  public static function delete($name) {
    if (self::exists($name)) {
      unset($_SESSION[$name]);
    }
  }

  //clears up the user agent data so it only reflects the user agent
  //and not the version numbers
  public static function uagent_no_version() {
    $uagent = $_SERVER['HTTP_USER_AGENT'];
    $regx = '/\/[a-zA-Z0-9.]+/';
    $newString = preg_replace($regx, '', $uagent);
    RETURN $newString;
  }
}
