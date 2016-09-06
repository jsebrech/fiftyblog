<?php

namespace Fifty;

session_start();

class _ {
  public static function render($template, $data) {
    ob_start();
    extract((array) $data);
    include $template;
    return ob_get_clean();
  }

  // based on http://upshots.org/php/php-seriously-simple-router
  public static function route($path, $routes) {
    foreach ($routes as $pattern => $callback) {
      if (preg_match('/^'.str_replace('/','\/',$pattern).'$/', $path, $params) === 1) {
        return call_user_func_array($callback, array_slice($params, 1));
      }
    }
    return isset($routes[404]) ? $routes[404]() : false;
  }

  public static function login($users, $message = null) {
    if (!self::loggedin($users)) {
      if (!isset($_SERVER["PHP_AUTH_USER"]) || !isset($users[$_SERVER["PHP_AUTH_USER"]]) ||
        $users[$_SERVER["PHP_AUTH_USER"]] != $_SERVER["PHP_AUTH_PW"]) {
        header('WWW-Authenticate: Basic realm="fifty"');
        header('HTTP/1.0 401 Unauthorized');
        echo $message ?: "Unauthorized";
        exit;
      }
      $_SESSION["user"] = $_SERVER["PHP_AUTH_USER"];
    };
    return self::loggedin();
  }

  public static function loggedin($users = null) {
    if (isset($_SESSION["user"])) {
      if (isset($users) && !in_array($_SESSION["user"], array_keys($users))) return false;
      return $_SESSION["user"];
    } else return false;
  }

  public static function logout($url = "/") {
    $_SESSION = array();
    session_regenerate_id(true);
    header("Location: $url");
  }
}