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

	public static function printStyles(): void {
		$cssMinifier = new CssMinifier( static::$styles );
		$minifiedCSS = $cssMinifier->minify();

		$main_css_file = fopen( WEBKIMA_ELEMENTS_PATH . 'assets/css/main.css', "w" )
		or die( "Unable to open main.css file!" );

		fwrite( $main_css_file, $minifiedCSS );
		fclose( $main_css_file );
	}

	public static function generateStyle($css_file_name, $style): void {
		$css_file = fopen( WEBKIMA_ELEMENTS_PATH . 'assets/widgets/css/' . $css_file_name, "w" )
		or die( "Unable to open file!" );

		fwrite( $css_file, $style );
		fclose( $css_file );

		static::$styles[] = WEBKIMA_ELEMENTS_PATH . 'assets/widgets/css/' . $css_file_name;
	}
}
