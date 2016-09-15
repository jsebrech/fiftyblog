<?php

class AuthPlugin {
  private $users = [];

  function __construct($users) {
    $this->users = $users;
  }

  function login() {
    if (!isset($_SERVER["PHP_AUTH_USER"]) || !isset($this->users[$_SERVER["PHP_AUTH_USER"]]) ||
      $this->users[$_SERVER["PHP_AUTH_USER"]] != $_SERVER["PHP_AUTH_PW"]) {
      header('WWW-Authenticate: Basic realm="fifty"');
      header('HTTP/1.0 401 Unauthorized');
      echo "Unauthorized";
      exit;
    }
    return $_SERVER["PHP_AUTH_USER"];
  }

  function logout() {
    header("Location: /");
  }
}