<?php
/**
 * Sticky Video Widget
 *
 * @package LC_Elementor_Addons_Kit
 */

if (!defined('ABSPATH')) {
    exit;
}

class LCAKE_Kit_Sticky_Video extends \Elementor\Widget_Base {

    public function get_name() {
        return 'lcake-kit-sticky-video';
    }

    public function get_categories() {
        return ['lcake-page-kit'];
    }

    public function get_title() {
        return esc_html__('LC Sticky Video', 'lc-addons-kit-for-elementor');
    }

    public function get_icon() {
        return 'eicon-youtube';
    }

    public function get_style_depends() {
        return ['lcake-kit-sticky-video-css'];
    }

    public function get_script_depends() {
        return ['lcake-kit-sticky-video-js'];
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
            'video_url',
            [
                'label' => esc_html__('Video URL', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => esc_html__('https://youtube.com/watch?v=...', 'lc-addons-kit-for-elementor'),
                'default' => ['url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ'],
                'show_external' => false,
            ]
        );

        $this->add_control(
            'stick_position',
            [
                'label' => esc_html__('Docked Position', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'bottom-right',
                'options' => [
                    'bottom-right' => esc_html__('Bottom Right', 'lc-addons-kit-for-elementor'),
                    'bottom-left' => esc_html__('Bottom Left', 'lc-addons-kit-for-elementor'),
                ],
                'prefix_class' => 'lcake-sticky-video--',
            ]
        );

        $this->add_control(
            'show_close',
            [
                'label' => esc_html__('Show Close Button', 'lc-addons-kit-for-elementor'),
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

        $this->add_responsive_control(
            'docked_width',
            [
                'label' => esc_html__('Docked Width', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => ['px' => ['min' => 200, 'max' => 500]],
                'default' => ['size' => 320, 'unit' => 'px'],
                'selectors' => ['{{WRAPPER}} .lcake-sticky-video.is-docked' => 'width: {{SIZE}}{{UNIT}};'],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $url = $settings['video_url']['url'] ?? '';

        if (empty($url)) {
            return;
        }

        $embed_html = wp_oembed_get($url);
        if (!$embed_html) {
            $embed_html = sprintf('<iframe src="%s" frameborder="0" allowfullscreen></iframe>', esc_url($url));
        }
        ?>
        <div class="lcake-sticky-video" data-show-close="<?php echo esc_attr($settings['show_close']); ?>">
            <div class="lcake-sticky-video-inner">
                <?php echo LCAKE_Kit_Utils::kses($embed_html); ?>
                <?php if ('yes' === $settings['show_close']) : ?>
                    <button type="button" class="lcake-sticky-video-close" aria-label="<?php echo esc_attr__('Close', 'lc-addons-kit-for-elementor'); ?>">&times;</button>
                <?php endif; ?>
            </div>
        </div>
        <?php
    }
}
