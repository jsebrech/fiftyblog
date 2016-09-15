<?php
use Fifty\_;

include("models/Post.php");

class Page {

  static function index() {
    if (isset($_GET["login"])) _::authenticate(true);
    return self::posts(
      Post::get(isset($_GET["from"]) ? $_GET["from"] : PHP_INT_MAX, 5)
    );
  }

  static function post($created) {
    return self::posts(Post::get($created));
  }

  static function notFound() {
    header("HTTP/1.0 404 Not Found");
    return _::render("views/page.phtml", [
      "title" => "404",
      "body" => "Oops, seems you backed into a corner there."
    ]);
  }

  private static function posts($posts) {
    $older = Post::get(end($posts)->created-1);
    return _::render("views/page.phtml", [
      "title" => Setting::get("title"),
      "body" => array_reduce($posts,
        function($str, $post) {
          return $str._::render("views/post.phtml", ["post" => $post]);
        }
      ).(((count($posts) > 1) && count($older)) ?
          '<br><p><a href="/?from='.$older[0]->created.'">Older</a></p>' : "")
    ]);
  }

}