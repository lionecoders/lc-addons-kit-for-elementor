<?php

/**
 * Plugin Name: LC Addons Kit for Elementor
 * Plugin URI: https://lionecoders.com
 * Description: A powerful Elementor addon plugin that offers a wide range of widgets categorized into 'LC Kit' and 'LC Header & Footer kit'.
 * Version: 1.0.0
 * Author: Lionecoders
 * Author URI: https://lionecoders.com
 * Text Domain: lc-addons-kit-for-elementor
 * Requires at least: 5.0
 * Tested up to: 6.4
 * Requires PHP: 7.4
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Requires Plugins: elementor
 * 
 **/

if (!defined('ABSPATH')) exit;

class LCAKE_Elementor_Addons_Kit
{

    public function __construct()
    {
        $this->define_constants();
        add_action('plugins_loaded', [$this, 'on_plugins_loaded']);
    }

    private function define_constants()
    {
        define('LCAKE_EAK_VERSION', '1.0.0');
        define('LCAKE_EAK_PATH', plugin_dir_path(__FILE__));
        define('LCAKE_EAK_URL', plugin_dir_url(__FILE__));
    }

    public function on_plugins_loaded()
    {
        if (!did_action('elementor/loaded')) {
            add_action('admin_notices', [$this, 'elementor_missing_notice']);
            return;
        }

        require_once LCAKE_EAK_PATH . 'includes/lcake-utils.php';
        require_once LCAKE_EAK_PATH . 'includes/lcake-lib.php';
        require_once LCAKE_EAK_PATH . 'includes/lcake-widget-loader.php';
        require_once LCAKE_EAK_PATH . 'admin/lcake-admin-page.php';
        new LCAKE_Kit_Widget_Loader();
        new LCAKE_Kit_Admin_Settings();
        new LCAKE_Lib();
    }


    public function elementor_missing_notice()
    {
        echo '<div class="notice notice-warning"><p>';
        echo esc_html__('LC Elementor Addons Kit requires Elementor to be installed and activated.', 'lc-addons-kit-for-elementor');
        echo '</p></div>';
    }
}

new LCAKE_Elementor_Addons_Kit();
