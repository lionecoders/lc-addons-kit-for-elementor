<?php
/**
 * Post Grid Widget
 * 
 * @package LC_Elementor_Addons_Kit
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Post Grid Widget Class
 */
class LC_Header_Footer_Post_Grid extends \Elementor\Widget_Base {

    /**
     * Get widget name
     */
    public function get_name() {
        return 'lc-header-footer-post-grid';
    }

    /**
     * Get widget title
     */
    public function get_title() {
        return esc_html__('Post Grid', 'lc-addons-kit-for-elementor');
    }

    /**
     * Get widget icon
     */
    public function get_icon() {
        return 'eicon-posts-grid';
    }

    /**
     * Get widget categories
     */
    public function get_categories() {
        return ['lc-header-footer-kit'];
    }

    /**
     * Add content controls
     */
    protected function add_content_controls() {
        $this->add_control(
            'title',
            [
                'label' => esc_html__('Title', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Latest Posts', 'lc-addons-kit-for-elementor'),
                'placeholder' => esc_html__('Enter title', 'lc-addons-kit-for-elementor'),
            ]
        );

        $this->add_control(
            'posts_per_page',
            [
                'label' => esc_html__('Posts Per Page', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 6,
                'min' => 1,
                'max' => 50,
            ]
        );

        $this->add_control(
            'columns',
            [
                'label' => esc_html__('Columns', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '3',
                'options' => [
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '6' => '6',
                ],
            ]
        );

        $this->add_control(
            'orderby',
            [
                'label' => esc_html__('Order By', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'date',
                'options' => [
                    'date' => esc_html__('Date', 'lc-addons-kit-for-elementor'),
                    'title' => esc_html__('Title', 'lc-addons-kit-for-elementor'),
                    'menu_order' => esc_html__('Menu Order', 'lc-addons-kit-for-elementor'),
                    'rand' => esc_html__('Random', 'lc-addons-kit-for-elementor'),
                    'comment_count' => esc_html__('Comment Count', 'lc-addons-kit-for-elementor'),
                ],
            ]
        );

        $this->add_control(
            'order',
            [
                'label' => esc_html__('Order', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'DESC',
                'options' => [
                    'ASC' => esc_html__('Ascending', 'lc-addons-kit-for-elementor'),
                    'DESC' => esc_html__('Descending', 'lc-addons-kit-for-elementor'),
                ],
            ]
        );

        $this->add_control(
            'show_thumbnail',
            [
                'label' => esc_html__('Show Thumbnail', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'lc-addons-kit-for-elementor'),
                'label_off' => esc_html__('Hide', 'lc-addons-kit-for-elementor'),
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_title',
            [
                'label' => esc_html__('Show Title', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'lc-addons-kit-for-elementor'),
                'label_off' => esc_html__('Hide', 'lc-addons-kit-for-elementor'),
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_excerpt',
            [
                'label' => esc_html__('Show Excerpt', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'lc-addons-kit-for-elementor'),
                'label_off' => esc_html__('Hide', 'lc-addons-kit-for-elementor'),
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'excerpt_length',
            [
                'label' => esc_html__('Excerpt Length', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 20,
                'min' => 5,
                'max' => 100,
                'condition' => [
                    'show_excerpt' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'show_date',
            [
                'label' => esc_html__('Show Date', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'lc-addons-kit-for-elementor'),
                'label_off' => esc_html__('Hide', 'lc-addons-kit-for-elementor'),
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_author',
            [
                'label' => esc_html__('Show Author', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'lc-addons-kit-for-elementor'),
                'label_off' => esc_html__('Hide', 'lc-addons-kit-for-elementor'),
                'default' => 'no',
            ]
        );
    }

    /**
     * Add style controls
     */
    protected function add_style_controls() {
        $this->add_control(
            'title_color',
            [
                'label' => esc_html__('Title Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lc-post-grid-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .lc-post-grid-title',
            ]
        );

        $this->add_control(
            'post_title_color',
            [
                'label' => esc_html__('Post Title Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lc-post-grid-item-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'post_title_hover_color',
            [
                'label' => esc_html__('Post Title Hover Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lc-post-grid-item-title:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'post_title_typography',
                'selector' => '{{WRAPPER}} .lc-post-grid-item-title',
            ]
        );

        $this->add_control(
            'excerpt_color',
            [
                'label' => esc_html__('Excerpt Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lc-post-grid-item-excerpt' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'excerpt_typography',
                'selector' => '{{WRAPPER}} .lc-post-grid-item-excerpt',
            ]
        );

        $this->add_control(
            'meta_color',
            [
                'label' => esc_html__('Meta Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lc-post-grid-item-meta' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'meta_typography',
                'selector' => '{{WRAPPER}} .lc-post-grid-item-meta',
            ]
        );

        $this->add_control(
            'grid_background_color',
            [
                'label' => esc_html__('Grid Background Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lc-post-grid' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'item_background_color',
            [
                'label' => esc_html__('Item Background Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lc-post-grid-item' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'item_border',
                'selector' => '{{WRAPPER}} .lc-post-grid-item',
            ]
        );

        $this->add_control(
            'item_border_radius',
            [
                'label' => esc_html__('Item Border Radius', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lc-post-grid-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'item_padding',
            [
                'label' => esc_html__('Item Padding', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lc-post-grid-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'grid_gap',
            [
                'label' => esc_html__('Grid Gap', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .lc-post-grid' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
    }

    /**
     * Render widget
     */
    protected function render_widget($settings) {
        $title = $settings['title'];
        $posts_per_page = $settings['posts_per_page'];
        $columns = $settings['columns'];
        $orderby = $settings['orderby'];
        $order = $settings['order'];
        $show_thumbnail = $settings['show_thumbnail'];
        $show_title = $settings['show_title'];
        $show_excerpt = $settings['show_excerpt'];
        $excerpt_length = $settings['excerpt_length'];
        $show_date = $settings['show_date'];
        $show_author = $settings['show_author'];

        $args = [
            'post_type' => 'post',
            'posts_per_page' => $posts_per_page,
            'orderby' => $orderby,
            'order' => $order,
            'post_status' => 'publish',
        ];

        $posts = new WP_Query($args);

        ?>
        <div class="lc-post-grid-widget">
            <?php if (!empty($title)) : ?>
                <h3 class="lc-post-grid-title"><?php echo esc_html($title); ?></h3>
            <?php endif; ?>

            <?php if ($posts->have_posts()) : ?>
                <div class="lc-post-grid lc-post-grid--<?php echo esc_attr($columns); ?>-columns">
                    <?php while ($posts->have_posts()) : $posts->the_post(); ?>
                        <article class="lc-post-grid-item">
                            <?php if ($show_thumbnail === 'yes' && has_post_thumbnail()) : ?>
                                <div class="lc-post-grid-item-thumbnail">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail('medium'); ?>
                                    </a>
                                </div>
                            <?php endif; ?>

                            <div class="lc-post-grid-item-content">
                                <?php if ($show_title === 'yes') : ?>
                                    <h4 class="lc-post-grid-item-title">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_title(); ?>
                                        </a>
                                    </h4>
                                <?php endif; ?>

                                <?php if ($show_excerpt === 'yes') : ?>
                                    <div class="lc-post-grid-item-excerpt">
                                        <?php echo wp_trim_words(get_the_excerpt(), $excerpt_length, '...'); ?>
                                    </div>
                                <?php endif; ?>

                                <?php if ($show_date === 'yes' || $show_author === 'yes') : ?>
                                    <div class="lc-post-grid-item-meta">
                                        <?php if ($show_date === 'yes') : ?>
                                            <span class="lc-post-grid-item-date">
                                                <?php echo get_the_date(); ?>
                                            </span>
                                        <?php endif; ?>

                                        <?php if ($show_author === 'yes') : ?>
                                            <span class="lc-post-grid-item-author">
                                                <?php echo esc_html__('by', 'lc-addons-kit-for-elementor'); ?> 
                                                <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>">
                                                    <?php the_author(); ?>
                                                </a>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </article>
                    <?php endwhile; ?>
                </div>
            <?php else : ?>
                <p class="lc-post-grid-empty"><?php echo esc_html__('No posts found.', 'lc-addons-kit-for-elementor'); ?></p>
            <?php endif; ?>

            <?php wp_reset_postdata(); ?>
        </div>
        <?php
    }

    /**
     * Content template
     */
    protected function content_template() {
        ?>
        <div class="lc-post-grid-widget">
            <# if (settings.title) { #>
                <h3 class="lc-post-grid-title">{{{ settings.title }}}</h3>
            <# } #>
            
            <div class="lc-post-grid lc-post-grid--{{ settings.columns }}-columns">
                <# for (var i = 0; i < 6; i++) { #>
                    <article class="lc-post-grid-item">
                        <# if (settings.show_thumbnail === 'yes') { #>
                            <div class="lc-post-grid-item-thumbnail">
                                <a href="#">
                                    <img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMzAwIiBoZWlnaHQ9IjIwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSIjZGRkIi8+PHRleHQgeD0iNTAlIiB5PSI1MCUiIGZvbnQtZmFtaWx5PSJBcmlhbCIgZm9udC1zaXplPSIxNCIgZmlsbD0iIzk5OSIgdGV4dC1hbmNob3I9Im1pZGRsZSIgZHk9Ii4zZW0iPlBvc3QgSW1hZ2U8L3RleHQ+PC9zdmc+" alt="Post Image">
                                </a>
                            </div>
                        <# } #>

                        <div class="lc-post-grid-item-content">
                            <# if (settings.show_title === 'yes') { #>
                                <h4 class="lc-post-grid-item-title">
                                    <a href="#"><?php echo esc_html__('Sample Post Title', 'lc-addons-kit-for-elementor'); ?></a>
                                </h4>
                            <# } #>

                            <# if (settings.show_excerpt === 'yes') { #>
                                <div class="lc-post-grid-item-excerpt">
                                    <?php echo esc_html__('This is a sample excerpt for the post grid widget. It shows how the content will appear in the grid layout.', 'lc-addons-kit-for-elementor'); ?>
                                </div>
                            <# } #>

                            <# if (settings.show_date === 'yes' || settings.show_author === 'yes') { #>
                                <div class="lc-post-grid-item-meta">
                                    <# if (settings.show_date === 'yes') { #>
                                        <span class="lc-post-grid-item-date"><?php echo esc_html__('January 1, 2024', 'lc-addons-kit-for-elementor'); ?></span>
                                    <# } #>

                                    <# if (settings.show_author === 'yes') { #>
                                        <span class="lc-post-grid-item-author">
                                            <?php echo esc_html__('by', 'lc-addons-kit-for-elementor'); ?> 
                                            <a href="#"><?php echo esc_html__('Admin', 'lc-addons-kit-for-elementor'); ?></a>
                                        </span>
                                    <# } #>
                                </div>
                            <# } #>
                        </div>
                    </article>
                <# } #>
            </div>
        </div>
        <?php
    }
} 