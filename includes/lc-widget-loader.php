<?php

if (!defined('ABSPATH')) exit;

class LC_Kit_Widget_Loader {

    public function __construct() {
        add_action('elementor/widgets/register', [$this, 'register_widgets']);
        add_action('elementor/elements/categories_registered', [$this, 'register_categories']);
    }

    public function register_categories($elements_manager) {
        $elements_manager->add_category(
            'lc-page-kit',
            [
                'title' => __('LC Page Kit', 'lc-elementor-addons-kit'),
                'icon'  => 'eicon-folder',
            ]
        );

        $elements_manager->add_category(
            'lc-header-footer-kit',
            [
                'title' => __('LC Header Footer kit', 'lc-elementor-addons-kit'),
                'icon'  => 'eicon-header',
            ]
        );
    }

    public function register_widgets($widgets_manager) {
        $folders = [
            'lc-kit' => 'LC_Kit_'
        ];
    
        foreach ($folders as $folder => $prefix) {
            $path = LC_EAK_PATH . 'includes/widgets/' . $folder . '/';
    
            foreach (glob($path . '*.php') as $file) {
                require_once $file;
    
                $base = basename($file, '.php'); // e.g., "image-accordion"
                $class = $prefix . str_replace(' ', '_', ucwords(str_replace('-', ' ', $base)));
    
                if (class_exists($class)) {
                    $widgets_manager->register(new $class());
                }
            }
        }
    }
    
}