<?php

// Register nav menu
register_nav_menus(array(
	'landing_menu' => 'Landing page menu',
));

add_action('wp_enqueue_scripts', 'theme_enqueue_styles');
function theme_enqueue_styles()
{

	wp_enqueue_style('theme-style', get_stylesheet_uri(), null, STM_THEME_VERSION, 'all');
}

function show_data($val)
{
	ob_start();
	?>
    <pre>
	<?php print_r($val); ?>
	</pre>
	<?php
	return ob_get_clean();
}

include_once 'inc/functions.php';
include_once 'inc/lms_metaboxes.php';
include_once 'inc/lms_settings/lms_wpcfto_ajax.php';