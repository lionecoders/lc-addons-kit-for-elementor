<?php
/**
 * Lottie Widget
 * 
 * @package LC_Elementor_Addons_Kit
 */

if (!defined('ABSPATH')) {
    exit;
}

class LC_Kit_Lottie extends \Elementor\Widget_Base {

    public function get_name() {
        return 'lc-kit-lottie';
    }

    public function get_title() {
        return esc_html__('Lottie', 'lc-elementor-addons-kit');
    }

    public function get_icon() {
        return 'eicon-animation';
    }

    public function get_categories() {
        return ['lc-page-kit'];
    }

    public function get_keywords() {
        return ['lottie', 'animation', 'json', 'svg', 'motion'];
    }

    public function get_script_depends() {
        return ['lc-lottie'];
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
            'lottie_url',
            [
                'label' => esc_html__('Lottie URL', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => esc_html__('https://example.com/animation.json', 'lc-elementor-addons-kit'),
                'description' => esc_html__('Enter the URL to your Lottie JSON file', 'lc-elementor-addons-kit'),
            ]
        );

        $this->add_control(
            'lottie_file',
            [
                'label' => esc_html__('Lottie File', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'media_type' => 'application/json',
                'description' => esc_html__('Upload your Lottie JSON file', 'lc-elementor-addons-kit'),
            ]
        );

        $this->add_control(
            'lottie_json',
            [
                'label' => esc_html__('Lottie JSON', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'description' => esc_html__('Paste your Lottie JSON code directly', 'lc-elementor-addons-kit'),
                'rows' => 10,
            ]
        );

        $this->add_control(
            'autoplay',
            [
                'label' => esc_html__('Autoplay', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'lc-elementor-addons-kit'),
                'label_off' => esc_html__('No', 'lc-elementor-addons-kit'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'loop',
            [
                'label' => esc_html__('Loop', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'lc-elementor-addons-kit'),
                'label_off' => esc_html__('No', 'lc-elementor-addons-kit'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'speed',
            [
                'label' => esc_html__('Speed', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0.1,
                        'max' => 3,
                        'step' => 0.1,
                    ],
                ],
                'default' => [
                    'size' => 1,
                ],
                'description' => esc_html__('Animation playback speed', 'lc-elementor-addons-kit'),
            ]
        );

        $this->add_control(
            'direction',
            [
                'label' => esc_html__('Direction', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 1,
                'options' => [
                    1 => esc_html__('Forward', 'lc-elementor-addons-kit'),
                    -1 => esc_html__('Reverse', 'lc-elementor-addons-kit'),
                ],
            ]
        );

        $this->add_control(
            'renderer',
            [
                'label' => esc_html__('Renderer', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'svg',
                'options' => [
                    'svg' => esc_html__('SVG', 'lc-elementor-addons-kit'),
                    'canvas' => esc_html__('Canvas', 'lc-elementor-addons-kit'),
                    'html' => esc_html__('HTML', 'lc-elementor-addons-kit'),
                ],
            ]
        );

        $this->add_control(
            'show_controls',
            [
                'label' => esc_html__('Show Controls', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'lc-elementor-addons-kit'),
                'label_off' => esc_html__('Hide', 'lc-elementor-addons-kit'),
                'return_value' => 'yes',
                'default' => '',
            ]
        );

        $this->add_control(
            'pause_on_hover',
            [
                'label' => esc_html__('Pause on Hover', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'lc-elementor-addons-kit'),
                'label_off' => esc_html__('No', 'lc-elementor-addons-kit'),
                'return_value' => 'yes',
                'default' => '',
            ]
        );

        $this->end_controls_section();
    }

    protected function add_style_controls() {
        $this->start_controls_section(
            'section_style_lottie',
            [
                'label' => esc_html__('Lottie', 'lc-elementor-addons-kit'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'width',
            [
                'label' => esc_html__('Width', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vw'],
                'range' => [
                    'px' => [
                        'min' => 50,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 10,
                        'max' => 100,
                        'step' => 1,
                    ],
                    'vw' => [
                        'min' => 10,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 300,
                ],
                'selectors' => [
                    '{{WRAPPER}} .lc-lottie-container' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'height',
            [
                'label' => esc_html__('Height', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vh'],
                'range' => [
                    'px' => [
                        'min' => 50,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 10,
                        'max' => 100,
                        'step' => 1,
                    ],
                    'vh' => [
                        'min' => 10,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 300,
                ],
                'selectors' => [
                    '{{WRAPPER}} .lc-lottie-container' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'background_color',
            [
                'label' => esc_html__('Background Color', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lc-lottie-container' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'lottie_border',
                'selector' => '{{WRAPPER}} .lc-lottie-container',
            ]
        );

        $this->add_control(
            'border_radius',
            [
                'label' => esc_html__('Border Radius', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lc-lottie-container' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'padding',
            [
                'label' => esc_html__('Padding', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lc-lottie-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'margin',
            [
                'label' => esc_html__('Margin', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lc-lottie-container' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_controls',
            [
                'label' => esc_html__('Controls', 'lc-elementor-addons-kit'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_controls' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'controls_background_color',
            [
                'label' => esc_html__('Background Color', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lc-lottie-controls' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'controls_color',
            [
                'label' => esc_html__('Color', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lc-lottie-controls button' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'controls_size',
            [
                'label' => esc_html__('Size', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 20,
                        'max' => 60,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'size' => 40,
                ],
                'selectors' => [
                    '{{WRAPPER}} .lc-lottie-controls button' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'controls_border_radius',
            [
                'label' => esc_html__('Border Radius', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lc-lottie-controls button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        $lottie_data = '';
        
        if (!empty($settings['lottie_url']['url'])) {
            $lottie_data = $settings['lottie_url']['url'];
        } elseif (!empty($settings['lottie_file']['url'])) {
            $lottie_data = $settings['lottie_file']['url'];
        } elseif (!empty($settings['lottie_json'])) {
            $lottie_data = $settings['lottie_json'];
        }

        if (empty($lottie_data)) {
            return;
        }

        $this->add_render_attribute('wrapper', 'class', 'lc-lottie-wrapper');
        $this->add_render_attribute('wrapper', 'data-autoplay', $settings['autoplay']);
        $this->add_render_attribute('wrapper', 'data-loop', $settings['loop']);
        $this->add_render_attribute('wrapper', 'data-speed', $settings['speed']['size']);
        $this->add_render_attribute('wrapper', 'data-direction', $settings['direction']);
        $this->add_render_attribute('wrapper', 'data-renderer', $settings['renderer']);
        $this->add_render_attribute('wrapper', 'data-pause-on-hover', $settings['pause_on_hover']);

        echo '<div ' . $this->get_render_attribute_string('wrapper') . '>';
        
        echo '<div class="lc-lottie-container">';
        
        if ($settings['renderer'] === 'json') {
            echo '<div class="lc-lottie-animation" data-lottie="' . esc_attr($lottie_data) . '"></div>';
        } else {
            echo '<div class="lc-lottie-animation" data-lottie-url="' . esc_url($lottie_data) . '"></div>';
        }
        
        echo '</div>';

        if ($settings['show_controls'] === 'yes') {
            echo '<div class="lc-lottie-controls">';
            echo '<button class="lc-lottie-play" title="' . esc_attr__('Play', 'lc-elementor-addons-kit') . '">▶</button>';
            echo '<button class="lc-lottie-pause" title="' . esc_attr__('Pause', 'lc-elementor-addons-kit') . '">⏸</button>';
            echo '<button class="lc-lottie-stop" title="' . esc_attr__('Stop', 'lc-elementor-addons-kit') . '">⏹</button>';
            echo '<button class="lc-lottie-restart" title="' . esc_attr__('Restart', 'lc-elementor-addons-kit') . '">⏮</button>';
            echo '</div>';
        }
        
        echo '</div>';
    }

    protected function content_template() {
        ?>
        <# 
        var lottieData = '';
        if (settings.lottie_url.url) {
            lottieData = settings.lottie_url.url;
        } else if (settings.lottie_file.url) {
            lottieData = settings.lottie_file.url;
        } else if (settings.lottie_json) {
            lottieData = settings.lottie_json;
        }
        #>
        
        <# if (lottieData) { #>
            <div class="lc-lottie-wrapper" 
                 data-autoplay="{{ settings.autoplay }}"
                 data-loop="{{ settings.loop }}"
                 data-speed="{{ settings.speed.size }}"
                 data-direction="{{ settings.direction }}"
                 data-renderer="{{ settings.renderer }}"
                 data-pause-on-hover="{{ settings.pause_on-hover }}">
                
                <div class="lc-lottie-container">
                    <# if (settings.renderer === 'json') { #>
                        <div class="lc-lottie-animation" data-lottie="{{ lottieData }}"></div>
                    <# } else { #>
                        <div class="lc-lottie-animation" data-lottie-url="{{ lottieData }}"></div>
                    <# } #>
                </div>
                
                <# if (settings.show_controls === 'yes') { #>
                    <div class="lc-lottie-controls">
                        <button class="lc-lottie-play" title="<?php echo esc_attr__('Play', 'lc-elementor-addons-kit'); ?>">▶</button>
                        <button class="lc-lottie-pause" title="<?php echo esc_attr__('Pause', 'lc-elementor-addons-kit'); ?>">⏸</button>
                        <button class="lc-lottie-stop" title="<?php echo esc_attr__('Stop', 'lc-elementor-addons-kit'); ?>">⏹</button>
                        <button class="lc-lottie-restart" title="<?php echo esc_attr__('Restart', 'lc-elementor-addons-kit'); ?>">⏮</button>
                    </div>
                <# } #>
                
            </div>
        <# } #>
        <?php
    }
} 