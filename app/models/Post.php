<?php
use Fifty\_;

class Post {

  /** @var string */
  public $title = "";
  /** @var string */
  public $body = "";
  /** @var int */
  public $created = null;

  public function __construct() {
    $this->created = time();
  }

  public function save(&$error = null) {
    if (empty($this->title)) {
      $error = "Title is required";
    } else if (empty($this->body)) {
      $error = "Body is required";
    } else if (!is_int($this->created)) {
      $error = "Created must be a timestamp number";
    } else {
      $error = "Unexpected error";
      return _::query(DB::get(),
        "insert or replace into posts (id, title, body) values(:created, :title, :body)",
        (array) $this);
    };
    return false;
  }

  static function delete($created) {
    return _::query(DB::get(), "delete from posts where id = ?", [$created]);
  }

  static function get($from, $count = 1) {
    return _::map(
      _::query(
        DB::get(),
        "select id as created, title, body from posts where id <= ? order by id desc limit ?",
        [$from, $count]
      )->fetchAll(),
      function($row) {
        return _::cast($row, "Post");
      }
    );
  }
}
