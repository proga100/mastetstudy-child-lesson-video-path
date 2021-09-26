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
		$payment_method = (!empty($_REQUEST['payment_code'])) ? sanitize_text_field($_REQUEST['payment_code']) : false;
		if ($payment_method) {
			$r = self::payment_processing($payment_method);
		}
		$r['redirect'] = true;
		//$r['text'] = __('To\'lovga o\'tish', 'masterstudy-child');
		//	print_r($r);
		wp_send_json($r);
	}

	public static function payment_processing()
	{

		$user = STM_LMS_User::get_current_user();
		if (empty($user['id'])) die;
		$user_id = $user['id'];

		$payment_code = (!empty($_GET['payment_code'])) ? sanitize_text_field($_GET['payment_code']) : '';

		$r = array(
			'status' => 'success'
		);

		if (empty($payment_code)) {
			$r = array(
				'status' => 'error',
				'message' => esc_html__('Tolov turini tanlang', 'masterstudy-lms-learning-management-system')
			);
			return $r;
		}

		$cart_items = stm_lms_get_cart_items($user_id, apply_filters('stm_lms_cart_items_fields', array('item_id', 'price')));
		$cart_total = STM_LMS_Cart::get_cart_totals($cart_items);
		$symbol = STM_LMS_Options::get_option('currency_symbol', 'none');

		/*Create ORDER*/
		$invoice = STM_LMS_Order::create_order([
			"user_id" => $user_id,
			"cart_items" => $cart_items,
			"payment_code" => $payment_code,
			"_order_total" => $cart_total['total'],
			"_order_currency" => $symbol
		], true);

		do_action('order_created', $user_id, $cart_items, $payment_code, $invoice);

		/*If Paypal*/
		if ($payment_code == 'paypal') {
			$r = self::paypal_payment($cart_total, $invoice, $user_id, $user);
		} else if ($payment_code == 'stripe') {
			$r = self::stripe_payment($cart_total, $invoice, $user_id);
		} else
			if ($payment_code == 'payme') {
				$r = self::payme_payment($cart_total, $invoice, $user_id, $user);
			} else
				if ($payment_code == 'click') {
					$r = self::click_payment($cart_total, $invoice, $user_id, $user);
				} else {
					$r['message'] = esc_html__('Buyurtma Yaratildi', 'masterstudy-lms-learning-management-system');
					$r['url'] = STM_LMS_User::user_page_url($user_id);
				}
		$r['cart_url'] = $r['url'];
		$r['text'] = $r['message'];
		return $r;
	}

	public static function paypal_payment($cart_total, $invoice, $user_id, $user)
	{
		$paypal = new STM_LMS_PayPal(
			$cart_total['total'],
			$invoice,
			$cart_total['item_name'],
			$invoice,
			$user['email']
		);
		$r['url'] = $paypal->generate_payment_url();
		$r['message'] = esc_html__("Tolovga otish", 'masterstudy-child');
		return $r;
	}

	public static function stripe_payment($cart_total, $invoice, $user_id)
	{
		if (!empty($_GET['token_id'])) {
			$url = 'https://api.stripe.com/v1/charges';
			$payment = STM_LMS_Options::get_option('payment_methods');
			if (empty($payment['stripe'])
				or empty($payment['stripe']['enabled'])
				or empty($payment['stripe']['fields'])
				or empty($payment['stripe']['fields']['secret_key'])
			) die;

			$sk_key = $payment['stripe']['fields']['secret_key'];

			$headers = array(
				'Authorization' => 'Bearer ' . $sk_key,
			);

			$currency = (!empty($payment['stripe']['fields']['currency'])) ? $payment['stripe']['fields']['currency'] : 'usd';

			$increment = apply_filters('masterstudy_payment_increment', 100);

			$args = array(
				'source' => $_GET['token_id'],
				'amount' => floatval($cart_total['total']) * $increment,
				'description' => sprintf(esc_html__('%s. Order key: %s', 'masterstudy-lms-learning-management-system'), $cart_total['item_name'], get_the_title($invoice)),
				'currency' => $currency,
			);

			$req = wp_remote_post($url, array('headers' => $headers, 'body' => $args));
			$req = wp_remote_retrieve_body($req);
			$req = json_decode($req, true);

			/*Check if paid*/
			$r['message'] = esc_html__('Tolovga otish', 'masterstudy-lms-learning-management-system');
			if (!empty($req['paid']) and !empty($req['amount']) and $req['amount'] == $cart_total['total'] * $increment) {
				update_post_meta($invoice, 'status', 'completed');
				STM_LMS_Order::accept_order($user_id, $invoice);
				$r['message'] = esc_html__('Order created. Payment completed.', 'masterstudy-lms-learning-management-system');
			} else {
				wp_delete_post($invoice, true);
				$r['status'] = 'error';
				$r['message'] = esc_html__('Error occurred. Please try again.', 'masterstudy-lms-learning-management-system');
				$r['url'] = false;
			}
			$r['url'] = STM_LMS_User::user_page_url($user_id);
			$r['order'] = $req;
		} else {
			$r = array(
				'status' => 'error',
				'message' => esc_html__('Please, select payment method', 'masterstudy-lms-learning-management-system')
			);
		}
		return $r;
	}

	public static function payme_payment($cart_total, $invoice, $user_id, $user)
	{
		$data = [
			'cart_total' => $cart_total['total'],
			'invoice' => $invoice,
			'cart_total_name' => $cart_total['item_name'],
			'user_email' => $user['email']
		];
		$form = apply_filters('get_payme_form', $data);
		$r['form_html'] = $form;
		$r['message'] = esc_html__("Tolovga otish", 'masterstudy-child');
		return $r;
	}

	public static function click_payment($cart_total, $invoice, $user_id, $user)
	{
		$data = [
			'cart_total' => $cart_total['total'],
			'invoice' => $invoice,
			'cart_total_name' => $cart_total['item_name'],
			'user_email' => $user['email']
		];
		$form = apply_filters('get_click_form', $data);
		$r['form_html'] = $form;
		$r['message'] = esc_html__("Tolovga otish", 'masterstudy-child');
		return $r;
	}
}