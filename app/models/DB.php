<?php

class DB {

  private static $db = null;

  static function get() {
      if (!self::$db) {
        self::$db = new PDO(Setting::get("db"));
        self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      }
      return self::$db;
  }
}