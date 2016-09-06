<?php
chdir(__DIR__); include("../lib/fifty.php"); use Fifty\_;

include "models/Setting.php";
include "controllers/Page.php";

echo _::route($_SERVER["REQUEST_URI"], [
  "/" => "Page::index",
  "/logout" => function() { _::logout(); },
  "/post/(.+)" => "Page::post"
]);
