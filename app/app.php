<?php
chdir(__DIR__); include("../lib/fifty.php"); use Fifty\_;

include "models/Setting.php";
include "models/DB.php";
include("models/Post.php");
include "controllers/Page.php";
include "controllers/BasicAuthPlugin.php";

_::$auth = new BasicAuthPlugin(Setting::get("users"));

echo _::route($_SERVER["REQUEST_URI"], [
  "/" => "Page::index",
  "/logout" => function() { _::authenticate(false); },
  "/post/(.+)" => "Page::view",
  "/edit/(.+)" => "Page::edit",
  "/delete/(.+)" => "Page::delete",
  ".*" => "Page::notFound"
]);
