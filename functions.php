<?php

// Register nav menu
register_nav_menus(
    array(
        'landing_menu' 	 => 'Landing page menu',
        'landing_footer' => 'Landing page footer menu',
    )
);

add_action('wp_enqueue_scripts', 'theme_enqueue_styles');
function theme_enqueue_styles()
{

	wp_enqueue_style('theme-style', get_stylesheet_uri(), null, STM_THEME_VERSION, 'all');
	wp_enqueue_style('custom-style', get_stylesheet_directory_uri() . '/assets/css/custom.css');
}



function show_data($val)
{
	?>
    <pre>
	<?php print_r($val); ?>
	</pre>
	<?php
}

include_once 'inc/functions.php';
include_once 'inc/lms_metaboxes.php';
include_once 'inc/lms_settings/lms_wpcfto_ajax.php';
include_once 'inc/lms_metaboxes_upload_video.php';
include_once 'inc/lms_settings/manage_course.php';
include_once 'lms/classes/cart.php';
include_once 'lms/classes/payment_methods/payme/payme.php';
include_once 'lms/classes/payment_methods/click_uz/lms-clickuz-gateway.php';
include_once 'lms/classes/user.php';
include_once 'lms/classes/user_hisobot.php';
add_filter( 'body_class','itstars_body_classes' );
function itstars_body_classes( $classes ) {
    $classes[] = 'itstars';
    return $classes;
}


// Disable All Update Notifications
function remove_core_updates(){
   	global $wp_version;return(object) array('last_checked'=> time(),'version_checked'=> $wp_version,);
}
add_filter('pre_site_transient_update_core','remove_core_updates');
add_filter('pre_site_transient_update_plugins','remove_core_updates');
add_filter('pre_site_transient_update_themes','remove_core_updates');