<?php
chdir(__DIR__); include("../lib/fifty.php"); use function Fifty\_;

include "models/Setting.php";
include "controllers/Page.php";

_($_SERVER["REQUEST_URI"])->route([
  "/" => "Page::index",
  "/post/(.+)" => "Page::post"
]);
