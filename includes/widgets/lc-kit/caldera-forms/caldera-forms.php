<?php
/**
 * Caldera Forms Widget
 *
 * @package LC_Elementor_Addons_Kit
 */

if (!defined('ABSPATH')) {
    exit;
}

class LCAKE_Kit_Caldera_Forms extends \Elementor\Widget_Base {

    public function get_name() {
        return 'lcake-kit-caldera-forms';
    }

    public function get_categories() {
        return ['lcake-page-kit'];
    }

    public function get_title() {
        return esc_html__('LC Caldera Forms', 'lc-addons-kit-for-elementor');
    }

    public function get_icon() {
        return 'eicon-form-horizontal';
    }

    public function get_style_depends() {
        return ['lcake-kit-caldera-forms-css'];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Content', 'lc-addons-kit-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $options = [0 => esc_html__('Select Form', 'lc-addons-kit-for-elementor')];
        if (class_exists('Caldera_Forms')) {
            $forms = get_option('caldera_forms', []);
            if (is_array($forms)) {
                foreach ($forms as $form) {
                    if (!empty($form['ID']) && !empty($form['name'])) {
                        $options[$form['ID']] = $form['name'];
                    }
                }
            }
        }

        $this->add_control(
            'form_id',
            [
                'label' => esc_html__('Select Form', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => $options,
                'default' => 0,
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        if (!class_exists('Caldera_Forms')) {
            LCAKE_Kit_Utils::plugin_inactive_notice('Caldera Forms');
            return;
        }

        $settings = $this->get_settings_for_display();

        if (empty($settings['form_id'])) {
            return;
        }
        ?>
        <div class="lcake-caldera-forms">
            <?php echo do_shortcode('[caldera_form id="' . sanitize_text_field($settings['form_id']) . '"]'); ?>
        </div>
        <?php
    }
}
