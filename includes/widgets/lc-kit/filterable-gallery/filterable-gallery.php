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
        return esc_html__('LC Filterable Gallery', 'lc-addons-kit-for-elementor');
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
            'section_style',
            [
                'label' => esc_html__('Style', 'lc-addons-kit-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'filter_active_color',
            [
                'label' => esc_html__('Active Filter Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#3b82f6',
                'selectors' => ['{{WRAPPER}} .lcake-filterable-gallery-filter.is-active' => 'background-color: {{VALUE}}; border-color: {{VALUE}};'],
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
                    <<?php echo $tag; ?> class="lcake-filterable-gallery-item" data-category="<?php echo esc_attr($cat_slugs); ?>"
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
