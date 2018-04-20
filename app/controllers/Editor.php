<?php

use Fifty\_;

class Editor {

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
            return "";
        } else return self::notFound();
    }
    
    static function forbidden() {
        header("HTTP/1.0 403 Forbidden");
        return _::render("views/page.phtml", [
            "title" => "403",
            "body" => "Wrong door buddy."
        ]);
    }
    
    private static function posteditor($post) {
        return _::render("views/page.phtml", [
            "title" => Setting::get("title"),
            "body" => _::render("views/edit.phtml", $post)
        ]);
    }

}