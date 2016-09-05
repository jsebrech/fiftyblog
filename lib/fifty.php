<?php

namespace Fifty;

session_start();

function _($for = null) {
  return new Fifty($for);
}

class Fifty {
  private $for = null;

  public function __construct($for) { $this->for = $for; }

  public function __invoke($for) { return _($for); }

  public function render($data) {
    ob_start();
    extract((array) $data);
    $_ = $this;
    include $this->for;
    return ob_get_clean();
  }

  // based on http://upshots.org/php/php-seriously-simple-router
  public function route($routes) {
    foreach ($routes as $pattern => $callback) {
      if (preg_match('/^'.str_replace('/','\/',$pattern).'$/', $this->for, $params) === 1) {
        array_shift($params);
        echo call_user_func_array($callback, array_values($params));
      }
    }
    // TODO: 404 handler
    return false;
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