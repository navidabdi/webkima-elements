<?php

namespace WebkimaElements\Pages;

class Admin
{
    public static function add_admin_pages()
    {
        add_menu_page(
            'Webkima Elements',
            'Webkima Elements',
            'manage_options',
            'webkima_elements',
            array('WebkimaElements\Pages\Admin', 'admin_index'),
            'dashicons-store',
            11
        );
    }

    public static function register()
    {
        add_action('admin_menu', array('WebkimaElements\Pages\Admin', 'add_admin_pages'));
    }

    public static function admin_index()
    {
        require_once WEBKIMA_ELEMENTS_PATH . 'templates/admin.php';
    }
}