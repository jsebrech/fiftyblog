<?php

namespace Fifty;

function _($for = null) {
  return new Fifty($for);
}

class Fifty {
  private $for = null;
  public function __construct($for) {
    $this->for = $for;
  }

  public function render($template) {
    ob_start();
    extract((array) $this->for);
    $_ = $this;
    include $template;
    return ob_get_clean();
  }

  public static function json($str) {
    return json_encode($str, JSON_HEX_TAG | JSON_HEX_AMP);
  }
}