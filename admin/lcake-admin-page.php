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

    private function load_widget_info()
    {
        $this->widgets = [];
        $folders = ['lc-kit']; // add more folders if needed

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

                $this->widgets[$base] = [
                    'id'          => $base,
                    'label'       => $label,
                    'description' => 'Control the visibility of this widget.',
                    'icon'        => 'dashicons-admin-generic',
                    'is_pro'      => (strpos($base, 'pro') !== false),
                ];
            }
        }

        // Sort widgets alphabetically by label
        uasort($this->widgets, fn($a, $b) => strcmp($a['label'], $b['label']));
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
            '3.0.0'
        );

        wp_localize_script('lcake-kit-react-app', 'LCAKE_SETTINGS', [
            'all_widgets' => array_values($this->widgets),
            'enabled_widgets' => get_option('lcake_kit_enabled_widgets', []),
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
