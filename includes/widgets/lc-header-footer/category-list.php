<?php
/**
 * Category List Widget
 * 
 * @package LC_Elementor_Addons_Kit
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Category List Widget Class
 */
class LC_Header_Footer_Category_List extends \Elementor\Widget_Base {

    /**
     * Get widget name
     */
    public function get_name() {
        return 'lc-header-footer-category-list';
    }

    /**
     * Get widget title
     */
    public function get_title() {
        return esc_html__('Category List', 'lc-addons-kit-for-elementor');
    }

    /**
     * Get widget icon
     */
    public function get_icon() {
        return 'eicon-post-list';
    }

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
                'default' => esc_html__('Categories', 'lc-addons-kit-for-elementor'),
                'placeholder' => esc_html__('Enter title', 'lc-addons-kit-for-elementor'),
            ]
        );

        $this->add_control(
            'number_of_categories',
            [
                'label' => esc_html__('Number of Categories', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 10,
                'min' => 1,
                'max' => 100,
            ]
        );

        $this->add_control(
            'orderby',
            [
                'label' => esc_html__('Order By', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'name',
                'options' => [
                    'name' => esc_html__('Name', 'lc-addons-kit-for-elementor'),
                    'count' => esc_html__('Count', 'lc-addons-kit-for-elementor'),
                    'slug' => esc_html__('Slug', 'lc-addons-kit-for-elementor'),
                    'term_id' => esc_html__('Term ID', 'lc-addons-kit-for-elementor'),
                ],
            ]
        );

        $this->add_control(
            'order',
            [
                'label' => esc_html__('Order', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'ASC',
                'options' => [
                    'ASC' => esc_html__('Ascending', 'lc-addons-kit-for-elementor'),
                    'DESC' => esc_html__('Descending', 'lc-addons-kit-for-elementor'),
                ],
            ]
        );

        $this->add_control(
            'show_count',
            [
                'label' => esc_html__('Show Post Count', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'lc-addons-kit-for-elementor'),
                'label_off' => esc_html__('Hide', 'lc-addons-kit-for-elementor'),
                'default' => 'yes',
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
                    '{{WRAPPER}} .lc-category-list-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .lc-category-list-title',
            ]
        );

        $this->add_control(
            'category_color',
            [
                'label' => esc_html__('Category Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lc-category-item a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'category_hover_color',
            [
                'label' => esc_html__('Category Hover Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lc-category-item a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'category_typography',
                'selector' => '{{WRAPPER}} .lc-category-item a',
            ]
        );

        $this->add_responsive_control(
            'category_spacing',
            [
                'label' => esc_html__('Category Spacing', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .lc-category-item' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
    }

    /**
     * Render widget
     */
    protected function render_widget($settings) {
        $title = $settings['title'];
        $number = $settings['number_of_categories'];
        $orderby = $settings['orderby'];
        $order = $settings['order'];
        $show_count = $settings['show_count'];

        $categories = get_categories([
            'number' => $number,
            'orderby' => $orderby,
            'order' => $order,
            'hide_empty' => false,
        ]);

        ?>
        <div class="lc-category-list-widget">
            <?php if (!empty($title)) : ?>
                <h3 class="lc-category-list-title"><?php echo esc_html($title); ?></h3>
            <?php endif; ?>

            <?php if (!empty($categories)) : ?>
                <ul class="lc-category-list">
                    <?php foreach ($categories as $category) : ?>
                        <li class="lc-category-item">
                            <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>">
                                <?php echo esc_html($category->name); ?>
                                <?php if ($show_count === 'yes') : ?>
                                    <span class="lc-category-count">(<?php echo esc_html($category->count); ?>)</span>
                                <?php endif; ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else : ?>
                <p class="lc-category-list-empty"><?php echo esc_html__('No categories found.', 'lc-addons-kit-for-elementor'); ?></p>
            <?php endif; ?>
        </div>
        <?php
    }

    /**
     * Content template
     */
    protected function content_template() {
        ?>
        <div class="lc-category-list-widget">
            <# if (settings.title) { #>
                <h3 class="lc-category-list-title">{{{ settings.title }}}</h3>
            <# } #>
            
            <ul class="lc-category-list">
                <# for (var i = 0; i < 5; i++) { #>
                    <li class="lc-category-item">
                        <a href="#">
                            <?php echo esc_html__('Category Name', 'lc-addons-kit-for-elementor'); ?>
                            <# if (settings.show_count === 'yes') { #>
                                <span class="lc-category-count">(5)</span>
                            <# } #>
                        </a>
                    </li>
                <# } #>
            </ul>
        </div>
        <?php
    }
} 