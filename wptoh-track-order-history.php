<?php

/**
 *
 * Plugin Name:       Track Order History for WooCommerce
 * Plugin URI:        https://addwebsolution.com/
 * Description:       The plugin lets you visit the orders made by the customers in the past.
 * Version:           1.3
 * Requires at least: 5.0
 * Requires PHP:      7.0
 * Author:            AddWeb Solution Pvt. Ltd.
 * Author URI:        https://addwebsolution.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wc-past-orders
 * Domain Path:       /languages
 *
 * 
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}


if ( ! defined( 'ABSPATH' ) ) exit;

if( ! class_exists( 'WPTOH_Track_Order_History' ) ):

/**
* Main Track Order History for WooCommerce class
*/
class WPTOH_Track_Order_History{
	
	/** Singleton *************************************************************/
	/**
	 * WPTOH_Track_Order_History The one true WPTOH_Track_Order_History.
	 */
	private static $instance;

    /**
     * Main Track Order History for WooCommerce Instance.
     * 
     * Insure that only one instance of WPTOH_Track_Order_History exists in memory at any one time.
     * Also prevents needing to define globals all over the place.
     *
     * @since 1.0.0
     * @static object $instance
     * @uses WPTOH_Track_Order_History::wptoh_setup_constants() Setup the constants needed.
     * @uses WPTOH_Track_Order_History::wptoh_includes() Include the required files.
     * @uses WPTOH_Track_Order_History::wptoh_laod_textdomain() load the language files.
     * @see run_awwptoh()
     * @return object| Track Order History for WooCommerce the one true Track Order History for WooCommerce.
     */
	public static function instance() {
		if( ! isset( self::$instance ) && ! (self::$instance instanceof WPTOH_Track_Order_History ) ) {
			self::$instance = new WPTOH_Track_Order_History;
			self::$instance->wptoh_setup_constants();

			add_action( 'plugins_loaded', array( self::$instance, 'wptoh_load_textdomain' ) );

			self::$instance->wptoh_includes();
			self::$instance->admin  = new WPTOH_Track_Order_History_Admin();
		}
		return self::$instance;	
	}

	/** Magic Methods *********************************************************/

	/**
	 * A dummy constructor to prevent WPTOH_Track_Order_History from being loaded more than once.
	 *
	 * @since 1.0.0
	 * @see WPTOH_Track_Order_History::instance()
	 * @see run_awwptoh()
	 */
	private function __construct() { /* Do nothing here */ }

	/**
	 * A dummy magic method to prevent WPTOH_Track_Order_History from being cloned.
	 *
	 * @since 1.0.0
	 */
	public function __clone() { _doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'wc-past-orders' ), '1.1.4' ); }

	/**
	 * A dummy magic method to prevent WPTOH_Track_Order_History from being unserialized.
	 *
	 * @since 1.0.0
	 */
	public function __wakeup() { _doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'wc-past-orders' ), '1.1.4' ); }


	/**
	 * Setup plugins constants.
	 *
	 * @access private
	 * @since 1.0.0
	 * @return void
	 */
	private function wptoh_setup_constants() {

		// Plugin version.
		if( ! defined( 'WPTOH_VERSION' ) ){
			define( 'WPTOH_VERSION', '1.0.0' );
		}

		// Plugin folder Path.
		if( ! defined( 'WPTOH_PLUGIN_DIR' ) ){
			define( 'WPTOH_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
		}

		// Plugin folder URL.
		if( ! defined( 'WPTOH_PLUGIN_URL' ) ){
			define( 'WPTOH_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
		}

		// Plugin root file.
		if( ! defined( 'WPTOH_PLUGIN_FILE' ) ){
			define( 'WPTOH_PLUGIN_FILE', __FILE__ );
		}



	}

	/**
	 * Include required files.
	 *
	 * @access private
	 * @since 1.0.0
	 * @return void
	 */
	private function wptoh_includes() {
		require_once WPTOH_PLUGIN_DIR . 'includes/class-wptoh-track-order-history-admin.php';
	}

	
	/**
	 * Loads the plugin language files.
	 * 
	 * @access public
	 * @since 1.0.0
	 * @return void
	 */
	public function wptoh_load_textdomain(){

		// Checks if WooCommerce is installed.
		if ( class_exists( 'WC_Integration' ) ) {
			load_plugin_textdomain(
				'wc-past-orders',
				false,
				basename( dirname( __FILE__ ) ) . '/languages'
			);
		}else{
			
			require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
			add_action( 'admin_notices', array( $this, 'addweb_plugin_notice' ) );

			deactivate_plugins( array(plugin_basename( __FILE__ )) ); 

			if ( isset( $_GET['activate'] ) ) {
				unset( $_GET['activate'] );
			}  
		}
	}

	/**
		* Display admin notices.
		* @since 1.1 add admin notice.
		*/
		public function addweb_plugin_notice() {
			echo sprintf('<div class="error"><p>%1$s</p></div>', esc_html( __( 'Sorry, but Track Order History for WooCommerce Plugin requires the Woocommerce plugin to be installed and active.', 'wc-past-orders' ) )
			);
		}
	
}

endif; // End If class exists check.

/**
 * The main function for that returns WPTOH_Track_Order_History
 *
 * The main function responsible for returning the one true WPTOH_Track_Order_History
 * Instance to functions everywhere.
 *
 * Use this function like you would a global variable, except without needing
 * to declare the global.
 *
 * Example: <?php $awwptoh = run_awwptoh(); ?>
 *
 * @since 1.0.0
 * @return object|WPTOH_Track_Order_History The one true WPTOH_Track_Order_History Instance.
 */
function run_awwptoh() {
	return WPTOH_Track_Order_History::instance();
}

// Get WPTOH_Track_Order_History Running.
$GLOBALS['awwptoh'] = run_awwptoh();


