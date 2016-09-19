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
