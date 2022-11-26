<?php
require "../../../../../wp-blog-header.php";
header("Content-type: text/css; charset:UTF-8");

use WebkimaElements\DynamicAssets;

foreach (DynamicAssets::printStyles() as $key => $style) {
  echo $style;
}
do_action("print_styles");
