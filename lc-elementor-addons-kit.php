<?php

/**
 * Plugin Name: LC Elementor Addons Kit
 * Plugin URI: https://lionecoders.com
 * Description: A powerful Elementor addon plugin that offers a wide range of widgets categorized into 'LC Kit' and 'LC Header & Footer kit'.
 * Version: 1.0.0
 * Author: Lionescoders
 * Author URI: https://lionecoders.com
 * Text Domain: lc-elementor-addons-kit
 * Domain Path: /languages
 * Requires at least: 5.0
 * Tested up to: 6.4
 * Requires PHP: 7.4
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

if (!defined('ABSPATH')) exit;

class LC_Elementor_Addons_Kit
{

    public function __construct()
    {
        $this->define_constants();
        add_action('plugins_loaded', [$this, 'on_plugins_loaded']);
        
    }

    private function define_constants()
    {
        define('LC_EAK_VERSION', '1.0.0');
        define('LC_EAK_PATH', plugin_dir_path(__FILE__));
        define('LC_EAK_URL', plugin_dir_url(__FILE__));
    }

    public function on_plugins_loaded()
    {
        if (!did_action('elementor/loaded')) {
            add_action('admin_notices', [$this, 'elementor_missing_notice']);
            return;
        }

        require_once LC_EAK_PATH . 'includes/lc-widget-loader.php';
        require_once LC_EAK_PATH . 'admin/lc-admin-page.php';
        new LC_Kit_Widget_Loader();
        new LC_Kit_Admin_Settings();
        add_action('elementor/frontend/after_register_scripts', [$this, 'register_widget_scripts']);
        add_action('elementor/frontend/after_register_styles', [$this, 'register_widget_styles']);

    }
    public function register_widget_scripts() {
        wp_register_script(
            'lc-kit-accordion',
            LC_EAK_URL . 'assets/js/lc-kit-accordion.js',
            ['jquery'],
            LC_EAK_VERSION,
            true
        );
        wp_register_script(
            'lc-kit-faq-js',
            LC_EAK_URL . 'assets/js/lc-kit-faq.js',
            ['jquery'],
            LC_EAK_VERSION,
            true
        );
        wp_enqueue_script('lc-kit-faq-js');
    }
    
    public function register_widget_styles() {
        wp_register_style(
            'lc-kit-accordion',
            LC_EAK_URL . 'assets/css/lc-kit-accordion.css',
            [],
            LC_EAK_VERSION
        );
        wp_register_style(
            'lc-kit-button',
            LC_EAK_URL . 'assets/css/lc-kit-button.css',
            [],
            LC_EAK_VERSION
        );
        wp_enqueue_style('lc-kit-button');

    
        wp_register_style(
            'lc-kit-social-icons',
            LC_EAK_URL . 'assets/css/lc-kit-social-icons.css',
            [],
            LC_EAK_VERSION
        );
        wp_enqueue_style('lc-kit-social-icons');

        wp_register_style(
            'lc-kit-faq-css',
            LC_EAK_URL . 'assets/css/lc-kit-faq.css',
            [],
            LC_EAK_VERSION
        );
        wp_enqueue_style('lc-kit-faq-css');



    }
    

    public function elementor_missing_notice()
    {
        echo '<div class="notice notice-warning"><p>';
        echo esc_html__('LC Elementor Addons Kit requires Elementor to be installed and activated.', 'lc-elementor-addons-kit');
        echo '</p></div>';
    }    
}

new LC_Elementor_Addons_Kit();
