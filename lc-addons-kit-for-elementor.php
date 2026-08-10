<?php

/**
 * Plugin Name: LC Addons Kit for Elementor
 * Plugin URI: https://lionecoders.com
 * Description: A powerful Elementor addon plugin that offers a wide range of widgets categorized into 'LC Kit'.
 * Version: 1.1.4
 * Author: Lionecoders
 * Author URI: https://lionecoders.com
 * Text Domain: lc-addons-kit-for-elementor
 * Requires at least: 5.0
 * Tested up to: 7.0
 * Requires PHP: 7.4
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Requires Plugins: elementor
 **/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Main plugin bootstrap class.
 * 
 * Initializes the plugin, defines constants, and loads all necessary dependencies
 * and core components after verifying Elementor is active.
 *
 * @since 1.0.0
 */
class LCAKE_Elementor_Addons_Kit {


	/**
	 * Constructor.
	 * 
	 * Sets up the plugin constants and hooks into 'plugins_loaded' to load the core classes.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$this->define_constants();
		add_action( 'plugins_loaded', array( $this, 'on_plugins_loaded' ) );
	}

	/**
	 * Defines global plugin constants.
	 * 
	 * @since 1.0.0
	 * @return void
	 */
	private function define_constants() {
		define( 'LCAKE_EAK_VERSION', '1.1.4' );
		define( 'LCAKE_EAK_PATH', plugin_dir_path( __FILE__ ) );
		define( 'LCAKE_EAK_URL', plugin_dir_url( __FILE__ ) );
	}

	/**
	 * Callback for the 'plugins_loaded' action.
	 * 
	 * Checks if Elementor is loaded. If it is, includes and instantiates all core classes 
	 * (Widgets Loader, Admin Settings, Icon Library, and Header/Footer Builder). 
	 * If not, displays an admin notice.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function on_plugins_loaded() {
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', array( $this, 'elementor_missing_notice' ) );
			return;
		}

		require_once LCAKE_EAK_PATH . 'includes/lcake-utils.php';
		require_once LCAKE_EAK_PATH . 'includes/lcake-dependency-checker.php';
		require_once LCAKE_EAK_PATH . 'includes/lcake-lib.php';
		require_once LCAKE_EAK_PATH . 'includes/lcake-widget-loader.php';
		require_once LCAKE_EAK_PATH . 'includes/lcake-header-footer-builder.php';
		require_once LCAKE_EAK_PATH . 'admin/lcake-admin-page.php';
		new LCAKE_Kit_Widget_Loader();
		new LCAKE_Kit_Admin_Settings();
		new LCAKE_Lib();
		new LCAKE_Header_Footer_Builder();
	}


	/**
	 * Displays an admin notice if Elementor is not active.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function elementor_missing_notice() {
		echo '<div class="notice notice-warning"><p>';
		echo esc_html__( 'LC Elementor Addons Kit requires Elementor to be installed and activated.', 'lc-addons-kit-for-elementor' );
		echo '</p></div>';
	}
}

new LCAKE_Elementor_Addons_Kit();
