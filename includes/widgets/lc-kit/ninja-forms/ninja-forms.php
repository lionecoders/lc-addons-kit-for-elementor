<?php
/**
 * Ninja Forms Widget
 *
 * @package LC_Elementor_Addons_Kit
 */

if (!defined('ABSPATH')) {
    exit;
}

class LCAKE_Kit_Ninja_Forms extends \Elementor\Widget_Base {

    public function get_name() {
        return 'lcake-kit-ninja-forms';
    }

    public function get_categories() {
        return ['lcake-page-kit'];
    }

    public function get_title() {
        return esc_html__('LC Ninja Forms', 'lc-addons-kit-for-elementor');
    }

    public function get_icon() {
        return 'eicon-form-horizontal';
    }

    public function get_style_depends() {
        return ['lcake-kit-ninja-forms-css'];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Content', 'lc-addons-kit-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'form_id',
            [
                'label' => esc_html__('Select Form', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => LCAKE_Kit_Utils::lcake_get_ninja_form(),
                'default' => 0,
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        if (!class_exists('Ninja_Forms')) {
            LCAKE_Kit_Utils::plugin_inactive_notice('Ninja Forms');
            return;
        }

        $settings = $this->get_settings_for_display();

        if (empty($settings['form_id'])) {
            return;
        }
        ?>
        <div class="lcake-ninja-forms">
            <?php echo do_shortcode('[ninja_form id="' . (int) $settings['form_id'] . '"]'); ?>
        </div>
        <?php
    }
}
