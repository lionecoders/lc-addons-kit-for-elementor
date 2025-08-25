<?php
/**
 * Icon Box Widget
 * 
 * @package LC_Elementor_Addons_Kit
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Icon Box Widget Class
 */
class LC_Kit_Icon_Box extends \Elementor\Widget_Base {

    /**
     * Get widget name
     */
    public function get_name() {
        return 'lc-kit-icon-box';
    }

    /**
     * Get widget categories
     */
    public function get_categories() {
        return ['lc-page-kit'];
    }

    /**
     * Get widget title
     */
    public function get_title() {
        return esc_html__('Icon Box', 'lc-elementor-addons-kit');
    }

    /**
     * Get widget icon
     */
    public function get_icon() {
        return 'eicon-icon-box';
    }

    /**
     * Add content controls
     */
    protected function add_content_controls() {
        $this->add_control(
            'icon',
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
            'title',
            [
                'label' => esc_html__('Title', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Icon Box Title', 'lc-elementor-addons-kit'),
                'placeholder' => esc_html__('Enter your title', 'lc-elementor-addons-kit'),
            ]
        );

        $this->add_control(
            'description',
            [
                'label' => esc_html__('Description', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'lc-elementor-addons-kit'),
                'placeholder' => esc_html__('Enter your description', 'lc-elementor-addons-kit'),
            ]
        );

        $this->add_control(
            'link',
            [
                'label' => esc_html__('Link', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => esc_html__('https://your-link.com', 'lc-elementor-addons-kit'),
                'default' => [
                    'url' => '',
                    'is_external' => false,
                    'nofollow' => false,
                ],
            ]
        );

        $this->add_control(
            'icon_position',
            [
                'label' => esc_html__('Icon Position', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'top',
                'options' => [
                    'top' => esc_html__('Top', 'lc-elementor-addons-kit'),
                    'left' => esc_html__('Left', 'lc-elementor-addons-kit'),
                    'right' => esc_html__('Right', 'lc-elementor-addons-kit'),
                ],
            ]
        );

        $this->add_control(
            'icon_size',
            [
                'label' => esc_html__('Icon Size', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 200,
                    ],
                    'em' => [
                        'min' => 0.5,
                        'max' => 20,
                    ],
                    'rem' => [
                        'min' => 0.5,
                        'max' => 20,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 60,
                ],
                'selectors' => [
                    '{{WRAPPER}} .lc-kit-icon-box-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .lc-kit-icon-box-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
    }

    /**
     * Add style controls
     */
    protected function add_style_controls() {
        // Icon styles
        $this->add_control(
            'icon_color',
            [
                'label' => esc_html__('Icon Color', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lc-kit-icon-box-icon i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .lc-kit-icon-box-icon svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'icon_background_color',
            [
                'label' => esc_html__('Icon Background Color', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lc-kit-icon-box-icon' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'icon_border',
                'selector' => '{{WRAPPER}} .lc-kit-icon-box-icon',
            ]
        );

        $this->add_control(
            'icon_border_radius',
            [
                'label' => esc_html__('Icon Border Radius', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lc-kit-icon-box-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Title styles
        $this->add_control(
            'title_color',
            [
                'label' => esc_html__('Title Color', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lc-kit-icon-box-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .lc-kit-icon-box-title',
            ]
        );

        // Description styles
        $this->add_control(
            'description_color',
            [
                'label' => esc_html__('Description Color', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lc-kit-icon-box-description' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'description_typography',
                'selector' => '{{WRAPPER}} .lc-kit-icon-box-description',
            ]
        );

        // Box styles
        $this->add_control(
            'box_background_color',
            [
                'label' => esc_html__('Box Background Color', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lc-kit-icon-box' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'box_border',
                'selector' => '{{WRAPPER}} .lc-kit-icon-box',
            ]
        );

        $this->add_control(
            'box_border_radius',
            [
                'label' => esc_html__('Box Border Radius', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lc-kit-icon-box' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'box_padding',
            [
                'label' => esc_html__('Box Padding', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lc-kit-icon-box' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
    }

    /**
     * Render widget
     */
    protected function render_widget($settings) {
        $icon = $settings['icon'];
        $title = $settings['title'];
        $description = $settings['description'];
        $link = $settings['link'];
        $icon_position = $settings['icon_position'];

        $this->add_render_attribute('icon_box', 'class', [
            'lc-kit-icon-box',
            'lc-kit-icon-box--' . $icon_position,
        ]);

        $this->add_render_attribute('icon', 'class', 'lc-kit-icon-box-icon');
        $this->add_render_attribute('title', 'class', 'lc-kit-icon-box-title');
        $this->add_render_attribute('description', 'class', 'lc-kit-icon-box-description');

        ?>
        <div <?php echo $this->get_render_attribute_string('icon_box'); ?>>
            <?php if (!empty($icon['value'])) : ?>
                <div <?php echo $this->get_render_attribute_string('icon'); ?>>
                    <?php \Elementor\Icons_Manager::render_icon($icon, ['aria-hidden' => 'true']); ?>
                </div>
            <?php endif; ?>

            <div class="lc-kit-icon-box-content">
                <?php if (!empty($title)) : ?>
                    <?php if (!empty($link['url'])) : ?>
                        <a href="<?php echo esc_url($link['url']); ?>" 
                           <?php echo $link['is_external'] ? 'target="_blank"' : ''; ?>
                           <?php echo $link['nofollow'] ? 'rel="nofollow"' : ''; ?>>
                            <h3 <?php echo $this->get_render_attribute_string('title'); ?>>
                                <?php echo esc_html($title); ?>
                            </h3>
                        </a>
                    <?php else : ?>
                        <h3 <?php echo $this->get_render_attribute_string('title'); ?>>
                            <?php echo esc_html($title); ?>
                        </h3>
                    <?php endif; ?>
                <?php endif; ?>

                <?php if (!empty($description)) : ?>
                    <div <?php echo $this->get_render_attribute_string('description'); ?>>
                        <?php echo wp_kses_post($description); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?php
    }

    /**
     * Content template
     */
    protected function content_template() {
        ?>
        <div class="lc-kit-icon-box lc-kit-icon-box--{{ settings.icon_position }}">
            <# if (settings.icon.value) { #>
                <div class="lc-kit-icon-box-icon">
                    {{{ elementor.helpers.renderIcon( view, settings.icon, { 'aria-hidden': true }, 'i' , 'object' ) }}}
                </div>
            <# } #>

            <div class="lc-kit-icon-box-content">
                <# if (settings.title) { #>
                    <# if (settings.link.url) { #>
                        <a href="{{ settings.link.url }}" 
                           <# if (settings.link.is_external) { #>target="_blank"<# } #>
                           <# if (settings.link.nofollow) { #>rel="nofollow"<# } #>>
                            <h3 class="lc-kit-icon-box-title">{{{ settings.title }}}</h3>
                        </a>
                    <# } else { #>
                        <h3 class="lc-kit-icon-box-title">{{{ settings.title }}}</h3>
                    <# } #>
                <# } #>

                <# if (settings.description) { #>
                    <div class="lc-kit-icon-box-description">
                        {{{ settings.description }}}
                    </div>
                <# } #>
            </div>
        </div>
        <?php
    }
} 