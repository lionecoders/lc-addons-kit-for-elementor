<?php
/**
 * BetterDocs Category Grid Widget
 *
 * @package LC_Elementor_Addons_Kit
 */

if (!defined('ABSPATH')) {
    exit;
}

class LCAKE_Kit_Betterdocs_Category_Grid extends \Elementor\Widget_Base {

    public function get_name() {
        return 'lcake-kit-betterdocs-category-grid';
    }

    public function get_categories() {
        return ['lcake-page-kit'];
    }

    public function get_title() {
        return esc_html__('LC Docs Category Grid', 'lc-addons-kit-for-elementor');
    }

    public function get_icon() {
        return 'eicon-posts-grid';
    }

    public function get_style_depends() {
        return ['lcake-kit-betterdocs-category-grid-css'];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Content', 'lc-addons-kit-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_responsive_control(
            'columns',
            [
                'label' => esc_html__('Columns', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '2',
                'options' => ['1' => '1', '2' => '2', '3' => '3'],
                'selectors' => ['{{WRAPPER}} .lcake-docs-category-grid' => 'grid-template-columns: repeat({{VALUE}}, 1fr);'],
            ]
        );

        $this->add_control(
            'articles_per_category',
            [
                'label' => esc_html__('Articles Per Category', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 5,
                'min' => 1,
                'max' => 20,
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
            'title_color',
            [
                'label' => esc_html__('Category Title Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#111827',
                'selectors' => ['{{WRAPPER}} .lcake-docs-category-grid-title' => 'color: {{VALUE}};'],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        if (!taxonomy_exists('doc_category') || !post_type_exists('docs')) {
            LCAKE_Kit_Utils::plugin_inactive_notice('BetterDocs');
            return;
        }

        $settings = $this->get_settings_for_display();

        $terms = get_terms(['taxonomy' => 'doc_category', 'hide_empty' => true]);

        if (empty($terms) || is_wp_error($terms)) {
            return;
        }
        ?>
        <div class="lcake-docs-category-grid">
            <?php foreach ($terms as $term) :
                $articles = get_posts([
                    'post_type' => 'docs',
                    'posts_per_page' => (int) $settings['articles_per_category'],
                    'tax_query' => [
                        ['taxonomy' => 'doc_category', 'field' => 'term_id', 'terms' => $term->term_id],
                    ],
                ]);

                if (empty($articles)) {
                    continue;
                }
                ?>
                <div class="lcake-docs-category-grid-column">
                    <h3 class="lcake-docs-category-grid-title">
                        <a href="<?php echo esc_url(get_term_link($term)); ?>"><?php echo esc_html($term->name); ?></a>
                    </h3>
                    <ul class="lcake-docs-category-grid-list">
                        <?php foreach ($articles as $article) : ?>
                            <li><a href="<?php echo esc_url(get_permalink($article)); ?>"><?php echo esc_html(get_the_title($article)); ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endforeach; ?>
        </div>
        <?php
    }
}
