<?php

/**
 * @package WebkimaElements
 * @author Nabi Abdi https://webkima.com
 * @class Enqueue
 */

namespace WebkimaElements;
use WebkimaElements\CssMinifier;

class DynamicAssets {

  public static array $styles = [];

  public static function printStyles(): array {
	  $fileNames  = [
			WEBKIMA_ELEMENTS_PATH . 'assets/css/iranyekan-font.css',
		  WEBKIMA_ELEMENTS_PATH . 'assets/css/vazir-font.css',
	  ];

	  $myfile = fopen(WEBKIMA_ELEMENTS_PATH . 'assets/css/main.css', "w") or die("Unable to open file!");
//	  $txt = self::$styles['gotoup'];
	  $cssMinifier = new CssMinifier($fileNames);
	  $txt = $cssMinifier->minify();
	  fwrite($myfile, $txt);
	  fclose($myfile);

    return self::$styles;
  }
}
