<?php
/**
 * BetterDocs Search Form Widget
 *
 * @package LC_Elementor_Addons_Kit
 */

if (!defined('ABSPATH')) {
    exit;
}

class LCAKE_Kit_Betterdocs_Search_Form extends \Elementor\Widget_Base {

    public function get_name() {
        return 'lcake-kit-betterdocs-search-form';
    }

    public function get_categories() {
        return ['lcake-page-kit'];
    }

    public function get_title() {
        return esc_html__('LC Docs Search Form', 'lc-addons-kit-for-elementor');
    }

    public function get_icon() {
        return 'eicon-search';
    }

    public function get_style_depends() {
        return ['lcake-kit-betterdocs-search-form-css'];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Content', 'lc-addons-kit-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'placeholder',
            [
                'label' => esc_html__('Placeholder', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Search the docs...', 'lc-addons-kit-for-elementor'),
            ]
        );

        $this->add_control(
            'button_text',
            [
                'label' => esc_html__('Button Text', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Search', 'lc-addons-kit-for-elementor'),
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
            'button_background',
            [
                'label' => esc_html__('Button Background', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#3b82f6',
                'selectors' => ['{{WRAPPER}} .lcake-docs-search-button' => 'background-color: {{VALUE}};'],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        if (!post_type_exists('docs')) {
            LCAKE_Kit_Utils::plugin_inactive_notice('BetterDocs');
            return;
        }

        $settings = $this->get_settings_for_display();
        ?>
        <form role="search" method="get" class="lcake-docs-search-form" action="<?php echo esc_url(home_url('/')); ?>">
            <input type="hidden" name="post_type" value="docs">
            <input type="search" class="lcake-docs-search-input" name="s" placeholder="<?php echo esc_attr($settings['placeholder']); ?>" value="<?php echo esc_attr(get_search_query()); ?>">
            <button type="submit" class="lcake-docs-search-button"><?php echo esc_html($settings['button_text']); ?></button>
        </form>
        <?php
    }
}
