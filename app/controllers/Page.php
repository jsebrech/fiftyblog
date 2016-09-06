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

  static function notFound() {
    header("HTTP/1.0 404 Not Found");
    return _::render("views/page.phtml", [
      "title" => "404",
      "body" =>
        _::render("views/navbar.phtml") .
        '<div class="container"><p>Oops, seems you backed into a corner there.</p></div>'
    ]);
  }

}