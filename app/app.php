<?php
include("fifty.php"); use function Fifty\_;

include("models/Post.php");

echo _("views/page.phtml")->render([
  "title" => "A Blog",
  "body" => _("views/index.phtml")->render([
    "title" => "A Blog",
    "posts" => Post::all()
  ])
]);

// TODO: regex router http://upshots.org/php/php-seriously-simple-router
