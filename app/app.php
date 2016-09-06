<?php
chdir(__DIR__); include("../lib/fifty.php"); use Fifty\_;

include "models/Setting.php";
include "controllers/Page.php";
include "controllers/AuthPlugin.php";

_::$auth = new AuthPlugin(Setting::get("users"));

echo _::route($_SERVER["REQUEST_URI"], [
  "/" => "Page::index",
  "/logout" => function() { _::logout(); },
  "/post/(.+)" => "Page::post",
  404 => "Page::notFound"
]);
