<?php
include("fifty.php");
use function Fifty\_;

echo _([
  "title" => "test",
  "body" => "blah < bloop",
  "attr" => "&\"\0'-a☃"
])->render("views/index.phtml");

// TODO: build blog page using bootstrap and dummy data

// TODO: regex router http://upshots.org/php/php-seriously-simple-router
