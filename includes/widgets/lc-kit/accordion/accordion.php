<?php
/**
 * Accordion Widget
 * 
 * @package LC_Elementor_Addons_Kit
 */

if (!defined('ABSPATH')) {
    exit;
}

class LCAKE_Kit_Accordion extends \Elementor\Widget_Base {

    public function get_name() {
        return 'lcake-kit-accordion';
    }

    public function get_title() {
        return esc_html__('Accordion', 'lc-addons-kit-for-elementor');
    }

    public function get_script_depends() {
        return ['lcake-kit-accordion'];
    }
    
    public function get_style_depends() {
        return ['lcake-kit-accordion'];
    }

    public function get_icon() {
        return 'eicon-accordion';
    }

    public function get_categories() {
        return ['lcake-page-kit'];
    }

    public function get_keywords() {
        return ['accordion', 'tabs', 'toggle', 'collapsible', 'faq'];
    }

    protected function register_controls() {
        $this->add_content_controls();
        $this->add_style_controls();
    }

    protected function add_content_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Content', 'lc-addons-kit-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'title',
            [
                'label' => esc_html__('Title', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Accordion Title', 'lc-addons-kit-for-elementor'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'content',
            [
                'label' => esc_html__('Content', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::WYSIWYG,
                'default' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'lc-addons-kit-for-elementor'),
                'show_label' => false,
            ]
        );

        $repeater->add_control(
            'icon',
            [
                'label' => esc_html__('Icon', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-plus',
                    'library' => 'fa-solid',
                ],
            ]
        );

        $repeater->add_control(
            'active_icon',
            [
                'label' => esc_html__('Active Icon', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-minus',
                    'library' => 'fa-solid',
                ],
            ]
        );

        $this->add_control(
            'accordion_items',
            [
                'label' => esc_html__('Accordion Items', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'title' => esc_html__('How do I start using WordPress?', 'lc-addons-kit-for-elementor'),
                        'content' => esc_html__('You can start by choosing a domain, getting web hosting, and installing WordPress with one click from most hosting dashboards', 'lc-addons-kit-for-elementor'),
                    ],
                    [
                        'title' => esc_html__('Can I build a website without coding in WordPress?', 'lc-addons-kit-for-elementor'),
                        'content' => esc_html__('Yes! WordPress has drag-and-drop builders like Elementor that let you build websites visually, without writing code.', 'lc-addons-kit-for-elementor'),
                    ],
                    [
                        'title' => esc_html__('What are WordPress themes and plugins?', 'lc-addons-kit-for-elementor'),
                        'content' => esc_html__('Themes control your website’s design, and plugins add new features like contact forms, galleries, SEO tools, and more.', 'lc-addons-kit-for-elementor'),
                    ],
                    [
                        'title' => esc_html__('How can I learn WordPress faster?', 'lc-addons-kit-for-elementor'),
                        'content' => esc_html__('Start by exploring the WordPress dashboard, watching tutorials on YouTube, or trying small changes like editing pages and posts.', 'lc-addons-kit-for-elementor'),
                    ],
                ],
                'title_field' => '{{{ title }}}',
            ]
        );

        $this->add_control(
            'active_item',
            [
                'label' => esc_html__('Active Item', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 10,
                'default' => 1,
                'description' => esc_html__('Enter the item number to open by default.', 'lc-addons-kit-for-elementor'),
            ]
        );

        $this->add_control(
            'icon_position',
            [
                'label' => esc_html__('Icon Position', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'lc-addons-kit-for-elementor'),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'lc-addons-kit-for-elementor'),
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'default' => 'right',
                'toggle' => false,
            ]
        );

        $this->add_control(
            'multiple',
            [
                'label' => esc_html__('Multiple Items Open', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'lc-addons-kit-for-elementor'),
                'label_off' => esc_html__('No', 'lc-addons-kit-for-elementor'),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $this->end_controls_section();
    }

    protected function add_style_controls() {
              $this->start_controls_section(
            'style_section',
            [
                'label' => esc_html__('Title', 'lc-addons-kit-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        // Typography for Title
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'accordion_title_typography',
                'selector' => '{{WRAPPER}} .lcake-accordion-title',
            ]
        );

        // Tabs for Open and Closed
        $this->start_controls_tabs('accordion_style_tabs');

        // -------- OPEN TAB --------
        $this->start_controls_tab(
            'accordion_open_tab_title',
            [
                'label' => esc_html__('Open', 'lc-addons-kit-for-elementor'),
            ]
        );

        $this->add_control(
            'accordion_open_color_title',
            [
                'label' => esc_html__('Text Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lcake-accordion-item.active .lcake-accordion-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'accordion_open_hover_color_title',
            [
                'label' => esc_html__('Hover Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lcake-accordion-item.active .lcake-accordion-header:hover .lcake-accordion-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'accordion_open_background_title',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .lcake-accordion-item.active .lcake-accordion-header',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'accordion_open_border_title',
                'selector' => '{{WRAPPER}} .lcake-accordion-item.active .lcake-accordion-header',
            ]
        );

        $this->add_control(
            'accordion_open_border_radius_title',
            [
                'label' => esc_html__('Border Radius', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .lcake-accordion-item.active .lcake-accordion-header' =>
                        'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'accordion_open_shadow_title',
                'selector' => '{{WRAPPER}} .lcake-accordion-item.active .lcake-accordion-header',
            ]
        );

        $this->end_controls_tab();

        // -------- CLOSED TAB --------
        $this->start_controls_tab(
            'accordion_closed_tab_title',
            [
                'label' => esc_html__('Closed', 'lc-addons-kit-for-elementor'),
            ]
        );

        $this->add_control(
            'accordion_closed_color_title',
            [
                'label' => esc_html__('Text Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lcake-accordion-item:not(.active) .lcake-accordion-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'accordion_closed_hover_color_title',
            [
                'label' => esc_html__('Hover Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lcake-accordion-item:not(.active) .lcake-accordion-header:hover .lcake-accordion-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'accordion_closed_background_title',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .lcake-accordion-item:not(.active) .lcake-accordion-header',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'accordion_closed_border_title',
                'selector' => '{{WRAPPER}} .lcake-accordion-item:not(.active) .lcake-accordion-header',
            ]
        );

        $this->add_control(
            'accordion_closed_border_radius_title',
            [
                'label' => esc_html__('Border Radius', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .lcake-accordion-item:not(.active) .lcake-accordion-header' =>
                        'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'accordion_closed_shadow_title',
                'selector' => '{{WRAPPER}} .lcake-accordion-item:not(.active) .lcake-accordion-header',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        // Divider
        $this->add_control(
            'accordion_title_divider',
            [
                'type' => \Elementor\Controls_Manager::DIVIDER,
                'style' => 'thick',
            ]
        );

        // Padding
        $this->add_responsive_control(
            'accordion_title_padding_title',
            [
                'label' => esc_html__('Padding', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .lcake-accordion-header' =>
                        'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Margin Bottom
        $this->add_responsive_control(
            'accordion_title_margin_bottom_title',
            [
                'label' => esc_html__('Margin Bottom', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .lcake-accordion-item:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Description (Subtitle) Style Section
        $this->start_controls_section(
            'lcake_accordion_description_style',
            [
                'label' => esc_html__('Description', 'lc-addons-kit-for-elementor'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        // Text Color
        $this->add_control(
            'lcake_accordion_description_color',
            [
                'label' => esc_html__('Text Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lcake-accordion-item.active .lcake-accordion-content' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'lcake_accordion_description_typography',
                'selector' => '{{WRAPPER}} .lcake-accordion-item.active .lcake-accordion-content',
            ]
        );

        // Background
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'lcake_accordion_description_background',
                'label' => esc_html__('Background', 'lc-addons-kit-for-elementor'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .lcake-accordion-item.active .lcake-accordion-content',
            ]
        );

        // Border
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'lcake_accordion_description_border',
                'selector' => '{{WRAPPER}} .lcake-accordion-item.active .lcake-accordion-content',
            ]
        );

        // Border Radius
        $this->add_control(
            'lcake_accordion_description_border_radius',
            [
                'label' => esc_html__('Border Radius', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .lcake-accordion-item.active .lcake-accordion-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Box Shadow
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'lcake_accordion_description_box_shadow',
                'selector' => '{{WRAPPER}} .lcake-accordion-item.active .lcake-accordion-content',
            ]
        );

        // Padding
        $this->add_responsive_control(
            'lcake_accordion_description_padding',
            [
                'label' => esc_html__('Padding', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .lcake-accordion-item.active .lcake-accordion-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Max Width (Only for specific style, if needed)
        $this->add_responsive_control(
            'lcake_accordion_description_max_width',
            [
                'label' => esc_html__('Max Width', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['%'],
                'range' => [
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 100,
                ],
                'selectors' => [
                    '{{WRAPPER}} .lcake-accordion-item.active .lcake-accordion-content' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'lcake_accordion_style' => 'floating-style',
                ],
            ]
        );

        $this->end_controls_section();

        // Accordion Border Style Section
        $this->start_controls_section(
            'lcake_accordion_section_border_style', [
                'label' => esc_html__('Border', 'lc-addons-kit-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs('lcake_accordion_border_style_tabs');

        // OPEN TAB
        $this->start_controls_tab(
            'lcake_accordion_border_style_open',
            [
                'label' => esc_html__('OPEN', 'lc-addons-kit-for-elementor'),
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'lcake_accordion_border_open',
                'label' => esc_html__('Border', 'lc-addons-kit-for-elementor'),
                'selector' => '{{WRAPPER}} .lcake-accordion .lcake-accordion-item.active',
            ]
        );

        $this->add_control(
            'lcake_accordion_border_radius_open',
            [
                'label' => esc_html__('Border Radius', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .lcake-accordion .lcake-accordion-item.active' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .lcake-accordion .lcake-accordion-item.active .lcake-accordion-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} 0{{UNIT}} 0{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'lcake_accordion_box_shadow_open',
                'label' => esc_html__('Box Shadow', 'lc-addons-kit-for-elementor'),
                'selector' => '{{WRAPPER}} .lcake-accordion .lcake-accordion-item.active',
            ]
        );

        $this->end_controls_tab();

        // CLOSED TAB
        $this->start_controls_tab(
            'lcake_accordion_border_style_closed',
            [
                'label' => esc_html__('CLOSED', 'lc-addons-kit-for-elementor'),
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'lcake_accordion_border_closed',
                'label' => esc_html__('Border', 'lc-addons-kit-for-elementor'),
                'selector' => '{{WRAPPER}} .lcake-accordion .lcake-accordion-item',
            ]
        );

        $this->add_control(
            'lcake_accordion_border_radius_closed',
            [
                'label' => esc_html__('Border Radius', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .lcake-accordion .lcake-accordion-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .lcake-accordion .lcake-accordion-title.collapsed' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'lcake_accordion_box_shadow_closed',
                'label' => esc_html__('Box Shadow', 'lc-addons-kit-for-elementor'),
                'selector' => '{{WRAPPER}} .lcake-accordion .lcake-accordion-item',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_control(
            'lcake_accordion_last_border_none',
            [
                'label' => esc_html__('Disable Border for Last Element?', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'lc-addons-kit-for-elementor'),
                'label_off' => esc_html__('No', 'lc-addons-kit-for-elementor'),
                'return_value' => 'yes',
                'default' => '',
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .lcake-accordion .lcake-accordion-item:last-child' => 'border: none;',
                ],
            ]
        );

        $this->end_controls_section();
        
        // Icon Style Section
        $this->start_controls_section(
            'lcake_accordion_section_icon_style', [
                'label' => esc_html__('Icon', 'lc-addons-kit-for-elementor'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs('lcake_accordion_icon_tabs');

        // === CLOSED TAB ===
        $this->start_controls_tab(
            'lcake_accordion_icon_closed_tab',
            ['label' => esc_html__('CLOSED', 'lc-addons-kit-for-elementor')]
        );

        $this->add_responsive_control(
            'lcake_accordion_icon_closed_size',
            [
                'label' => esc_html__('Size', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => ['px' => ['min' => 6, 'max' => 300]],
                'selectors' => [
                    '{{WRAPPER}} .lcake-accordion .lcake-accordion-item:not(.active) .lcake-accordion-icon svg' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'lcake_accordion_icon_closed_color',
            [
                'label' => esc_html__('Closed Icon Color', 'lc-addons-kit-for-elementor'),
                'type'  => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lcake-accordion .lcake-accordion-item:not(.active) .lcake-accordion-icon i, {{WRAPPER}} .lcake-accordion .lcake-accordion-item:not(.active) .lcake-accordion-icon svg' => 'color: {{VALUE}}; fill: {{VALUE}}; stroke: {{VALUE}};',
                ],
            ]
        );

       $this->add_control(
            'lcake_accordion_icon_closed_hover_color',
            [
                'label' => esc_html__('Closed Icon Hover Color', 'lc-addons-kit-for-elementor'),
                'type'  => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lcake-accordion .lcake-accordion-item:not(.active) .lcake-accordion-header:hover .lcake-accordion-icon i, {{WRAPPER}} .lcake-accordion .lcake-accordion-item:not(.active) .lcake-accordion-header:hover .lcake-accordion-icon svg' => 'color: {{VALUE}}; fill: {{VALUE}}; stroke: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'lcake_accordion_icon_closed_bg',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .lcake-accordion .lcake-accordion-item:not(.active) .lcake-accordion-icon',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'lcake_accordion_icon_closed_border',
                'selector' => '{{WRAPPER}} .lcake-accordion .lcake-accordion-item:not(.active) .lcake-accordion-icon',
            ]
        );

        $this->end_controls_tab();

        // === OPEN TAB ===
        $this->start_controls_tab(
            'lcake_accordion_icon_open_tab',
            ['label' => esc_html__('OPEN', 'lc-addons-kit-for-elementor')]
        );

        $this->add_responsive_control(
            'lcake_accordion_icon_open_size',
            [
                'label' => esc_html__('Size', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => ['px' => ['min' => 6, 'max' => 300]],
                'selectors' => [
                    '{{WRAPPER}} .lcake-accordion .lcake-accordion-item.active .lcake-accordion-icon-active svg' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'lcake_accordion_icon_open_color',
            [
                'label' => esc_html__('Open Icon Color', 'lc-addons-kit-for-elementor'),
                'type'  => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lcake-accordion .lcake-accordion-item.active .lcake-accordion-icon-active i, {{WRAPPER}} .lcake-accordion .lcake-accordion-item.active .lcake-accordion-icon-active svg' => 'color: {{VALUE}}; fill: {{VALUE}}; stroke: {{VALUE}};',
                ],
            ]
        );
        
        $this->add_control(
            'lcake_accordion_icon_open_hover_color',
            [
                'label' => esc_html__('Open Icon Hover Color', 'lc-addons-kit-for-elementor'),
                'type'  => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lcake-accordion .lcake-accordion-item.active .lcake-accordion-header:hover .lcake-accordion-icon-active i, {{WRAPPER}} .lcake-accordion .lcake-accordion-item.active .lcake-accordion-header:hover .lcake-accordion-icon-active svg' => 'color: {{VALUE}}; fill: {{VALUE}}; stroke: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'lcake_accordion_icon_open_bg',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .lcake-accordion .lcake-accordion-item.active .lcake-accordion-icon-active',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'lcake_accordion_icon_open_border',
                'selector' => '{{WRAPPER}} .lcake-accordion .lcake-accordion-item.active .lcake-accordion-icon-active',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        // === COMMON CONTROLS ===
        $this->add_control(
            'lcake_accordion_icon_radius',
            [
                'label' => esc_html__('Border Radius', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .lcake-accordion .lcake-accordion-icon, {{WRAPPER}} .lcake-accordion .lcake-accordion-icon-active' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'lcake_accordion_icon_padding',
            [
                'label' => esc_html__('Padding', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .lcake-accordion .lcake-accordion-icon, {{WRAPPER}} .lcake-accordion .lcake-accordion-icon-active' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'lcake_accordion_icon_margin',
            [
                'label' => esc_html__('Margin', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .lcake-accordion .lcake-accordion-icon, {{WRAPPER}} .lcake-accordion .lcake-accordion-icon-active' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

    }



    public function render() {
        $settings = $this->get_settings_for_display();

        if (empty($settings['accordion_items'])) {
            return;
        }
        
        $multiple = ($settings['multiple'] === 'yes') ? 'yes' : 'no';

        $this->add_render_attribute('wrapper', 'class', 'lcake-elementor-addons-kit');
        $this->add_render_attribute('wrapper', 'data-multiple', $multiple);

        echo '<div ' . esc_attr($this->get_render_attribute_string('wrapper')) . '>';
        echo '<div class="lcake-accordion" data-multiple="' . esc_attr($multiple) . '">';

        

        foreach ($settings['accordion_items'] as $index => $item) {
            $item_class = 'lcake-accordion-item';
            if ($index + 1 == $settings['active_item']) {
                $item_class .= ' active';
            }

            echo '<div class="' . esc_attr($item_class) . '">';
            $icon_position_class = ($settings['icon_position'] === 'left') ? 'icon-left' : '';
            echo '<div class="lcake-accordion-header ' . esc_attr($icon_position_class) . '">';
            echo '<div class="lcake-accordion-title">' . esc_html($item['title']) . '</div>';

            if (!empty($item['icon']['value']) || !empty($item['active_icon']['value'])) {
                echo '<div class="lcake-accordion-icon">';
                if (!empty($item['icon']['value'])) {
                    \Elementor\Icons_Manager::render_icon($item['icon'], ['aria-hidden' => 'true']);
                }
                if (!empty($item['active_icon']['value'])) {
                    echo '<span class="lcake-accordion-icon-active">';
                    \Elementor\Icons_Manager::render_icon($item['active_icon'], ['aria-hidden' => 'true']);
                    echo '</span>';
                }
                echo '</div>';
            }

            echo '</div>';

            echo '<div class="lcake-accordion-content">';
            echo '<div class="lcake-accordion-body">';
            echo wp_kses_post($item['content']);
            echo '</div>';
            echo '</div>'; 

            echo '</div>'; 
        }
        echo '</div>'; 
        echo '</div>'; 
    }
}