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
        return esc_html__('LC Login / Register', 'lc-addons-kit-for-elementor');
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
            'section_style',
            [
                'label' => esc_html__('Style', 'lc-addons-kit-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'accent_color',
            [
                'label' => esc_html__('Accent Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#3b82f6',
                'selectors' => [
                    '{{WRAPPER}} .lcake-login-register-tab.is-active' => 'color: {{VALUE}}; border-color: {{VALUE}};',
                    '{{WRAPPER}} .lcake-login-register button[type="submit"]' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        if (is_user_logged_in()) {
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
        $show_register = 'yes' === $settings['show_register_tab'] && get_option('users_can_register');
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
