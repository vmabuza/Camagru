<?php

class Cookie {

  public static function set($name, $value, $exp) {
    if (setCookie($name, $value, time() + $exp, '/')) {
      return (true);
    }
    return (false);
  }

  public static function delete($name) {
    self::set($name, '', time() - 1);
  }

  public static function get($name) {
    if(self::exists($name))
      return ($_COOKIE[$name]);
    return (null);
  }

  public static function exists($name) {
    return (isset($_COOKIE[$name]));
  }
}
