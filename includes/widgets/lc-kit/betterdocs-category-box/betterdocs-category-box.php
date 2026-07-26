<?php
/**
 * BetterDocs Category Box Widget
 *
 * @package LC_Elementor_Addons_Kit
 */

if (!defined('ABSPATH')) {
    exit;
}

class LCAKE_Kit_Betterdocs_Category_Box extends \Elementor\Widget_Base {

    public function get_name() {
        return 'lcake-kit-betterdocs-category-box';
    }

    public function get_categories() {
        return ['lcake-page-kit'];
    }

    public function get_title() {
        return esc_html__('LC Docs Category Box', 'lc-addons-kit-for-elementor');
    }

    public function get_icon() {
        return 'eicon-info-box';
    }

    public function get_style_depends() {
        return ['lcake-kit-betterdocs-category-box-css'];
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
                'default' => '3',
                'options' => ['2' => '2', '3' => '3', '4' => '4'],
                'selectors' => ['{{WRAPPER}} .lcake-docs-category-box' => 'grid-template-columns: repeat({{VALUE}}, 1fr);'],
            ]
        );

        $this->add_control(
            'exclude_empty',
            [
                'label' => esc_html__('Hide Empty Categories', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
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
            'icon_color',
            [
                'label' => esc_html__('Icon Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#3b82f6',
                'selectors' => ['{{WRAPPER}} .lcake-docs-category-icon' => 'color: {{VALUE}};'],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        if (!taxonomy_exists('doc_category')) {
            LCAKE_Kit_Utils::plugin_inactive_notice('BetterDocs');
            return;
        }

        $settings = $this->get_settings_for_display();

        $terms = get_terms([
            'taxonomy' => 'doc_category',
            'hide_empty' => 'yes' === $settings['exclude_empty'],
        ]);

        if (empty($terms) || is_wp_error($terms)) {
            return;
        }
        ?>
        <div class="lcake-docs-category-box">
            <?php foreach ($terms as $term) : ?>
                <a href="<?php echo esc_url(get_term_link($term)); ?>" class="lcake-docs-category-card">
                    <span class="lcake-docs-category-icon" aria-hidden="true">&#128196;</span>
                    <span class="lcake-docs-category-name"><?php echo esc_html($term->name); ?></span>
                    <span class="lcake-docs-category-count">
                        <?php
                        printf(
                            /* translators: %d: number of articles */
                            esc_html(_n('%d Article', '%d Articles', $term->count, 'lc-addons-kit-for-elementor')),
                            (int) $term->count
                        );
                        ?>
                    </span>
                </a>
            <?php endforeach; ?>
        </div>
        <?php
    }
}
