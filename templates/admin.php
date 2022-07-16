<?php
/**
 * @package  WebkimaElements
 */
?>

<div class="wrap">
	<h1><?php _e('Webkima Elements', WEBKIMA_ELEMENTS_TEXT_DOMAIN); ?></h1>
    
	<?php settings_errors(); ?>

	<form method="post" action="options.php">
		<?php
  settings_fields('webkima_elements_options_group');
  do_settings_sections('webkima_elements');
  submit_button();
  ?>
	</form>
</div>
