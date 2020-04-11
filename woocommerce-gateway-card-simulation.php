<?php
/*
 * Plugin Name: WooCommerce Card Simulation Gateway
 * Description: Simulating Card Payment Gateway.
 * Version: 1.0.0
 * Author: Shazzad Hossain Khan
 * Requires at least: 4.4
 * Tested up to: 4.9
 * WC requires at least: 3.0.0
 * WC tested up to: 3.4
 * Text Domain: card_simulation
 * Domain Path: /languages/
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Define base file
if ( ! defined( 'WC_DC_PLUGIN_FILE' ) ) {
	define( 'WC_DC_PLUGIN_FILE', __FILE__ );
}


/**
 * WooCommerce missing fallback notice.
 *
 * @return string
 */
function wc_card_simulation_missing_wc_notice() {
	/* translators: 1. URL link. */
	echo '<div class="error"><p><strong>' . sprintf( esc_html__( 'Card_Simulation requires WooCommerce to be installed and active. You can download %s here.', 'card_simulation' ), '<a href="https://woocommerce.com/" target="_blank">WooCommerce</a>' ) . '</strong></p></div>';
}


/**
 * WooCommerce version fallback notice.
 *
 * @return string
 */
function wc_card_simulation_version_wc_notice() {
	echo '<div class="error"><p><strong>' . esc_html__( 'Card_Simulation requires mimumum WooCommerce 3.0. Please upgrade.', 'card_simulation' ) . '</strong></p></div>';
}


/**
 * Intialize everything after plugins_loaded action
 */
add_action( 'plugins_loaded', 'wc_card_simulation_init', 5 );
function wc_card_simulation_init() {
	if ( ! class_exists( 'WooCommerce' ) ) {
		add_action( 'admin_notices', 'wc_card_simulation_missing_wc_notice' );
		return;
	}

	if ( version_compare( WC_VERSION, '3.0', '<') ) {
		add_action( 'admin_notices', 'wc_card_simulation_version_wc_notice' );
		return;
	}

	// Load the main plug class
	if ( ! class_exists( 'WC_Card_Simulation' ) ) {
		require dirname( __FILE__ ) . '/includes/class-wc-card-simulation.php';
	}

	wc_card_simulation();
}

/* Plugin instance */
function wc_card_simulation() {
	return WC_Card_Simulation::get_instance();
}
