<?php
/**
 * Funfact Widget
 * 
 * @package LC_Elementor_Addons_Kit
 */

if (!defined('ABSPATH')) {
    exit;
}

class LC_Kit_Funfact extends \Elementor\Widget_Base {

    public function get_name() {
        return 'lc-kit-funfact';
    }

    public function get_title() {
        return esc_html__('LC Funfact', 'lc-addons-kit-for-elementor');
    }

    public function get_icon() {
        return 'eicon-number-field';
    }

    public function get_categories() {
        return ['lc-page-kit'];
    }

    public function get_keywords() {
        return ['funfact', 'counter', 'statistics', 'number', 'animation'];
    }

    public function get_script_depends() {
        return ['lc-funfact'];
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
            'number',
            [
                'label' => esc_html__('Number', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 100,
                'min' => 0,
                'step' => 1,
            ]
        );

        $repeater->add_control(
            'title',
            [
                'label' => esc_html__('Title', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Funfact Title', 'lc-addons-kit-for-elementor'),
            ]
        );

        $repeater->add_control(
            'description',
            [
                'label' => esc_html__('Description', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'lc-addons-kit-for-elementor'),
            ]
        );

        $repeater->add_control(
            'icon',
            [
                'label' => esc_html__('Icon', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-star',
                    'library' => 'fa-solid',
                ],
            ]
        );

        $repeater->add_control(
            'prefix',
            [
                'label' => esc_html__('Prefix', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__('+', 'lc-addons-kit-for-elementor'),
            ]
        );

        $repeater->add_control(
            'suffix',
            [
                'label' => esc_html__('Suffix', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__('K', 'lc-addons-kit-for-elementor'),
            ]
        );

        $repeater->add_control(
            'link',
            [
                'label' => esc_html__('Link', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => esc_html__('https://your-link.com', 'lc-addons-kit-for-elementor'),
            ]
        );

        $this->add_control(
            'funfact_items',
            [
                'label' => esc_html__('Funfact Items', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'number' => 100,
                        'title' => esc_html__('Happy Clients', 'lc-addons-kit-for-elementor'),
                        'description' => esc_html__('Satisfied customers worldwide', 'lc-addons-kit-for-elementor'),
                    ],
                    [
                        'number' => 500,
                        'title' => esc_html__('Projects Completed', 'lc-addons-kit-for-elementor'),
                        'description' => esc_html__('Successful projects delivered', 'lc-addons-kit-for-elementor'),
                    ],
                    [
                        'number' => 50,
                        'title' => esc_html__('Team Members', 'lc-addons-kit-for-elementor'),
                        'description' => esc_html__('Expert professionals', 'lc-addons-kit-for-elementor'),
                    ],
                    [
                        'number' => 10,
                        'title' => esc_html__('Years Experience', 'lc-addons-kit-for-elementor'),
                        'description' => esc_html__('Industry expertise', 'lc-addons-kit-for-elementor'),
                    ],
                ],
                'title_field' => '{{{ title }}}',
            ]
        );

        $this->add_control(
            'columns',
            [
                'label' => esc_html__('Columns', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '4',
                'options' => [
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                    '6' => '6',
                ],
            ]
        );

        $this->add_control(
            'animation_duration',
            [
                'label' => esc_html__('Animation Duration', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 500,
                'max' => 5000,
                'step' => 100,
                'default' => 2000,
                'description' => esc_html__('Duration in milliseconds', 'lc-addons-kit-for-elementor'),
            ]
        );

        $this->add_control(
            'animation_delay',
            [
                'label' => esc_html__('Animation Delay', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 2000,
                'step' => 100,
                'default' => 0,
                'description' => esc_html__('Delay before animation starts (ms)', 'lc-addons-kit-for-elementor'),
            ]
        );

        $this->end_controls_section();
    }

    protected function add_style_controls() {
        $this->start_controls_section(
            'section_style_funfact',
            [
                'label' => esc_html__('Funfact', 'lc-addons-kit-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'funfact_alignment',
            [
                'label' => esc_html__('Alignment', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'lc-addons-kit-for-elementor'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'lc-addons-kit-for-elementor'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'lc-addons-kit-for-elementor'),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .lc-funfact-item' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'funfact_background_color',
            [
                'label' => esc_html__('Background Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lc-funfact-item' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'funfact_border',
                'selector' => '{{WRAPPER}} .lc-funfact-item',
            ]
        );

        $this->add_control(
            'funfact_border_radius',
            [
                'label' => esc_html__('Border Radius', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lc-funfact-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'funfact_padding',
            [
                'label' => esc_html__('Padding', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lc-funfact-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'funfact_margin',
            [
                'label' => esc_html__('Margin', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lc-funfact-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_icon',
            [
                'label' => esc_html__('Icon', 'lc-addons-kit-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'icon_size',
            [
                'label' => esc_html__('Size', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 6,
                        'max' => 300,
                    ],
                ],
                'default' => [
                    'size' => 50,
                ],
                'selectors' => [
                    '{{WRAPPER}} .lc-funfact-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label' => esc_html__('Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lc-funfact-icon' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'icon_background_color',
            [
                'label' => esc_html__('Background Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lc-funfact-icon' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_margin',
            [
                'label' => esc_html__('Margin', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lc-funfact-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_number',
            [
                'label' => esc_html__('Number', 'lc-addons-kit-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'number_color',
            [
                'label' => esc_html__('Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lc-funfact-number' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'number_typography',
                'selector' => '{{WRAPPER}} .lc-funfact-number',
            ]
        );

        $this->add_responsive_control(
            'number_margin',
            [
                'label' => esc_html__('Margin', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lc-funfact-number' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_title',
            [
                'label' => esc_html__('Title', 'lc-addons-kit-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__('Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lc-funfact-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .lc-funfact-title',
            ]
        );

        $this->add_responsive_control(
            'title_margin',
            [
                'label' => esc_html__('Margin', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lc-funfact-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_description',
            [
                'label' => esc_html__('Description', 'lc-addons-kit-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'description_color',
            [
                'label' => esc_html__('Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lc-funfact-description' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'description_typography',
                'selector' => '{{WRAPPER}} .lc-funfact-description',
            ]
        );

        $this->add_responsive_control(
            'description_margin',
            [
                'label' => esc_html__('Margin', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lc-funfact-description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        if (empty($settings['funfact_items'])) {
            return;
        }

        $this->add_render_attribute('wrapper', 'class', 'lc-funfact-wrapper');
        $this->add_render_attribute('wrapper', 'data-columns', $settings['columns']);
        $this->add_render_attribute('wrapper', 'data-duration', $settings['animation_duration']);
        $this->add_render_attribute('wrapper', 'data-delay', $settings['animation_delay']);

        echo '<div ' . $this->get_render_attribute_string('wrapper') . '>';
        
        foreach ($settings['funfact_items'] as $item) {
            $item_class = 'lc-funfact-item';
            if (!empty($item['link']['url'])) {
                $item_class .= ' has-link';
            }

            echo '<div class="' . esc_attr($item_class) . '">';
            
            if (!empty($item['link']['url'])) {
                $this->add_link_attributes('link_' . $item['_id'], $item['link']);
                echo '<a ' . $this->get_render_attribute_string('link_' . $item['_id']) . '>';
            }

            if (!empty($item['icon']['value'])) {
                echo '<div class="lc-funfact-icon">';
                \Elementor\Icons_Manager::render_icon($item['icon'], ['aria-hidden' => 'true']);
                echo '</div>';
            }

            echo '<div class="lc-funfact-number" data-number="' . esc_attr($item['number']) . '">';
            if (!empty($item['prefix'])) {
                echo '<span class="lc-funfact-prefix">' . esc_html($item['prefix']) . '</span>';
            }
            echo '<span class="lc-funfact-counter">0</span>';
            if (!empty($item['suffix'])) {
                echo '<span class="lc-funfact-suffix">' . esc_html($item['suffix']) . '</span>';
            }
            echo '</div>';

            if (!empty($item['title'])) {
                echo '<div class="lc-funfact-title">' . esc_html($item['title']) . '</div>';
            }

            if (!empty($item['description'])) {
                echo '<div class="lc-funfact-description">' . esc_html($item['description']) . '</div>';
            }

            if (!empty($item['link']['url'])) {
                echo '</a>';
            }

            echo '</div>';
        }

        echo '</div>';
    }

    protected function content_template() {
        ?>
        <# if (settings.funfact_items.length > 0) { #>
            <div class="lc-funfact-wrapper" data-columns="{{ settings.columns }}" data-duration="{{ settings.animation_duration }}" data-delay="{{ settings.animation_delay }}">
                <# _.each(settings.funfact_items, function(item) { #>
                    <div class="lc-funfact-item<# if (item.link.url) { #> has-link<# } #>">
                        <# if (item.link.url) { #>
                            <a href="{{ item.link.url }}">
                        <# } #>
                        
                        <# if (item.icon.value) { #>
                            <div class="lc-funfact-icon">
                                <i class="{{ item.icon.value }}" aria-hidden="true"></i>
                            </div>
                        <# } #>
                        
                        <div class="lc-funfact-number" data-number="{{ item.number }}">
                            <# if (item.prefix) { #>
                                <span class="lc-funfact-prefix">{{{ item.prefix }}}</span>
                            <# } #>
                            <span class="lc-funfact-counter">0</span>
                            <# if (item.suffix) { #>
                                <span class="lc-funfact-suffix">{{{ item.suffix }}}</span>
                            <# } #>
                        </div>
                        
                        <# if (item.title) { #>
                            <div class="lc-funfact-title">{{{ item.title }}}</div>
                        <# } #>
                        
                        <# if (item.description) { #>
                            <div class="lc-funfact-description">{{{ item.description }}}</div>
                        <# } #>
                        
                        <# if (item.link.url) { #>
                            </a>
                        <# } #>
                    </div>
                <# }); #>
            </div>
        <# } #>
        <?php
    }
} 