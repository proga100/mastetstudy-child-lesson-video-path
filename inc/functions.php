<?php
if (!function_exists('stm_put_log')) {
	function stm_put_log($file_name, $data, $append = true)
	{
		$file = get_stylesheet_directory() . "/logs/{$file_name}.log";
		$data = date('d.m.Y H:i:s', time()) . " - " . var_export($data, true) . "\n";
		if ($append) file_put_contents($file, $data, FILE_APPEND);
		else file_put_contents($file, $data);
	}
}

function add_init_lms()
{
	wp_dequeue_script('stm-lms-lms');
	wp_enqueue_script('stm-lms-lms-custom', get_stylesheet_directory_uri() . '/assets/js/lms.js', [], stm_lms_custom_styles_v(), false);
	wp_localize_script('stm-lms-lms-custom', 'stm_lms_vars', array(
		'symbol' => STM_LMS_Options::get_option('currency_symbol', '$'),
		'position' => STM_LMS_Options::get_option('currency_position', 'left'),
		'currency_thousands' => STM_LMS_Options::get_option('currency_thousands', ','),
		'wp_rest_nonce' => wp_create_nonce('wp_rest')
	));
}

add_action('wp_enqueue_scripts', 'add_init_lms', 11);
