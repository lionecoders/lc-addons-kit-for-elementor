<?php
/**
 * Accordion Widget
 * 
 * @package LC_Elementor_Addons_Kit
 */

if (!defined('ABSPATH')) {
    exit;
}

class LC_Kit_Accordion extends \Elementor\Widget_Base {

    public function get_name() {
        return 'lc-kit-accordion';
    }

    public function get_title() {
        return esc_html__('Accordion', 'lc-elementor-addons-kit');
    }

    public function get_script_depends() {
        return ['lc-kit-accordion'];
    }
    
    public function get_style_depends() {
        return ['lc-kit-accordion'];
    }

    public function get_icon() {
        return 'eicon-accordion';
    }

    public function get_categories() {
        return ['lc-page-kit'];
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
                'label' => esc_html__('Content', 'lc-elementor-addons-kit'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'title',
            [
                'label' => esc_html__('Title', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Accordion Title', 'lc-elementor-addons-kit'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'content',
            [
                'label' => esc_html__('Content', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::WYSIWYG,
                'default' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'lc-elementor-addons-kit'),
                'show_label' => false,
            ]
        );

        $repeater->add_control(
            'icon',
            [
                'label' => esc_html__('Icon', 'lc-elementor-addons-kit'),
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
                'label' => esc_html__('Active Icon', 'lc-elementor-addons-kit'),
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
                'label' => esc_html__('Accordion Items', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'title' => esc_html__('How do I start using WordPress?', 'lc-elementor-addons-kit'),
                        'content' => esc_html__('You can start by choosing a domain, getting web hosting, and installing WordPress with one click from most hosting dashboards', 'lc-elementor-addons-kit'),
                    ],
                    [
                        'title' => esc_html__('Can I build a website without coding in WordPress?', 'lc-elementor-addons-kit'),
                        'content' => esc_html__('Yes! WordPress has drag-and-drop builders like Elementor that let you build websites visually, without writing code.', 'lc-elementor-addons-kit'),
                    ],
                    [
                        'title' => esc_html__('What are WordPress themes and plugins?', 'lc-elementor-addons-kit'),
                        'content' => esc_html__('Themes control your website’s design, and plugins add new features like contact forms, galleries, SEO tools, and more.', 'lc-elementor-addons-kit'),
                    ],
                    [
                        'title' => esc_html__('How can I learn WordPress faster?', 'lc-elementor-addons-kit'),
                        'content' => esc_html__('Start by exploring the WordPress dashboard, watching tutorials on YouTube, or trying small changes like editing pages and posts.', 'lc-elementor-addons-kit'),
                    ],
                ],
                'title_field' => '{{{ title }}}',
            ]
        );

        $this->add_control(
            'active_item',
            [
                'label' => esc_html__('Active Item', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 10,
                'default' => 1,
                'description' => esc_html__('Enter the item number to open by default.', 'lc-elementor-addons-kit'),
            ]
        );

        $this->add_control(
            'icon_position',
            [
                'label' => esc_html__('Icon Position', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'lc-elementor-addons-kit'),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'lc-elementor-addons-kit'),
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
                'label' => esc_html__('Multiple Items Open', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'lc-elementor-addons-kit'),
                'label_off' => esc_html__('No', 'lc-elementor-addons-kit'),
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
                'label' => esc_html__('Title', 'lc-elementor-addons-kit'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        // Typography for Title
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'accordion_title_typography',
                'selector' => '{{WRAPPER}} .lc-accordion-title',
            ]
        );

        // Tabs for Open and Closed
        $this->start_controls_tabs('accordion_style_tabs');

        // -------- OPEN TAB --------
        $this->start_controls_tab(
            'accordion_open_tab_title',
            [
                'label' => esc_html__('Open', 'lc-elementor-addons-kit'),
            ]
        );

        $this->add_control(
            'accordion_open_color_title',
            [
                'label' => esc_html__('Text Color', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lc-accordion-item.active .lc-accordion-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'accordion_open_hover_color_title',
            [
                'label' => esc_html__('Hover Color', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lc-accordion-item.active .lc-accordion-header:hover .lc-accordion-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'accordion_open_background_title',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .lc-accordion-item.active .lc-accordion-header',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'accordion_open_border_title',
                'selector' => '{{WRAPPER}} .lc-accordion-item.active .lc-accordion-header',
            ]
        );

        $this->add_control(
            'accordion_open_border_radius_title',
            [
                'label' => esc_html__('Border Radius', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .lc-accordion-item.active .lc-accordion-header' =>
                        'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'accordion_open_shadow_title',
                'selector' => '{{WRAPPER}} .lc-accordion-item.active .lc-accordion-header',
            ]
        );

        $this->end_controls_tab();

        // -------- CLOSED TAB --------
        $this->start_controls_tab(
            'accordion_closed_tab_title',
            [
                'label' => esc_html__('Closed', 'lc-elementor-addons-kit'),
            ]
        );

        $this->add_control(
            'accordion_closed_color_title',
            [
                'label' => esc_html__('Text Color', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lc-accordion-item:not(.active) .lc-accordion-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'accordion_closed_hover_color_title',
            [
                'label' => esc_html__('Hover Color', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lc-accordion-item:not(.active) .lc-accordion-header:hover .lc-accordion-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'accordion_closed_background_title',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .lc-accordion-item:not(.active) .lc-accordion-header',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'accordion_closed_border_title',
                'selector' => '{{WRAPPER}} .lc-accordion-item:not(.active) .lc-accordion-header',
            ]
        );

        $this->add_control(
            'accordion_closed_border_radius_title',
            [
                'label' => esc_html__('Border Radius', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .lc-accordion-item:not(.active) .lc-accordion-header' =>
                        'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'accordion_closed_shadow_title',
                'selector' => '{{WRAPPER}} .lc-accordion-item:not(.active) .lc-accordion-header',
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
                'label' => esc_html__('Padding', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .lc-accordion-header' =>
                        'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Margin Bottom
        $this->add_responsive_control(
            'accordion_title_margin_bottom_title',
            [
                'label' => esc_html__('Margin Bottom', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .lc-accordion-item:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Description (Subtitle) Style Section
        $this->start_controls_section(
            'lc_accordion_description_style',
            [
                'label' => esc_html__('Description', 'lc-elementor-addons-kit'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        // Text Color
        $this->add_control(
            'lc_accordion_description_color',
            [
                'label' => esc_html__('Text Color', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lc-accordion-item.active .lc-accordion-content' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'lc_accordion_description_typography',
                'selector' => '{{WRAPPER}} .lc-accordion-item.active .lc-accordion-content',
            ]
        );

        // Background
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'lc_accordion_description_background',
                'label' => esc_html__('Background', 'lc-elementor-addons-kit'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .lc-accordion-item.active .lc-accordion-content',
            ]
        );

        // Border
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'lc_accordion_description_border',
                'selector' => '{{WRAPPER}} .lc-accordion-item.active .lc-accordion-content',
            ]
        );

        // Border Radius
        $this->add_control(
            'lc_accordion_description_border_radius',
            [
                'label' => esc_html__('Border Radius', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .lc-accordion-item.active .lc-accordion-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Box Shadow
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'lc_accordion_description_box_shadow',
                'selector' => '{{WRAPPER}} .lc-accordion-item.active .lc-accordion-content',
            ]
        );

        // Padding
        $this->add_responsive_control(
            'lc_accordion_description_padding',
            [
                'label' => esc_html__('Padding', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .lc-accordion-item.active .lc-accordion-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Max Width (Only for specific style, if needed)
        $this->add_responsive_control(
            'lc_accordion_description_max_width',
            [
                'label' => esc_html__('Max Width', 'lc-elementor-addons-kit'),
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
                    '{{WRAPPER}} .lc-accordion-item.active .lc-accordion-content' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'lc_accordion_style' => 'floating-style',
                ],
            ]
        );

        $this->end_controls_section();

        // Accordion Border Style Section
        $this->start_controls_section(
            'lc_accordion_section_border_style', [
                'label' => esc_html__('Border', 'lc-elementor-addons-kit'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs('lc_accordion_border_style_tabs');

        // OPEN TAB
        $this->start_controls_tab(
            'lc_accordion_border_style_open',
            [
                'label' => esc_html__('OPEN', 'lc-elementor-addons-kit'),
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'lc_accordion_border_open',
                'label' => esc_html__('Border', 'lc-elementor-addons-kit'),
                'selector' => '{{WRAPPER}} .lc-accordion .lc-accordion-item.active',
            ]
        );

        $this->add_control(
            'lc_accordion_border_radius_open',
            [
                'label' => esc_html__('Border Radius', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .lc-accordion .lc-accordion-item.active' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .lc-accordion .lc-accordion-item.active .lc-accordion-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} 0{{UNIT}} 0{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'lc_accordion_box_shadow_open',
                'label' => esc_html__('Box Shadow', 'lc-elementor-addons-kit'),
                'selector' => '{{WRAPPER}} .lc-accordion .lc-accordion-item.active',
            ]
        );

        $this->end_controls_tab();

        // CLOSED TAB
        $this->start_controls_tab(
            'lc_accordion_border_style_closed',
            [
                'label' => esc_html__('CLOSED', 'lc-elementor-addons-kit'),
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'lc_accordion_border_closed',
                'label' => esc_html__('Border', 'lc-elementor-addons-kit'),
                'selector' => '{{WRAPPER}} .lc-accordion .lc-accordion-item',
            ]
        );

        $this->add_control(
            'lc_accordion_border_radius_closed',
            [
                'label' => esc_html__('Border Radius', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .lc-accordion .lc-accordion-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .lc-accordion .lc-accordion-title.collapsed' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'lc_accordion_box_shadow_closed',
                'label' => esc_html__('Box Shadow', 'lc-elementor-addons-kit'),
                'selector' => '{{WRAPPER}} .lc-accordion .lc-accordion-item',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_control(
            'lc_accordion_last_border_none',
            [
                'label' => esc_html__('Disable Border for Last Element?', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'lc-elementor-addons-kit'),
                'label_off' => esc_html__('No', 'lc-elementor-addons-kit'),
                'return_value' => 'yes',
                'default' => '',
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .lc-accordion .lc-accordion-item:last-child' => 'border: none;',
                ],
            ]
        );

        $this->end_controls_section();
        
        // Icon Style Section
        $this->start_controls_section(
            'lc_accordion_section_icon_style', [
                'label' => esc_html__('Icon', 'lc-elementor-addons-kit'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs('lc_accordion_icon_tabs');

        // === CLOSED TAB ===
        $this->start_controls_tab(
            'lc_accordion_icon_closed_tab',
            ['label' => esc_html__('CLOSED', 'lc-elementor-addons-kit')]
        );

        $this->add_responsive_control(
            'lc_accordion_icon_closed_size',
            [
                'label' => esc_html__('Size', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => ['px' => ['min' => 6, 'max' => 300]],
                'selectors' => [
                    '{{WRAPPER}} .lc-accordion .lc-accordion-item:not(.active) .lc-accordion-icon svg' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'lc_accordion_icon_closed_color',
            [
                'label' => esc_html__('Closed Icon Color', 'lc-elementor-addons-kit'),
                'type'  => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lc-accordion .lc-accordion-item:not(.active) .lc-accordion-icon i, {{WRAPPER}} .lc-accordion .lc-accordion-item:not(.active) .lc-accordion-icon svg' => 'color: {{VALUE}}; fill: {{VALUE}}; stroke: {{VALUE}};',
                ],
            ]
        );

       $this->add_control(
            'lc_accordion_icon_closed_hover_color',
            [
                'label' => esc_html__('Closed Icon Hover Color', 'lc-elementor-addons-kit'),
                'type'  => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lc-accordion .lc-accordion-item:not(.active) .lc-accordion-header:hover .lc-accordion-icon i, {{WRAPPER}} .lc-accordion .lc-accordion-item:not(.active) .lc-accordion-header:hover .lc-accordion-icon svg' => 'color: {{VALUE}}; fill: {{VALUE}}; stroke: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'lc_accordion_icon_closed_bg',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .lc-accordion .lc-accordion-item:not(.active) .lc-accordion-icon',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'lc_accordion_icon_closed_border',
                'selector' => '{{WRAPPER}} .lc-accordion .lc-accordion-item:not(.active) .lc-accordion-icon',
            ]
        );

        $this->end_controls_tab();

        // === OPEN TAB ===
        $this->start_controls_tab(
            'lc_accordion_icon_open_tab',
            ['label' => esc_html__('OPEN', 'lc-elementor-addons-kit')]
        );

        $this->add_responsive_control(
            'lc_accordion_icon_open_size',
            [
                'label' => esc_html__('Size', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => ['px' => ['min' => 6, 'max' => 300]],
                'selectors' => [
                    '{{WRAPPER}} .lc-accordion .lc-accordion-item.active .lc-accordion-icon-active svg' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'lc_accordion_icon_open_color',
            [
                'label' => esc_html__('Open Icon Color', 'lc-elementor-addons-kit'),
                'type'  => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lc-accordion .lc-accordion-item.active .lc-accordion-icon-active i, {{WRAPPER}} .lc-accordion .lc-accordion-item.active .lc-accordion-icon-active svg' => 'color: {{VALUE}}; fill: {{VALUE}}; stroke: {{VALUE}};',
                ],
            ]
        );
        
        $this->add_control(
            'lc_accordion_icon_open_hover_color',
            [
                'label' => esc_html__('Open Icon Hover Color', 'lc-elementor-addons-kit'),
                'type'  => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lc-accordion .lc-accordion-item.active .lc-accordion-header:hover .lc-accordion-icon-active i, {{WRAPPER}} .lc-accordion .lc-accordion-item.active .lc-accordion-header:hover .lc-accordion-icon-active svg' => 'color: {{VALUE}}; fill: {{VALUE}}; stroke: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'lc_accordion_icon_open_bg',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .lc-accordion .lc-accordion-item.active .lc-accordion-icon-active',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'lc_accordion_icon_open_border',
                'selector' => '{{WRAPPER}} .lc-accordion .lc-accordion-item.active .lc-accordion-icon-active',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        // === COMMON CONTROLS ===
        $this->add_control(
            'lc_accordion_icon_radius',
            [
                'label' => esc_html__('Border Radius', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .lc-accordion .lc-accordion-icon, {{WRAPPER}} .lc-accordion .lc-accordion-icon-active' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'lc_accordion_icon_padding',
            [
                'label' => esc_html__('Padding', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .lc-accordion .lc-accordion-icon, {{WRAPPER}} .lc-accordion .lc-accordion-icon-active' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'lc_accordion_icon_margin',
            [
                'label' => esc_html__('Margin', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .lc-accordion .lc-accordion-icon, {{WRAPPER}} .lc-accordion .lc-accordion-icon-active' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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

        $this->add_render_attribute('wrapper', 'class', 'lc-elementor-addons-kit');
        $this->add_render_attribute('wrapper', 'data-multiple', $multiple);

        echo '<div ' . $this->get_render_attribute_string('wrapper') . '>';
        echo '<div class="lc-accordion" data-multiple="' . esc_attr($multiple) . '">';

        

        foreach ($settings['accordion_items'] as $index => $item) {
            $item_class = 'lc-accordion-item';
            if ($index + 1 == $settings['active_item']) {
                $item_class .= ' active';
            }

            echo '<div class="' . esc_attr($item_class) . '">';
            $icon_position_class = ($settings['icon_position'] === 'left') ? 'icon-left' : '';
            echo '<div class="lc-accordion-header ' . esc_attr($icon_position_class) . '">';
            echo '<div class="lc-accordion-title">' . esc_html($item['title']) . '</div>';

            if (!empty($item['icon']['value']) || !empty($item['active_icon']['value'])) {
                echo '<div class="lc-accordion-icon">';
                if (!empty($item['icon']['value'])) {
                    \Elementor\Icons_Manager::render_icon($item['icon'], ['aria-hidden' => 'true']);
                }
                if (!empty($item['active_icon']['value'])) {
                    echo '<span class="lc-accordion-icon-active">';
                    \Elementor\Icons_Manager::render_icon($item['active_icon'], ['aria-hidden' => 'true']);
                    echo '</span>';
                }
                echo '</div>';
            }

            echo '</div>'; // .lc-accordion-header

            echo '<div class="lc-accordion-content">';
            echo '<div class="lc-accordion-body">';
            echo wp_kses_post($item['content']);
            echo '</div>';
            echo '</div>'; // .lc-accordion-content

            echo '</div>'; // .lc-accordion-item
        }
        echo '</div>'; // .lc-accordion
        echo '</div>'; // .lc-accordion
    }
}