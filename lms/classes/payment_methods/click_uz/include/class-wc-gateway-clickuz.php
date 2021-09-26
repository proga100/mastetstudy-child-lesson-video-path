<?php
/**
 * Click.uz Payment Gateway.
 *
 * Provides a Click.uz Payment Gateway.
 *
 * @class 		WC_Gateway_Clickuz
 * @extends		WC_Payment_Gateway
 * @version		1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WC_Gateway_Clickuz Class.
 */
class WC_Gateway_Clickuz extends WC_Payment_Gateway {

	/** @var bool Whether or not logging is enabled */
	public static $log_enabled = false;

	/** @var WC_Logger Logger instance */
	public static $log = false;

	/**
	 * Constructor for the gateway.
	 */
	public function __construct() {
		$this->id                 = 'clickuz';
		$this->has_fields         = false;
		$this->order_button_text  = __( 'Pay', 'clickuz' );
		$this->method_title       = 'CLICK';
		$this->method_description = __( 'Proceed payment with CLICK', 'clickuz' );
		$this->supports           = array( 'products', );

		// Load the settings.
		$this->init_form_fields();
		$this->init_settings();

		// Define user set variables.
		$this->title          = is_admin() ? 'CLICK' : 'Click <img src="' . CLICK_LOGO . '" alt="Click" style="width: auto; height: 30px;" />';
		$this->description    = __('Pay with CLICK', 'clickuz');
		$this->testmode       = 'yes' === $this->get_option( 'testmode', 'no' );
		$this->debug          = 'yes' === $this->get_option( 'debug', 'no' );

		self::$log_enabled    = true;

		add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( $this, 'process_admin_options' ) );
		add_action( 'woocommerce_receipt_' . $this->id, array($this, 'form') );
	}

	/**
	 * Logging method.
	 *
	 * @param string $message Log message.
	 * @param string $level   Optional. Default 'info'.
	 *     emergency|alert|critical|error|warning|notice|info|debug
	 */
	public static function log( $message, $level = 'info' ) {
		if ( self::$log_enabled ) {
			if ( empty( self::$log ) ) {
				self::$log = wc_get_logger();
			}
			self::$log->log( $level, $message, array( 'source' => 'paypal' ) );
		}
	}


	/**
	 * Initialise Gateway Settings Form Fields.
	 */
	public function init_form_fields() {
		$this->form_fields = include( 'settings.php' );
	}

	/**
	 * Process the payment and return the result.
	 * @param  int $order_id
	 * @return array
	 */

	 
	public function process_payment( $order_id ) {
		$order = new WC_Order($order_id);
        //wc_empty_cart();
		return array(
			'result' => 'success',
			'redirect' => add_query_arg(
				'order',
				$order->get_id(),
				add_query_arg('key', $order->get_order_key(), wc_get_page_permalink('pay') )
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
	 * @param  WC_Order $order
	 * @return bool
	 */
	public function can_refund_order( $order ) {
		return $order && $order->get_transaction_id();
	}

public function form($order_id)
        {
             
            // echo '';
            echo $this->order_details($order_id);
            echo '<p>' . __('Thank you for your order, press "Pay" button to continue.', 'payme') . '</p>';
            echo $this->generate_form($order_id);
            
            
            
        }
        
    
 public function order_details($order_id)
        {
       // Get an instance of the WC_Order object
$order = wc_get_order( $order_id );

// convert an amount to the coins (Payme accepts only coins)
$sum = $order->get_total() ;
// format the amount
$sum = number_format($sum, 0, '.', '');
$item_list = '';

$order_data = $order->get_data(); // The Order data
$order_status = $order_data['status'];
$order_currency = $order_data['currency'];
$order_payment_method_title = $order_data['payment_method_title'];
$order_date = $order_data['date_created']->date('Y/m/d');
$shipping = $order->get_shipping_to_display();

## BILLING INFORMATION:

$order_billing_first_name = $order_data['billing']['first_name'];
$order_billing_last_name = $order_data['billing']['last_name'];
$order_billing_address_1 = $order_data['billing']['address_1'];
$order_billing_state = $order_data['billing']['state'];
$order_billing_email = $order_data['billing']['email'];
$order_billing_phone = $order_data['billing']['phone'];
$order_delivery_time = $order_data['additional']['delivery_time'];

// Iterating through each WC_Order_Item_Product objects
foreach ($order->get_items() as $item_key => $item ):
    ## Using WC_Order_Item methods ##
    // Item ID is directly accessible from the $item_key in the foreach loop or
    $item_id = $item->get_id();

    ## Using WC_Order_Item_Product methods ##
    $product      = $item->get_product(); // Get the WC_Product object
    $product_id   = $item->get_product_id(); // the Product id
    $variation_id = $item->get_variation_id(); // the Variation id
    $item_name    = $item->get_name(); // Name of the product
    $quantity     = $item->get_quantity();  

    $tax_class    = $item->get_tax_class();
    $line_subtotal     = $item->get_subtotal(); // Line subtotal (non discounted)
    $line_subtotal_tax = $item->get_subtotal_tax(); // Line subtotal tax (non discounted)
    $line_total        = $item->get_total(); // Line total (discounted)
    $line_total_tax    = $item->get_total_tax(); // Line total tax (discounted)

    
    // Get data from The WC_product object using methods (examples)
    $product        = $item->get_product(); // Get the WC_Product object
    $product_url = $product->get_permalink();
    $product_price  = $product->get_price();
    $item_list .=  '<tr><td><a href = "' . $product_url .'">' .$item_name .'</a> x '.$quantity .'</td><td>'.$quantity*$product_price .$order_currency.'</td></tr>';
endforeach; 


$table =  <<< TABLE

<div class = "row">
    <div class = "col-md-7">
        <h2 class="woocommerce-order-details__title">Информация о заказе</h2><br>
        <table class="woocommerce-table woocommerce-table--order-details shop_table order_details bpc">
          <tr>
            <td>НОМЕР ЗАКАЗА:</td>
            <td>$order_id</td>
          </tr>
         <tr>
            <td>ДАТА:</td>
            <td>$order_date</td>
          </tr>
          <tr>
            <td>Товар:</td>
            <td><table style="width:100%">$item_list</table></td>
          </tr>
         <tr>
            <td>Доставка:</td>
            <td>$shipping</td>
          </tr>
           <tr>
            <td>Метод оплаты:</td>
            <td><strong>$order_payment_method_title</strong></td>
          </tr>
           <tr>
            <td>ВСЕГО:</td>
            <td><strong>$sum</strong>$order_currency</td>
          </tr>
        </table>
    </div>
    <div class = "col-md-5">
        <div class = "woocommerce-customer-details">
            <h2 class="woocommerce-column__title">Платёжный адрес</h2><br>
            <address>
                $order_billing_first_name $order_billing_last_name <br>
                 $order_billing_state <br>
                 $order_billing_address_1 <br>
                $order_billing_phone <br>
                $order_billing_email
            </address>    
        </div>
    </div>
</div>

TABLE;
            
            return $table;
        }
    
        
        
	public function generate_form( $order_id ) {

		$order              = wc_get_order( $order_id );

        $order_number       = $order->get_order_number();
        $secret             = $this->get_option('secret_key' );
		$merchantID         = $this->get_option('merchant_id');
		$merchantUserID     = $this->get_option('merchant_user_id');
		$merchantServiceID  = $this->get_option('merchant_service_id');
		$transID            = $order_id != $order_number ? $order_number . CLICK_DELIMITER . $order_id : $order_id;
        $transAmount        = number_format($order->get_total(), 0, '.', '');
		$transNote          = '';
		$userPhone          = preg_replace("/[^0-9,.]/", "", $order->get_billing_phone() );
		$userEmail          = $order->get_billing_email();
		$signTime           = date("Y-m-d h:i:s");
		$signString         = md5 ($signTime. $secret. $merchantServiceID. $transID. $transAmount);
		$returnURL          = add_query_arg(array('click-return' => WC()->customer->get_id()),  $order->get_view_order_url());
	    ?>
        <form action="https://my.click.uz/pay/" id=”click_form” method="post" target="_blank">
            <input type="hidden" name="MERCHANT_TRANS_AMOUNT"   value="<?php echo $transAmount; ?>" class=”click_input” id=”click_amount_field” />
            <input type="hidden" name="MERCHANT_ID"             value="<?php echo $merchantID; ?>"/>
            <input type="hidden" name="MERCHANT_USER_ID"        value="<?php echo $merchantUserID; ?>"/>
            <input type="hidden" name="MERCHANT_SERVICE_ID"     value="<?php echo $merchantServiceID; ?>"/>
            <input type="hidden" name="MERCHANT_TRANS_ID"       value="<?php echo $transID; ?>"/>
            <input type="hidden" name="MERCHANT_TRANS_NOTE"     value="<?php echo $transNote; ?>"/>
            <input type="hidden" name="MERCHANT_USER_PHONE"     value="<?php echo $userPhone; ?>"/>
            <input type="hidden" name="MERCHANT_USER_EMAIL"     value="<?php echo $userEmail; ?>"/>
            <input type="hidden" name="SIGN_TIME"               value="<?php echo $signTime; ?>"/>
            <input type="hidden" name="SIGN_STRING"             value="<?php echo $signString; ?>"/>
            <input type="hidden" name="RETURN_URL"              value="<?php echo $returnURL; ?>"/>
            <button class="click_logo"><i></i><?php _e('Оплатить')?></button>
            <a class="button cancel" href = "/checkout/">Вернуться к оформлению заказа</a>
        </form>
        <?php
    }
}
