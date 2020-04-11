<?php
/**
 * WooCommerce Card_Simulation Payment Gateway.
 *
 * @class       WC_Gateway_Card_Simulation
 * @extends     WC_Payment_Gateway
**/


class WC_Gateway_Card_Simulation extends WC_Payment_Gateway_CC {

	public function __construct() {
		$this->id                 = 'card_simulation';
		$this->has_fields         = false;
		$this->order_button_text  = __('Proceed to Payment', 'card_simulation');
		$this->method_title       = __('Card Simulation', 'card_simulation');
		$this->method_description = __('Card Simulation payment gateway for WooCommerce.', 'card_simulation');
		$this->supports           = array( 'products' );
		$this->icon               = WC_DC_URL . '/images/gateway-logo.png';

		// Get setting values
		$this->title              = $this->get_option( 'title', 'Credit & Debit Cards' );
		$this->description        = $this->get_option( 'description', 'Pay securely by Credit or Debit card.' );

		$this->init_form_fields();

		add_action( 'woocommerce_update_options_payment_gateways_'. $this->id, array( $this, 'process_admin_options' ) );
	}


	/**
	 * Return whether or not this gateway still requires setup to function.
	 *
	 * @return bool
	 */
	public function needs_setup() {
		return false;
	}



	/**
	 * Intialize form fields
	 *
	 */
	public function init_form_fields() {
		$this->form_fields = include WC_DC_DIR . 'includes/settings-card-simulation.php';
	}

	/**
	 * Process payment
	 *
	 * @param  $order_id Order id.
	 * @return bool|array
	 */
	public function process_payment( $order_id ) {
		$order = wc_get_order( $order_id );

		$order->payment_complete();
		wc_reduce_stock_levels( $order_id );

		return array(
			'result' => 'success',
			'redirect' => $this->get_return_url( $order )
		);
	}
}
