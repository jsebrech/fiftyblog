<?php

namespace Fifty;

session_start();

class _ {
  public static $auth = null;

  public static function render($template, $data = array()) {
    ob_start();
    extract((array) $data);
    include $template;
    return ob_get_clean();
  }

  // based on http://upshots.org/php/php-seriously-simple-router
  public static function route($path, $routes) {
    foreach ($routes as $pattern => $callback) {
      if (preg_match('/^'.str_replace('/','\/',$pattern).'$/', strtok($path, "?"), $params) === 1) {
        return call_user_func_array($callback, array_slice($params, 1));
      }
    }
    return false;
  }

  public static function login() {
    if (!self::loggedin() && self::$auth) {
      $_SESSION["user"] = self::$auth->login();
    };
    return self::loggedin();
  }

  public static function loggedin() {
    return isset($_SESSION["user"]) ? $_SESSION["user"] : false;
  }

  public static function logout() {
    $_SESSION = array();
    session_regenerate_id(true);
    if (self::$auth) self::$auth->logout();
  }
}