<?php

/**
 * @package WebkimaElements
 * @author Nabi Abdi https://webkima.com
 * @class Plugin
 */

namespace WebkimaElements;

use WebkimaElements\Enqueue;

class Plugin {

    const PERFIX = 'webkima-elements';

    const L10N = self::PERFIX;

    /**
     * Registers pre init hooks.
     *
     * @since  1.0.0
     * @return void
     */
    public static function pre_init(): void {

    }

    /**
     * Registers init hooks.
     *
     * @since  1.0.0
     * @return void
     */
    public static function init(): void {
	    Enqueue::init();
	    RegisterElementorWidgets::init();
	    DynamicAssets::printStyles();
    }

    /**
     * Registers and loads text domains.
     *
     * @since  1.0.0
     * @return void
     */
    public static function loadTextDomain(): void {
        load_plugin_textdomain('webkima-elements', false, 'webkima-elements/languages/');
    }
}