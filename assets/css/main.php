<?php
$root_path_arr = explode('wp-content' , __DIR__);
include_once reset($root_path_arr) . DIRECTORY_SEPARATOR . 'wp-load.php';

use WebkimaElements\DynamicAssets;

foreach (DynamicAssets::printStyles() as $style) {
  echo $style;
}
do_action("webkima_elements_print_styles");
header('Content-type: text/css; charset:UTF-8');