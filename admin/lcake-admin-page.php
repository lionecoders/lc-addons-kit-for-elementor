<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class LCAKE_Kit_Admin_Settings
{
    private $widgets = [];
    private $menu_slug = 'lcake_menu';
    private $page_hook = '';

    public function __construct()
    {
        $this->load_widget_info();

        add_action('admin_menu', [$this, 'add_settings_page']);
        add_action('admin_init', [$this, 'remove_wordpress_notices']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_assets']);
        add_action('admin_init', [$this, 'register_settings']);
        add_action('rest_api_init', [$this, 'register_rest_routes']);
    }

    /**
     * Maps a widget's filename (basename, no extension) to a display category.
     * Anything from the lc-header-footer folder is always grouped separately
     * regardless of this map (see load_widget_info()).
     */
    private function get_category_map()
    {
        return [
            // Content & Layout
            'accordion' => 'Content & Layout', 'breadcrumbs' => 'Content & Layout', 'button' => 'Content & Layout',
            'code-snippet' => 'Content & Layout', 'content-ticker' => 'Content & Layout', 'cta-box' => 'Content & Layout',
            'drop-caps' => 'Content & Layout', 'dual-color-header' => 'Content & Layout', 'fancy-text' => 'Content & Layout',
            'faq' => 'Content & Layout', 'feature-list' => 'Content & Layout', 'flip-box' => 'Content & Layout',
            'heading' => 'Content & Layout', 'icon-box' => 'Content & Layout', 'image-box' => 'Content & Layout',
            'interactive-circle' => 'Content & Layout', 'simple-menu' => 'Content & Layout', 'tab' => 'Content & Layout',
            'tooltip' => 'Content & Layout', 'svg-draw' => 'Content & Layout',
            // Media & Gallery
            'image-accordion' => 'Media & Gallery', 'image-comparison' => 'Media & Gallery', 'filterable-gallery' => 'Media & Gallery',
            'nft-gallery' => 'Media & Gallery', 'sticky-video' => 'Media & Gallery', 'video' => 'Media & Gallery',
            'lottie' => 'Media & Gallery', 'client-logo' => 'Media & Gallery',
            // Data & Stats
            'pie-chart' => 'Data & Stats', 'progress-bar' => 'Data & Stats', 'data-table' => 'Data & Stats',
            'advanced-data-table' => 'Data & Stats', 'business-reviews' => 'Data & Stats', 'post-grid' => 'Data & Stats',
            'post-timeline' => 'Data & Stats', 'funfact' => 'Data & Stats', 'countdown-timer' => 'Data & Stats',
            'event-calendar' => 'Data & Stats',
            // Team & Social Proof
            'team' => 'Team & Social Proof', 'testimonial' => 'Team & Social Proof', 'pricing-table' => 'Team & Social Proof',
            'business-hours' => 'Team & Social Proof', 'social-icons' => 'Team & Social Proof',
            // WooCommerce
            'product-grid' => 'WooCommerce', 'woo-add-to-cart' => 'WooCommerce', 'woo-cart' => 'WooCommerce',
            'woo-checkout' => 'WooCommerce', 'woo-product-carousel' => 'WooCommerce', 'woo-product-compare' => 'WooCommerce',
            'woo-product-description' => 'WooCommerce', 'woo-product-gallery' => 'WooCommerce', 'woo-product-images' => 'WooCommerce',
            'woo-product-list' => 'WooCommerce', 'woo-product-price' => 'WooCommerce', 'woo-product-rating' => 'WooCommerce',
            'woo-product-short-description' => 'WooCommerce', 'woo-product-tabs' => 'WooCommerce', 'woo-product-title' => 'WooCommerce',
            // Forms
            'contact-form-7' => 'Forms', 'mailchimp' => 'Forms', 'gravity-forms' => 'Forms', 'ninja-forms' => 'Forms',
            'wp-forms' => 'Forms', 'fluent-form' => 'Forms', 'we-forms' => 'Forms', 'caldera-forms' => 'Forms',
            'formstack' => 'Forms', 'type-form' => 'Forms',
            // Social & Integrations
            'facebook-feed' => 'Social & Integrations', 'twitter-feed' => 'Social & Integrations', 'login-register' => 'Social & Integrations',
            'embed-press' => 'Social & Integrations', 'betterdocs-category-box' => 'Social & Integrations',
            'betterdocs-category-grid' => 'Social & Integrations', 'betterdocs-search-form' => 'Social & Integrations',
            'better-payment' => 'Social & Integrations',
        ];
    }

    private function get_category_meta()
    {
        return [
            'Content & Layout' => ['icon' => 'dashicons-layout', 'description' => 'General-purpose content and layout building block.'],
            'Media & Gallery' => ['icon' => 'dashicons-format-gallery', 'description' => 'Image, video, or gallery display widget.'],
            'Data & Stats' => ['icon' => 'dashicons-chart-bar', 'description' => 'Displays dynamic data, stats, or lists.'],
            'Team & Social Proof' => ['icon' => 'dashicons-groups', 'description' => 'Showcases people, pricing, or reviews.'],
            'WooCommerce' => ['icon' => 'dashicons-cart', 'description' => 'WooCommerce store widget (requires WooCommerce).'],
            'Forms' => ['icon' => 'dashicons-email-alt', 'description' => 'Form-plugin integration (requires the matching plugin).'],
            'Social & Integrations' => ['icon' => 'dashicons-share', 'description' => 'Third-party service or social integration.'],
            'Header & Footer' => ['icon' => 'dashicons-menu-alt', 'description' => 'Building block for the Header/Footer Builder.'],
            'Other' => ['icon' => 'dashicons-admin-generic', 'description' => 'Control the visibility of this widget.'],
        ];
    }

    private function load_widget_info()
    {
        $this->widgets = [];
        $folders = ['lc-kit', 'lc-header-footer'];
        $category_map = $this->get_category_map();
        $category_meta = $this->get_category_meta();

        foreach ($folders as $folder) {
            $path = LCAKE_EAK_PATH . 'includes/widgets/' . $folder . '/';
            if (!is_dir($path)) continue;

            // Find PHP files inside folder and subfolders
            $files = glob($path . '*.php');
            $subdir_files = glob($path . '*/*.php');
            $all_files = array_merge($files, $subdir_files);

            foreach ($all_files as $file) {
                $base  = basename($file, '.php'); // file name without .php
                $label = ucwords(str_replace(['-', '_'], ' ', $base)); // convert to "Accordion" style
                if ($base === 'twitter-feed') {
                    $label = 'X (Twitter) Feed';
                }

                // Composite ID: matches the enable-check in LCAKE_Kit_Widget_Loader::register_widgets(),
                // and disambiguates same-named files that exist in more than one folder (e.g. "post-grid").
                $id = $folder . ':' . $base;

                $category = 'lc-header-footer' === $folder
                    ? 'Header & Footer'
                    : ($category_map[$base] ?? 'Other');
                $meta = $category_meta[$category] ?? $category_meta['Other'];

                $plugin_name = '';
                $plugin_link = '';

                if ($category === 'WooCommerce') {
                    $plugin_name = 'WooCommerce';
                    $plugin_link = 'https://wordpress.org/plugins/woocommerce/';
                } elseif ($category === 'Forms') {
                    if ($base === 'contact-form-7') {
                        $plugin_name = 'Contact Form 7';
                        $plugin_link = 'https://wordpress.org/plugins/contact-form-7/';
                    } elseif ($base === 'mailchimp') {
                        $plugin_name = 'Mailchimp for WP';
                        $plugin_link = 'https://wordpress.org/plugins/mailchimp-for-wp/';
                    } elseif ($base === 'gravity-forms') {
                        $plugin_name = 'Gravity Forms';
                        $plugin_link = 'https://www.gravityforms.com/';
                    } elseif ($base === 'ninja-forms') {
                        $plugin_name = 'Ninja Forms';
                        $plugin_link = 'https://wordpress.org/plugins/ninja-forms/';
                    } elseif ($base === 'wp-forms') {
                        $plugin_name = 'WPForms';
                        $plugin_link = 'https://wordpress.org/plugins/wpforms-lite/';
                    } elseif ($base === 'fluent-form') {
                        $plugin_name = 'Fluent Forms';
                        $plugin_link = 'https://wordpress.org/plugins/fluentform/';
                    } elseif ($base === 'we-forms') {
                        $plugin_name = 'weForms';
                        $plugin_link = 'https://wordpress.org/plugins/weforms/';
                    } elseif ($base === 'caldera-forms') {
                        $plugin_name = 'Caldera Forms';
                        $plugin_link = 'https://wordpress.org/plugins/caldera-forms/';
                    } elseif ($base === 'formstack') {
                        $plugin_name = 'Formstack';
                        $plugin_link = 'https://www.formstack.com/';
                    } elseif ($base === 'type-form') {
                        $plugin_name = 'Typeform';
                        $plugin_link = 'https://www.typeform.com/';
                    }
                } elseif (strpos($base, 'betterdocs-') === 0) {
                    $plugin_name = 'BetterDocs';
                    $plugin_link = 'https://wordpress.org/plugins/betterdocs/';
                }

                $icon = 'eicon-editor-list-bullet'; // default fallback icon
                $file_content = file_get_contents($file);
                if ($file_content !== false) {
                    if (preg_match('/function\s+get_icon\s*\(\s*\)\s*\{?\s*return\s+[\'"]([^\'"]+)[\'"]/i', $file_content, $matches)) {
                        $icon = $matches[1];
                    }
                }

                $this->widgets[$id] = [
                    'id'          => $id,
                    'label'       => $label,
                    'description' => $meta['description'],
                    'icon'        => $icon,
                    'category'    => $category,
                    'plugin_name' => $plugin_name,
                    'plugin_link' => $plugin_link,
                ];
            }
        }

        // Sort widgets by category, then alphabetically by label within each category
        uasort($this->widgets, function ($a, $b) {
            return 0 !== ($cat_cmp = strcmp($a['category'], $b['category'])) ? $cat_cmp : strcmp($a['label'], $b['label']);
        });
    }

    public function add_settings_page()
    {
       
        add_menu_page('LC Kit', 'LC Kit', 'manage_options', $this->menu_slug, [$this, 'render_settings_page'], 'dashicons-screenoptions');
        $this->page_hook = add_submenu_page($this->menu_slug, 'LC Kit Widget Manager', 'Widget Manager', 'manage_options', $this->menu_slug, [$this, 'render_settings_page']);
    }

    public function remove_wordpress_notices()
    {
        if (isset($_GET['page']) && $_GET['page'] === $this->menu_slug) {
            remove_all_actions('admin_notices');
            remove_all_actions('all_admin_notices');
        }
    }

    public function register_settings()
    {
        register_setting('lcake_kit_settings_group', 'lcake_kit_enabled_widgets', ['type' => 'array', 'default' => []]);
    }

    public function register_rest_routes()
    {
        register_rest_route('lcake-kit/v1', '/save-settings', [
            'methods' => 'POST',
            'callback' => [$this, 'handle_save_settings_rest'],
            'permission_callback' => fn() => current_user_can('manage_options'),
        ]);
    }

    public function handle_save_settings_rest($request)
    {
        $enabled_widgets = $request->get_param('enabled_widgets');
        $sanitized_enabled = [];
        if (is_array($enabled_widgets)) {
            $all_widget_keys = array_keys($this->widgets);
            foreach ($enabled_widgets as $widget_class) {
                if (in_array(trim($widget_class), $all_widget_keys)) {
                    $sanitized_enabled[] = trim($widget_class);
                }
            }
        }
        update_option('lcake_kit_enabled_widgets', $sanitized_enabled);
        return new WP_REST_Response(['success' => true, 'message' => 'Settings saved successfully.'], 200);
    }

    public function enqueue_admin_assets($hook)
    {
        if ($hook !== $this->page_hook) return;

        $script_path = 'admin/build/index.js';
        $script_asset_path = dirname(__FILE__) . '/build/index.asset.php';
        $script_asset = file_exists($script_asset_path) ? require($script_asset_path) : ['dependencies' => ['wp-element'], 'version' => filemtime(LCAKE_EAK_PATH . $script_path)];

        // The wp_enqueue_script for react-beautiful-dnd has been removed as requested.

        wp_enqueue_script(
            'lcake-kit-react-app',
            LCAKE_EAK_URL . $script_path,
            $script_asset['dependencies'], // Dependency on dnd script is removed.
            $script_asset['version'],
            true
        );

        wp_enqueue_style(
            'lcake-kit-admin-styles',
            LCAKE_EAK_URL . 'admin/css/admin-styles.css',
            [],
            filemtime(LCAKE_EAK_PATH . 'admin/css/admin-styles.css')
        );

        wp_enqueue_style('elementor-icons');

        $enabled_widgets = get_option('lcake_kit_enabled_widgets', null);
        if ($enabled_widgets === null) {
            $enabled_widgets = array_keys($this->widgets);
        }

        wp_localize_script('lcake-kit-react-app', 'LCAKE_SETTINGS', [
            'all_widgets' => array_values($this->widgets),
            'enabled_widgets' => $enabled_widgets,
            'api_url' => rest_url('lcake-kit/v1/save-settings'),
            'nonce' => wp_create_nonce('wp_rest'),
        ]);
    }

    public function render_settings_page()
    {
?>
        <div class="wrap" id="lcake-kit-react-root">
            <p>Loading Widget Manager</p>
        </div>
<?php
    }
}
