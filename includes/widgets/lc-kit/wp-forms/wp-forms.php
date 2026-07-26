<?php
/**
 * WPForms Widget
 *
 * @package LC_Elementor_Addons_Kit
 */

if (!defined('ABSPATH')) {
    exit;
}

class LCAKE_Kit_Wp_Forms extends \Elementor\Widget_Base {

    public function get_name() {
        return 'lcake-kit-wp-forms';
    }

    public function get_categories() {
        return ['lcake-page-kit'];
    }

    public function get_title() {
        return esc_html__('LC WPForms', 'lc-addons-kit-for-elementor');
    }

    public function get_icon() {
        return 'eicon-form-horizontal';
    }

    public function get_style_depends() {
        return ['lcake-kit-wp-forms-css'];
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
                'options' => LCAKE_Kit_Utils::lcake_get_wpforms(),
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

        $this->end_controls_section();
    }

    protected function render() {
        if (!function_exists('wpforms')) {
            LCAKE_Kit_Utils::plugin_inactive_notice('WPForms');
            return;
        }

        $settings = $this->get_settings_for_display();

        if (empty($settings['form_id'])) {
            return;
        }
        ?>
        <div class="lcake-wp-forms">
            <?php echo do_shortcode(sprintf(
                '[wpforms id="%d" title="%s"]',
                (int) $settings['form_id'],
                'yes' === $settings['show_title'] ? 'true' : 'false'
            )); ?>
        </div>
        <?php
    }
}
