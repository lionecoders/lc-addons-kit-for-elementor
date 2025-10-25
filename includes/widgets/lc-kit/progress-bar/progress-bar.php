<?php

/**
 * Progress Bar Widget
 * 
 * @package LC_Elementor_Addons_Kit
 */

if (!defined('ABSPATH')) {
    exit;
}

class LCAKE_Kit_Progress_Bar extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'lcake-kit-progress-bar';
    }

    public function get_title()
    {
        return esc_html__('Progress Bar', 'lc-addons-kit-for-elementor');
    }

    public function get_icon()
    {
        return 'eicon-lcake-bar';
    }

    public function get_categories()
    {
        return ['lcake-page-kit'];
    }

    public function get_keywords()
    {
        return ['progress', 'bar', 'skill', 'percentage', 'meter'];
    }

    public function get_script_depends()
    {
        return ['lcake-kit-progress-bar-js'];
    }

    public function get_style_depends()
    {
        return ['lcake-kit-progress-bar-css'];
    }

    protected function register_controls()
    {
        $this->start_controls_section(
            'lcake_progressbar_content',
            [
                'label' => esc_html__('Progress Bar', 'lc-addons-kit-for-elementor'),
            ]
        );

        $this->add_control(
            'lcake_progressbar_style',
            [
                'label' => esc_html__('Style', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '',
                'options' => [
                    '' => esc_html__('Default', 'lc-addons-kit-for-elementor'),
                    'inner-content skill-big' => esc_html__('Inner Content', 'lc-addons-kit-for-elementor'),
                    'skilltrack-style2' => esc_html__('Track Shadow', 'lc-addons-kit-for-elementor'),
                    'tooltip-style3' => esc_html__('Tooltip (Classic)', 'lc-addons-kit-for-elementor'),
                    'tooltip-style2' => esc_html__('Tooltip (Boxed)', 'lc-addons-kit-for-elementor'),
                    'tooltip-style' => esc_html__('Tooltip (Rounded)', 'lc-addons-kit-for-elementor'),
                    'pin-style' => esc_html__('Tooltip (Pin)', 'lc-addons-kit-for-elementor'),
                    'style-switch' => esc_html__('Switch', 'lc-addons-kit-for-elementor'),
                    'style-ribbon' => esc_html__('Ribbon', 'lc-addons-kit-for-elementor'),
                    'style-stripe skill-medium tooltip-style' => esc_html__('Striped', 'lc-addons-kit-for-elementor'),
                ],
            ]
        );

        $this->add_control(
            'lcake_progressbar_icons',
            [
                'label'         => esc_html__('Add Icon', 'lc-addons-kit-for-elementor'),
                'label_block'   => true,
                'type'          => \Elementor\Controls_Manager::ICONS,
                'fa4compatibility' => 'lcake_progressbar_icon',
                'default' => [
                    'value' => 'icon icon-arrow-right',
                    'library' => 'lcakeicons',
                ],
                'condition' => [
                    'lcake_progressbar_style' => ['inner-content skill-big'],
                ],
            ]
        );


        $this->add_control(
            'lcake_progressbar_title',
            [
                'label'         => esc_html__('Title', 'lc-addons-kit-for-elementor'),
                'label_block'   => true,
                'type'          => \Elementor\Controls_Manager::TEXT,
                'dynamic'         => [
                    'active' => true,
                ],
                'default'       => 'WordPress',
            ]
        );

        $this->add_control(
            'lcake_progressbar_percentage',
            [
                'label'     => esc_html__('Percentage', 'lc-addons-kit-for-elementor'),
                'type'      => \Elementor\Controls_Manager::NUMBER,
                'dynamic'     => [
                    'active' => true,
                ],
                'min'       => 1,
                'max'       => 100,
                'step'      => 1,
                'default'   => 90,
            ]
        );

        $this->add_control(
            'lcake_progressbar_percentage_show',
            [
                'label' => esc_html__('Hide Percentage Number? ', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'no',
                'return_value' => 'none',
                'label_on' => esc_html__('Yes', 'lc-addons-kit-for-elementor'),
                'label_off' => esc_html__('No', 'lc-addons-kit-for-elementor'),
                'selectors' => [
                    '{{WRAPPER}} .lcake-bar-group .lcake-percentage-wrapper' => 'display: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'lcake_progressbar_data_duration',
            [
                'label'     => esc_html__('Animation Duration', 'lc-addons-kit-for-elementor'),
                'type'      => \Elementor\Controls_Manager::SLIDER,
                'dynamic'     => [
                    'active' => true,
                ],
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 10000,
                        'step' => 5,
                    ],

                ],
                'default' => [
                    'size' => 3500,
                ],

            ]
        );

        $this->end_controls_section();


        // Bar Styles
        $this->start_controls_section(
            'lcake_progressbar_bar_style',
            [
                'label' => esc_html__('Bar', 'lc-addons-kit-for-elementor'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name'      => 'lcake_progressbar_background',
                'label'     => esc_html__('Background', 'lc-addons-kit-for-elementor'),
                'types'     => ['classic', 'gradient'],
                'selector'  => '{{WRAPPER}} .lcake-bar-group .lcake-bar',
                'default'   => '#f5f5f5'
            ]
        );

        $this->add_responsive_control(
            'lcake_progressbar_bar_height',
            [
                'label'         => esc_html__('Height', 'lc-addons-kit-for-elementor'),
                'type'          => \Elementor\Controls_Manager::SLIDER,
                'size_units'    => ['px', 'em'],
                'range'  => [
                    'px' => [
                        'min'   => 1,
                        'max'   => 200,
                    ],
                ],
                'separator'  => 'before',
                'condition' => [
                    'lcake_progressbar_style!' => ['style-switch'],
                ],
                'selectors' => [
                    '{{WRAPPER}} .lcake-bar-group .lcake-bar' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'lcake_progressbar_bar_shadow',
                'label' => esc_html__('Shadow', 'lc-addons-kit-for-elementor'),
                'selector' => '{{WRAPPER}} .lcake-bar-group .lcake-bar',
            ]
        );

        $this->add_responsive_control(
            'lcake_progressbar_bar_radius',
            [
                'label'      => esc_html__('Border Radius', 'lc-addons-kit-for-elementor'),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .lcake-bar-group .lcake-bar' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'lcake_progressbar_bar_padding',
            [
                'label'      => esc_html__('Padding', 'lc-addons-kit-for-elementor'),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'condition' => [
                    'lcake_progressbar_style!' => ['style-switch'],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .lcake-bar-group .lcake-bar' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'lcake_progressbar_bar_margin',
            [
                'label'      => esc_html__('Margin Bottom', 'lc-addons-kit-for-elementor'),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units'    => ['px', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .lcake-bar-group .lcake-bar' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],

            ]
        );

        $this->end_controls_section();


        // Track Styles
        $this->start_controls_section(
            'lcake_progressbar_track_style',
            [
                'label'  => esc_html__('Track', 'lc-addons-kit-for-elementor'),
                'tab'    => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name'      => 'lcake_progressbar_track_color',
                'label'     => esc_html__('Track Color', 'lc-addons-kit-for-elementor'),
                'types'     => ['classic', 'gradient'],

                'condition' => [
                    'lcake_progressbar_style!' => ['style-stripe skill-medium tooltip-style'],
                ],
                'selector'  => '{{WRAPPER}} .lcake-bar-group .lcake-bar-track',
            ]
        );
        //lcake_progressbar_style style-stripe skill-medium tooltip-style
        $this->add_responsive_control(
            'lcake_progressbar_strip_color',
            [
                'label'      => esc_html__('Stripe Color', 'lc-addons-kit-for-elementor'),
                'type'       => \Elementor\Controls_Manager::COLOR,
                'condition' => [
                    'lcake_progressbar_style' => ['style-stripe skill-medium tooltip-style'],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .style-stripe .lcake-single-skill-bar .lcake-bar-track' => 'background: repeating-linear-gradient(to right, {{VALUE}}, {{VALUE}} 4px, #FFFFFF 4px, #FFFFFF 8px);',
                ],

            ]
        );

        $this->add_responsive_control(
            'lcake_progressbar_switch_color',
            [
                'label'      => esc_html__('Switch Color', 'lc-addons-kit-for-elementor'),
                'type'       => \Elementor\Controls_Manager::COLOR,
                'condition' => [
                    'lcake_progressbar_style' => ['style-switch'],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .lcake-bar-group .lcake-single-skill-bar .lcake-bar-track:before' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} .lcake-bar-group .lcake-single-skill-bar .lcake-bar-track:after' => 'color: {{VALUE}};'
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'lcake_progressbar_track_shadow',
                'label' => esc_html__('Shadow', 'lc-addons-kit-for-elementor'),
                'selector' => '{{WRAPPER}} .lcake-bar-group .lcake-bar-track',
            ]
        );

        $this->add_responsive_control(
            'lcake_progressbar_track_radius',
            [
                'label'      => esc_html__('Border Radius', 'lc-addons-kit-for-elementor'),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .lcake-bar-group .lcake-bar-track' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();


        // Title Styles
        $this->start_controls_section(
            'lcake_progressbar_title_style',
            [
                'label' => esc_html__('Title', 'lc-addons-kit-for-elementor'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'lcake_progressbar_title_color',
            [
                'label'      => esc_html__('Color', 'lc-addons-kit-for-elementor'),
                'type'       => \Elementor\Controls_Manager::COLOR,
                'selectors'  => [
                    '{{WRAPPER}} .lcake-bar-group .lcake-skill-title' => 'color: {{VALUE}};'
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'       => 'lcake_progressbar_title_typography',
                'selector'   => '{{WRAPPER}} .lcake-bar-group .lcake-skill-title',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Text_Shadow::get_type(),
            [
                'name'       => 'lcake_progressbar_title_shadow',
                'selector'   => '{{WRAPPER}} .lcake-bar-group .lcake-skill-title',
            ]
        );

        $this->add_responsive_control(
            'lcake_progressbar_margin_bottom',
            [
                'type'          => \Elementor\Controls_Manager::SLIDER,
                'label'         => esc_html__('Margin Bottom', 'lc-addons-kit-for-elementor'),
                'size_units'    => ['px'],
                'range'  => [
                    'px' => [
                        'min'   => 1,
                        'max'   => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .lcake-bar-content' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();


        // Percent Styles
        $this->start_controls_section(
            'lcake_progressbar_percent_style',
            [
                'label' => esc_html__('Percent', 'lc-addons-kit-for-elementor'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'lcake_progressbar_percent_color',
            [
                'label'      => esc_html__('Color', 'lc-addons-kit-for-elementor'),
                'type'       => \Elementor\Controls_Manager::COLOR,
                'selectors'  => [
                    '{{WRAPPER}} .lcake-bar-group .lcake-percentage-wrapper' => 'color: {{VALUE}};'
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'       => 'lcake_progressbar_percent_typography',
                'selector'   => '{{WRAPPER}} .lcake-bar-group .lcake-percentage-wrapper',
            ]
        );

        $this->add_responsive_control(
            'lcake_progressbar_percent_tooltip_bg',
            [
                'label'      => esc_html__('Background Color', 'lc-addons-kit-for-elementor'),
                'type'       => \Elementor\Controls_Manager::COLOR,
                'condition' => [
                    'lcake_progressbar_style' => ['tooltip-style', 'style-stripe skill-medium tooltip-style'],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .lcake-bar-group .lcake-single-skill-bar .svg-content > svg' => 'fill: {{VALUE}};'
                ],
            ]
        );

        $this->add_responsive_control(
            'lcake_progressbar_percent_pin_bg',
            [
                'label'      => esc_html__('Background Color', 'lc-addons-kit-for-elementor'),
                'type'       => \Elementor\Controls_Manager::COLOR,
                'condition' => [
                    'lcake_progressbar_style' => ['style-ribbon', 'pin-style', 'tooltip-style2', 'tooltip-style3'],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .lcake-bar-group .lcake-single-skill-bar .lcake-percentage-wrapper,
                    {{WRAPPER}} .lcake-bar-group.pin-style .lcake-single-skill-bar .lcake-percentage-wrapper:before' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .lcake-bar-group .lcake-single-skill-bar .lcake-percentage-wrapper:before' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Text_Shadow::get_type(),
            [
                'name'       => 'lcake_progressbar_percent_shadow',
                'selector'   => '{{WRAPPER}} .lcake-bar-group .lcake-percentage-wrapper',
            ]
        );

        $this->end_controls_section();

        // Icon Styles
        $this->start_controls_section(
            'lcake_progressbar_icon_style',
            [
                'label' => esc_html__('Icon', 'lc-addons-kit-for-elementor'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'lcake_progressbar_style!' => '',
                    'lcake_progressbar_style' => 'inner-content skill-big'
                ]
            ]
        );

        $this->add_responsive_control(
            'lcake_progressbar_icon_color',
            [
                'label'      => esc_html__('Color', 'lc-addons-kit-for-elementor'),
                'type'       => \Elementor\Controls_Manager::COLOR,
                'selectors'  => [
                    '{{WRAPPER}} .lcake-bar-group .bar-track > span i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .lcake-bar-group .lcake-bar-track > span svg path'  => 'stroke: {{VALUE}}; fill: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'lcake_progressbar_icon_typography',
            [
                'type'          => \Elementor\Controls_Manager::SLIDER,
                'label'         => esc_html__('Icon Size', 'lc-addons-kit-for-elementor'),
                'size_units'    => ['px', 'em'],
                'range'  => [
                    'px' => [
                        'min'   => 1,
                        'max'   => 200,
                    ],
                ],
                'default' => ['unit' => 'px', 'size' => '15'],
                'selectors' => [
                    '{{WRAPPER}} .lcake-bar-group .bar-track > span i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .lcake-bar-group .bar-track > span svg'   => 'max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

    }

    protected function render()
    {
        echo '<div class="lcake-main-wrapper" >';
        $this->render_raw();
        echo '</div>';
    }

    protected function render_raw()
    {
        $settings = $this->get_settings_for_display();
        extract($settings);

?>
        <div class="lcake-bar-trigger">
            <div class="lcake-bar-group <?php echo esc_attr($lcake_progressbar_style); ?>" data-progress-bar="">
                <div class="lcake-single-skill-bar">
                    <?php if ('style-switch' != $lcake_progressbar_style): ?>
                        <div class="lcake-bar-content">
                            <span class="lcake-skill-title"><?php echo esc_html($lcake_progressbar_title); ?></span>
                        </div>

                        <div class="lcake-bar">
                            <div class="lcake-bar-track">
                                <?php if ('inner-content skill-big' == $lcake_progressbar_style):

                                    // new icon
                                    $migrated = isset($settings['__fa4_migrated']['lcake_progressbar_icons']);
                                    $is_new = empty($settings['lcake_progressbar_icon']);
                                ?>

                                    <span class="lcake-bar-icon">
                                        <?php
                                        if ($is_new || $migrated) {
                                            \Elementor\Icons_Manager::render_icon($settings['lcake_progressbar_icons'], ['aria-hidden' => 'true']);
                                        } else {
                                        ?>
                                            <i class="<?php echo esc_attr($settings['lcake_progressbar_icon']); ?>" aria-hidden="true"></i>
                                        <?php
                                        }
                                        ?>
                                    </span>
                                <?php endif; ?>

                                <div class="lcake-percentage-wrapper">
                                    <span class="lcake-number-percentage" data-value="<?php echo esc_attr($lcake_progressbar_percentage); ?>" data-animation-duration="<?php echo esc_attr($lcake_progressbar_data_duration['size']); ?>">0</span>%

                                    <?php if ('tooltip-style' == $lcake_progressbar_style): ?>
                                        <div class="lcake-svg-content">
                                            <svg version="1.1" xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" preserveAspectRatio="none" viewBox="0 0 116 79.6">
                                                <g>
                                                    <path d="M0,18.3v21.3C0,49.8,8.2,58,18.3,58h5.9c7.8,0,15.3,3.1,20.8,8.6l13,13l13-13c5.5-5.5,13-8.6,20.8-8.6h5.9 c10.1,0,18.3-8.2,18.3-18.3V18.3C116,8.2,107.8,0,97.7,0H18.3C8.2,0,0,8.2,0,18.3z" />
                                                </g>
                                            </svg>
                                        </div>
                                    <?php elseif ('style-stripe skill-medium tooltip-style' == $lcake_progressbar_style): ?>
                                        <div class="lcake-svg-content">
                                            <svg version="1.1" xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" preserveAspectRatio="none" viewBox="0 0 116 79.6">
                                                <g>
                                                    <path d="M0,18.3v21.3C0,49.8,8.2,58,18.3,58h5.9c7.8,0,15.3,3.1,20.8,8.6l13,13l13-13c5.5-5.5,13-8.6,20.8-8.6h5.9 c10.1,0,18.3-8.2,18.3-18.3V18.3C116,8.2,107.8,0,97.7,0H18.3C8.2,0,0,8.2,0,18.3z" />
                                                </g>
                                            </svg>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="lcake-content-group">
                            <div class="lcake-bar-content">
                                <span class="lcake-skill-title"><?php echo esc_html($lcake_progressbar_title); ?></span>
                            </div>

                            <div class="lcake-bar">
                                <div class="lcake-bar-track"></div>
                            </div>
                        </div>

                        <span class="lcake-percentage-wrapper">
                            <span class="lcake-number-percentage" data-value="<?php echo esc_attr($lcake_progressbar_percentage); ?>" data-animation-duration="<?php echo esc_attr($lcake_progressbar_data_duration['size']); ?>">0</span>%
                        </span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
<?php
    }
}
