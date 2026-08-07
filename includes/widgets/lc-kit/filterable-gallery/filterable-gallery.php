<?php
/**
 * Filterable Gallery Widget
 *
 * @package LC_Elementor_Addons_Kit
 */

if (!defined('ABSPATH')) {
    exit;
}

class LCAKE_Kit_Filterable_Gallery extends \Elementor\Widget_Base {

    public function get_name() {
        return 'lcake-kit-filterable-gallery';
    }

    public function get_categories() {
        return ['lcake-page-kit'];
    }

    public function get_title() {
        return esc_html__('Filterable Gallery', 'lc-addons-kit-for-elementor');
    }

    public function get_icon() {
        return 'eicon-gallery-grid';
    }

    public function get_style_depends() {
        return ['lcake-kit-filterable-gallery-css'];
    }

    public function get_script_depends() {
        return ['lcake-kit-filterable-gallery-js'];
    }

    protected function register_controls() {
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
                'default' => ['url' => \Elementor\Utils::get_placeholder_image_src()],
            ]
        );

        $repeater->add_control(
            'title',
            [
                'label' => esc_html__('Title', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Gallery Item', 'lc-addons-kit-for-elementor'),
            ]
        );

        $repeater->add_control(
            'category',
            [
                'label' => esc_html__('Category', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('General', 'lc-addons-kit-for-elementor'),
                'description' => esc_html__('Comma separate multiple categories.', 'lc-addons-kit-for-elementor'),
            ]
        );

        $repeater->add_control(
            'link',
            [
                'label' => esc_html__('Link', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::URL,
                'default' => ['url' => ''],
            ]
        );

        $this->add_control(
            'gallery_items',
            [
                'label' => esc_html__('Gallery Items', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    ['title' => esc_html__('Item One', 'lc-addons-kit-for-elementor'), 'category' => 'Web'],
                    ['title' => esc_html__('Item Two', 'lc-addons-kit-for-elementor'), 'category' => 'App'],
                    ['title' => esc_html__('Item Three', 'lc-addons-kit-for-elementor'), 'category' => 'Web, Branding'],
                ],
                'title_field' => '{{{ title }}}',
            ]
        );

        $this->add_responsive_control(
            'columns',
            [
                'label' => esc_html__('Columns', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '3',
                'options' => ['2' => '2', '3' => '3', '4' => '4'],
                'selectors' => ['{{WRAPPER}} .lcake-filterable-gallery-grid' => 'grid-template-columns: repeat({{VALUE}}, 1fr);'],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_filters',
            [
                'label' => esc_html__('Filters', 'lc-addons-kit-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'filter_alignment',
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
                'default' => 'left',
                'selectors' => [
                    '{{WRAPPER}} .lcake-filterable-gallery-filters' => 'justify-content: {{VALUE}};',
                ],
                'selectors_dictionary' => [
                    'left' => 'flex-start',
                    'center' => 'center',
                    'right' => 'flex-end',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'filter_typography',
                'selector' => '{{WRAPPER}} .lcake-filterable-gallery-filter',
            ]
        );

        $this->start_controls_tabs('tabs_filter_style');

        $this->start_controls_tab(
            'tab_filter_normal',
            [
                'label' => esc_html__('Normal', 'lc-addons-kit-for-elementor'),
            ]
        );

        $this->add_control(
            'filter_color',
            [
                'label' => esc_html__('Text Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#374151',
                'selectors' => [
                    '{{WRAPPER}} .lcake-filterable-gallery-filter' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'filter_bg_color',
            [
                'label' => esc_html__('Background Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .lcake-filterable-gallery-filter' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'filter_border_color',
            [
                'label' => esc_html__('Border Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#e5e7eb',
                'selectors' => [
                    '{{WRAPPER}} .lcake-filterable-gallery-filter' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_filter_hover',
            [
                'label' => esc_html__('Hover', 'lc-addons-kit-for-elementor'),
            ]
        );

        $this->add_control(
            'filter_hover_color',
            [
                'label' => esc_html__('Text Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#3b82f6',
                'selectors' => [
                    '{{WRAPPER}} .lcake-filterable-gallery-filter:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'filter_hover_bg_color',
            [
                'label' => esc_html__('Background Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lcake-filterable-gallery-filter:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'filter_hover_border_color',
            [
                'label' => esc_html__('Border Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#3b82f6',
                'selectors' => [
                    '{{WRAPPER}} .lcake-filterable-gallery-filter:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_filter_active',
            [
                'label' => esc_html__('Active', 'lc-addons-kit-for-elementor'),
            ]
        );

        $this->add_control(
            'filter_active_color_tab',
            [
                'label' => esc_html__('Text Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .lcake-filterable-gallery-filter.is-active' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'filter_active_bg_color',
            [
                'label' => esc_html__('Background Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#3b82f6',
                'selectors' => [
                    '{{WRAPPER}} .lcake-filterable-gallery-filter.is-active' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'filter_active_border_color_tab',
            [
                'label' => esc_html__('Border Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#3b82f6',
                'selectors' => [
                    '{{WRAPPER}} .lcake-filterable-gallery-filter.is-active' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'filter_padding',
            [
                'label' => esc_html__('Padding', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'default' => [
                    'top' => '8',
                    'bottom' => '8',
                    'left' => '20',
                    'right' => '20',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
                'selectors' => [
                    '{{WRAPPER}} .lcake-filterable-gallery-filter' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'filter_border_radius',
            [
                'label' => esc_html__('Border Radius', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'default' => [
                    'size' => 20,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .lcake-filterable-gallery-filter' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'filter_spacing',
            [
                'label' => esc_html__('Spacing Below Filter', 'lc-addons-kit-for-elementor'),
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
                    '{{WRAPPER}} .lcake-filterable-gallery-filters' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_grid',
            [
                'label' => esc_html__('Grid & Items', 'lc-addons-kit-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'grid_gap',
            [
                'label' => esc_html__('Gap', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => ['px' => ['min' => 0, 'max' => 60]],
                'default' => ['size' => 24, 'unit' => 'px'],
                'selectors' => ['{{WRAPPER}} .lcake-filterable-gallery-grid' => 'gap: {{SIZE}}{{UNIT}};'],
            ]
        );

        $this->add_responsive_control(
            'item_border_radius',
            [
                'label' => esc_html__('Item Border Radius', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'default' => [
                    'size' => 16,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .lcake-filterable-gallery-item' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'image_hover_animation',
            [
                'label' => esc_html__('Image Hover Animation', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'zoom-in',
                'options' => [
                    'zoom-in' => esc_html__('Zoom In', 'lc-addons-kit-for-elementor'),
                    'zoom-out' => esc_html__('Zoom Out', 'lc-addons-kit-for-elementor'),
                    'grayscale' => esc_html__('Grayscale', 'lc-addons-kit-for-elementor'),
                    'blur' => esc_html__('Blur', 'lc-addons-kit-for-elementor'),
                    'none' => esc_html__('None', 'lc-addons-kit-for-elementor'),
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_overlay',
            [
                'label' => esc_html__('Overlay', 'lc-addons-kit-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'overlay_display',
            [
                'label' => esc_html__('Overlay Display', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'hover',
                'options' => [
                    'hover' => esc_html__('On Hover', 'lc-addons-kit-for-elementor'),
                    'always' => esc_html__('Always Show', 'lc-addons-kit-for-elementor'),
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'overlay_bg',
                'label' => esc_html__('Background', 'lc-addons-kit-for-elementor'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .lcake-filterable-gallery-overlay',
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__('Title Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .lcake-filterable-gallery-title' => 'color: {{VALUE}};',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .lcake-filterable-gallery-title',
            ]
        );

        $this->add_responsive_control(
            'overlay_padding',
            [
                'label' => esc_html__('Padding', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'default' => [
                    'top' => '20',
                    'bottom' => '20',
                    'left' => '20',
                    'right' => '20',
                    'unit' => 'px',
                    'isLinked' => true,
                ],
                'selectors' => [
                    '{{WRAPPER}} .lcake-filterable-gallery-overlay' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $items = $settings['gallery_items'] ?? [];

        if (empty($items)) {
            return;
        }

        $categories = ['all' => esc_html__('All', 'lc-addons-kit-for-elementor')];
        foreach ($items as $item) {
            $cats = array_filter(array_map('trim', explode(',', $item['category'] ?? '')));
            foreach ($cats as $cat) {
                $categories[sanitize_title($cat)] = $cat;
            }
        }
        ?>
        <div class="lcake-filterable-gallery">
            <div class="lcake-filterable-gallery-filters">
                <?php foreach ($categories as $slug => $label) : ?>
                    <button type="button" class="lcake-filterable-gallery-filter<?php echo 'all' === $slug ? ' is-active' : ''; ?>" data-filter="<?php echo esc_attr($slug); ?>">
                        <?php echo esc_html($label); ?>
                    </button>
                <?php endforeach; ?>
            </div>
            <div class="lcake-filterable-gallery-grid">
                <?php foreach ($items as $item) :
                    $cats = array_filter(array_map('trim', explode(',', $item['category'] ?? '')));
                    $cat_slugs = implode(' ', array_map('sanitize_title', $cats));
                    $link = $item['link'] ?? [];
                    $tag = !empty($link['url']) ? 'a' : 'div';
                    ?>
                    <<?php echo $tag; ?> class="lcake-filterable-gallery-item anim-<?php echo esc_attr($settings['image_hover_animation'] ?? 'zoom-in'); ?> overlay-<?php echo esc_attr($settings['overlay_display'] ?? 'hover'); ?>" data-category="<?php echo esc_attr($cat_slugs); ?>"
                        <?php if ('a' === $tag) : ?>href="<?php echo esc_url($link['url']); ?>"<?php endif; ?>>
                        <?php echo LCAKE_Kit_Utils::get_attachment_image_html($item, 'image', 'medium', ['class' => 'lcake-filterable-gallery-image']); ?>
                        <?php if (!empty($item['title'])) : ?>
                            <div class="lcake-filterable-gallery-overlay">
                                <span class="lcake-filterable-gallery-title"><?php echo esc_html($item['title']); ?></span>
                            </div>
                        <?php endif; ?>
                    </<?php echo $tag; ?>>
                <?php endforeach; ?>
            </div>
        </div>
        <?php
    }
}
