<?php
STM_Custom_LMS_Cart::init();

class STM_Custom_LMS_Cart extends STM_LMS_Cart
{
	public static function init()
	{
		add_filter('stm-lms-payment-methods', 'STM_Custom_LMS_Cart::stm_lms_payment_methods');
		add_filter('wpcfto_field_payments', 'STM_Custom_LMS_Cart::stm_lms_settings_payment_methods');

		remove_action('wp_ajax_stm_lms_add_to_cart', 'STM_LMS_Cart::add_to_cart');
		remove_action('wp_ajax_nopriv_stm_lms_add_to_cart', 'STM_LMS_Cart::add_to_cart');
		add_action('wp_ajax_stm_lms_add_to_cart', 'STM_Custom_LMS_Cart::stm_add_to_cart');
		add_action('wp_ajax_nopriv_stm_lms_add_to_cart', 'STM_Custom_LMS_Cart::stm_add_to_cart');
	}

	public static function stm_lms_payment_methods($payment_methods)
	{
		$payment_methods['payme'] = esc_html__('Payme', 'masterstudy-child');
		$payment_methods['click'] = esc_html__('Click', 'masterstudy-child');
		return $payment_methods;
	}

	public static function stm_lms_settings_payment_methods($template)
	{
		return get_stylesheet_directory() . '/settings/payments/fields/payments.php';
	}

	public static function stm_add_to_cart()
	{

		check_ajax_referer('stm_lms_add_to_cart', 'nonce');

		if (!is_user_logged_in() or empty($_GET['item_id'])) die;

		$item_id = intval($_GET['item_id']);
		$user = STM_LMS_User::get_current_user();
		$user_id = $user['id'];

		$r = self::_add_to_cart($item_id, $user_id);
		$payment_method = (!empty($_REQUEST['payment_method'])) ? sanitize_text_field($_REQUEST['payment_method']) : false;
		if ($payment_method) {
			self::payment_processing($payment_method);
		}

		$r['text'] = __('To\'lovga o\'tish', 'masterstudy-child');
	//	print_r($r);
		wp_send_json($r);
	}

	public static function payment_processing($payment_method)
	{

	}
}