<?php
include("fifty.php");
include("models/Post.php");
use function Fifty\_;

echo _("views/page.phtml")->render([
  "title" => "A Blog",
  "body" => _("views/index.phtml")->render([
    "title" => "A Blog",
    "posts" => Post::all()
  ])
]);

// TODO: regex router http://upshots.org/php/php-seriously-simple-router
