<?php


namespace WebkimaElements\Base;


class Enqueue
{
    public function register()
        {
            add_action('admin_enqueue_scripts', array($this, 'enqueue'));
        }

    public function enqueue()
    {
        wp_enqueue_style('webkima-elements', WEBKIMA_ELEMENTS_URL . 'assets/css/style.css');
        wp_enqueue_script('webkima-elements', WEBKIMA_ELEMENTS_URL . 'assets/js/javascript.js');
    }

}