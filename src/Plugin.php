<?php

/**
 * @package WebkimaElements
 * @author Nabi Abdi https://webkima.com
 * @class Plugin
 */

namespace WebkimaElements;


class Plugin {

    const PERFIX = 'webkima-elements';

    const L10N = self::PERFIX;

    /**
     * Registers pre init hooks.
     *
     * @since  1.0.0
     * @return void
     */
    public static function pre_init() {

    }

    /**
     * Registers init hooks.
     *
     * @since  1.0.0
     * @return void
     */
    public static function init() {

    }

    /**
     * Registers and loads text domains.
     *
     * @since  1.0.0
     * @return void
     */
    public static function load_textdomain() {
        load_plugin_textdomain(static::L10N, false, static::L10N . '/languages/');
    }

}