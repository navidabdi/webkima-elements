<?php
/**
 * @package  WebkimaElements
 */
?>

<div class="wrap">
	<h1><?php _e('Webkima Elements', WEBKIMA_ELEMENTS_TEXT_DOMAIN); ?></h1>
    
	<?php settings_errors(); ?>

    <ul class="nav nav-tabs">
		<li class="active"><a href="#tab-1"><?php _e(
    'Manage Settings',
    WEBKIMA_ELEMENTS_TEXT_DOMAIN
  ); ?></a></li>
		<li><a href="#tab-2"><?php _e(
    'Updates',
    WEBKIMA_ELEMENTS_TEXT_DOMAIN
  ); ?></a></li>
		<li><a href="#tab-3"><?php _e(
    'About',
    WEBKIMA_ELEMENTS_TEXT_DOMAIN
  ); ?></a></li>
	</ul>


    <div class="tab-content">
		<div id="tab-1" class="tab-pane active">

        <form method="post" action="options.php">
            <?php
            settings_fields('webkima_elements_settings');
            do_settings_sections('webkima_elements');
            submit_button();
            ?>
	    </form>
			
		</div>

		<div id="tab-2" class="tab-pane">
			<h3>Updates</h3>
		</div>

		<div id="tab-3" class="tab-pane">
			<h3>About</h3>
		</div>
	</div>

</div>
