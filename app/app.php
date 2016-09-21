<?php
chdir(__DIR__); include "../vendor/autoload.php";
use Fifty\_;

include "models/Setting.php";
include("models/Post.php");
include "controllers/Page.php";
include "controllers/BasicAuthPlugin.php";

_::$auth = new BasicAuthPlugin(Setting::get("users"));
_::$pdo = new PDO(Setting::get("db"));
_::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

echo _::route($_SERVER["REQUEST_URI"], [
  "/" => "Page::index",
  "/logout" => function() { _::authenticate(false); },
  "/post/(.+)" => "Page::view",
  "/edit/(.+)" => "Page::edit",
  "/delete/(.+)" => "Page::delete",
  ".*" => "Page::notFound"
]);
