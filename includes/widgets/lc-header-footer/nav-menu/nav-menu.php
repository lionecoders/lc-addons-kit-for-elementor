<?php
/**
 * Nav Menu Widget
 *
 * @package LC_Elementor_Addons_Kit
 */

if (!defined('ABSPATH')) {
    exit;
}

class LC_Header_Footer_Nav_Menu extends \Elementor\Widget_Base {

    public function get_name() {
        return 'lc-header-footer-nav-menu';
    }

    public function get_title() {
        return esc_html__('Nav Menu', 'lc-addons-kit-for-elementor');
    }

    public function get_icon() {
        return 'eicon-nav-menu';
    }

    public function get_categories() {
        return ['lc-header-footer-kit1'];
    }

    public function get_style_depends() {
        return ['lc-header-footer-nav-menu-css'];
    }

    public function get_script_depends() {
        return ['lc-header-footer-nav-menu-js'];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Content', 'lc-addons-kit-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $menus = wp_get_nav_menus();
        $menu_options = [0 => esc_html__('— Select a Menu —', 'lc-addons-kit-for-elementor')];
        foreach ($menus as $menu) {
            $menu_options[$menu->term_id] = $menu->name;
        }

        $this->add_control(
            'menu',
            [
                'label' => esc_html__('Menu', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => $menu_options,
                'default' => 0,
                'description' => empty($menus)
                    ? esc_html__('No menus found. Create one under Appearance > Menus.', 'lc-addons-kit-for-elementor')
                    : '',
            ]
        );

        $this->add_control(
            'layout',
            [
                'label' => esc_html__('Layout', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'horizontal',
                'options' => [
                    'horizontal' => esc_html__('Horizontal', 'lc-addons-kit-for-elementor'),
                    'vertical' => esc_html__('Vertical', 'lc-addons-kit-for-elementor'),
                ],
                'prefix_class' => 'lc-hf-nav-menu--',
            ]
        );

        $this->add_control(
            'mobile_breakpoint',
            [
                'label' => esc_html__('Collapse Below (px)', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 800,
                'description' => esc_html__('Pair with the Mobile Menu Toggle widget below this width.', 'lc-addons-kit-for-elementor'),
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
            'item_spacing',
            [
                'label' => esc_html__('Spacing', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => ['px' => ['min' => 0, 'max' => 60]],
                'default' => ['size' => 28, 'unit' => 'px'],
                'selectors' => ['{{WRAPPER}} .lc-hf-nav-menu' => 'gap: {{SIZE}}{{UNIT}};'],
            ]
        );

        $this->add_control(
            'link_color',
            [
                'label' => esc_html__('Link Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#111827',
                'selectors' => ['{{WRAPPER}} .lc-hf-nav-menu > li > a' => 'color: {{VALUE}};'],
            ]
        );

        $this->add_control(
            'link_hover_color',
            [
                'label' => esc_html__('Hover / Active Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#3b82f6',
                'selectors' => [
                    '{{WRAPPER}} .lc-hf-nav-menu > li > a:hover' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .lc-hf-nav-menu > li.current-menu-item > a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'link_typography',
                'selector' => '{{WRAPPER}} .lc-hf-nav-menu > li > a',
            ]
        );

        $this->add_control(
            'submenu_background',
            [
                'label' => esc_html__('Submenu Background', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => ['{{WRAPPER}} .lc-hf-nav-submenu' => 'background-color: {{VALUE}};'],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $menu_id = (int) $settings['menu'];

        if (empty($menu_id)) {
            if (current_user_can('edit_theme_options')) {
                echo '<p class="lc-hf-notice">' . esc_html__('Select a menu to display.', 'lc-addons-kit-for-elementor') . '</p>';
            }
            return;
        }

        $args = [
            'menu' => $menu_id,
            'container' => 'nav',
            'container_class' => 'lc-hf-nav-menu-wrapper',
            'menu_class' => 'lc-hf-nav-menu',
            'echo' => false,
            'fallback_cb' => false,
            'walker' => new LC_Header_Footer_Nav_Menu_Walker(),
        ];

        $menu_html = wp_nav_menu($args);

        if (!$menu_html) {
            return;
        }

        echo LCAKE_Kit_Utils::kses($menu_html);
    }
}

if (!class_exists('LC_Header_Footer_Nav_Menu_Walker')) {
    class LC_Header_Footer_Nav_Menu_Walker extends \Walker_Nav_Menu {
        public function start_lvl(&$output, $depth = 0, $args = null) {
            $output .= '<ul class="lc-hf-nav-submenu lc-hf-nav-submenu--depth-' . (int) $depth . '">';
        }

        public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
            $has_children = in_array('menu-item-has-children', $item->classes, true);
            $classes = implode(' ', array_filter($item->classes));

            $output .= '<li class="' . esc_attr($classes) . ($has_children ? ' lc-hf-has-submenu' : '') . '">';
            $output .= '<a href="' . esc_url($item->url) . '">' . esc_html($item->title);
            if ($has_children) {
                $output .= '<span class="lc-hf-submenu-caret" aria-hidden="true">&#9662;</span>';
            }
            $output .= '</a>';
        }
    }
}
