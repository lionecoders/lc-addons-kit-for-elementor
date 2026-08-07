<?php
/**
 * Login / Register Widget
 *
 * @package LC_Elementor_Addons_Kit
 */

if (!defined('ABSPATH')) {
    exit;
}

class LCAKE_Kit_Login_Register extends \Elementor\Widget_Base {

    public function get_name() {
        return 'lcake-kit-login-register';
    }

    public function get_categories() {
        return ['lcake-page-kit'];
    }

    public function get_title() {
        return esc_html__('Login / Register', 'lc-addons-kit-for-elementor');
    }

    public function get_icon() {
        return 'eicon-lock-user';
    }

    public function get_style_depends() {
        return ['lcake-kit-login-register-css'];
    }

    public function get_script_depends() {
        return ['lcake-kit-login-register-js'];
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
            'show_register_tab',
            [
                'label' => esc_html__('Show Register Tab', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => get_option('users_can_register') ? 'yes' : '',
            ]
        );

        $this->add_control(
            'redirect_url',
            [
                'label' => esc_html__('Redirect After Login', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::URL,
                'default' => ['url' => ''],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_container',
            [
                'label' => esc_html__('Container', 'lc-addons-kit-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'box_max_width',
            [
                'label' => esc_html__('Max Width', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 200,
                        'max' => 1200,
                    ],
                ],
                'default' => [
                    'size' => 420,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .lcake-login-register' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'box_background',
                'label' => esc_html__('Background', 'lc-addons-kit-for-elementor'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .lcake-login-register',
            ]
        );

        $this->add_responsive_control(
            'box_padding',
            [
                'label' => esc_html__('Padding', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'default' => [
                    'top' => '30',
                    'bottom' => '30',
                    'left' => '30',
                    'right' => '30',
                    'unit' => 'px',
                    'isLinked' => true,
                ],
                'selectors' => [
                    '{{WRAPPER}} .lcake-login-register' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'box_border_radius',
            [
                'label' => esc_html__('Border Radius', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'default' => [
                    'top' => '20',
                    'bottom' => '20',
                    'left' => '20',
                    'right' => '20',
                    'unit' => 'px',
                    'isLinked' => true,
                ],
                'selectors' => [
                    '{{WRAPPER}} .lcake-login-register' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'box_shadow',
                'selector' => '{{WRAPPER}} .lcake-login-register',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_tabs',
            [
                'label' => esc_html__('Tabs', 'lc-addons-kit-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'tabs_typography',
                'selector' => '{{WRAPPER}} .lcake-login-register-tab',
            ]
        );

        $this->add_responsive_control(
            'tabs_spacing',
            [
                'label' => esc_html__('Spacing Below Tabs', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'size' => 24,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .lcake-login-register-tabs' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('tabs_style');

        $this->start_controls_tab(
            'tab_normal',
            [
                'label' => esc_html__('Normal', 'lc-addons-kit-for-elementor'),
            ]
        );

        $this->add_control(
            'tab_color',
            [
                'label' => esc_html__('Text Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#6b7280',
                'selectors' => [
                    '{{WRAPPER}} .lcake-login-register-tab' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_active',
            [
                'label' => esc_html__('Active', 'lc-addons-kit-for-elementor'),
            ]
        );

        $this->add_control(
            'tab_active_color',
            [
                'label' => esc_html__('Text Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#3b82f6',
                'selectors' => [
                    '{{WRAPPER}} .lcake-login-register-tab.is-active' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'tab_active_border_color',
            [
                'label' => esc_html__('Border Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#3b82f6',
                'selectors' => [
                    '{{WRAPPER}} .lcake-login-register-tab.is-active' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_fields',
            [
                'label' => esc_html__('Labels & Inputs', 'lc-addons-kit-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'heading_labels',
            [
                'label' => esc_html__('Labels', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'label_color',
            [
                'label' => esc_html__('Label Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#111827',
                'selectors' => [
                    '{{WRAPPER}} .lcake-login-register label' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'label_typography',
                'selector' => '{{WRAPPER}} .lcake-login-register label',
            ]
        );

        $this->add_responsive_control(
            'label_spacing',
            [
                'label' => esc_html__('Spacing Below Label', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'default' => [
                    'size' => 6,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .lcake-login-register label' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'heading_inputs',
            [
                'label' => esc_html__('Inputs', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'input_typography',
                'selector' => '{{WRAPPER}} .lcake-login-register input[type="text"], {{WRAPPER}} .lcake-login-register input[type="email"], {{WRAPPER}} .lcake-login-register input[type="password"]',
            ]
        );

        $this->add_control(
            'input_text_color',
            [
                'label' => esc_html__('Text Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lcake-login-register input[type="text"], {{WRAPPER}} .lcake-login-register input[type="email"], {{WRAPPER}} .lcake-login-register input[type="password"]' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'input_bg_color',
            [
                'label' => esc_html__('Background Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lcake-login-register input[type="text"], {{WRAPPER}} .lcake-login-register input[type="email"], {{WRAPPER}} .lcake-login-register input[type="password"]' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'input_border_color',
            [
                'label' => esc_html__('Border Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lcake-login-register input[type="text"], {{WRAPPER}} .lcake-login-register input[type="email"], {{WRAPPER}} .lcake-login-register input[type="password"]' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'input_focus_border_color',
            [
                'label' => esc_html__('Focus Border Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lcake-login-register input[type="text"]:focus, {{WRAPPER}} .lcake-login-register input[type="email"]:focus, {{WRAPPER}} .lcake-login-register input[type="password"]:focus' => 'border-color: {{VALUE}}; outline: none;',
                ],
            ]
        );

        $this->add_responsive_control(
            'input_padding',
            [
                'label' => esc_html__('Padding', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'default' => [
                    'top' => '12',
                    'bottom' => '12',
                    'left' => '16',
                    'right' => '16',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
                'selectors' => [
                    '{{WRAPPER}} .lcake-login-register input[type="text"], {{WRAPPER}} .lcake-login-register input[type="email"], {{WRAPPER}} .lcake-login-register input[type="password"]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'input_border_radius',
            [
                'label' => esc_html__('Border Radius', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'default' => [
                    'size' => 10,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .lcake-login-register input[type="text"], {{WRAPPER}} .lcake-login-register input[type="email"], {{WRAPPER}} .lcake-login-register input[type="password"]' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_button',
            [
                'label' => esc_html__('Submit Button', 'lc-addons-kit-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'button_typography',
                'selector' => '{{WRAPPER}} .lcake-login-register button[type="submit"], {{WRAPPER}} .lcake-login-register input[type="submit"]',
            ]
        );

        $this->start_controls_tabs('button_style');

        $this->start_controls_tab(
            'button_normal',
            [
                'label' => esc_html__('Normal', 'lc-addons-kit-for-elementor'),
            ]
        );

        $this->add_control(
            'button_color',
            [
                'label' => esc_html__('Text Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .lcake-login-register button[type="submit"], {{WRAPPER}} .lcake-login-register input[type="submit"]' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_bg_color',
            [
                'label' => esc_html__('Background Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#3b82f6',
                'selectors' => [
                    '{{WRAPPER}} .lcake-login-register button[type="submit"], {{WRAPPER}} .lcake-login-register input[type="submit"]' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'button_hover',
            [
                'label' => esc_html__('Hover', 'lc-addons-kit-for-elementor'),
            ]
        );

        $this->add_control(
            'button_hover_color',
            [
                'label' => esc_html__('Text Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .lcake-login-register button[type="submit"]:hover, {{WRAPPER}} .lcake-login-register input[type="submit"]:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_hover_bg_color',
            [
                'label' => esc_html__('Background Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#2563eb',
                'selectors' => [
                    '{{WRAPPER}} .lcake-login-register button[type="submit"]:hover, {{WRAPPER}} .lcake-login-register input[type="submit"]:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'button_padding',
            [
                'label' => esc_html__('Padding', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'default' => [
                    'top' => '12',
                    'bottom' => '12',
                    'left' => '16',
                    'right' => '16',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
                'selectors' => [
                    '{{WRAPPER}} .lcake-login-register button[type="submit"], {{WRAPPER}} .lcake-login-register input[type="submit"]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'button_border_radius',
            [
                'label' => esc_html__('Border Radius', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'default' => [
                    'size' => 10,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .lcake-login-register button[type="submit"], {{WRAPPER}} .lcake-login-register input[type="submit"]' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        if (is_user_logged_in() && ! \Elementor\Plugin::$instance->editor->is_edit_mode()) {
            ?>
            <div class="lcake-login-register lcake-login-register--logged-in">
                <p>
                    <?php
                    printf(
                        /* translators: %s: user display name */
                        esc_html__('You are logged in as %s.', 'lc-addons-kit-for-elementor'),
                        '<strong>' . esc_html(wp_get_current_user()->display_name) . '</strong>'
                    );
                    ?>
                </p>
                <a class="lcake-login-register-logout" href="<?php echo esc_url(wp_logout_url(get_permalink())); ?>">
                    <?php esc_html_e('Log Out', 'lc-addons-kit-for-elementor'); ?>
                </a>
            </div>
            <?php
            return;
        }

        $settings = $this->get_settings_for_display();
        $show_register = 'yes' === $settings['show_register_tab'];
        $redirect = !empty($settings['redirect_url']['url']) ? $settings['redirect_url']['url'] : get_permalink();
        ?>
        <div class="lcake-login-register">
            <div class="lcake-login-register-tabs" role="tablist">
                <button type="button" class="lcake-login-register-tab is-active" data-target="login"><?php esc_html_e('Login', 'lc-addons-kit-for-elementor'); ?></button>
                <?php if ($show_register) : ?>
                    <button type="button" class="lcake-login-register-tab" data-target="register"><?php esc_html_e('Register', 'lc-addons-kit-for-elementor'); ?></button>
                <?php endif; ?>
                <button type="button" class="lcake-login-register-tab" data-target="lostpassword"><?php esc_html_e('Lost Password', 'lc-addons-kit-for-elementor'); ?></button>
            </div>

            <div class="lcake-login-register-panel is-active" data-panel="login">
                <?php
                wp_login_form([
                    'redirect' => $redirect,
                    'form_id' => 'lcake-login-form-' . $this->get_id(),
                    'label_username' => esc_html__('Username or Email', 'lc-addons-kit-for-elementor'),
                    'label_password' => esc_html__('Password', 'lc-addons-kit-for-elementor'),
                    'label_remember' => esc_html__('Remember Me', 'lc-addons-kit-for-elementor'),
                    'label_log_in' => esc_html__('Log In', 'lc-addons-kit-for-elementor'),
                    'remember' => true,
                ]);
                ?>
            </div>

            <?php if ($show_register) : ?>
                <div class="lcake-login-register-panel" data-panel="register">
                    <form method="post" action="<?php echo esc_url(wp_registration_url()); ?>">
                        <p>
                            <label for="lcake_user_login"><?php esc_html_e('Username', 'lc-addons-kit-for-elementor'); ?></label>
                            <input type="text" name="user_login" id="lcake_user_login" required>
                        </p>
                        <p>
                            <label for="lcake_user_email"><?php esc_html_e('Email', 'lc-addons-kit-for-elementor'); ?></label>
                            <input type="email" name="user_email" id="lcake_user_email" required>
                        </p>
                        <p>
                            <button type="submit"><?php esc_html_e('Register', 'lc-addons-kit-for-elementor'); ?></button>
                        </p>
                    </form>
                </div>
            <?php endif; ?>

            <div class="lcake-login-register-panel" data-panel="lostpassword">
                <form method="post" action="<?php echo esc_url(wp_lostpassword_url($redirect)); ?>">
                    <p>
                        <label for="lcake_user_login_lp"><?php esc_html_e('Username or Email', 'lc-addons-kit-for-elementor'); ?></label>
                        <input type="text" name="user_login" id="lcake_user_login_lp" required>
                    </p>
                    <p>
                        <button type="submit"><?php esc_html_e('Reset Password', 'lc-addons-kit-for-elementor'); ?></button>
                    </p>
                </form>
            </div>
        </div>
        <?php
    }
}
