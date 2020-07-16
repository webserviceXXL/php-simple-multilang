<?php

class Lang {
  protected $locale;
  protected $strings;

  public function __construct($l = "en-US") {
    $this->locale = $l;
    $tmp = explode("-", $l);
    $lang = $tmp[0];
    $langfile = __DIR__ . "/" . $lang . ".json";
    if(!file_exists($langfile)) {
      $langfile = __DIR__ . "/en.json";
    }
    $_strings = file_get_contents($langfile);
    $this->strings = json_decode($_strings, true);
  }

  public function t($selector) {
    try {
      $s = explode(".", $selector);
      for($i = 0; $i < count($s); $i++) {
        if($i == 0) {
          if(array_key_exists($s[$i], $this->strings)) {
            $el = $this->strings[$s[$i]];
          } else {
            $el = "$selector not found for locale $this->locale";
            break;
          }
        } else {
          if(array_key_exists($s[$i], $el)) {
            $el = $el[$s[$i]];
          } else {
            $el = "$selector not found for locale $this->locale";
            break;
          }
        }
      }
    } catch (\Throwable $th) {
      $el = "$selector not found for locale $this->locale";
    }
    return $el;
  }
}
