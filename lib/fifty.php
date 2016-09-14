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

  public static function cast($that, $as) {
    $result = new $as();
    $that = (array) $that;
    foreach ((new \ReflectionClass($result))->getProperties() as $prop) {
      $name = $prop->getName();
      if (isset($that[$name])) {
        $val = $that[$name];
        if (preg_match('/@var[\\s]+([\\S]+)/', $prop->getDocComment(), $matches)) {
          if (class_exists($matches[1])) {
            $val = self::cast($that[$name], $matches[1]);
          } else {
            settype($val, $matches[1]);
          }
        };
        $prop->setValue($result, $val);
      }
    };
    return $result;
  }

  public static function query(\PDO $pdo, $sql, $bind = array()) {
    $stmt = $pdo->prepare($sql);
    return $stmt->execute($bind) ? $stmt : false;
  }

  public static function map($that, $with) {
    return array_map($with, $that, array_keys($that));
  }
}
