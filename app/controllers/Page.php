<?php
use Fifty\_;

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

    static function notFound() {
        header("HTTP/1.0 404 Not Found");
        return _::render("views/page.phtml", [
            "title" => Setting::get("title")." - 404",
            "body" => 'It seems you backed into a corner. Better <a href="/">go back</a>.'
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