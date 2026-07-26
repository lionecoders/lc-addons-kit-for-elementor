<?php
/**
 * Interactive Circle Widget
 *
 * @package LC_Elementor_Addons_Kit
 */

if (!defined('ABSPATH')) {
    exit;
}

class LCAKE_Kit_Interactive_Circle extends \Elementor\Widget_Base {

    public function get_name() {
        return 'lcake-kit-interactive-circle';
    }

    public function get_categories() {
        return ['lcake-page-kit'];
    }

    public function get_title() {
        return esc_html__('LC Interactive Circle', 'lc-addons-kit-for-elementor');
    }

    public function get_icon() {
        return 'eicon-counter-circle';
    }

    public function get_style_depends() {
        return ['lcake-kit-interactive-circle-css'];
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
            'icon',
            [
                'label' => esc_html__('Icon', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => ['value' => 'fas fa-heart', 'library' => 'fa-solid'],
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => esc_html__('Title', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Design', 'lc-addons-kit-for-elementor'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'link',
            [
                'label' => esc_html__('Link', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::URL,
                'default' => ['url' => ''],
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

        $this->add_responsive_control(
            'circle_size',
            [
                'label' => esc_html__('Size', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => ['px' => ['min' => 60, 'max' => 300]],
                'default' => ['size' => 140, 'unit' => 'px'],
                'selectors' => [
                    '{{WRAPPER}} .lcake-interactive-circle' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'circle_color',
            [
                'label' => esc_html__('Ring Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#3b82f6',
                'selectors' => ['{{WRAPPER}} .lcake-interactive-circle' => 'border-color: {{VALUE}};'],
            ]
        );

        $this->add_control(
            'circle_hover_background',
            [
                'label' => esc_html__('Hover Background', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#3b82f6',
                'selectors' => ['{{WRAPPER}} .lcake-interactive-circle:hover' => 'background-color: {{VALUE}};'],
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label' => esc_html__('Icon Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#3b82f6',
                'selectors' => [
                    '{{WRAPPER}} .lcake-interactive-circle-icon i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .lcake-interactive-circle-icon svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__('Title Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#111827',
                'selectors' => ['{{WRAPPER}} .lcake-interactive-circle-title' => 'color: {{VALUE}};'],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $link = $settings['link'] ?? [];
        $tag = !empty($link['url']) ? 'a' : 'div';

        if ('a' === $tag) {
            $this->add_link_attributes('link', $link);
        }
        $this->add_render_attribute('link', 'class', 'lcake-interactive-circle');
        ?>
        <<?php echo $tag; ?> <?php echo $this->get_render_attribute_string('link'); ?>>
            <span class="lcake-interactive-circle-icon">
                <?php \Elementor\Icons_Manager::render_icon($settings['icon'], ['aria-hidden' => 'true']); ?>
            </span>
            <?php if (!empty($settings['title'])) : ?>
                <span class="lcake-interactive-circle-title"><?php echo esc_html($settings['title']); ?></span>
            <?php endif; ?>
        </<?php echo $tag; ?>>
        <?php
    }
}
