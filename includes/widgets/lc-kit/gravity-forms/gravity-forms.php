<?php
/**
 * Gravity Forms Widget
 *
 * @package LC_Elementor_Addons_Kit
 */

if (!defined('ABSPATH')) {
    exit;
}

class LCAKE_Kit_Gravity_Forms extends \Elementor\Widget_Base {

    public function get_name() {
        return 'lcake-kit-gravity-forms';
    }

    public function get_categories() {
        return ['lcake-page-kit'];
    }

    public function get_title() {
        return esc_html__('LC Gravity Forms', 'lc-addons-kit-for-elementor');
    }

    public function get_icon() {
        return 'eicon-form-horizontal';
    }

    public function get_style_depends() {
        return ['lcake-kit-gravity-forms-css'];
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
                'options' => LCAKE_Kit_Utils::lcake_get_gravity_forms(),
                'default' => 0,
            ]
        );

        $this->add_control(
            'show_title',
            [
                'label' => esc_html__('Show Form Title', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => '',
            ]
        );

        $this->add_control(
            'show_description',
            [
                'label' => esc_html__('Show Form Description', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => '',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        if (!class_exists('GFForms')) {
            LCAKE_Kit_Utils::plugin_inactive_notice('Gravity Forms');
            return;
        }

        $settings = $this->get_settings_for_display();

        if (empty($settings['form_id'])) {
            return;
        }
        ?>
        <div class="lcake-gravity-forms">
            <?php echo do_shortcode(sprintf(
                '[gravityform id="%d" title="%s" description="%s" ajax="true"]',
                (int) $settings['form_id'],
                'yes' === $settings['show_title'] ? 'true' : 'false',
                'yes' === $settings['show_description'] ? 'true' : 'false'
            )); ?>
        </div>
        <?php
    }
}
