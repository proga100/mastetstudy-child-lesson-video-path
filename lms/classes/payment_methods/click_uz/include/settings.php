<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Settings for PayPal Gateway.
 */
return array(
	'enabled' => array(
		'title'   => __( 'Enable/Disable', 'clickuz' ),
		'type'    => 'checkbox',
		'label'   => __( 'Enable pay via CLICK', 'clickuz' ),
		'default' => 'yes',
	),

	'api_details' => array(
		'title'       => __( 'API credentials', 'clickuz' ),
		'type'        => 'title',
		'description' => __( 'Enter your Click.Uz API credentials.', 'clickuz' ),
	),
	'merchant_id' => array(
		'title'       => __( 'Merchant ID', 'clickuz' ),
		'type'        => 'text',
		'default'     => '',
		'desc_tip'    => true,
	),
    'merchant_user_id' => array(
        'title'       => __( 'Merchant User ID', 'clickuz' ),
        'type'        => 'text',
        'default'     => '',
        'desc_tip'    => true,
    ),
	'merchant_service_id' => array(
		'title'       => __( 'Merchant Service ID', 'clickuz' ),
		'type'        => 'text',
		'default'     => '',
		'desc_tip'    => true,
	),
	'secret_key' => array(
		'title'       => __( 'Secret Key', 'clickuz' ),
		'type'        => 'text',
		'default'     => '',
		'desc_tip'    => true,
	),
    'after_payment_status' => array(
        'title'       => __( 'Status of order after payment', 'clickuz' ),
        'type'        => 'select',
        'default'     => 'wc-processing',
        'options'     => wc_get_order_statuses(),
    ),
    'url_details' => array(
        'title'       => __( 'Service parameters', 'clickuz' ),
        'type'        => 'title',
        'description' => __( 'Url addesses for changing to set on Merchant cabinet', 'clickuz' ) . '<br/><br/>' .
                         __( 'Prepare url', 'clickuz' ) .': ' . site_url() . '/?payment_processing=click<br/><br/>' .
                         __( 'Complete url', 'clickuz' ) .': ' . site_url().'/?payment_complete=click',
    ),
);
