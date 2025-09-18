<?php
/**
 * Image Accordion Widget
 * 
 * @package LC_Elementor_Addons_Kit
 */

if (!defined('ABSPATH')) {
    exit;
}

class LC_Kit_Image_Accordion extends \Elementor\Widget_Base {

    public function get_name() {
        return 'lc-kit-image-accordion';
    }

    public function get_title() {
        return esc_html__('Image Accordion Widget', 'lc-addons-kit-for-elementor');
    }

    public function get_icon() {
        return 'eicon-gallery-grid';
    }

    public function get_categories() {
        return ['lc-page-kit'];
    }

    public function get_keywords() {
        return ['image', 'accordion', 'gallery', 'hover', 'effect'];
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
            'image',
            [
                'label' => esc_html__('Image', 'lc-addons-kit-for-elementor'),
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
                'default' => esc_html__('Accordion Item', 'lc-addons-kit-for-elementor'),
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
            'link',
            [
                'label' => esc_html__('Link', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => esc_html__('https://your-link.com', 'lc-addons-kit-for-elementor'),
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
                        'title' => esc_html__('Accordion Item #1', 'lc-addons-kit-for-elementor'),
                        'description' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'lc-addons-kit-for-elementor'),
                    ],
                    [
                        'title' => esc_html__('Accordion Item #2', 'lc-addons-kit-for-elementor'),
                        'description' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'lc-addons-kit-for-elementor'),
                    ],
                    [
                        'title' => esc_html__('Accordion Item #3', 'lc-addons-kit-for-elementor'),
                        'description' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'lc-addons-kit-for-elementor'),
                    ],
                ],
                'title_field' => '{{{ title }}}',
            ]
        );

        $this->add_control(
            'height',
            [
                'label' => esc_html__('Height', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'vh'],
                'range' => [
                    'px' => [
                        'min' => 200,
                        'max' => 800,
                        'step' => 10,
                    ],
                    'vh' => [
                        'min' => 20,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 400,
                ],
                'selectors' => [
                    '{{WRAPPER}} .lc-image-accordion' => 'height: {{SIZE}}{{UNIT}};',
                ],
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
            ]
        );

        $this->end_controls_section();
    }

    protected function add_style_controls() {
        $this->start_controls_section(
            'style_section',
            [
                'label' => esc_html__('Style', 'lc-addons-kit-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'border_radius',
            [
                'label' => esc_html__('Border Radius', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lc-image-accordion-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'overlay_color',
            [
                'label' => esc_html__('Overlay Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lc-image-accordion-item::before' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'overlay_opacity',
            [
                'label' => esc_html__('Overlay Opacity', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 1,
                        'min' => 0.1,
                        'step' => 0.1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .lc-image-accordion-item::before' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Title Style
        $this->start_controls_section(
            'title_style_section',
            [
                'label' => esc_html__('Title', 'lc-addons-kit-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .lc-image-accordion-title',
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__('Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lc-image-accordion-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Text_Shadow::get_type(),
            [
                'name' => 'title_text_shadow',
                'selector' => '{{WRAPPER}} .lc-image-accordion-title',
            ]
        );

        $this->end_controls_section();

        // Description Style
        $this->start_controls_section(
            'description_style_section',
            [
                'label' => esc_html__('Description', 'lc-addons-kit-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'description_typography',
                'selector' => '{{WRAPPER}} .lc-image-accordion-description',
            ]
        );

        $this->add_control(
            'description_color',
            [
                'label' => esc_html__('Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lc-image-accordion-description' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        if (empty($settings['accordion_items'])) {
            return;
        }

        $this->add_render_attribute('wrapper', 'class', 'lc-image-accordion');
        $this->add_render_attribute('wrapper', 'data-active', $settings['active_item']);

        echo '<div ' . $this->get_render_attribute_string('wrapper') . '>';
        
        foreach ($settings['accordion_items'] as $index => $item) {
            $item_class = 'lc-image-accordion-item';
            if ($index + 1 == $settings['active_item']) {
                $item_class .= ' active';
            }

            echo '<div class="' . esc_attr($item_class) . '">';
            
            if (!empty($item['image']['url'])) {
                echo '<div class="lc-image-accordion-image">';
                echo '<img src="' . esc_url($item['image']['url']) . '" alt="' . esc_attr($item['title']) . '">';
                echo '</div>';
            }

            echo '<div class="lc-image-accordion-content">';
            
            if (!empty($item['title'])) {
                echo '<h3 class="lc-image-accordion-title">' . esc_html($item['title']) . '</h3>';
            }

            if (!empty($item['description'])) {
                echo '<div class="lc-image-accordion-description">' . esc_html($item['description']) . '</div>';
            }

            if (!empty($item['link']['url'])) {
                $this->add_link_attributes('link_' . $index, $item['link']);
                echo '<a ' . $this->get_render_attribute_string('link_' . $index) . ' class="lc-image-accordion-link">';
                echo esc_html__('Learn More', 'lc-addons-kit-for-elementor');
                echo '</a>';
            }

            echo '</div>';
            echo '</div>';
        }

        echo '</div>';
    }

    protected function content_template() {
        ?>
        <# if (settings.accordion_items.length > 0) { #>
            <div class="lc-image-accordion" data-active="{{ settings.active_item }}">
                <# _.each(settings.accordion_items, function(item, index) { #>
                    <div class="lc-image-accordion-item<# if (index + 1 == settings.active_item) { #> active<# } #>">
                        <# if (item.image.url) { #>
                            <div class="lc-image-accordion-image">
                                <img src="{{ item.image.url }}" alt="{{ item.title }}">
                            </div>
                        <# } #>
                        <div class="lc-image-accordion-content">
                            <# if (item.title) { #>
                                <h3 class="lc-image-accordion-title">{{{ item.title }}}</h3>
                            <# } #>
                            <# if (item.description) { #>
                                <div class="lc-image-accordion-description">{{{ item.description }}}</div>
                            <# } #>
                            <# if (item.link.url) { #>
                                <a href="{{ item.link.url }}" class="lc-image-accordion-link">
                                    <?php echo esc_html__('Learn More', 'lc-addons-kit-for-elementor'); ?>
                                </a>
                            <# } #>
                        </div>
                    </div>
                <# }); #>
            </div>
        <# } #>
        <?php
    }
} 