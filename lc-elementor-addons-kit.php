<?php

/**
 * Plugin Name: LC Elementor Addons Kit
 * Plugin URI: https://lionecoders.com
 * Description: A powerful Elementor addon plugin that offers a wide range of widgets categorized into 'LC Kit' and 'LC Header & Footer kit'.
 * Version: 1.0.0
 * Author: Lionescoders
 * Author URI: https://lionecoders.com/contact/
 * Text Domain: lc-elementor-addons-kit
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

        require_once LC_EAK_PATH . 'includes/lc-utils.php';
        require_once LC_EAK_PATH . 'includes/lc-widget-loader.php';
        require_once LC_EAK_PATH . 'admin/lc-admin-page.php';
        new LC_Kit_Widget_Loader();
        new LC_Kit_Admin_Settings();
        add_action('elementor/frontend/after_register_scripts', [$this, 'register_widget_scripts']);
        add_action('elementor/frontend/after_register_styles', [$this, 'register_widget_styles']);
    }
    public function register_widget_scripts()
    {
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

        wp_register_script(
            'lc-kit-pie-chart-js',
            LC_EAK_URL . 'assets/js/lc-kit-pie-chart.js',
            ['jquery'],
            LC_EAK_VERSION,
            true
        );
        wp_enqueue_script('lc-kit-pie-chart-js');

        wp_register_script(
            'lc-kit-testimonial-js',
            LC_EAK_URL . 'assets/js/lc-kit-testimonial.js',
            ['jquery', 'lc-swiper-js'],
            LC_EAK_VERSION,
            true
        );
        
        // Debug: Log script registration
        error_log('LC Plugin: Registered testimonial script: lc-kit-testimonial-js');
    }

    public function register_widget_styles()
    {
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

        wp_register_style(
            'lc-kit-pie-chart-css',
            LC_EAK_URL . 'assets/css/lc-kit-pie-chart.css',
            [],
            LC_EAK_VERSION
        );
        wp_register_style(
            'lc-kit-testimonial-css',
            LC_EAK_URL . 'assets/css/lc-kit-testimonial.css',
            [],
            LC_EAK_VERSION
        );
        wp_enqueue_style('lc-kit-testimonial-css');

        wp_register_script(
            'lc-chartjs',
            LC_EAK_URL . '/assets/js/chart.umd.min.js',
            [],
            '4.4.0',
            true
        );
        wp_enqueue_script('lc-chartjs');

        wp_register_style('lc-btsp-css', LC_EAK_URL . 'assets/css/bootstrap.min.css', [], true, 'all');
        wp_register_script('lc-btsp-js', LC_EAK_URL . '/assets/js/bootstrap.bundle.min.js', [], '5.3.7', true);
        wp_register_style('lc-swiper-css', LC_EAK_URL . 'assets/css/swiper-bundle.min.css', [], true, 'all');
        wp_register_script('lc-swiper-js', LC_EAK_URL . '/assets/js/swiper-bundle.min.js', [], '11.2.10', true);

        wp_enqueue_style('lc-swiper-css');
        wp_enqueue_script('lc-swiper-js');
        wp_enqueue_script('lc-btsp-js');
        wp_enqueue_style('lc-btsp-css');
    }


    public function elementor_missing_notice()
    {
        echo '<div class="notice notice-warning"><p>';
        echo esc_html__('LC Elementor Addons Kit requires Elementor to be installed and activated.', 'lc-elementor-addons-kit');
        echo '</p></div>';
    }
}

new LC_Elementor_Addons_Kit();
