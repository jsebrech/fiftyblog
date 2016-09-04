<?php

class Setting {
  static function get($key) {
    include "config.php";
    return $settings[$key];
  }
}
