<?php
/**
 * Facebook Page Feed Widget
 *
 * @package LC_Elementor_Addons_Kit
 */

if (!defined('ABSPATH')) {
    exit;
}

class LCAKE_Kit_Facebook_Feed extends \Elementor\Widget_Base {

    public function get_name() {
        return 'lcake-kit-facebook-feed';
    }

    public function get_categories() {
        return ['lcake-page-kit'];
    }

    public function get_title() {
        return esc_html__('LC Facebook Feed', 'lc-addons-kit-for-elementor');
    }

    public function get_icon() {
        return 'eicon-facebook';
    }

    public function get_style_depends() {
        return ['lcake-kit-facebook-feed-css'];
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
            'page_url',
            [
                'label' => esc_html__('Facebook Page URL', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'https://www.facebook.com/WordPress',
                'placeholder' => 'https://www.facebook.com/yourpage',
                'label_block' => true,
            ]
        );

        $this->add_control(
            'tabs',
            [
                'label' => esc_html__('Tabs', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'multiple' => true,
                'default' => ['timeline'],
                'options' => [
                    'timeline' => esc_html__('Timeline', 'lc-addons-kit-for-elementor'),
                    'events' => esc_html__('Events', 'lc-addons-kit-for-elementor'),
                    'messages' => esc_html__('Messages', 'lc-addons-kit-for-elementor'),
                ],
            ]
        );

        $this->add_control(
            'small_header',
            [
                'label' => esc_html__('Small Header', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => '',
            ]
        );

        $this->add_control(
            'show_cover',
            [
                'label' => esc_html__('Show Cover Photo', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_facepile',
            [
                'label' => esc_html__('Show Friend\'s Faces', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => '',
            ]
        );

        $this->add_responsive_control(
            'width',
            [
                'label' => esc_html__('Width', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => ['px' => ['min' => 180, 'max' => 500]],
                'default' => ['size' => 340, 'unit' => 'px'],
            ]
        );

        $this->add_responsive_control(
            'height',
            [
                'label' => esc_html__('Height', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => ['px' => ['min' => 200, 'max' => 1200]],
                'default' => ['size' => 500, 'unit' => 'px'],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $page_url = esc_url($settings['page_url'] ?? '');

        if (empty($page_url)) {
            return;
        }

        $width = !empty($settings['width']['size']) ? (int) $settings['width']['size'] : 340;
        $height = !empty($settings['height']['size']) ? (int) $settings['height']['size'] : 500;
        $tabs = !empty($settings['tabs']) ? implode(',', $settings['tabs']) : 'timeline';

        $args = [
            'href' => $page_url,
            'tabs' => $tabs,
            'width' => $width,
            'height' => $height,
            'small_header' => 'yes' === $settings['small_header'] ? 'true' : 'false',
            'adapt_container_width' => 'true',
            'hide_cover' => 'yes' === $settings['show_cover'] ? 'false' : 'true',
            'show_facepile' => 'yes' === $settings['show_facepile'] ? 'true' : 'false',
        ];

        $embed_src = add_query_arg($args, 'https://www.facebook.com/plugins/page.php');
        ?>
        <div class="lcake-facebook-feed" style="max-width: <?php echo esc_attr($width); ?>px;">
            <iframe src="<?php echo esc_url($embed_src); ?>"
                    width="<?php echo esc_attr($width); ?>"
                    height="<?php echo esc_attr($height); ?>"
                    style="border:none;overflow:hidden;max-width:100%;"
                    scrolling="no"
                    frameborder="0"
                    allowfullscreen="true"
                    allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"
                    loading="lazy"></iframe>
        </div>
        <?php
    }
}
