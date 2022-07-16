<?php
/**
 * @package  WebkimaElements
 */
?>

<div class="wrap">
	<h1 class='we-title'><?php _e('Webkima Elements', 'webkima-elements'); ?></h1>
    
	<?php settings_errors(); ?>

    <ul class="nav nav-tabs">
		<li class="active"><a href="#tab-1"><?php _e(
    'Manage Settings',
    'webkima-elements'
  ); ?></a></li>
		
		<li><a href="#tab-2"><?php _e('About', 'webkima-elements'); ?></a></li>
	</ul>


    <div class="tab-content">
		<div id="tab-1" class="tab-pane active">
		<div class="we-container">
        <form method="post" action="options.php" >
            <?php
            settings_fields('webkima_elements_settings');
            do_settings_sections('webkima_elements');
            submit_button();
            ?>
	    </form>
		</div>
		</div>

		

		<div id="tab-2" class="tab-pane">
			<div class="we-container">
        <h3><?php _e('About', 'webkima-elements'); ?></h3>
   <p><?php _e(
     'This plugin is developed by Webkima Academy team.
we wanna add a lot of cool feaure to this plugin as soon as posible.
Notice: We try our best to keep this plugin as fast as we can.',
     'webkima-elements'
   ); ?></p>
   
      </div>
		</div>
	</div>

</div>
