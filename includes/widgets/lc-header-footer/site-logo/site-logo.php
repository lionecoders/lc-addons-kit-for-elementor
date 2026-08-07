<?php
/**
 * Site Logo Widget
 *
 * @package LC_Elementor_Addons_Kit
 */

if (!defined('ABSPATH')) {
    exit;
}

class LC_Header_Footer_Site_Logo extends \Elementor\Widget_Base {

    public function get_name() {
        return 'lc-header-footer-site-logo';
    }

    public function get_title() {
        return esc_html__('Site Logo', 'lc-addons-kit-for-elementor');
    }

    public function get_icon() {
        return 'eicon-site-logo';
    }

    public function get_categories() {
        return ['lc-header-footer-kit1'];
    }

    public function get_style_depends() {
        return ['lc-header-footer-site-logo-css'];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Content', 'lc-addons-kit-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $custom_logo_id = get_theme_mod('custom_logo');
        $default_logo = $custom_logo_id ? wp_get_attachment_image_src($custom_logo_id, 'full')[0] : '';

        $this->add_control(
            'logo',
            [
                'label' => esc_html__('Logo', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => ['url' => $default_logo],
                'description' => sprintf(
                    /* translators: %s: Link to WordPress Customizer */
                    esc_html__('Defaults to your Customizer site logo if left empty. Set it %shere%s.', 'lc-addons-kit-for-elementor'),
                    '<a href="' . esc_url(admin_url('customize.php?autofocus[control]=custom_logo')) . '" target="_blank">',
                    '</a>'
                ),
            ]
        );

        $this->add_control(
            'link_to_home',
            [
                'label' => esc_html__('Link to Home', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_responsive_control(
            'logo_width',
            [
                'label' => esc_html__('Width', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => ['px' => ['min' => 30, 'max' => 500], '%' => ['min' => 10, 'max' => 100]],
                'default' => ['size' => 140, 'unit' => 'px'],
                'selectors' => [
                    '{{WRAPPER}} .lc-hf-site-logo img' => 'width: {{SIZE}}{{UNIT}}; height: auto;',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $logo_url = $settings['logo']['url'] ?? '';

        if (empty($logo_url)) {
            $custom_logo_id = get_theme_mod('custom_logo');
            if ($custom_logo_id) {
                $logo_src = wp_get_attachment_image_src($custom_logo_id, 'full');
                $logo_url = $logo_src ? $logo_src[0] : '';
            }
        }

        if (empty($logo_url)) {
            if (current_user_can('customize')) {
                echo '<p class="lc-hf-notice">' . sprintf(
                    /* translators: %s: Link to WordPress Customizer */
                    esc_html__('No logo set. Choose one above or set a Site Logo in the %sWordPress Customizer%s.', 'lc-addons-kit-for-elementor'),
                    '<a href="' . esc_url(admin_url('customize.php?autofocus[control]=custom_logo')) . '" target="_blank">',
                    '</a>'
                ) . '</p>';
            }
            return;
        }

        $tag_open = 'yes' === $settings['link_to_home'] ? '<a href="' . esc_url(home_url('/')) . '" class="lc-hf-site-logo-link">' : '';
        $tag_close = 'yes' === $settings['link_to_home'] ? '</a>' : '';
        ?>
        <div class="lc-hf-site-logo">
            <?php echo $tag_open; ?>
            <img src="<?php echo esc_url($logo_url); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>">
            <?php echo $tag_close; ?>
        </div>
        <?php
    }
}
