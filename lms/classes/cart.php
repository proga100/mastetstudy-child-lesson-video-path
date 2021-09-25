<?php
STM_Custom_LMS_Cart::init();

class STM_Custom_LMS_Cart extends STM_LMS_Cart
{
	public static function init()
	{
		add_filter('stm-lms-payment-methods', 'STM_Custom_LMS_Cart::stm_lms_payment_methods');
		add_filter('wpcfto_field_payments', 'STM_Custom_LMS_Cart::stm_lms_settings_payment_methods');
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
}