<?php

class user_accept
{

	public function __construct()
	{
		add_filter('manage_users_columns', [$this, 'new_modify_user_table']);
		add_filter('manage_users_custom_column', [$this, 'new_modify_user_table_row'], 10, 3);
		add_action('admin_enqueue_scripts', [$this, 'suedsicht_theme_add_editor_assets']);
		add_action('wp_ajax_stm_lms_offerta_accept', [$this,'stm_lms_offerta_accept']);

	}

	public function stm_lms_offerta_accept()
	{
		check_ajax_referer('stm_lms_add_to_cart', 'nonce');
		$user_id = ($_REQUEST['userid']) ? sanitize_text_field($_REQUEST['userid']) : null;
		$accept = ($_REQUEST['accept']) ? sanitize_text_field($_REQUEST['accept']) : null;

		update_user_meta($user_id, 'accept', $accept);
		$user_info = get_user_meta($user_id);
		$button = $this->get_button($user_id, $accept);
		$response = [
			'userid' => $user_id,
			'userinfo' => $user_info,
			'button' => $button
		];
		if ($accept == 'yes') {
			$this->send_user_adminstudent_email($user_id);
		}

		wp_send_json($response);
	}

	function get_button($user_id, $accept)
	{


		if ($accept == 'yes') {
			$button = '<span id="user_stm_id_' . $user_id . '"  class="user-accept user-red user-admin-button" data-userid="' . $user_id . '" data-accept="no">Tasdiqdan Ochirish</span>';
		} else {
			$button = '<span id="user_stm_id_' . $user_id . '"  class="user-accept user-green user-admin-button" data-userid="' . $user_id . '" data-accept="yes">Tasdiqlash</span>';
		}
		return $button;
	}

	function send_user_adminstudent_email($user_id)
	{
		$firstname = get_user_meta($user_id, 'first_name', true);
		$lastname = get_user_meta($user_id, 'last_name', true);
		$user_info = get_userdata($user_id);
		$user_email = $user_info->user_email;

		$body = "<h2>Xurmatli $firstname $lastname! <br> sizning Profilingiz tasdiqlandi.
     itstars.uz kirib kurslarni sotib olishingiz mumkin</h2>";

		$headers = 'From: Itstar <admin@itstars.uz>' . "\r\n";
		wp_mail($user_email, 'itstars.uz dan sizga Habar bor', $body, $headers);
	}

	function new_modify_user_table($column)
	{
		$column['accept'] = 'Tasdiqlash';

		return $column;
	}


	function new_modify_user_table_row($val, $column_name, $user_id)
	{
		switch ($column_name) {
			case 'accept' :
				$accept = get_the_author_meta('accept', $user_id);
				$button = $this->get_button($user_id, $accept);
				return "<span class='user-stm-button'>$button</span>";
			default:
		}
		return $val;
	}


	function suedsicht_theme_add_editor_assets()
	{
		wp_enqueue_style('custom-gutenberg-stylesheet', get_stylesheet_directory_uri() . '/assets/css/user-admin.css', array(), wp_get_theme()->get('Version'), 'all');
		wp_enqueue_script('suedsicht-admin-js', get_stylesheet_directory_uri() . '/assets/js/user-admin.js', ['jquery'], time());
	}


}

new user_accept;

?>