<?php
use function Fifty\_;

include("models/Post.php");

class Page {
  private static function posts($posts) {
    return _("views/page.phtml")->render([
      "title" => Setting::get("title"),
      "body" => _("views/posts.phtml")->render([
        "title" => Setting::get("title"),
        "posts" => $posts
      ])
    ]);
  }

  static function index() {
    return self::posts(Post::get(false, 5));
  }

  static function post($created) {
    return self::posts(Post::get($created));
  }
}