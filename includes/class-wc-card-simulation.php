<?php
/**
 * WooCommerce Card_Simulation Plugin.
 *
 * @class       WC_Card_Simulation
**/


final class WC_Card_Simulation {

	/**
	 * @var plugin name
	 */
	public $name = 'WooCommerce Gateway Card Simulation';


	/**
	 * @var plugin version
	 */
	public $version = '1.0.0';


	/**
	 * @var Singleton The reference the *Singleton* instance of this class
	 */
	protected static $_instance = null;


	/**
	 * @var plugin settings
	 */
	protected static $settings = null;


	public static $log = false;

	/**
	 * Returns the *Singleton* instance of this class.
	 *
	 * @return Singleton The *Singleton* instance.
	 */
	public static function get_instance()
	{
		if (is_null (self::$_instance )) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}


	/**
	 * Private clone method to prevent cloning of the instance of the
	 * *Singleton* instance.
	 *
	 * @return void
	 */
	private function __clone() {}


	/**
	 * Private unserialize method to prevent unserializing of the *Singleton*
	 * instance.
	 *
	 * @return void
	 */
	private function __wakeup() {}


	/**
	 * Protected constructor to prevent creating a new instance of the
	 * *Singleton* via the `new` operator from outside of this class.
	 */
	private function __construct() {
		$this->define_constants();
		$this->init_settings();
		$this->includes();
		$this->register_hooks();
	}


	/**
	 * Define constants
	 */
    private function define_constants() {
		define( 'WC_DC_DIR'				, plugin_dir_path( WC_DC_PLUGIN_FILE ) );
		define( 'WC_DC_URL'				, plugin_dir_url( WC_DC_PLUGIN_FILE ) );
		define( 'WC_DC_BASENAME'		, plugin_basename( WC_DC_PLUGIN_FILE ) );
		define( 'WC_DC_VERSION'			, $this->version );
		define( 'WC_DC_NAME'			, $this->name );
	}


	private function init_settings() {
		if ( is_null( self::$settings ) ) {
			self::$settings = get_option( 'woocommerce_card_simulation_settings', array() );
		}
	}

	/**
	 * Include plugin dependency files
	 */
    private function includes() {
		require( WC_DC_DIR . '/includes/class-wc-gateway-card-simulation.php' );
	}


	/**
	 * Register hooks
	 */
    private function register_hooks() {
		add_action('woocommerce_payment_gateways', array($this, 'add_gateway'), 0);
		add_filter('plugin_action_links_'. WC_DC_BASENAME, array($this, 'plugin_action_links'));
	}


	/**
	 * Add the gateways to WooCommerce.
	 */
    public function add_gateway( $methods ) {
        $methods[] = 'WC_Gateway_Card_Simulation';
        return $methods;
    }


	/**
	 * Adds plugin action links.
	 */
	public function plugin_action_links( $links ) {
		$links['settings'] = '<a href="'. admin_url( 'admin.php?page=wc-settings&tab=checkout&section=card_simulation' ) .'">' . __('Settings', 'card_simulation') . '</a>';
		return $links;
	}


	/**
	 * Get option from plugin settings
	 */
	public static function get_option( $name, $default = null) {
		if ( ! empty( self::$settings ) ) {
			if ( array_key_exists( $name, self::$settings ) ) {
				return self::$settings[$name];
			}
		}

		return $default;
	}


	/**
	 * Logging method.
	 *
	 * @param string $message Log message.
	 * @param string $level Optional. Default 'info'. Possible values:
	 *                      emergency|alert|critical|error|warning|notice|info|debug.
	 */
	public static function log( $message, $level = 'info' ) {
		if ( 'yes' === self::get_option( 'debug', 'yes' ) ) {
			if ( empty( self::$log ) ) {
				self::$log = wc_get_logger();
			}

			self::$log->log( $level, $message, array( 'source' => 'card_simulation' ) );
		}
	}
}
