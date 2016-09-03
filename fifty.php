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

  public static function html($str) {
    // https://www.owasp.org/index.php/Abridged_XSS_Prevention_Cheat_Sheet#RULE_.231_-_HTML_Escape_Before_Inserting_Untrusted_Data_into_HTML_Element_Content
    // htmlspecialchars does the right thing, except for replacing /, which is probably ok
    return htmlspecialchars($str);
  }

  public static function attr($str) {
    // https://www.owasp.org/index.php/Abridged_XSS_Prevention_Cheat_Sheet#RULE_.232_-_Attribute_Escape_Before_Inserting_Untrusted_Data_into_HTML_Common_Attributes
    // https://github.com/twigphp/Twig/blob/f0a4fa678465491947554f6687c5fca5e482f8ec/lib/Twig/Extension/Core.php#L1090
    // replace everything below 0xFF that is not known safe by an entity
    return preg_replace_callback('#[^a-zA-Z0-9,\.\-_]#Su', function($matches) {
      return mb_encode_numericentity($matches[0], array(0, 0xff, 0, 0xff), "UTF-8");
    }, $str);
  }

  public static function json($str) {
    return json_encode($str, JSON_HEX_TAG | JSON_HEX_AMP);
  }
}