<?php
/**
 * Settings for Card_Simulation Gateway.
 *
**/

defined( 'ABSPATH' ) || exit;


return array(
	'enabled' => array(
		'title' => __('Enable:', 'card_simulation'),
		'type' => 'checkbox',
		'label' => ' ',
		'default' => 'no',
		'desc_tip' => true
	),
	'title' => array(
		'title' => __('Title:', 'card_simulation'),
		'type' => 'text',
		'description' => __('Title of Card_Simulation Payment Gateway that users see on Checkout page.', 'card_simulation'),
		'default' => __('Credit & Debit Cards', 'card_simulation'),
		'desc_tip' => true
	),
	'description' => array(
		'title' => __('Description:', 'card_simulation'),
		'type' => 'textarea',
		'description' => __('Description of Card_Simulation Payment Gateway that users sees on Checkout page.', 'card_simulation'),
		'default' => __('Pay securely by Credit or Debit card.', 'card_simulation'),
		'desc_tip' => true
	),
	'advanced_settings'           => array(
		'title'       => __( 'Advanced options', 'card_simulation' ),
		'type'        => 'title'
	),
	'debug' => array(
		'title' => __('Debug log', 'card_simulation'),
		'type' => 'checkbox',
		'label' => 'Enable logging',
		'description' => sprintf( __('Log Card_Simulation events, such as Webhook requests, inside %1$s. Note: this may log personal information. We recommend using this for debugging purposes only and deleting the logs when finished. <a href="%2$s">View logs here</a>', 'card_simulation'), '<code>' . WC_Log_Handler_File::get_log_file_path( 'card_simulation' ) . '</code>', admin_url('admin.php?page=wc-status&tab=logs') ),
		'default' => 'no',
	)
);
