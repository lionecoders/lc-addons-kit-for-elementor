<?php
/**
 * MailChimp Widget
 * 
 * @package LC_Elementor_Addons_Kit
 */

if (!defined('ABSPATH')) {
    exit;
}

class LC_Kit_Mailchimp extends \Elementor\Widget_Base {

    public function get_name() {
        return 'lc-kit-mailchimp';
    }

    public function get_title() {
        return esc_html__('MailChimp', 'lc-elementor-addons-kit');
    }

    public function get_icon() {
        return 'eicon-mail';
    }

    public function get_categories() {
        return ['lc-page-kit'];
    }

    public function get_keywords() {
        return ['mailchimp', 'email', 'newsletter', 'subscribe', 'form'];
    }

    protected function add_content_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Content', 'lc-elementor-addons-kit'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => esc_html__('Title', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Subscribe to our newsletter', 'lc-elementor-addons-kit'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'description',
            [
                'label' => esc_html__('Description', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => esc_html__('Get the latest news and updates delivered to your inbox.', 'lc-elementor-addons-kit'),
                'rows' => 3,
            ]
        );

        $this->add_control(
            'api_key',
            [
                'label' => esc_html__('MailChimp API Key', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__('Enter your MailChimp API key', 'lc-elementor-addons-kit'),
                'description' => esc_html__('You can find your API key in your MailChimp account under Account > Extras > API Keys.', 'lc-elementor-addons-kit'),
            ]
        );

        $this->add_control(
            'list_id',
            [
                'label' => esc_html__('Audience ID', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__('Enter your MailChimp Audience ID', 'lc-elementor-addons-kit'),
                'description' => esc_html__('You can find your Audience ID in your MailChimp account under Audience > Settings > Audience name and defaults.', 'lc-elementor-addons-kit'),
            ]
        );

        $this->add_control(
            'email_placeholder',
            [
                'label' => esc_html__('Email Placeholder', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Enter your email address', 'lc-elementor-addons-kit'),
            ]
        );

        $this->add_control(
            'button_text',
            [
                'label' => esc_html__('Button Text', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Subscribe', 'lc-elementor-addons-kit'),
            ]
        );

        $this->add_control(
            'show_name_field',
            [
                'label' => esc_html__('Show Name Field', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'lc-elementor-addons-kit'),
                'label_off' => esc_html__('Hide', 'lc-elementor-addons-kit'),
                'return_value' => 'yes',
                'default' => '',
            ]
        );

        $this->add_control(
            'name_placeholder',
            [
                'label' => esc_html__('Name Placeholder', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Enter your name', 'lc-elementor-addons-kit'),
                'condition' => [
                    'show_name_field' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'layout',
            [
                'label' => esc_html__('Layout', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'inline',
                'options' => [
                    'inline' => esc_html__('Inline', 'lc-elementor-addons-kit'),
                    'stacked' => esc_html__('Stacked', 'lc-elementor-addons-kit'),
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function add_style_controls() {
        $this->start_controls_section(
            'section_style_form',
            [
                'label' => esc_html__('Form', 'lc-elementor-addons-kit'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'form_background_color',
            [
                'label' => esc_html__('Background Color', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lc-mailchimp-form' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'form_border',
                'selector' => '{{WRAPPER}} .lc-mailchimp-form',
            ]
        );

        $this->add_control(
            'form_border_radius',
            [
                'label' => esc_html__('Border Radius', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lc-mailchimp-form' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'form_padding',
            [
                'label' => esc_html__('Padding', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lc-mailchimp-form' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_title',
            [
                'label' => esc_html__('Title', 'lc-elementor-addons-kit'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__('Color', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lc-mailchimp-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .lc-mailchimp-title',
            ]
        );

        $this->add_responsive_control(
            'title_margin',
            [
                'label' => esc_html__('Margin', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lc-mailchimp-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_description',
            [
                'label' => esc_html__('Description', 'lc-elementor-addons-kit'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'description_color',
            [
                'label' => esc_html__('Color', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lc-mailchimp-description' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'description_typography',
                'selector' => '{{WRAPPER}} .lc-mailchimp-description',
            ]
        );

        $this->add_responsive_control(
            'description_margin',
            [
                'label' => esc_html__('Margin', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lc-mailchimp-description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_inputs',
            [
                'label' => esc_html__('Input Fields', 'lc-elementor-addons-kit'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'input_background_color',
            [
                'label' => esc_html__('Background Color', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lc-mailchimp-input' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'input_color',
            [
                'label' => esc_html__('Text Color', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lc-mailchimp-input' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'input_typography',
                'selector' => '{{WRAPPER}} .lc-mailchimp-input',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'input_border',
                'selector' => '{{WRAPPER}} .lc-mailchimp-input',
            ]
        );

        $this->add_control(
            'input_border_radius',
            [
                'label' => esc_html__('Border Radius', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lc-mailchimp-input' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'input_padding',
            [
                'label' => esc_html__('Padding', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lc-mailchimp-input' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'input_margin',
            [
                'label' => esc_html__('Margin', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lc-mailchimp-input' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_button',
            [
                'label' => esc_html__('Button', 'lc-elementor-addons-kit'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'button_background_color',
            [
                'label' => esc_html__('Background Color', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lc-mailchimp-button' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_color',
            [
                'label' => esc_html__('Text Color', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lc-mailchimp-button' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'button_typography',
                'selector' => '{{WRAPPER}} .lc-mailchimp-button',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'button_border',
                'selector' => '{{WRAPPER}} .lc-mailchimp-button',
            ]
        );

        $this->add_control(
            'button_border_radius',
            [
                'label' => esc_html__('Border Radius', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lc-mailchimp-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_padding',
            [
                'label' => esc_html__('Padding', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lc-mailchimp-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        $this->add_render_attribute('wrapper', 'class', 'lc-mailchimp-wrapper');
        $this->add_render_attribute('wrapper', 'class', 'lc-mailchimp--' . $settings['layout']);

        echo '<div ' . $this->get_render_attribute_string('wrapper') . '>';

        if (!empty($settings['title'])) {
            echo '<h3 class="lc-mailchimp-title">' . esc_html($settings['title']) . '</h3>';
        }

        if (!empty($settings['description'])) {
            echo '<div class="lc-mailchimp-description">' . esc_html($settings['description']) . '</div>';
        }

        echo '<form class="lc-mailchimp-form" method="post">';
        echo '<input type="hidden" name="lc_mailchimp_api_key" value="' . esc_attr($settings['api_key']) . '">';
        echo '<input type="hidden" name="lc_mailchimp_list_id" value="' . esc_attr($settings['list_id']) . '">';
        echo '<input type="hidden" name="lc_mailchimp_nonce" value="' . wp_create_nonce('lc_mailchimp_nonce') . '">';

        if ($settings['show_name_field'] === 'yes') {
            echo '<input type="text" name="lc_mailchimp_name" class="lc-mailchimp-input lc-mailchimp-name" placeholder="' . esc_attr($settings['name_placeholder']) . '" required>';
        }

        echo '<input type="email" name="lc_mailchimp_email" class="lc-mailchimp-input lc-mailchimp-email" placeholder="' . esc_attr($settings['email_placeholder']) . '" required>';
        echo '<button type="submit" class="lc-mailchimp-button">' . esc_html($settings['button_text']) . '</button>';

        echo '<div class="lc-mailchimp-message"></div>';
        echo '</form>';

        echo '</div>';
    }

    protected function content_template() {
        ?>
        <div class="lc-mailchimp-wrapper lc-mailchimp--{{ settings.layout }}">
            <# if (settings.title) { #>
                <h3 class="lc-mailchimp-title">{{{ settings.title }}}</h3>
            <# } #>
            
            <# if (settings.description) { #>
                <div class="lc-mailchimp-description">{{{ settings.description }}}</div>
            <# } #>
            
            <form class="lc-mailchimp-form" method="post">
                <input type="hidden" name="lc_mailchimp_api_key" value="{{ settings.api_key }}">
                <input type="hidden" name="lc_mailchimp_list_id" value="{{ settings.list_id }}">
                <input type="hidden" name="lc_mailchimp_nonce" value="">
                
                <# if (settings.show_name_field === 'yes') { #>
                    <input type="text" name="lc_mailchimp_name" class="lc-mailchimp-input lc-mailchimp-name" placeholder="{{ settings.name_placeholder }}" required>
                <# } #>
                
                <input type="email" name="lc_mailchimp_email" class="lc-mailchimp-input lc-mailchimp-email" placeholder="{{ settings.email_placeholder }}" required>
                <button type="submit" class="lc-mailchimp-button">{{{ settings.button_text }}}</button>
                
                <div class="lc-mailchimp-message"></div>
            </form>
        </div>
        <?php
    }
} 