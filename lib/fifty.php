<?php

namespace Fifty;

session_start();

class _ {
  public static $auth = null;

  // based on http://upshots.org/php/php-seriously-simple-router
  public static function route($path, $routes) {
    foreach ($routes as $pattern => $callback) {
      if (preg_match('/^'.str_replace('/','\/',$pattern).'$/', strtok($path, "?"), $params) === 1) {
        return call_user_func_array($callback, array_slice($params, 1));
      }
    }
    return false;
  }

  public static function authenticate($a = null) {
    if ($a === false) { // logout
      $_SESSION = [];
      session_regenerate_id(true);
      if (self::$auth) self::$auth->logout();
    } else if (isset($_SESSION["user"])) { // logged in
      return $_SESSION["user"];
    } else if ($a && self::$auth) { // login
      return $_SESSION["user"] = self::$auth->login($a);
    }
    return false;
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

  // TODO: validate method

  public static function query(\PDO $pdo, $sql, $bind = array()) {
    $stmt = $pdo->prepare($sql);
    return $stmt->execute($bind) ? $stmt : false;
  }

  // TODO: keep or toss?
  public static function map($that, $with) {
    return array_map($with, $that, array_keys($that));
  }

  public static function render($template, $data = array()) {
    ob_start();
    extract((array) $data);
    include $template;
    return ob_get_clean();
  }

}
