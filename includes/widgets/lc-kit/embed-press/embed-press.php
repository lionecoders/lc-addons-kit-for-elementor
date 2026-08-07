<?php
/**
 * Embed Anything (EmbedPress-style) Widget
 *
 * @package LC_Elementor_Addons_Kit
 */

if (!defined('ABSPATH')) {
    exit;
}

class LCAKE_Kit_Embed_Press extends \Elementor\Widget_Base {

    public function get_name() {
        return 'lcake-kit-embed-press';
    }

    public function get_categories() {
        return ['lcake-page-kit'];
    }

    public function get_title() {
        return esc_html__('Embed Anything', 'lc-addons-kit-for-elementor');
    }

    public function get_icon() {
        return 'eicon-code';
    }

    public function get_style_depends() {
        return ['lcake-kit-embed-press-css'];
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
            'embed_url',
            [
                'label' => esc_html__('URL', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => esc_html__('https://youtube.com/... or a PDF / doc link', 'lc-addons-kit-for-elementor'),
                'default' => ['url' => ''],
                'show_external' => false,
            ]
        );

        $this->add_responsive_control(
            'height',
            [
                'label' => esc_html__('Height', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => ['px' => ['min' => 200, 'max' => 1200]],
                'default' => ['size' => 480, 'unit' => 'px'],
                'selectors' => ['{{WRAPPER}} .lcake-embed-press iframe' => 'height: {{SIZE}}{{UNIT}};'],
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
            'border_radius',
            [
                'label' => esc_html__('Border Radius', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => ['px' => ['min' => 0, 'max' => 40]],
                'default' => ['size' => 16, 'unit' => 'px'],
                'selectors' => ['{{WRAPPER}} .lcake-embed-press' => 'border-radius: {{SIZE}}{{UNIT}}; overflow: hidden;'],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $url = $settings['embed_url']['url'] ?? '';

        if (empty($url)) {
            return;
        }

        $embed_html = wp_oembed_get($url);

        if (!$embed_html) {
            $is_pdf = 'pdf' === strtolower(pathinfo(wp_parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION));
            $src = $is_pdf ? 'https://docs.google.com/gview?url=' . rawurlencode($url) . '&embedded=true' : esc_url($url);
            $embed_html = sprintf('<iframe src="%s" frameborder="0" allowfullscreen loading="lazy"></iframe>', esc_url($src));
        }
        ?>
        <div class="lcake-embed-press">
            <?php echo LCAKE_Kit_Utils::kses($embed_html); ?>
        </div>
        <?php
    }
}
