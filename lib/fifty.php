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

  // based on http://upshots.org/php/php-seriously-simple-router
  public function route($routes) {
    foreach ($routes as $pattern => $callback) {
      if (preg_match('/^'.str_replace('/','\/',$pattern).'$/', $this->for, $params) === 1) {
        array_shift($params);
        echo call_user_func_array($callback, array_values($params));
      }
    }
    // TODO: 404 handler
    return false;
  }
}