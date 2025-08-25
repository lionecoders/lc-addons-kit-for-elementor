<?php
/**
 * Progress Bar Widget
 * 
 * @package LC_Elementor_Addons_Kit
 */

if (!defined('ABSPATH')) {
    exit;
}

class LC_Kit_Progress_Bar extends \Elementor\Widget_Base {

    public function get_name() {
        return 'lc-kit-progress-bar';
    }

    public function get_title() {
        return esc_html__('Progress Bar', 'lc-elementor-addons-kit');
    }

    public function get_icon() {
        return 'eicon-skill-bar';
    }

    public function get_categories() {
        return ['lc-page-kit'];
    }

    public function get_keywords() {
        return ['progress', 'bar', 'skill', 'percentage', 'meter'];
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
            'title',
            [
                'label' => esc_html__('Title', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Skill Name', 'lc-elementor-addons-kit'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'progress_type',
            [
                'label' => esc_html__('Type', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'line',
                'options' => [
                    'line' => esc_html__('Line', 'lc-elementor-addons-kit'),
                    'circle' => esc_html__('Circle', 'lc-elementor-addons-kit'),
                    'half-circle' => esc_html__('Half Circle', 'lc-elementor-addons-kit'),
                ],
            ]
        );

        $this->add_control(
            'percent',
            [
                'label' => esc_html__('Percentage', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['%'],
                'range' => [
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 50,
                ],
            ]
        );

        $this->add_control(
            'display_percentage',
            [
                'label' => esc_html__('Display Percentage', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'lc-elementor-addons-kit'),
                'label_off' => esc_html__('Hide', 'lc-elementor-addons-kit'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'inner_text',
            [
                'label' => esc_html__('Inner Text', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__('e.g. Web Design', 'lc-elementor-addons-kit'),
                'condition' => [
                    'progress_type' => ['circle', 'half-circle'],
                ],
            ]
        );

        $this->add_control(
            'view',
            [
                'label' => esc_html__('View', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::HIDDEN,
                'default' => 'traditional',
            ]
        );

        $this->end_controls_section();
    }

    protected function add_style_controls() {
        $this->start_controls_section(
            'section_progress_style',
            [
                'label' => esc_html__('Progress Bar', 'lc-elementor-addons-kit'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'bar_color',
            [
                'label' => esc_html__('Color', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lc-progress-bar-fill' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .lc-progress-circle-fill' => 'stroke: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'bar_background_color',
            [
                'label' => esc_html__('Background Color', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lc-progress-bar-bg' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .lc-progress-circle-bg' => 'stroke: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'bar_height',
            [
                'label' => esc_html__('Height', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 50,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'size' => 6,
                ],
                'selectors' => [
                    '{{WRAPPER}} .lc-progress-bar-bg' => 'height: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'progress_type' => 'line',
                ],
            ]
        );

        $this->add_control(
            'bar_border_radius',
            [
                'label' => esc_html__('Border Radius', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'size' => 3,
                ],
                'selectors' => [
                    '{{WRAPPER}} .lc-progress-bar-bg' => 'border-radius: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .lc-progress-bar-fill' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'progress_type' => 'line',
                ],
            ]
        );

        $this->add_control(
            'bar_stroke_width',
            [
                'label' => esc_html__('Stroke Width', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 50,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'size' => 6,
                ],
                'selectors' => [
                    '{{WRAPPER}} .lc-progress-circle-bg' => 'stroke-width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .lc-progress-circle-fill' => 'stroke-width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'progress_type' => ['circle', 'half-circle'],
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_title_style',
            [
                'label' => esc_html__('Title', 'lc-elementor-addons-kit'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__('Color', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lc-progress-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .lc-progress-title',
            ]
        );

        $this->add_responsive_control(
            'title_margin',
            [
                'label' => esc_html__('Margin', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lc-progress-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_percentage_style',
            [
                'label' => esc_html__('Percentage', 'lc-elementor-addons-kit'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'display_percentage' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'percentage_color',
            [
                'label' => esc_html__('Color', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lc-progress-percentage' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'percentage_typography',
                'selector' => '{{WRAPPER}} .lc-progress-percentage',
            ]
        );

        $this->add_responsive_control(
            'percentage_margin',
            [
                'label' => esc_html__('Margin', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lc-progress-percentage' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        $this->add_render_attribute('wrapper', 'class', 'lc-progress-wrapper');
        $this->add_render_attribute('wrapper', 'class', 'lc-progress--' . $settings['progress_type']);

        echo '<div ' . $this->get_render_attribute_string('wrapper') . '>';

        if (!empty($settings['title'])) {
            echo '<div class="lc-progress-title">' . esc_html($settings['title']) . '</div>';
        }

        if ($settings['progress_type'] === 'line') {
            $this->render_line_progress($settings);
        } else {
            $this->render_circle_progress($settings);
        }

        echo '</div>';
    }

    private function render_line_progress($settings) {
        $percentage = $settings['percent']['size'];
        
        echo '<div class="lc-progress-bar">';
        echo '<div class="lc-progress-bar-bg">';
        echo '<div class="lc-progress-bar-fill" style="width: ' . esc_attr($percentage) . '%"></div>';
        echo '</div>';
        
        if ($settings['display_percentage'] === 'yes') {
            echo '<div class="lc-progress-percentage">' . esc_html($percentage) . '%</div>';
        }
        
        echo '</div>';
    }

    private function render_circle_progress($settings) {
        $percentage = $settings['percent']['size'];
        $radius = 50;
        $circumference = 2 * M_PI * $radius;
        $stroke_dasharray = $circumference;
        $stroke_dashoffset = $circumference - ($percentage / 100) * $circumference;
        
        if ($settings['progress_type'] === 'half-circle') {
            $stroke_dasharray = $circumference / 2;
            $stroke_dashoffset = ($circumference / 2) - ($percentage / 100) * ($circumference / 2);
        }

        echo '<div class="lc-progress-circle">';
        echo '<svg viewBox="0 0 120 120" class="lc-progress-circle-svg">';
        
        if ($settings['progress_type'] === 'half-circle') {
            echo '<circle cx="60" cy="60" r="' . $radius . '" class="lc-progress-circle-bg" stroke-dasharray="' . $stroke_dasharray . '" stroke-dashoffset="0" transform="rotate(-90 60 60)"></circle>';
            echo '<circle cx="60" cy="60" r="' . $radius . '" class="lc-progress-circle-fill" stroke-dasharray="' . $stroke_dasharray . '" stroke-dashoffset="' . $stroke_dashoffset . '" transform="rotate(-90 60 60)"></circle>';
        } else {
            echo '<circle cx="60" cy="60" r="' . $radius . '" class="lc-progress-circle-bg"></circle>';
            echo '<circle cx="60" cy="60" r="' . $radius . '" class="lc-progress-circle-fill" stroke-dasharray="' . $stroke_dasharray . '" stroke-dashoffset="' . $stroke_dashoffset . '" transform="rotate(-90 60 60)"></circle>';
        }
        
        echo '</svg>';
        
        echo '<div class="lc-progress-circle-content">';
        if ($settings['display_percentage'] === 'yes') {
            echo '<div class="lc-progress-percentage">' . esc_html($percentage) . '%</div>';
        }
        if (!empty($settings['inner_text'])) {
            echo '<div class="lc-progress-inner-text">' . esc_html($settings['inner_text']) . '</div>';
        }
        echo '</div>';
        
        echo '</div>';
    }

    protected function content_template() {
        ?>
        <div class="lc-progress-wrapper lc-progress--{{ settings.progress_type }}">
            <# if (settings.title) { #>
                <div class="lc-progress-title">{{{ settings.title }}}</div>
            <# } #>
            
            <# if (settings.progress_type === 'line') { #>
                <div class="lc-progress-bar">
                    <div class="lc-progress-bar-bg">
                        <div class="lc-progress-bar-fill" style="width: {{ settings.percent.size }}%"></div>
                    </div>
                    <# if (settings.display_percentage === 'yes') { #>
                        <div class="lc-progress-percentage">{{{ settings.percent.size }}}%</div>
                    <# } #>
                </div>
            <# } else { #>
                <div class="lc-progress-circle">
                    <svg viewBox="0 0 120 120" class="lc-progress-circle-svg">
                        <circle cx="60" cy="60" r="50" class="lc-progress-circle-bg"></circle>
                        <circle cx="60" cy="60" r="50" class="lc-progress-circle-fill" stroke-dasharray="314" stroke-dashoffset="{{ 314 - (settings.percent.size / 100) * 314 }}" transform="rotate(-90 60 60)"></circle>
                    </svg>
                    <div class="lc-progress-circle-content">
                        <# if (settings.display_percentage === 'yes') { #>
                            <div class="lc-progress-percentage">{{{ settings.percent.size }}}%</div>
                        <# } #>
                        <# if (settings.inner_text) { #>
                            <div class="lc-progress-inner-text">{{{ settings.inner_text }}}</div>
                        <# } #>
                    </div>
                </div>
            <# } #>
        </div>
        <?php
    }
} 