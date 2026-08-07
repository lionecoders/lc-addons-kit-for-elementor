<?php
/**
 * Post Grid Widget
 *
 * @package LC_Elementor_Addons_Kit
 */

if (!defined('ABSPATH')) {
    exit;
}

class LCAKE_Kit_Post_Grid extends \Elementor\Widget_Base {

    public function get_name() {
        return 'lcake-kit-post-grid';
    }

    public function get_categories() {
        return ['lcake-page-kit'];
    }

    public function get_title() {
        return esc_html__('Post Grid', 'lc-addons-kit-for-elementor');
    }

    public function get_icon() {
        return 'eicon-posts-grid';
    }

    public function get_style_depends() {
        return ['lcake-kit-post-grid-css'];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Query', 'lc-addons-kit-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $post_types = get_post_types(['public' => true], 'objects');
        $post_type_options = [];
        foreach ($post_types as $post_type) {
            if ('attachment' === $post_type->name) {
                continue;
            }
            $post_type_options[$post_type->name] = $post_type->label;
        }

        $this->add_control(
            'post_type',
            [
                'label' => esc_html__('Post Type', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'post',
                'options' => $post_type_options,
            ]
        );

        $this->add_control(
            'posts_per_page',
            [
                'label' => esc_html__('Posts Count', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 6,
                'min' => 1,
                'max' => 50,
            ]
        );

        $this->add_control(
            'order_by',
            [
                'label' => esc_html__('Order By', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'date',
                'options' => [
                    'date' => esc_html__('Date', 'lc-addons-kit-for-elementor'),
                    'title' => esc_html__('Title', 'lc-addons-kit-for-elementor'),
                    'rand' => esc_html__('Random', 'lc-addons-kit-for-elementor'),
                ],
            ]
        );

        $this->add_control(
            'order',
            [
                'label' => esc_html__('Order', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'DESC',
                'options' => ['DESC' => esc_html__('Descending', 'lc-addons-kit-for-elementor'), 'ASC' => esc_html__('Ascending', 'lc-addons-kit-for-elementor')],
            ]
        );

        $this->add_responsive_control(
            'columns',
            [
                'label' => esc_html__('Columns', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '3',
                'options' => ['1' => '1', '2' => '2', '3' => '3', '4' => '4'],
                'selectors' => ['{{WRAPPER}} .lcake-post-grid' => 'grid-template-columns: repeat({{VALUE}}, 1fr);'],
            ]
        );

        $this->add_control(
            'show_excerpt',
            [
                'label' => esc_html__('Show Excerpt', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'excerpt_length',
            [
                'label' => esc_html__('Excerpt Length (words)', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 20,
                'condition' => ['show_excerpt' => 'yes'],
            ]
        );

        $this->add_control(
            'show_meta',
            [
                'label' => esc_html__('Show Date & Author', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->end_controls_section();

        // --- Card & Grid Section ---
        $this->start_controls_section(
            'section_style_card',
            [
                'label' => esc_html__('Card & Grid', 'lc-addons-kit-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'grid_gap',
            [
                'label' => esc_html__('Gap', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'size' => 24,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .lcake-post-grid' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('card_states');

        $this->start_controls_tab(
            'card_normal',
            [
                'label' => esc_html__('Normal', 'lc-addons-kit-for-elementor'),
            ]
        );

        $this->add_control(
            'card_bg_color',
            [
                'label' => esc_html__('Background Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .lcake-post-grid-card' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'card_shadow',
                'selector' => '{{WRAPPER}} .lcake-post-grid-card',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'card_hover',
            [
                'label' => esc_html__('Hover', 'lc-addons-kit-for-elementor'),
            ]
        );

        $this->add_control(
            'card_hover_bg_color',
            [
                'label' => esc_html__('Background Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lcake-post-grid-card:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'card_hover_shadow',
                'selector' => '{{WRAPPER}} .lcake-post-grid-card:hover',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'card_padding',
            [
                'label' => esc_html__('Content Padding', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'default' => [
                    'top' => '22',
                    'bottom' => '22',
                    'left' => '22',
                    'right' => '22',
                    'unit' => 'px',
                    'isLinked' => true,
                ],
                'selectors' => [
                    '{{WRAPPER}} .lcake-post-grid-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'card_border_radius',
            [
                'label' => esc_html__('Border Radius', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'default' => [
                    'top' => '20',
                    'bottom' => '20',
                    'left' => '20',
                    'right' => '20',
                    'unit' => 'px',
                    'isLinked' => true,
                ],
                'selectors' => [
                    '{{WRAPPER}} .lcake-post-grid-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'card_border',
                'label' => esc_html__('Border', 'lc-addons-kit-for-elementor'),
                'selector' => '{{WRAPPER}} .lcake-post-grid-card',
            ]
        );

        $this->add_responsive_control(
            'card_hover_translate',
            [
                'label' => esc_html__('Hover Translate Y (px)', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -50,
                        'max' => 50,
                    ],
                ],
                'default' => [
                    'size' => -6,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .lcake-post-grid-card:hover' => 'transform: translateY({{SIZE}}px);',
                ],
            ]
        );

        $this->end_controls_section();

        // --- Image Section ---
        $this->start_controls_section(
            'section_style_image',
            [
                'label' => esc_html__('Image', 'lc-addons-kit-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'image_aspect_ratio',
            [
                'label' => esc_html__('Aspect Ratio', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '16/10',
                'options' => [
                    '16/10' => esc_html__('16:10', 'lc-addons-kit-for-elementor'),
                    '16/9' => esc_html__('16:9', 'lc-addons-kit-for-elementor'),
                    '4/3' => esc_html__('4:3', 'lc-addons-kit-for-elementor'),
                    '1/1' => esc_html__('1:1', 'lc-addons-kit-for-elementor'),
                    'auto' => esc_html__('Auto (Original)', 'lc-addons-kit-for-elementor'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .lcake-post-grid-thumb' => 'aspect-ratio: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'image_border_radius',
            [
                'label' => esc_html__('Border Radius', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lcake-post-grid-thumb' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .lcake-post-grid-thumb img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'image_hover_zoom',
            [
                'label' => esc_html__('Hover Zoom Scale', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 1.5,
                        'step' => 0.01,
                    ],
                ],
                'default' => [
                    'size' => 1.06,
                ],
                'selectors' => [
                    '{{WRAPPER}} .lcake-post-grid-card:hover .lcake-post-grid-thumb img' => 'transform: scale({{SIZE}});',
                ],
            ]
        );

        $this->end_controls_section();

        // --- Title Section ---
        $this->start_controls_section(
            'section_style_title',
            [
                'label' => esc_html__('Title', 'lc-addons-kit-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs('title_color_states');

        $this->start_controls_tab(
            'title_color_normal',
            [
                'label' => esc_html__('Normal', 'lc-addons-kit-for-elementor'),
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__('Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#111827',
                'selectors' => [
                    '{{WRAPPER}} .lcake-post-grid-title a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'title_color_hover',
            [
                'label' => esc_html__('Hover', 'lc-addons-kit-for-elementor'),
            ]
        );

        $this->add_control(
            'title_hover_color',
            [
                'label' => esc_html__('Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#3b82f6',
                'selectors' => [
                    '{{WRAPPER}} .lcake-post-grid-title a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .lcake-post-grid-title a, {{WRAPPER}} .lcake-post-grid-title',
            ]
        );

        $this->add_responsive_control(
            'title_margin',
            [
                'label' => esc_html__('Margin', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'default' => [
                    'top' => '0',
                    'bottom' => '10',
                    'left' => '0',
                    'right' => '0',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
                'selectors' => [
                    '{{WRAPPER}} .lcake-post-grid-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'title_hover_underline',
            [
                'label' => esc_html__('Hover Underline', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'none',
                'options' => [
                    'none' => esc_html__('Hide', 'lc-addons-kit-for-elementor'),
                    'underline' => esc_html__('Show', 'lc-addons-kit-for-elementor'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .lcake-post-grid-title a:hover' => 'text-decoration: {{VALUE}} !important;',
                ],
            ]
        );

        $this->end_controls_section();

        // --- Meta Section ---
        $this->start_controls_section(
            'section_style_meta',
            [
                'label' => esc_html__('Meta', 'lc-addons-kit-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_meta' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'meta_color',
            [
                'label' => esc_html__('Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#9ca3af',
                'selectors' => [
                    '{{WRAPPER}} .lcake-post-grid-meta' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'meta_typography',
                'selector' => '{{WRAPPER}} .lcake-post-grid-meta, {{WRAPPER}} .lcake-post-grid-meta span',
            ]
        );

        $this->add_responsive_control(
            'meta_margin',
            [
                'label' => esc_html__('Margin', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'default' => [
                    'top' => '0',
                    'bottom' => '10',
                    'left' => '0',
                    'right' => '0',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
                'selectors' => [
                    '{{WRAPPER}} .lcake-post-grid-meta' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // --- Excerpt Section ---
        $this->start_controls_section(
            'section_style_excerpt',
            [
                'label' => esc_html__('Excerpt', 'lc-addons-kit-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_excerpt' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'excerpt_color',
            [
                'label' => esc_html__('Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#6b7280',
                'selectors' => [
                    '{{WRAPPER}} .lcake-post-grid-excerpt' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'excerpt_typography',
                'selector' => '{{WRAPPER}} .lcake-post-grid-excerpt',
            ]
        );

        $this->add_responsive_control(
            'excerpt_margin',
            [
                'label' => esc_html__('Margin', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'default' => [
                    'top' => '0',
                    'bottom' => '0',
                    'left' => '0',
                    'right' => '0',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
                'selectors' => [
                    '{{WRAPPER}} .lcake-post-grid-excerpt' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        $query = new \WP_Query([
            'post_type' => $settings['post_type'],
            'posts_per_page' => (int) $settings['posts_per_page'],
            'orderby' => $settings['order_by'],
            'order' => $settings['order'],
            'ignore_sticky_posts' => true,
        ]);

        if (!$query->have_posts()) {
            return;
        }
        ?>
        <div class="lcake-post-grid">
            <?php while ($query->have_posts()) : $query->the_post(); ?>
                <article class="lcake-post-grid-card">
                    <?php if (has_post_thumbnail()) : ?>
                        <a href="<?php the_permalink(); ?>" class="lcake-post-grid-thumb">
                            <?php the_post_thumbnail('medium_large'); ?>
                        </a>
                    <?php endif; ?>
                    <div class="lcake-post-grid-content">
                        <?php if ('yes' === $settings['show_meta']) : ?>
                            <div class="lcake-post-grid-meta">
                                <span><?php echo esc_html(get_the_date()); ?></span>
                                <span>&bull;</span>
                                <span><?php the_author(); ?></span>
                            </div>
                        <?php endif; ?>
                        <h3 class="lcake-post-grid-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h3>
                        <?php if ('yes' === $settings['show_excerpt']) : ?>
                            <div class="lcake-post-grid-excerpt">
                                <?php echo esc_html(wp_trim_words(get_the_excerpt(), (int) $settings['excerpt_length'], '...')); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </article>
            <?php endwhile; ?>
        </div>
        <?php
        wp_reset_postdata();
    }
}
