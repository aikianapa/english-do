<?php

class modBarcode {
  function __construct($dom) {
      $this->init($dom);
  }
  public function init($dom) {
  		$out = $dom->app->fromFile(__DIR__ ."/barcode_ui.php",true);
      $out->prepend('<base href="/modules/barcode/" />');
      $dom->after($out);
      $dom->remove();
  }
}

?>
