<?php
use Fifty\_;

include("models/Post.php");

class Page {
  private static function posts($posts) {
    return _::render("views/page.phtml", [
      "title" => Setting::get("title"),
      "body" => _::render("views/posts.phtml", [
        "title" => Setting::get("title"),
        "posts" => $posts
      ])
    ]);
  }

  static function index() {
    if (isset($_GET["login"])) _::login();
    return self::posts(Post::get(false, 5));
  }

  static function post($created) {
    return self::posts(Post::get($created));
  }

}