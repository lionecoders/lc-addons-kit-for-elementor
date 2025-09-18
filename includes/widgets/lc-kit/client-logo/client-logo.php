<?php
/**
 * Client Logo Widget
 * 
 * @package LC_Elementor_Addons_Kit
 */

if (!defined('ABSPATH')) {
    exit;
}

class LC_Kit_Client_Logo extends \Elementor\Widget_Base {

    public function get_name() {
        return 'lc-kit-client-logo';
    }

    public function get_title() {
        return esc_html__('Client Logo', 'lc-addons-kit-for-elementor');
    }

    public function get_icon() {
        return 'eicon-carousel';
    }

    public function get_categories() {
        return ['lc-page-kit'];
    }

    public function get_keywords() {
        return ['client', 'logo', 'brand', 'carousel', 'slider', 'partners'];
    }

    public function get_script_depends() {
        return ['lc-client-logo'];
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
            'logo',
            [
                'label' => esc_html__('Logo', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $repeater->add_control(
            'title',
            [
                'label' => esc_html__('Title', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Client Name', 'lc-addons-kit-for-elementor'),
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
            'logos',
            [
                'label' => esc_html__('Logos', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'title' => esc_html__('Client #1', 'lc-addons-kit-for-elementor'),
                    ],
                    [
                        'title' => esc_html__('Client #2', 'lc-addons-kit-for-elementor'),
                    ],
                    [
                        'title' => esc_html__('Client #3', 'lc-addons-kit-for-elementor'),
                    ],
                    [
                        'title' => esc_html__('Client #4', 'lc-addons-kit-for-elementor'),
                    ],
                ],
                'title_field' => '{{{ title }}}',
            ]
        );

        $this->add_control(
            'layout',
            [
                'label' => esc_html__('Layout', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'grid',
                'options' => [
                    'grid' => esc_html__('Grid', 'lc-addons-kit-for-elementor'),
                    'carousel' => esc_html__('Carousel', 'lc-addons-kit-for-elementor'),
                ],
            ]
        );

        $this->add_responsive_control(
            'columns',
            [
                'label' => esc_html__('Columns', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '4',
                'tablet_default' => '2',
                'mobile_default' => '1',
                'options' => [
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                    '6' => '6',
                ],
                'condition' => [
                    'layout' => 'grid',
                ],
            ]
        );

        $this->add_control(
            'show_title',
            [
                'label' => esc_html__('Show Title', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'lc-addons-kit-for-elementor'),
                'label_off' => esc_html__('Hide', 'lc-addons-kit-for-elementor'),
                'return_value' => 'yes',
                'default' => '',
            ]
        );

        $this->end_controls_section();

        // Carousel Settings
        $this->start_controls_section(
            'carousel_section',
            [
                'label' => esc_html__('Carousel Settings', 'lc-addons-kit-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'layout' => 'carousel',
                ],
            ]
        );

        $this->add_control(
            'autoplay',
            [
                'label' => esc_html__('Autoplay', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'lc-addons-kit-for-elementor'),
                'label_off' => esc_html__('No', 'lc-addons-kit-for-elementor'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'autoplay_speed',
            [
                'label' => esc_html__('Autoplay Speed', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 1000,
                'max' => 10000,
                'step' => 500,
                'default' => 3000,
                'condition' => [
                    'autoplay' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'pause_on_hover',
            [
                'label' => esc_html__('Pause on Hover', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'lc-addons-kit-for-elementor'),
                'label_off' => esc_html__('No', 'lc-addons-kit-for-elementor'),
                'return_value' => 'yes',
                'default' => 'yes',
                'condition' => [
                    'autoplay' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'show_arrows',
            [
                'label' => esc_html__('Show Arrows', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'lc-addons-kit-for-elementor'),
                'label_off' => esc_html__('Hide', 'lc-addons-kit-for-elementor'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_dots',
            [
                'label' => esc_html__('Show Dots', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'lc-addons-kit-for-elementor'),
                'label_off' => esc_html__('Hide', 'lc-addons-kit-for-elementor'),
                'return_value' => 'yes',
                'default' => '',
            ]
        );

        $this->add_control(
            'slides_to_show',
            [
                'label' => esc_html__('Slides to Show', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 10,
                'default' => 4,
            ]
        );

        $this->add_control(
            'slides_to_scroll',
            [
                'label' => esc_html__('Slides to Scroll', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 10,
                'default' => 1,
            ]
        );

        $this->end_controls_section();
    }

    protected function add_style_controls() {
        $this->start_controls_section(
            'section_style_logo',
            [
                'label' => esc_html__('Logo', 'lc-addons-kit-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'logo_width',
            [
                'label' => esc_html__('Width', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 50,
                        'max' => 300,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 10,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 150,
                ],
                'selectors' => [
                    '{{WRAPPER}} .lc-client-logo img' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'logo_height',
            [
                'label' => esc_html__('Height', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 30,
                        'max' => 200,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 10,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 80,
                ],
                'selectors' => [
                    '{{WRAPPER}} .lc-client-logo img' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'logo_opacity',
            [
                'label' => esc_html__('Opacity', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 1,
                        'min' => 0.1,
                        'step' => 0.1,
                    ],
                ],
                'default' => [
                    'size' => 0.7,
                ],
                'selectors' => [
                    '{{WRAPPER}} .lc-client-logo img' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->add_control(
            'logo_hover_opacity',
            [
                'label' => esc_html__('Hover Opacity', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 1,
                        'min' => 0.1,
                        'step' => 0.1,
                    ],
                ],
                'default' => [
                    'size' => 1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .lc-client-logo:hover img' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'logo_border',
                'selector' => '{{WRAPPER}} .lc-client-logo',
            ]
        );

        $this->add_control(
            'logo_border_radius',
            [
                'label' => esc_html__('Border Radius', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lc-client-logo' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'logo_padding',
            [
                'label' => esc_html__('Padding', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lc-client-logo' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'logo_margin',
            [
                'label' => esc_html__('Margin', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lc-client-logo' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_title',
            [
                'label' => esc_html__('Title', 'lc-addons-kit-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_title' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__('Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lc-client-logo-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .lc-client-logo-title',
            ]
        );

        $this->add_responsive_control(
            'title_margin',
            [
                'label' => esc_html__('Margin', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lc-client-logo-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_arrows',
            [
                'label' => esc_html__('Arrows', 'lc-addons-kit-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'layout' => 'carousel',
                    'show_arrows' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'arrows_color',
            [
                'label' => esc_html__('Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lc-client-logo-arrow' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'arrows_background_color',
            [
                'label' => esc_html__('Background Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lc-client-logo-arrow' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'arrows_size',
            [
                'label' => esc_html__('Size', 'lc-addons-kit-for-elementor'),
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
                    '{{WRAPPER}} .lc-client-logo-arrow' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_dots',
            [
                'label' => esc_html__('Dots', 'lc-addons-kit-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'layout' => 'carousel',
                    'show_dots' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'dots_color',
            [
                'label' => esc_html__('Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lc-client-logo-dot' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'dots_active_color',
            [
                'label' => esc_html__('Active Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lc-client-logo-dot.active' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'dots_size',
            [
                'label' => esc_html__('Size', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 6,
                        'max' => 20,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'size' => 10,
                ],
                'selectors' => [
                    '{{WRAPPER}} .lc-client-logo-dot' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        if (empty($settings['logos'])) {
            return;
        }

        $this->add_render_attribute('wrapper', 'class', 'lc-client-logo-wrapper');
        $this->add_render_attribute('wrapper', 'class', 'lc-client-logo--' . $settings['layout']);

        if ($settings['layout'] === 'carousel') {
            $this->add_render_attribute('wrapper', 'data-autoplay', $settings['autoplay']);
            $this->add_render_attribute('wrapper', 'data-autoplay-speed', $settings['autoplay_speed']);
            $this->add_render_attribute('wrapper', 'data-pause-on-hover', $settings['pause_on_hover']);
            $this->add_render_attribute('wrapper', 'data-slides-to-show', $settings['slides_to_show']);
            $this->add_render_attribute('wrapper', 'data-slides-to-scroll', $settings['slides_to_scroll']);
        } else {
            $this->add_render_attribute('wrapper', 'data-columns', $settings['columns']);
        }

        echo '<div ' . $this->get_render_attribute_string('wrapper') . '>';

        if ($settings['layout'] === 'carousel' && $settings['show_arrows'] === 'yes') {
            echo '<div class="lc-client-logo-arrow lc-client-logo-arrow-prev">&lt;</div>';
        }

        echo '<div class="lc-client-logo-container">';
        
        foreach ($settings['logos'] as $logo) {
            echo '<div class="lc-client-logo">';
            
            if (!empty($logo['logo']['url'])) {
                if (!empty($logo['link']['url'])) {
                    $this->add_link_attributes('link_' . $logo['_id'], $logo['link']);
                    echo '<a ' . $this->get_render_attribute_string('link_' . $logo['_id']) . '>';
                }
                
                echo '<img src="' . esc_url($logo['logo']['url']) . '" alt="' . esc_attr($logo['title']) . '">';
                
                if (!empty($logo['link']['url'])) {
                    echo '</a>';
                }
            }

            if ($settings['show_title'] === 'yes' && !empty($logo['title'])) {
                echo '<div class="lc-client-logo-title">' . esc_html($logo['title']) . '</div>';
            }

            echo '</div>';
        }

        echo '</div>';

        if ($settings['layout'] === 'carousel' && $settings['show_arrows'] === 'yes') {
            echo '<div class="lc-client-logo-arrow lc-client-logo-arrow-next">&gt;</div>';
        }

        if ($settings['layout'] === 'carousel' && $settings['show_dots'] === 'yes') {
            echo '<div class="lc-client-logo-dots"></div>';
        }

        echo '</div>';
    }

    protected function content_template() {
        ?>
        <# if (settings.logos.length > 0) { #>
            <div class="lc-client-logo-wrapper lc-client-logo--{{ settings.layout }}" 
                 data-autoplay="{{ settings.autoplay }}"
                 data-autoplay-speed="{{ settings.autoplay_speed }}"
                 data-pause-on-hover="{{ settings.pause_on_hover }}"
                 data-slides-to-show="{{ settings.slides_to_show }}"
                 data-slides-to-scroll="{{ settings.slides_to_scroll }}"
                 data-columns="{{ settings.columns }}">
                
                <# if (settings.layout === 'carousel' && settings.show_arrows === 'yes') { #>
                    <div class="lc-client-logo-arrow lc-client-logo-arrow-prev">&lt;</div>
                <# } #>
                
                <div class="lc-client-logo-container">
                    <# _.each(settings.logos, function(logo) { #>
                        <div class="lc-client-logo">
                            <# if (logo.logo.url) { #>
                                <# if (logo.link.url) { #>
                                    <a href="{{ logo.link.url }}">
                                <# } #>
                                <img src="{{ logo.logo.url }}" alt="{{ logo.title }}">
                                <# if (logo.link.url) { #>
                                    </a>
                                <# } #>
                            <# } #>
                            <# if (settings.show_title === 'yes' && logo.title) { #>
                                <div class="lc-client-logo-title">{{{ logo.title }}}</div>
                            <# } #>
                        </div>
                    <# }); #>
                </div>
                
                <# if (settings.layout === 'carousel' && settings.show_arrows === 'yes') { #>
                    <div class="lc-client-logo-arrow lc-client-logo-arrow-next">&gt;</div>
                <# } #>
                
                <# if (settings.layout === 'carousel' && settings.show_dots === 'yes') { #>
                    <div class="lc-client-logo-dots"></div>
                <# } #>
            </div>
        <# } #>
        <?php
    }
} 