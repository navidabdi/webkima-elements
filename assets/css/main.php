<?php

include '../../../../../wp-load.php';
header('Content-type: text/css; charset:UTF-8');

use WebkimaElements\DynamicAssets;

foreach (DynamicAssets::printStyles() as $style) {
  echo $style;
}
do_action("webkima_elements_print_styles");
