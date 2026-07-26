<?php

if (!defined('ABSPATH'))
    exit;

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
                'icon' => 'eicon-folder',
            ]
        );

        // Backward compatibility: some widgets still reference 'lc-page-kit'
        $elements_manager->add_category(
            'lc-page-kit',
            [
                'title' => __('LC Page Kit', 'lc-addons-kit-for-elementor'),
                'icon' => 'eicon-folder',
            ]
        );

        $elements_manager->add_category(
            'lc-header-footer-kit1',
            [
                'title' => __('LC Header Footer kit', 'lc-addons-kit-for-elementor'),
                'icon' => 'eicon-header',
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

                // Composite ID disambiguates same-named files across folders (e.g. "post-grid"
                // exists in both lc-kit and lc-header-footer). This is what the Widget Manager saves.
                $widget_id = $folder . ':' . $widget_name;

                // Convert to PascalCase for class name (e.g., accordion → LCAKE_Kit_Accordion)
                $class = $prefix . str_replace(' ', '_', ucwords(str_replace('-', ' ', $widget_name)));

                if (class_exists($class)) {
                    // If no specific selection saved, register all by default
                    if (empty($enabled_widgets) || !is_array($enabled_widgets)) {
                        $widgets_manager->register(new $class());
                        continue;
                    }

                    // Otherwise, only register if enabled in settings. Accept the legacy bare
                    // filename too (pre-composite-ID saves only ever covered the lc-kit folder).
                    $is_enabled = in_array($widget_id, $enabled_widgets, true)
                        || ('lc-kit' === $folder && in_array($widget_name, $enabled_widgets, true));

                    if ($is_enabled) {
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
            'lcake-kit-funfact-js' => ['file' => 'lcake-kit-funfact.js', 'deps' => ['jquery', 'elementor-frontend'], 'enqueue' => true, 'path' => ''],
            'lcake-kit-countdown-timer-js' => ['file' => 'lcake-kit-countdown-timer.js', 'deps' => ['jquery', 'elementor-frontend', 'lcake-kit-countdown-js'], 'enqueue' => true, 'path' => ''],
            'lcake-kit-countdown-js' => ['file' => 'jquery.countdown.min.js', 'deps' => ['jquery'], 'enqueue' => true, 'path' => ''],
            'lcake-kit-lottie-js' => ['file' => 'lcake-kit-lottie.js', 'deps' => ['jquery', 'elementor-frontend'], 'enqueue' => true, 'path' => ''],
            'lcake-kit-fancy-text-js' => ['file' => 'lcake-kit-fancy-text.js', 'deps' => ['jquery', 'elementor-frontend'], 'enqueue' => false, 'path' => ''],
            'lcake-kit-svg-draw-js' => ['file' => 'lcake-kit-svg-draw.js', 'deps' => ['jquery', 'elementor-frontend'], 'enqueue' => false, 'path' => ''],
            'lcake-kit-code-snippet-js' => ['file' => 'lcake-kit-code-snippet.js', 'deps' => ['jquery', 'elementor-frontend'], 'enqueue' => false, 'path' => ''],
            'lcake-kit-filterable-gallery-js' => ['file' => 'lcake-kit-filterable-gallery.js', 'deps' => ['jquery', 'elementor-frontend'], 'enqueue' => false, 'path' => ''],
            'lcake-kit-sticky-video-js' => ['file' => 'lcake-kit-sticky-video.js', 'deps' => ['jquery', 'elementor-frontend'], 'enqueue' => false, 'path' => ''],
            'lcake-kit-advanced-data-table-js' => ['file' => 'lcake-kit-advanced-data-table.js', 'deps' => ['jquery', 'elementor-frontend'], 'enqueue' => false, 'path' => ''],
            'lcake-kit-woo-product-carousel-js' => ['file' => 'lcake-kit-woo-product-carousel.js', 'deps' => ['jquery', 'elementor-frontend', 'lcake-swiper-js'], 'enqueue' => false, 'path' => ''],
            'lcake-kit-woo-product-images-js' => ['file' => 'lcake-kit-woo-product-images.js', 'deps' => ['jquery', 'elementor-frontend'], 'enqueue' => false, 'path' => ''],
            'lcake-kit-type-form-js' => ['file' => 'lcake-kit-type-form.js', 'deps' => ['jquery', 'elementor-frontend'], 'enqueue' => false, 'path' => ''],
            'lcake-kit-twitter-feed-js' => ['file' => 'lcake-kit-twitter-feed.js', 'deps' => ['jquery', 'elementor-frontend'], 'enqueue' => false, 'path' => ''],
            'lcake-kit-login-register-js' => ['file' => 'lcake-kit-login-register.js', 'deps' => ['jquery', 'elementor-frontend'], 'enqueue' => false, 'path' => ''],
            'lcake-kit-event-calendar-js' => ['file' => 'lcake-kit-event-calendar.js', 'deps' => ['jquery', 'elementor-frontend'], 'enqueue' => false, 'path' => ''],
            'lc-header-footer-nav-menu-js' => ['file' => 'lc-header-footer-nav-menu.js', 'deps' => ['jquery', 'elementor-frontend'], 'enqueue' => false, 'path' => ''],
            'lc-header-footer-mobile-menu-toggle-js' => ['file' => 'lc-header-footer-mobile-menu-toggle.js', 'deps' => ['jquery', 'elementor-frontend'], 'enqueue' => false, 'path' => ''],
            'lc-header-footer-search-toggle-js' => ['file' => 'lc-header-footer-search-toggle.js', 'deps' => ['jquery', 'elementor-frontend'], 'enqueue' => false, 'path' => ''],
            'lc-header-footer-cart-icon-js' => ['file' => 'lc-header-footer-cart-icon.js', 'deps' => ['jquery', 'elementor-frontend'], 'enqueue' => false, 'path' => ''],
            // 'lcake-kit-client-logo' => ['file' => 'lcake-kit-client-logo.js', 'deps' => ['jquery', 'lcake-swiper-js'], 'enqueue' => false, 'path' => '']
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
            'lcake-kit-countdown-timer-css' => ['file' => 'lcake-kit-countdown-timer.css', 'enqueue' => true, 'path' => ''],
            'lcake-kit-drop-caps-css' => ['file' => 'lcake-kit-drop-caps.css', 'enqueue' => true, 'path' => ''],
            'lcake-kit-heading-css' => ['file' => 'lcake-kit-heading.css', 'enqueue' => true, 'path' => ''],
            'lcake-kit-image-box-css' => ['file' => 'lcake-kit-image-box.css', 'enqueue' => true, 'path' => ''],
            'lcake-kit-icon-box-css' => ['file' => 'lcake-kit-icon-box.css', 'enqueue' => true, 'path' => ''],
            'lcake-kit-lottie-css' => ['file' => 'lcake-kit-lottie.css', 'enqueue' => true, 'path' => ''],
            'lcake-kit-video-css' => ['file' => 'lcake-kit-video.css', 'enqueue' => true, 'path' => ''],
            'lcake-kit-breadcrumbs-css' => ['file' => 'lcake-kit-breadcrumbs.css', 'enqueue' => false, 'path' => ''],
            'lcake-kit-cta-box-css' => ['file' => 'lcake-kit-cta-box.css', 'enqueue' => false, 'path' => ''],
            'lcake-kit-flip-box-css' => ['file' => 'lcake-kit-flip-box.css', 'enqueue' => false, 'path' => ''],
            'lcake-kit-feature-list-css' => ['file' => 'lcake-kit-feature-list.css', 'enqueue' => false, 'path' => ''],
            'lcake-kit-tooltip-css' => ['file' => 'lcake-kit-tooltip.css', 'enqueue' => false, 'path' => ''],
            'lcake-kit-dual-color-header-css' => ['file' => 'lcake-kit-dual-color-header.css', 'enqueue' => false, 'path' => ''],
            'lcake-kit-fancy-text-css' => ['file' => 'lcake-kit-fancy-text.css', 'enqueue' => false, 'path' => ''],
            'lcake-kit-content-ticker-css' => ['file' => 'lcake-kit-content-ticker.css', 'enqueue' => false, 'path' => ''],
            'lcake-kit-simple-menu-css' => ['file' => 'lcake-kit-simple-menu.css', 'enqueue' => false, 'path' => ''],
            'lcake-kit-svg-draw-css' => ['file' => 'lcake-kit-svg-draw.css', 'enqueue' => false, 'path' => ''],
            'lcake-kit-code-snippet-css' => ['file' => 'lcake-kit-code-snippet.css', 'enqueue' => false, 'path' => ''],
            'lcake-kit-interactive-circle-css' => ['file' => 'lcake-kit-interactive-circle.css', 'enqueue' => false, 'path' => ''],
            'lcake-kit-filterable-gallery-css' => ['file' => 'lcake-kit-filterable-gallery.css', 'enqueue' => false, 'path' => ''],
            'lcake-kit-nft-gallery-css' => ['file' => 'lcake-kit-nft-gallery.css', 'enqueue' => false, 'path' => ''],
            'lcake-kit-sticky-video-css' => ['file' => 'lcake-kit-sticky-video.css', 'enqueue' => false, 'path' => ''],
            'lcake-kit-post-grid-css' => ['file' => 'lcake-kit-post-grid.css', 'enqueue' => false, 'path' => ''],
            'lcake-kit-post-timeline-css' => ['file' => 'lcake-kit-post-timeline.css', 'enqueue' => false, 'path' => ''],
            'lcake-kit-data-table-css' => ['file' => 'lcake-kit-data-table.css', 'enqueue' => false, 'path' => ''],
            'lcake-kit-advanced-data-table-css' => ['file' => 'lcake-kit-advanced-data-table.css', 'enqueue' => false, 'path' => ''],
            'lcake-kit-business-reviews-css' => ['file' => 'lcake-kit-business-reviews.css', 'enqueue' => false, 'path' => ''],
            'lcake-kit-product-grid-css' => ['file' => 'lcake-kit-product-grid.css', 'enqueue' => false, 'path' => ''],
            'lcake-kit-woo-product-list-css' => ['file' => 'lcake-kit-woo-product-list.css', 'enqueue' => false, 'path' => ''],
            'lcake-kit-woo-product-carousel-css' => ['file' => 'lcake-kit-woo-product-carousel.css', 'enqueue' => false, 'path' => ''],
            'lcake-kit-woo-product-title-css' => ['file' => 'lcake-kit-woo-product-title.css', 'enqueue' => false, 'path' => ''],
            'lcake-kit-woo-product-price-css' => ['file' => 'lcake-kit-woo-product-price.css', 'enqueue' => false, 'path' => ''],
            'lcake-kit-woo-product-rating-css' => ['file' => 'lcake-kit-woo-product-rating.css', 'enqueue' => false, 'path' => ''],
            'lcake-kit-woo-product-short-description-css' => ['file' => 'lcake-kit-woo-product-short-description.css', 'enqueue' => false, 'path' => ''],
            'lcake-kit-woo-product-description-css' => ['file' => 'lcake-kit-woo-product-description.css', 'enqueue' => false, 'path' => ''],
            'lcake-kit-woo-product-tabs-css' => ['file' => 'lcake-kit-woo-product-tabs.css', 'enqueue' => false, 'path' => ''],
            'lcake-kit-woo-product-gallery-css' => ['file' => 'lcake-kit-woo-product-gallery.css', 'enqueue' => false, 'path' => ''],
            'lcake-kit-woo-product-images-css' => ['file' => 'lcake-kit-woo-product-images.css', 'enqueue' => false, 'path' => ''],
            'lcake-kit-woo-add-to-cart-css' => ['file' => 'lcake-kit-woo-add-to-cart.css', 'enqueue' => false, 'path' => ''],
            'lcake-kit-woo-cart-css' => ['file' => 'lcake-kit-woo-cart.css', 'enqueue' => false, 'path' => ''],
            'lcake-kit-woo-checkout-css' => ['file' => 'lcake-kit-woo-checkout.css', 'enqueue' => false, 'path' => ''],
            'lcake-kit-woo-product-compare-css' => ['file' => 'lcake-kit-woo-product-compare.css', 'enqueue' => false, 'path' => ''],
            'lcake-kit-gravity-forms-css' => ['file' => 'lcake-kit-gravity-forms.css', 'enqueue' => false, 'path' => ''],
            'lcake-kit-ninja-forms-css' => ['file' => 'lcake-kit-ninja-forms.css', 'enqueue' => false, 'path' => ''],
            'lcake-kit-wp-forms-css' => ['file' => 'lcake-kit-wp-forms.css', 'enqueue' => false, 'path' => ''],
            'lcake-kit-fluent-form-css' => ['file' => 'lcake-kit-fluent-form.css', 'enqueue' => false, 'path' => ''],
            'lcake-kit-we-forms-css' => ['file' => 'lcake-kit-we-forms.css', 'enqueue' => false, 'path' => ''],
            'lcake-kit-caldera-forms-css' => ['file' => 'lcake-kit-caldera-forms.css', 'enqueue' => false, 'path' => ''],
            'lcake-kit-formstack-css' => ['file' => 'lcake-kit-formstack.css', 'enqueue' => false, 'path' => ''],
            'lcake-kit-type-form-css' => ['file' => 'lcake-kit-type-form.css', 'enqueue' => false, 'path' => ''],
            'lcake-kit-facebook-feed-css' => ['file' => 'lcake-kit-facebook-feed.css', 'enqueue' => false, 'path' => ''],
            'lcake-kit-twitter-feed-css' => ['file' => 'lcake-kit-twitter-feed.css', 'enqueue' => false, 'path' => ''],
            'lcake-kit-login-register-css' => ['file' => 'lcake-kit-login-register.css', 'enqueue' => false, 'path' => ''],
            'lcake-kit-event-calendar-css' => ['file' => 'lcake-kit-event-calendar.css', 'enqueue' => false, 'path' => ''],
            'lcake-kit-embed-press-css' => ['file' => 'lcake-kit-embed-press.css', 'enqueue' => false, 'path' => ''],
            'lcake-kit-betterdocs-category-box-css' => ['file' => 'lcake-kit-betterdocs-category-box.css', 'enqueue' => false, 'path' => ''],
            'lcake-kit-betterdocs-category-grid-css' => ['file' => 'lcake-kit-betterdocs-category-grid.css', 'enqueue' => false, 'path' => ''],
            'lcake-kit-betterdocs-search-form-css' => ['file' => 'lcake-kit-betterdocs-search-form.css', 'enqueue' => false, 'path' => ''],
            'lcake-kit-better-payment-css' => ['file' => 'lcake-kit-better-payment.css', 'enqueue' => false, 'path' => ''],
            'lc-header-footer-site-logo-css' => ['file' => 'lc-header-footer-site-logo.css', 'enqueue' => false, 'path' => ''],
            'lc-header-footer-site-title-css' => ['file' => 'lc-header-footer-site-title.css', 'enqueue' => false, 'path' => ''],
            'lc-header-footer-nav-menu-css' => ['file' => 'lc-header-footer-nav-menu.css', 'enqueue' => false, 'path' => ''],
            'lc-header-footer-mobile-menu-toggle-css' => ['file' => 'lc-header-footer-mobile-menu-toggle.css', 'enqueue' => false, 'path' => ''],
            'lc-header-footer-search-toggle-css' => ['file' => 'lc-header-footer-search-toggle.css', 'enqueue' => false, 'path' => ''],
            'lc-header-footer-cart-icon-css' => ['file' => 'lc-header-footer-cart-icon.css', 'enqueue' => false, 'path' => ''],
            'lc-header-footer-contact-info-css' => ['file' => 'lc-header-footer-contact-info.css', 'enqueue' => false, 'path' => ''],
            'lc-header-footer-copyright-text-css' => ['file' => 'lc-header-footer-copyright-text.css', 'enqueue' => false, 'path' => ''],
            // 'lcake-kit-client-logo' => ['file' => 'lcake-kit-client-logo.css', 'enqueue' => false, 'path' => '']
        ];

        LCAKE_Kit_Utils::lcake_file_enqueue($styles, 'style');
    }
}
