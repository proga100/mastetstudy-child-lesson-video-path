<?php
/**
 * Click.uz Payment Gateway.
 *
 * Provides a Click.uz Payment Gateway.
 *
 * @class        WC_Gateway_Clickuz
 * @extends        WC_Payment_Gateway
 * @version        1.0.0
 */

if (!defined('ABSPATH')) {
	exit;
}

/**
 * WC_Gateway_Clickuz Class.
 */
class LMS_Gateway_Clickuz
{

	/** @var bool Whether or not logging is enabled */
	public static $log_enabled = false;

	/** @var WC_Logger Logger instance */
	public static $log = false;

	/**
	 * Constructor for the gateway.
	 */
	public function __construct()
	{
		$this->id = 'clickuz';
		$this->has_fields = false;
		$this->order_button_text = __('Pay', 'clickuz');
		$this->method_title = 'CLICK';
		$this->method_description = __('Proceed payment with CLICK', 'clickuz');
		$this->supports = array('products',);

		// Load the settings.
		//$this->init_form_fields();
		//$this->init_settings();

		// Define user set variables.
		$this->title = is_admin() ? 'CLICK' : 'Click <img src="' . CLICK_LOGO . '" alt="Click" style="width: auto; height: 30px;" />';
		$this->description = __('Pay with CLICK', 'clickuz');

		$payment_methods = STM_LMS_Options::get_option('payment_methods');

		$this->testmode = ($payment_methods['click']['fields']['testmode'] == 'yes') ? $payment_methods['click']['fields']['testmode'] : 'no';
		$this->debug = ($payment_methods['click']['fields']['debug'] == 'yes') ? $payment_methods['click']['fields']['debug'] : 'no';

		self::$log_enabled = true;
		add_filter('get_click_form', [$this, 'get_click_form']);
	}

	/**
	 * Logging method.
	 *
	 * @param string $message Log message.
	 * @param string $level Optional. Default 'info'.
	 *     emergency|alert|critical|error|warning|notice|info|debug
	 */
	public static function log($message, $level = 'info')
	{
		if (self::$log_enabled) {
			if (empty(self::$log)) {
				self::$log = wc_get_logger();
			}
			self::$log->log($level, $message, array('source' => 'paypal'));
		}
	}


	/**
	 * Initialise Gateway Settings Form Fields.
	 */
	public function init_form_fields()
	{
		$this->form_fields = include('settings.php');
	}

	/**
	 * Process the payment and return the result.
	 * @param int $order_id
	 * @return array
	 */


	public function process_payment($order_id)
	{
		$order = new WC_Order($order_id);
		//wc_empty_cart();
		return array(
			'result' => 'success',
			'redirect' => add_query_arg(
				'order',
				$order->get_id(),
				add_query_arg('key', $order->get_order_key(), wc_get_page_permalink('pay'))
			)
		);
		// return [
		//         'result' => 'success',
		//         'redirect' => add_query_arg(
		//             'order_pay',
		//             $order->get_id(),
		//             add_query_arg('key', $order->get_order_key(), $order->get_checkout_payment_url(true))
		//         )
		//     ];
	}

	/**
	 * @param WC_Order $order
	 * @return bool
	 */
	public function can_refund_order($order)
	{
		return $order && $order->get_transaction_id();
	}

	public function get_click_form($data)
	{
		return $this->generate_form($data);
	}

	public function generate_form($data)
	{
		$order_number = $data['invoice'];
		$payment_methods = STM_LMS_Options::get_option('payment_methods');

		$this->testmode = ($payment_methods['click']['fields']['testmode'] == 'yes') ? $payment_methods['click']['fields']['testmode'] : 'no';
		$this->debug = ($payment_methods['click']['fields']['debug'] == 'yes') ? $payment_methods['click']['fields']['debug'] : 'no';

		$secret =  $payment_methods['click']['fields']['secret_key'] ;
		$merchantID = $payment_methods['click']['fields']['merchant_id'] ;
		$merchantUserID = $payment_methods['click']['fields']['merchant_user_id']  ;
		$merchantServiceID = $payment_methods['click']['fields']['merchant_service_id'] ;
		$transID = $data['invoice'];
		$transAmount = number_format($data['cart_total'], 0, '.', '');
		$transNote = '';
		$userPhone = preg_replace("/[^0-9,.]/", "", $data['phone']);
		$userEmail = $data['user_email'];
		$signTime = date("Y-m-d h:i:s");
		$signString = md5($signTime . $secret . $merchantServiceID . $transID . $transAmount);
		//$returnURL = add_query_arg(array('click-return' => WC()->customer->get_id()), $order->get_view_order_url());
		ob_start();
		?>
        <form id="stm_lms_form_html_processing"  action="https://my.click.uz/pay/" id=”click_form” method="post">
            <input type="hidden" name="MERCHANT_TRANS_AMOUNT" value="<?php echo $transAmount; ?>" class=”click_input”
                   id=”click_amount_field”/>
            <input type="hidden" name="MERCHANT_ID" value="<?php echo $merchantID; ?>"/>
            <input type="hidden" name="MERCHANT_USER_ID" value="<?php echo $merchantUserID; ?>"/>
            <input type="hidden" name="MERCHANT_SERVICE_ID" value="<?php echo $merchantServiceID; ?>"/>
            <input type="hidden" name="MERCHANT_TRANS_ID" value="<?php echo $transID; ?>"/>
            <input type="hidden" name="MERCHANT_TRANS_NOTE" value="<?php echo $transNote; ?>"/>
            <input type="hidden" name="MERCHANT_USER_PHONE" value="<?php echo $userPhone; ?>"/>
            <input type="hidden" name="MERCHANT_USER_EMAIL" value="<?php echo $userEmail; ?>"/>
            <input type="hidden" name="SIGN_TIME" value="<?php echo $signTime; ?>"/>
            <input type="hidden" name="SIGN_STRING" value="<?php echo $signString; ?>"/>
            <input type="hidden" name="RETURN_URL" value="<?php echo $returnURL; ?>"/>
        </form>
		<?php
		return ob_get_clean();
	}
}

new LMS_Gateway_Clickuz;
