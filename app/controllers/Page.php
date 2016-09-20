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

  static function view($created) {
    return self::posts(Post::get($created));
  }

  static function edit($created) {
    if (_::authenticate()) {
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
        /** @var Post $post */
        $post = _::cast($_POST, "Post");
        if (!$post->save($error)) {
          return self::posteditor(
            array_merge((array)$post, ["error" => $error]));
        } else {
          header("Location: /post/".$post->created);
          return "";
        }
      } else {
        if ($created == "new") {
          $post = new Post();
        } else {
          $post = Post::get($created);
          if (count($post)) $post = $post[0];
        };
        return isset($post) ? self::posteditor($post) : self::notFound();
      }
    } else return self::forbidden();
  }

  static function delete($created) {
    if (_::authenticate()) {
      Post::delete($created);
      header("Location: /");
    } else return self::notFound();
  }

  static function notFound() {
    header("HTTP/1.0 404 Not Found");
    return _::render("views/page.phtml", [
      "title" => Setting::get("title")." - 404",
      "body" => 'It seems you backed into a corner. Better <a href="/">go back</a>.'
    ]);
  }

  static function forbidden() {
    header("HTTP/1.0 403 Forbidden");
    return _::render("views/page.phtml", [
      "title" => "403",
      "body" => "Wrong door buddy."
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

  private static function posteditor($post) {
    return _::render("views/page.phtml", [
      "title" => Setting::get("title"),
      "body" => _::render("views/edit.phtml", $post)
    ]);
  }

}