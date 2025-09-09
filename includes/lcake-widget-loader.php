<?php

if (!defined('ABSPATH')) exit;

class LCAKE_Kit_Widget_Loader
{

    public function __construct()
    {
        add_action('elementor/widgets/register', [$this, 'register_widgets']);
        add_action('elementor/elements/categories_registered', [$this, 'register_categories']);
        add_action('elementor/frontend/after_register_scripts', [$this, 'register_widget_scripts']);
        add_action('elementor/frontend/after_register_styles', [$this, 'register_widget_styles']);
    }

    public function register_categories($elements_manager)
    {
        $elements_manager->add_category(
            'lcake-page-kit',
            [
                'title' => __('LC Page Kit', 'lc-elementor-addons-kit'),
                'icon'  => 'eicon-folder',
            ]
        );

        $elements_manager->add_category(
            'lcake-header-footer-kit',
            [
                'title' => __('LC Header Footer kit', 'lc-elementor-addons-kit'),
                'icon'  => 'eicon-header',
            ]
        );
    }

    public function register_widgets($widgets_manager)
    {
        $folders = [
            'lc-kit' => 'LCAKE_Kit_'
        ];

        foreach ($folders as $folder => $prefix) {
            $path = LCAKE_EAK_PATH . 'includes/widgets/' . $folder . '/';

            // Get all PHP files including those in subdirectories
            $files = glob($path . '*.php');
            $subdir_files = glob($path . '*/*.php');
            $all_files = array_merge($files, $subdir_files);

            foreach ($all_files as $file) {
                require_once $file;

                $base = basename($file, '.php');
                $class = $prefix . str_replace(' ', '_', ucwords(str_replace('-', ' ', $base)));

                if (class_exists($class)) {
                    $widgets_manager->register(new $class());
                }
            }
        }
    }

    public function register_widget_scripts()
    {
        $scripts = [
            'lcake-kit-accordion' => ['file' => 'lcake-kit-accordion.js', 'deps' => ['jquery'], 'enqueue' => false],
            'lcake-kit-faq-js' => ['file' => 'lcake-kit-faq.js', 'deps' => ['jquery'], 'enqueue' => true],
            'lcake-kit-pie-chart-js' => ['file' => 'lcake-kit-pie-chart.js', 'deps' => ['jquery'], 'enqueue' => true],
            'lcake-kit-testimonial-js' => ['file' => 'lcake-kit-testimonial.js', 'deps' => ['jquery', 'lcake-swiper-js'], 'enqueue' => false],
            'lcake-chartjs' => ['file' => 'chart.min.js', 'deps' => ['jquery'], 'enqueue' => true],
            'lcake-swiper-js' => ['file' => 'swiper-bundle.min.js', 'deps' => ['jquery'], 'enqueue' => true],
            'lcake-btsp-js' => ['file' => 'bootstrap.bundle.min.js', 'deps' => ['jquery'], 'enqueue' => true]
        ];

        LCAKE_Kit_Utils::lcake_file_enqueue($scripts, 'script' );
    }

    public function register_widget_styles()
    {
        $styles = [
            'lcake-kit-accordion' => ['file' => 'lcake-kit-accordion.css', 'enqueue' => false],
            'lcake-kit-button' => ['file' => 'lcake-kit-button.css', 'enqueue' => true],
            'lcake-kit-social-icons' => ['file' => 'lcake-kit-social-icons.css', 'enqueue' => true],
            'lcake-kit-faq-css' => ['file' => 'lcake-kit-faq.css', 'enqueue' => true],
            'lcake-kit-pie-chart-css' => ['file' => 'lcake-kit-pie-chart.css', 'enqueue' => true],
            'lcake-kit-testimonial-css' => ['file' => 'lcake-kit-testimonial.css', 'enqueue' => false],
            'lcake-btsp-css' => ['file' => 'bootstrap.min.css', 'enqueue' => true],
            'lcake-swiper-css' => ['file' => 'swiper-bundle.min.css', 'enqueue' => true],
        ];        

        LCAKE_Kit_Utils::lcake_file_enqueue($styles, 'style' );
    }
}
