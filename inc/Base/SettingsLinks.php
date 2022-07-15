<?php


namespace WebkimaElements\Base;


class SettingsLinks
{
    public function register()
    {
        add_filter('plugin_action_links_' . WEBKIMA_ELEMENTS_NAME, array($this, 'settings_links'));
    }

    public function settings_links($links)
    {
        $setting_links = '<a href="admin.php?page=webkima_elements">'.__( 'Settings', 'webkima-elements' ).'</a>';
        array_push($links, $setting_links);
        return $links;
    }

}