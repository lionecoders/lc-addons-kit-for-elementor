<?php
/**
 * Flip Box Widget
 *
 * @package LC_Elementor_Addons_Kit
 */

if (!defined('ABSPATH')) {
    exit;
}

class LCAKE_Kit_Flip_Box extends \Elementor\Widget_Base {

    public function get_name() {
        return 'lcake-kit-flip-box';
    }

    public function get_categories() {
        return ['lcake-page-kit'];
    }

    public function get_title() {
        return esc_html__('LC Flip Box', 'lc-addons-kit-for-elementor');
    }

    public function get_icon() {
        return 'eicon-flip-box';
    }

    public function get_style_depends() {
        return ['lcake-kit-flip-box-css'];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'section_front',
            [
                'label' => esc_html__('Front Side', 'lc-addons-kit-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'front_icon',
            [
                'label' => esc_html__('Icon', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => ['value' => 'fas fa-star', 'library' => 'fa-solid'],
            ]
        );

        $this->add_control(
            'front_title',
            [
                'label' => esc_html__('Title', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Front Title', 'lc-addons-kit-for-elementor'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'front_description',
            [
                'label' => esc_html__('Description', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => esc_html__('Hover over this box to reveal more information.', 'lc-addons-kit-for-elementor'),
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_back',
            [
                'label' => esc_html__('Back Side', 'lc-addons-kit-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'back_title',
            [
                'label' => esc_html__('Title', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Back Title', 'lc-addons-kit-for-elementor'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'back_description',
            [
                'label' => esc_html__('Description', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'lc-addons-kit-for-elementor'),
            ]
        );

        $this->add_control(
            'back_button_text',
            [
                'label' => esc_html__('Button Text', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Learn More', 'lc-addons-kit-for-elementor'),
            ]
        );

        $this->add_control(
            'back_button_link',
            [
                'label' => esc_html__('Button Link', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => esc_html__('https://your-link.com', 'lc-addons-kit-for-elementor'),
                'default' => ['url' => '', 'is_external' => false, 'nofollow' => false],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_settings',
            [
                'label' => esc_html__('Settings', 'lc-addons-kit-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'flip_direction',
            [
                'label' => esc_html__('Flip Direction', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'left',
                'options' => [
                    'left' => esc_html__('Left to Right', 'lc-addons-kit-for-elementor'),
                    'top' => esc_html__('Top to Bottom', 'lc-addons-kit-for-elementor'),
                ],
                'prefix_class' => 'lcake-flip-box--',
            ]
        );

        $this->add_responsive_control(
            'box_height',
            [
                'label' => esc_html__('Height', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => ['px' => ['min' => 150, 'max' => 600]],
                'default' => ['size' => 280, 'unit' => 'px'],
                'selectors' => [
                    '{{WRAPPER}} .lcake-flip-box' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_box',
            [
                'label' => esc_html__('Box Style', 'lc-addons-kit-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'front_background',
            [
                'label' => esc_html__('Front Background', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => ['{{WRAPPER}} .lcake-flip-box-front' => 'background-color: {{VALUE}};'],
            ]
        );

        $this->add_control(
            'back_background',
            [
                'label' => esc_html__('Back Background', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#3b82f6',
                'selectors' => ['{{WRAPPER}} .lcake-flip-box-back' => 'background-color: {{VALUE}};'],
            ]
        );

        $this->add_control(
            'box_border_radius',
            [
                'label' => esc_html__('Border Radius', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'default' => ['top' => '24', 'right' => '24', 'bottom' => '24', 'left' => '24', 'unit' => 'px', 'isLinked' => true],
                'selectors' => [
                    '{{WRAPPER}} .lcake-flip-box-front, {{WRAPPER}} .lcake-flip-box-back' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'box_shadow',
                'selector' => '{{WRAPPER}} .lcake-flip-box-front, {{WRAPPER}} .lcake-flip-box-back',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_front_content',
            [
                'label' => esc_html__('Front Content', 'lc-addons-kit-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'front_icon_color',
            [
                'label' => esc_html__('Icon Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#3b82f6',
                'selectors' => [
                    '{{WRAPPER}} .lcake-flip-box-front i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .lcake-flip-box-front svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'front_icon_size',
            [
                'label' => esc_html__('Icon Size', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => ['px' => ['min' => 10, 'max' => 150]],
                'default' => ['size' => 50, 'unit' => 'px'],
                'selectors' => [
                    '{{WRAPPER}} .lcake-flip-box-front i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .lcake-flip-box-front svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'front_title_color',
            [
                'label' => esc_html__('Title Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#111827',
                'selectors' => ['{{WRAPPER}} .lcake-flip-box-front .lcake-flip-box-title' => 'color: {{VALUE}};'],
            ]
        );

        $this->add_control(
            'front_description_color',
            [
                'label' => esc_html__('Description Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#6b7280',
                'selectors' => ['{{WRAPPER}} .lcake-flip-box-front .lcake-flip-box-description' => 'color: {{VALUE}};'],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_back_content',
            [
                'label' => esc_html__('Back Content', 'lc-addons-kit-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'back_title_color',
            [
                'label' => esc_html__('Title Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => ['{{WRAPPER}} .lcake-flip-box-back .lcake-flip-box-title' => 'color: {{VALUE}};'],
            ]
        );

        $this->add_control(
            'back_description_color',
            [
                'label' => esc_html__('Description Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => 'rgba(255,255,255,0.85)',
                'selectors' => ['{{WRAPPER}} .lcake-flip-box-back .lcake-flip-box-description' => 'color: {{VALUE}};'],
            ]
        );

        $this->add_control(
            'back_button_color',
            [
                'label' => esc_html__('Button Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#3b82f6',
                'selectors' => ['{{WRAPPER}} .lcake-flip-box-button' => 'color: {{VALUE}};'],
            ]
        );

        $this->add_control(
            'back_button_background',
            [
                'label' => esc_html__('Button Background', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => ['{{WRAPPER}} .lcake-flip-box-button' => 'background-color: {{VALUE}};'],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $back_link = $settings['back_button_link'] ?? [];

        if (!empty($back_link['url'])) {
            $this->add_link_attributes('back_button_link', $back_link);
        }
        $this->add_render_attribute('back_button_link', 'class', 'lcake-flip-box-button');
        ?>
        <div class="lcake-flip-box">
            <div class="lcake-flip-box-inner">
                <div class="lcake-flip-box-front">
                    <?php if (!empty($settings['front_icon']['value'])) : ?>
                        <div class="lcake-flip-box-icon">
                            <?php \Elementor\Icons_Manager::render_icon($settings['front_icon'], ['aria-hidden' => 'true']); ?>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($settings['front_title'])) : ?>
                        <h3 class="lcake-flip-box-title"><?php echo wp_kses_post($settings['front_title']); ?></h3>
                    <?php endif; ?>
                    <?php if (!empty($settings['front_description'])) : ?>
                        <div class="lcake-flip-box-description"><?php echo wp_kses_post($settings['front_description']); ?></div>
                    <?php endif; ?>
                </div>
                <div class="lcake-flip-box-back">
                    <?php if (!empty($settings['back_title'])) : ?>
                        <h3 class="lcake-flip-box-title"><?php echo wp_kses_post($settings['back_title']); ?></h3>
                    <?php endif; ?>
                    <?php if (!empty($settings['back_description'])) : ?>
                        <div class="lcake-flip-box-description"><?php echo wp_kses_post($settings['back_description']); ?></div>
                    <?php endif; ?>
                    <?php if (!empty($settings['back_button_text'])) : ?>
                        <a <?php echo $this->get_render_attribute_string('back_button_link'); ?>>
                            <?php echo esc_html($settings['back_button_text']); ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php
    }
}
