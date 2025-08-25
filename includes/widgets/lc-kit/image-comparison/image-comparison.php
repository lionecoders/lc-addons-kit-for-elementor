<?php
/**
 * Image Comparison Widget
 * 
 * @package LC_Elementor_Addons_Kit
 */

if (!defined('ABSPATH')) {
    exit;
}

class LC_Kit_Image_Comparison extends \Elementor\Widget_Base {

    public function get_name() {
        return 'lc-kit-image-comparison';
    }

    public function get_title() {
        return esc_html__('Image Comparison', 'lc-elementor-addons-kit');
    }

    public function get_icon() {
        return 'eicon-image-before-after';
    }

    public function get_categories() {
        return ['lc-page-kit'];
    }

    public function get_keywords() {
        return ['image', 'comparison', 'before', 'after', 'slider', 'overlay'];
    }

    public function get_script_depends() {
        return ['lc-image-comparison'];
    }

    protected function add_content_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Content', 'lc-elementor-addons-kit'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'before_image',
            [
                'label' => esc_html__('Before Image', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_control(
            'after_image',
            [
                'label' => esc_html__('After Image', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Image_Size::get_type(),
            [
                'name' => 'before_image',
                'default' => 'large',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Image_Size::get_type(),
            [
                'name' => 'after_image',
                'default' => 'large',
            ]
        );

        $this->add_control(
            'before_label',
            [
                'label' => esc_html__('Before Label', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Before', 'lc-elementor-addons-kit'),
            ]
        );

        $this->add_control(
            'after_label',
            [
                'label' => esc_html__('After Label', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('After', 'lc-elementor-addons-kit'),
            ]
        );

        $this->add_control(
            'default_offset',
            [
                'label' => esc_html__('Default Offset', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'size' => 50,
                ],
                'description' => esc_html__('Default position of the slider (percentage)', 'lc-elementor-addons-kit'),
            ]
        );

        $this->add_control(
            'orientation',
            [
                'label' => esc_html__('Orientation', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'horizontal',
                'options' => [
                    'horizontal' => esc_html__('Horizontal', 'lc-elementor-addons-kit'),
                    'vertical' => esc_html__('Vertical', 'lc-elementor-addons-kit'),
                ],
            ]
        );

        $this->add_control(
            'show_labels',
            [
                'label' => esc_html__('Show Labels', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'lc-elementor-addons-kit'),
                'label_off' => esc_html__('Hide', 'lc-elementor-addons-kit'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_handle',
            [
                'label' => esc_html__('Show Handle', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'lc-elementor-addons-kit'),
                'label_off' => esc_html__('Hide', 'lc-elementor-addons-kit'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->end_controls_section();
    }

    protected function add_style_controls() {
        $this->start_controls_section(
            'section_style_comparison',
            [
                'label' => esc_html__('Comparison', 'lc-elementor-addons-kit'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'border_radius',
            [
                'label' => esc_html__('Border Radius', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lc-image-comparison' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'comparison_border',
                'selector' => '{{WRAPPER}} .lc-image-comparison',
            ]
        );

        $this->add_responsive_control(
            'comparison_padding',
            [
                'label' => esc_html__('Padding', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lc-image-comparison' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_labels',
            [
                'label' => esc_html__('Labels', 'lc-elementor-addons-kit'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_labels' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'label_background_color',
            [
                'label' => esc_html__('Background Color', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lc-image-comparison-label' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'label_color',
            [
                'label' => esc_html__('Text Color', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lc-image-comparison-label' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'label_typography',
                'selector' => '{{WRAPPER}} .lc-image-comparison-label',
            ]
        );

        $this->add_responsive_control(
            'label_padding',
            [
                'label' => esc_html__('Padding', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lc-image-comparison-label' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'label_border_radius',
            [
                'label' => esc_html__('Border Radius', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lc-image-comparison-label' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_handle',
            [
                'label' => esc_html__('Handle', 'lc-elementor-addons-kit'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_handle' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'handle_background_color',
            [
                'label' => esc_html__('Background Color', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lc-image-comparison-handle' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'handle_border_color',
            [
                'label' => esc_html__('Border Color', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lc-image-comparison-handle' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'handle_size',
            [
                'label' => esc_html__('Size', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 20,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'size' => 40,
                ],
                'selectors' => [
                    '{{WRAPPER}} .lc-image-comparison-handle' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'handle_border_width',
            [
                'label' => esc_html__('Border Width', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 10,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'size' => 2,
                ],
                'selectors' => [
                    '{{WRAPPER}} .lc-image-comparison-handle' => 'border-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'handle_border_radius',
            [
                'label' => esc_html__('Border Radius', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lc-image-comparison-handle' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_divider',
            [
                'label' => esc_html__('Divider Line', 'lc-elementor-addons-kit'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'divider_color',
            [
                'label' => esc_html__('Color', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lc-image-comparison-divider' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'divider_width',
            [
                'label' => esc_html__('Width', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 10,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'size' => 2,
                ],
                'selectors' => [
                    '{{WRAPPER}} .lc-image-comparison-divider' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        if (empty($settings['before_image']['url']) || empty($settings['after_image']['url'])) {
            return;
        }

        $this->add_render_attribute('wrapper', 'class', 'lc-image-comparison');
        $this->add_render_attribute('wrapper', 'data-orientation', $settings['orientation']);
        $this->add_render_attribute('wrapper', 'data-offset', $settings['default_offset']['size']);
        $this->add_render_attribute('wrapper', 'data-show-labels', $settings['show_labels']);
        $this->add_render_attribute('wrapper', 'data-show-handle', $settings['show_handle']);

        echo '<div ' . $this->get_render_attribute_string('wrapper') . '>';
        
        echo '<div class="lc-image-comparison-container">';
        
        // Before image
        echo '<div class="lc-image-comparison-before">';
        echo '<img src="' . esc_url($settings['before_image']['url']) . '" alt="' . esc_attr($settings['before_label']) . '">';
        if ($settings['show_labels'] === 'yes' && !empty($settings['before_label'])) {
            echo '<div class="lc-image-comparison-label lc-image-comparison-label-before">' . esc_html($settings['before_label']) . '</div>';
        }
        echo '</div>';
        
        // After image
        echo '<div class="lc-image-comparison-after">';
        echo '<img src="' . esc_url($settings['after_image']['url']) . '" alt="' . esc_attr($settings['after_label']) . '">';
        if ($settings['show_labels'] === 'yes' && !empty($settings['after_label'])) {
            echo '<div class="lc-image-comparison-label lc-image-comparison-label-after">' . esc_html($settings['after_label']) . '</div>';
        }
        echo '</div>';
        
        // Divider line
        echo '<div class="lc-image-comparison-divider"></div>';
        
        // Handle
        if ($settings['show_handle'] === 'yes') {
            echo '<div class="lc-image-comparison-handle">';
            echo '<div class="lc-image-comparison-handle-arrow lc-image-comparison-handle-arrow-left">&lt;</div>';
            echo '<div class="lc-image-comparison-handle-arrow lc-image-comparison-handle-arrow-right">&gt;</div>';
            echo '</div>';
        }
        
        echo '</div>';
        
        echo '</div>';
    }

    protected function content_template() {
        ?>
        <# if (settings.before_image.url && settings.after_image.url) { #>
            <div class="lc-image-comparison" 
                 data-orientation="{{ settings.orientation }}"
                 data-offset="{{ settings.default_offset.size }}"
                 data-show-labels="{{ settings.show_labels }}"
                 data-show-handle="{{ settings.show_handle }}">
                
                <div class="lc-image-comparison-container">
                    
                    <div class="lc-image-comparison-before">
                        <img src="{{ settings.before_image.url }}" alt="{{ settings.before_label }}">
                        <# if (settings.show_labels === 'yes' && settings.before_label) { #>
                            <div class="lc-image-comparison-label lc-image-comparison-label-before">{{{ settings.before_label }}}</div>
                        <# } #>
                    </div>
                    
                    <div class="lc-image-comparison-after">
                        <img src="{{ settings.after_image.url }}" alt="{{ settings.after_label }}">
                        <# if (settings.show_labels === 'yes' && settings.after_label) { #>
                            <div class="lc-image-comparison-label lc-image-comparison-label-after">{{{ settings.after_label }}}</div>
                        <# } #>
                    </div>
                    
                    <div class="lc-image-comparison-divider"></div>
                    
                    <# if (settings.show_handle === 'yes') { #>
                        <div class="lc-image-comparison-handle">
                            <div class="lc-image-comparison-handle-arrow lc-image-comparison-handle-arrow-left">&lt;</div>
                            <div class="lc-image-comparison-handle-arrow lc-image-comparison-handle-arrow-right">&gt;</div>
                        </div>
                    <# } #>
                    
                </div>
                
            </div>
        <# } #>
        <?php
    }
} 