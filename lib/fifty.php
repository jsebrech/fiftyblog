<?php

namespace Fifty;

function _($for = null) {
  return new Fifty($for);
}

class Fifty {
  private $for = null;

  public function __construct($for) { $this->for = $for; }

  public function __invoke($for) { return _($for); }

  public function render($data) {
    ob_start();
    extract((array) $data);
    $_ = $this;
    include $this->for;
    return ob_get_clean();
  }

  public static function json($str) {
    return json_encode($str, JSON_HEX_TAG | JSON_HEX_AMP);
  }
}