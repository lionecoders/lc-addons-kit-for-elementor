<?php
/**
 * Search Toggle Widget
 *
 * @package LC_Elementor_Addons_Kit
 */

if (!defined('ABSPATH')) {
    exit;
}

class LC_Header_Footer_Search_Toggle extends \Elementor\Widget_Base {

    public function get_name() {
        return 'lc-header-footer-search-toggle';
    }

    public function get_title() {
        return esc_html__('Search Toggle', 'lc-addons-kit-for-elementor');
    }

    public function get_icon() {
        return 'eicon-search';
    }

    public function get_categories() {
        return ['lc-header-footer-kit1'];
    }

    public function get_keywords() {
        return ['lc', 'lcake', 'search', 'toggle'];
    }

    public function get_style_depends() {
        return ['lc-header-footer-search-toggle-css'];
    }

    public function get_script_depends() {
        return ['lc-header-footer-search-toggle-js'];
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
                'default' => esc_html__('Search…', 'lc-addons-kit-for-elementor'),
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
                'default' => '#111827',
                'selectors' => ['{{WRAPPER}} .lc-hf-search-toggle-btn' => 'color: {{VALUE}};'],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <div class="lc-hf-search-toggle">
            <button type="button" class="lc-hf-search-toggle-btn" aria-label="<?php echo esc_attr__('Toggle search', 'lc-addons-kit-for-elementor'); ?>" aria-expanded="false">
                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <circle cx="11" cy="11" r="7"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
            </button>
            <form role="search" method="get" class="lc-hf-search-form" action="<?php echo esc_url(home_url('/')); ?>">
                <input type="search" name="s" class="lc-hf-search-input" placeholder="<?php echo esc_attr($settings['placeholder']); ?>" value="<?php echo esc_attr(get_search_query()); ?>">
            </form>
        </div>
        <?php
    }
}
