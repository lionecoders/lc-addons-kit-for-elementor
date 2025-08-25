<?php
/**
 * Tab Widget
 * 
 * @package LC_Elementor_Addons_Kit
 */

if (!defined('ABSPATH')) {
    exit;
}

class LC_Kit_Tab extends \Elementor\Widget_Base {

    public function get_name() {
        return 'lc-kit-tab';
    }

    public function get_title() {
        return esc_html__('Tab', 'lc-elementor-addons-kit');
    }

    public function get_icon() {
        return 'eicon-tabs';
    }

    public function get_categories() {
        return ['lc-page-kit'];
    }

    public function get_keywords() {
        return ['tab', 'tabs', 'toggle', 'accordion', 'content'];
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
            'tab_title',
            [
                'label' => esc_html__('Tab Title', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Tab Title', 'lc-elementor-addons-kit'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'tab_content',
            [
                'label' => esc_html__('Tab Content', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::WYSIWYG,
                'default' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'lc-elementor-addons-kit'),
                'show_label' => false,
            ]
        );

        $repeater->add_control(
            'tab_icon',
            [
                'label' => esc_html__('Icon', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-star',
                    'library' => 'fa-solid',
                ],
            ]
        );

        $this->add_control(
            'tabs',
            [
                'label' => esc_html__('Tabs', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'tab_title' => esc_html__('Tab #1', 'lc-elementor-addons-kit'),
                        'tab_content' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'lc-elementor-addons-kit'),
                    ],
                    [
                        'tab_title' => esc_html__('Tab #2', 'lc-elementor-addons-kit'),
                        'tab_content' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'lc-elementor-addons-kit'),
                    ],
                    [
                        'tab_title' => esc_html__('Tab #3', 'lc-elementor-addons-kit'),
                        'tab_content' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'lc-elementor-addons-kit'),
                    ],
                ],
                'title_field' => '{{{ tab_title }}}',
            ]
        );

        $this->add_control(
            'type',
            [
                'label' => esc_html__('Type', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'horizontal',
                'options' => [
                    'horizontal' => esc_html__('Horizontal', 'lc-elementor-addons-kit'),
                    'vertical' => esc_html__('Vertical', 'lc-elementor-addons-kit'),
                ],
            ]
        );

        $this->add_control(
            'active_tab',
            [
                'label' => esc_html__('Active Tab', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 10,
                'default' => 1,
            ]
        );

        $this->add_control(
            'show_icon',
            [
                'label' => esc_html__('Show Icon', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'lc-elementor-addons-kit'),
                'label_off' => esc_html__('Hide', 'lc-elementor-addons-kit'),
                'return_value' => 'yes',
                'default' => '',
            ]
        );

        $this->end_controls_section();
    }

    protected function add_style_controls() {
        $this->start_controls_section(
            'section_style_tabs',
            [
                'label' => esc_html__('Tabs', 'lc-elementor-addons-kit'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'tabs_background_color',
            [
                'label' => esc_html__('Background Color', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lc-tabs-nav' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'tabs_border',
                'selector' => '{{WRAPPER}} .lc-tabs-nav',
            ]
        );

        $this->add_control(
            'tabs_border_radius',
            [
                'label' => esc_html__('Border Radius', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lc-tabs-nav' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'tabs_padding',
            [
                'label' => esc_html__('Padding', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lc-tabs-nav' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_tab_items',
            [
                'label' => esc_html__('Tab Items', 'lc-elementor-addons-kit'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'tab_item_background_color',
            [
                'label' => esc_html__('Background Color', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lc-tab-item' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'tab_item_color',
            [
                'label' => esc_html__('Text Color', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lc-tab-item' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'tab_item_typography',
                'selector' => '{{WRAPPER}} .lc-tab-item',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'tab_item_border',
                'selector' => '{{WRAPPER}} .lc-tab-item',
            ]
        );

        $this->add_control(
            'tab_item_border_radius',
            [
                'label' => esc_html__('Border Radius', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lc-tab-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'tab_item_padding',
            [
                'label' => esc_html__('Padding', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lc-tab-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'tab_item_margin',
            [
                'label' => esc_html__('Margin', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lc-tab-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_active_tab',
            [
                'label' => esc_html__('Active Tab', 'lc-elementor-addons-kit'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'active_tab_background_color',
            [
                'label' => esc_html__('Background Color', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lc-tab-item.active' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'active_tab_color',
            [
                'label' => esc_html__('Text Color', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lc-tab-item.active' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'active_tab_border',
                'selector' => '{{WRAPPER}} .lc-tab-item.active',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_content',
            [
                'label' => esc_html__('Content', 'lc-elementor-addons-kit'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'content_background_color',
            [
                'label' => esc_html__('Background Color', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lc-tabs-content' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'content_color',
            [
                'label' => esc_html__('Text Color', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lc-tabs-content' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'content_typography',
                'selector' => '{{WRAPPER}} .lc-tabs-content',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'content_border',
                'selector' => '{{WRAPPER}} .lc-tabs-content',
            ]
        );

        $this->add_control(
            'content_border_radius',
            [
                'label' => esc_html__('Border Radius', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lc-tabs-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'content_padding',
            [
                'label' => esc_html__('Padding', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lc-tabs-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_icon',
            [
                'label' => esc_html__('Icon', 'lc-elementor-addons-kit'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_icon' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label' => esc_html__('Color', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lc-tab-icon' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'icon_size',
            [
                'label' => esc_html__('Size', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 6,
                        'max' => 300,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .lc-tab-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_margin',
            [
                'label' => esc_html__('Margin', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lc-tab-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        if (empty($settings['tabs'])) {
            return;
        }

        $this->add_render_attribute('wrapper', 'class', 'lc-tabs-wrapper');
        $this->add_render_attribute('wrapper', 'class', 'lc-tabs--' . $settings['type']);

        echo '<div ' . $this->get_render_attribute_string('wrapper') . '>';

        // Tab Navigation
        echo '<div class="lc-tabs-nav">';
        foreach ($settings['tabs'] as $index => $tab) {
            $tab_class = 'lc-tab-item';
            if ($index + 1 == $settings['active_tab']) {
                $tab_class .= ' active';
            }

            echo '<div class="' . esc_attr($tab_class) . '" data-tab="' . ($index + 1) . '">';
            
            if ($settings['show_icon'] === 'yes' && !empty($tab['tab_icon']['value'])) {
                echo '<span class="lc-tab-icon">';
                \Elementor\Icons_Manager::render_icon($tab['tab_icon'], ['aria-hidden' => 'true']);
                echo '</span>';
            }
            
            echo '<span class="lc-tab-title">' . esc_html($tab['tab_title']) . '</span>';
            echo '</div>';
        }
        echo '</div>';

        // Tab Content
        echo '<div class="lc-tabs-content">';
        foreach ($settings['tabs'] as $index => $tab) {
            $content_class = 'lc-tab-content';
            if ($index + 1 == $settings['active_tab']) {
                $content_class .= ' active';
            }

            echo '<div class="' . esc_attr($content_class) . '" data-tab="' . ($index + 1) . '">';
            echo '<div class="lc-tab-body">';
            echo wp_kses_post($tab['tab_content']);
            echo '</div>';
            echo '</div>';
        }
        echo '</div>';

        echo '</div>';
    }

    protected function content_template() {
        ?>
        <# if (settings.tabs.length > 0) { #>
            <div class="lc-tabs-wrapper lc-tabs--{{ settings.type }}">
                <div class="lc-tabs-nav">
                    <# _.each(settings.tabs, function(tab, index) { #>
                        <div class="lc-tab-item<# if (index + 1 == settings.active_tab) { #> active<# } #>" data-tab="{{ index + 1 }}">
                            <# if (settings.show_icon === 'yes' && tab.tab_icon.value) { #>
                                <span class="lc-tab-icon">
                                    <i class="{{ tab.tab_icon.value }}" aria-hidden="true"></i>
                                </span>
                            <# } #>
                            <span class="lc-tab-title">{{{ tab.tab_title }}}</span>
                        </div>
                    <# }); #>
                </div>
                
                <div class="lc-tabs-content">
                    <# _.each(settings.tabs, function(tab, index) { #>
                        <div class="lc-tab-content<# if (index + 1 == settings.active_tab) { #> active<# } #>" data-tab="{{ index + 1 }}">
                            <div class="lc-tab-body">
                                {{{ tab.tab_content }}}
                            </div>
                        </div>
                    <# }); #>
                </div>
            </div>
        <# } #>
        <?php
    }
} 