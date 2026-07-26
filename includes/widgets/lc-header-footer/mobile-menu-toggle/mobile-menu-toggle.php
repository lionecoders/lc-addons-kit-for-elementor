<?php
/**
 * Mobile Menu Toggle Widget
 *
 * @package LC_Elementor_Addons_Kit
 */

if (!defined('ABSPATH')) {
    exit;
}

class LC_Header_Footer_Mobile_Menu_Toggle extends \Elementor\Widget_Base {

    public function get_name() {
        return 'lc-header-footer-mobile-menu-toggle';
    }

    public function get_title() {
        return esc_html__('Mobile Menu Toggle', 'lc-addons-kit-for-elementor');
    }

    public function get_icon() {
        return 'eicon-menu-bar';
    }

    public function get_categories() {
        return ['lc-header-footer-kit1'];
    }

    public function get_style_depends() {
        return ['lc-header-footer-mobile-menu-toggle-css'];
    }

    public function get_script_depends() {
        return ['lc-header-footer-mobile-menu-toggle-js'];
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
            'notice',
            [
                'type' => \Elementor\Controls_Manager::RAW_HTML,
                'raw' => esc_html__('Toggles the "lcake-mobile-menu-open" class on <body>. Pair this with the Nav Menu widget on the same header template — it hides/shows automatically below its collapse breakpoint.', 'lc-addons-kit-for-elementor'),
                'content_classes' => 'elementor-descriptor',
            ]
        );

        $this->add_responsive_control(
            'breakpoint',
            [
                'label' => esc_html__('Show Toggle Below (px)', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 800,
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style',
            [
                'label' => esc_html__('Style', 'lc-addons-kit-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'bar_color',
            [
                'label' => esc_html__('Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#111827',
                'selectors' => ['{{WRAPPER}} .lc-hf-menu-toggle-bar' => 'background-color: {{VALUE}};'],
            ]
        );

        $this->add_responsive_control(
            'toggle_size',
            [
                'label' => esc_html__('Size', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => ['px' => ['min' => 20, 'max' => 60]],
                'default' => ['size' => 28, 'unit' => 'px'],
                'selectors' => ['{{WRAPPER}} .lc-hf-menu-toggle' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};'],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $breakpoint = !empty($settings['breakpoint']) ? (int) $settings['breakpoint'] : 800;
        ?>
        <button type="button" class="lc-hf-menu-toggle" data-breakpoint="<?php echo esc_attr($breakpoint); ?>" aria-label="<?php echo esc_attr__('Toggle menu', 'lc-addons-kit-for-elementor'); ?>" aria-expanded="false">
            <span class="lc-hf-menu-toggle-bar"></span>
            <span class="lc-hf-menu-toggle-bar"></span>
            <span class="lc-hf-menu-toggle-bar"></span>
        </button>
        <?php
    }
}
