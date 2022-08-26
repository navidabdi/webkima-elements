<?php
require "../../../../../wp-blog-header.php";
header("Content-type: text/css; charset:UTF-8");
use WebkimaElements\Base\DynamicAssets;
foreach (DynamicAssets::print_styles() as $style) {
  echo $style;
}
