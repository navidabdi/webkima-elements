<?php
use WebkimaElements\Base\DynamicAssets;
// use WebkimaElements\Elementor\Webkima_EL_Mobile_Menu;
// require_once WEBKIMA_ELEMENTS_PATH . "inc/Elementor/WebkimaELMobileMenu.php";
// Webkima_EL_Mobile_Menu::add_default_styles();

function dynamic_styles($styles = [])
{
  // DynamicAssets::$styles["mobile_menu"] = "test";
  echo "yedsgsjdfjksdgsjkdgfdvcdhscvbhdsv";
}
function dynamic_styles1($styles = [])
{
  // DynamicAssets::$styles["mobile_menu"] = "test";
  echo "945451615154";
}

// add_action("print_styles", "dynamic_styles", 10);
// add_action("print_styles", "dynamic_styles1", 9);
// dynamic_styles(["another"]);

function test()
{
  echo 5215444;
  DynamicAssets::$styles["mobile_menu"] =
    "#webkimael_mobile_menu_icon{cursor:pointer}#webkimael_mobile_menu_dark_part{position:fixed;inset:0;background-color:rgba(0,0,0,.5);visibility:hidden;pointer-events:none;opacity:0;transition:opacity .2s ease-in-out;z-index:99999}#webkimael_mobile_menu_main.active #webkimael_mobile_menu_dark_part{visibility:visible;pointer-events:auto;opacity:1}#webkimael_mobile_menu_main.active .webkimael_mobile_menu_aside{transform:translateX(0)}.webkimael_mobile_menu_aside{position:fixed;background-color:#fff;box-shadow:0 0 10px 5px rgba(0,0,0,.05);top:0;left:auto;right:0;bottom:0;transition:transform .2s ease-in-out;transform:translateX(100%);z-index:100000}.webkimael_mobile_menu_aside ul{list-style:none;display:flex;flex-direction:column;margin:0;padding:2rem 0}.webkimael_mobile_menu_aside>ul>li a{text-decoration:none;display:block;transition:.2s}.webkimael_mobile_menu_aside>ul>li a:hover{background-color:#6495ed;color:#fff}.webkimael_mobile_menu_aside>ul>li>ul{padding:0;background:#f3f3f3;height:0;pointer-events:none;opacity:0}.webkimael_mobile_menu_aside>ul>li.active>ul{height:100%;pointer-events:auto;opacity:1}.menu-item-has-children{position:relative}.menu-item-has-children>a:before{font-family:'Font Awesome 5 Free';font-weight:900;content:'\f107';position:absolute;transition:transform .3s}.menu-item-has-children.active>a:before{transform:rotate(180deg)}";
}
