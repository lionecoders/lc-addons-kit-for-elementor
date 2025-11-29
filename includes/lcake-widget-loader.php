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
                'title' => __('LC Page Kit', 'lc-addons-kit-for-elementor'),
                'icon'  => 'eicon-folder',
            ]
        );

        // Backward compatibility: some widgets still reference 'lc-page-kit'
        $elements_manager->add_category(
            'lc-page-kit',
            [
                'title' => __('LC Page Kit', 'lc-addons-kit-for-elementor'),
                'icon'  => 'eicon-folder',
            ]
        );

        $elements_manager->add_category(
            'lc-header-footer-kit1',
            [
                'title' => __('LC Header Footer kit', 'lc-addons-kit-for-elementor'),
                'icon'  => 'eicon-header',
            ]
        );
    }

    public function register_widgets($widgets_manager)
    {
        // Get the saved list of enabled widget names (IDs) from the database.
        // Example: [ 'accordion', 'button', 'icon-box' ]
        $enabled_widgets = get_option('lcake_kit_enabled_widgets', []);

        $folders = [
            'lc-kit' => 'LCAKE_Kit_',
            'lc-header-footer' => 'LC_Header_Footer_',
        ];

        foreach ($folders as $folder => $prefix) {
            $path = LCAKE_EAK_PATH . 'includes/widgets/' . $folder . '/';
            if (!is_dir($path)) {
                continue;
            }

            // Get all PHP files including those in subdirectories
            $files = glob($path . '*.php');
            $subdir_files = glob($path . '*/*.php');
            $all_files = array_merge($files ?: [], $subdir_files ?: []);

            foreach ($all_files as $file) {
                require_once $file;

                // Widget name = filename without extension (e.g., accordion.php → accordion)
                $widget_name = basename($file, '.php');

                // Convert to PascalCase for class name (e.g., accordion → LCAKE_Kit_Accordion)
                $class = $prefix . str_replace(' ', '_', ucwords(str_replace('-', ' ', $widget_name)));

                if (class_exists($class)) {
                    // If no specific selection saved, register all by default
                    if (empty($enabled_widgets) || !is_array($enabled_widgets)) {
                        $widgets_manager->register(new $class());
                        continue;
                    }

                    // Otherwise, only register if enabled in settings
                    if (in_array($widget_name, $enabled_widgets, true)) {
                        $widgets_manager->register(new $class());
                    }
                }
            }
        }
    }
    public function register_widget_scripts()
    {
        $scripts = [
            'lcake-kit-jquery-event-move' => ['file' => 'jquery.event.move.min.js', 'deps' => ['jquery'], 'enqueue' => false, 'path' => ''],
            'lcake-kit-twentytwenty' => ['file' => 'jquery.twentytwenty.min.js', 'deps' => ['jquery', 'lcake-kit-jquery-event-move'], 'enqueue' => false, 'path' => ''],
            'lcake-kit-image-comparison' => ['file' => 'image-comparison.js', 'deps' => ['jquery', 'elementor-frontend', 'lcake-kit-twentytwenty'], 'enqueue' => false, 'path' => ''],
            'lcake-kit-tab-js' => ['file' => 'lcake-kit-tab.js', 'deps' => ['jquery'], 'enqueue' => false, 'path' => ''],
            'lcake-kit-accordion' => ['file' => 'lcake-kit-accordion.js', 'deps' => ['jquery'], 'enqueue' => false, 'path' => ''],
            'lcake-kit-faq-js' => ['file' => 'lcake-kit-faq.js', 'deps' => ['jquery'], 'enqueue' => true, 'path' => ''],
            'lcake-kit-pie-chart-js' => ['file' => 'lcake-kit-pie-chart.js', 'deps' => ['jquery'], 'enqueue' => true, 'path' => ''],
            'lcake-kit-testimonial-js' => ['file' => 'lcake-kit-testimonial.js', 'deps' => ['jquery', 'elementor-frontend'], 'enqueue' => false, 'path' => ''],
            'lcake-kit-progress-bar-js' => ['file' => 'lcake-kit-progress-bar.js', 'deps' => ['jquery', 'elementor-frontend'], 'enqueue' => false, 'path' => ''],
            'lcake-team-js' => ['file' => 'lcake-team.js', 'deps' => ['jquery'], 'enqueue' => false, 'path' => ''],
            'lcake-chart-js' => ['file' => 'lcake-chart.min.js', 'deps' => ['jquery'], 'enqueue' => true, 'path' => '', 'module' => true],
            'lcake-btsp-js' => ['file' => 'bootstrap.bundle.min.js', 'deps' => ['jquery'], 'enqueue' => true, 'path' => ''],
            'lcake-dialog-js' => ['file' => 'dialog.min.js', 'deps' => ['jquery'], 'enqueue' => true, 'path' => ''],
            'lcake-kit-image-accordion' => ['file' => 'lcake-kit-image-accordion.js', 'deps' => ['jquery', 'elementor-frontend'], 'enqueue' => false, 'path' => ''],
            'lcake-swiper-js' => ['file' => 'swiper-bundle.min.js', 'deps' => ['jquery'], 'enqueue' => false, 'path' => ''],
            'lcake-kit-client-logo' => ['file' => 'lcake-kit-client-logo.js', 'deps' => ['jquery', 'lcake-swiper-js'], 'enqueue' => false, 'path' => '']
        ];

        LCAKE_Kit_Utils::lcake_file_enqueue($scripts, 'script');
    }

    public function register_widget_styles()
    {
        $styles = [
            'lcake-kit-twentytwenty' => ['file' => 'twentytwenty.min.css', 'enqueue' => false, 'path' => ''],
            'lcake-kit-accordion' => ['file' => 'lcake-kit-accordion.css', 'enqueue' => false, 'path' => ''],
            'lcake-kit-button' => ['file' => 'lcake-kit-button.css', 'enqueue' => true, 'path' => ''],
            'lcake-kit-business-hours' => ['file' => 'lcake-kit-business-hours.css', 'enqueue' => true, 'path' => ''],
            'lcake-kit-price-table' => ['file' => 'lcake-kit-price-table.css', 'enqueue' => true, 'path' => ''],
            'lcake-kit-social-icons' => ['file' => 'lcake-kit-social-icons.css', 'enqueue' => true, 'path' => ''],
            'lcake-kit-image-comparison' => ['file' => 'image-comparison.css', 'enqueue' => true, 'path' => ''],
            'lcake-kit-faq-css' => ['file' => 'lcake-kit-faq.css', 'enqueue' => true, 'path' => ''],
            'lcake-kit-pie-chart-css' => ['file' => 'lceak-kit-pie-chart.css', 'enqueue' => true, 'path' => ''],
            'lcake-kit-testimonial-css' => ['file' => 'lcake-kit-testimonial.css', 'enqueue' => false, 'path' => ''],
            'lcake-team-css' => ['file' => 'lcake-team.css', 'enqueue' => false, 'path' => ''],
            'lcake-kit-tab-css' => ['file' => 'lcake-kit-tab.css', 'enqueue' => false, 'path' => ''],
            'lcake-kit-progress-bar-css' => ['file' => 'lcake-kit-progress-bar.css', 'enqueue' => false, 'path' => ''],
            'lcake-btsp-css' => ['file' => 'bootstrap.min.css', 'enqueue' => true, 'path' => ''],
            'lcake-swiper-css' => ['file' => 'swiper-bundle.min.css', 'enqueue' => true, 'path' => ''],
            'lcakeicons' => ['file' => 'lcakeicons.css', 'enqueue' => true, 'path' => 'assets/icons'],
            'lcake-kit-image-accordion' => ['file' => 'lcake-kit-image-accordion.css', 'enqueue' => false, 'path' => ''],
            'lcake-kit-client-logo' => ['file' => 'lcake-kit-client-logo.css', 'enqueue' => false, 'path' => '']
        ];

        LCAKE_Kit_Utils::lcake_file_enqueue($styles, 'style');
    }
}
