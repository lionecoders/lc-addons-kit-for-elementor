<?php
/**
 * Contact Form 7 Widget
 * 
 * @package LC_Elementor_Addons_Kit
 */

if (!defined('ABSPATH')) {
    exit;
}

class LC_Kit_Contact_Form_7 extends \Elementor\Widget_Base {

    public function get_name() {
        return 'lc-kit-contact-form-7';
    }

    public function get_title() {
        return esc_html__('LC Contact Form 7', 'lc-addons-kit-for-elementor');
    }

    public function get_icon() {
        return 'eicon-form-horizontal';
    }

    public function get_categories() {
        return ['lc-page-kit'];
    }

    public function get_keywords() {
        return ['contact', 'form', 'cf7', 'contact form 7', 'form'];
    }

    protected function add_content_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Content', 'lc-addons-kit-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'form_id',
            [
                'label' => esc_html__('Select Form', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => $this->get_contact_form_7_forms(),
                'default' => '',
                'description' => esc_html__('Select a Contact Form 7 form to display. Make sure Contact Form 7 plugin is installed and activated.', 'lc-addons-kit-for-elementor'),
            ]
        );

        $this->add_control(
            'form_title',
            [
                'label' => esc_html__('Form Title', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__('Enter form title', 'lc-addons-kit-for-elementor'),
            ]
        );

        $this->add_control(
            'form_description',
            [
                'label' => esc_html__('Form Description', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'placeholder' => esc_html__('Enter form description', 'lc-addons-kit-for-elementor'),
                'rows' => 3,
            ]
        );

        $this->add_control(
            'show_form_title',
            [
                'label' => esc_html__('Show Form Title', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'lc-addons-kit-for-elementor'),
                'label_off' => esc_html__('Hide', 'lc-addons-kit-for-elementor'),
                'return_value' => 'yes',
                'default' => '',
            ]
        );

        $this->add_control(
            'show_form_description',
            [
                'label' => esc_html__('Show Form Description', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'lc-addons-kit-for-elementor'),
                'label_off' => esc_html__('Hide', 'lc-addons-kit-for-elementor'),
                'return_value' => 'yes',
                'default' => '',
            ]
        );

        $this->end_controls_section();
    }

    protected function add_style_controls() {
        $this->start_controls_section(
            'section_style_form',
            [
                'label' => esc_html__('Form', 'lc-addons-kit-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'form_background_color',
            [
                'label' => esc_html__('Background Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lc-contact-form-7' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'form_border',
                'selector' => '{{WRAPPER}} .lc-contact-form-7',
            ]
        );

        $this->add_control(
            'form_border_radius',
            [
                'label' => esc_html__('Border Radius', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lc-contact-form-7' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'form_padding',
            [
                'label' => esc_html__('Padding', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lc-contact-form-7' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_title',
            [
                'label' => esc_html__('Title', 'lc-addons-kit-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_form_title' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__('Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lc-contact-form-7-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .lc-contact-form-7-title',
            ]
        );

        $this->add_responsive_control(
            'title_margin',
            [
                'label' => esc_html__('Margin', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lc-contact-form-7-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_description',
            [
                'label' => esc_html__('Description', 'lc-addons-kit-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_form_description' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'description_color',
            [
                'label' => esc_html__('Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lc-contact-form-7-description' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'description_typography',
                'selector' => '{{WRAPPER}} .lc-contact-form-7-description',
            ]
        );

        $this->add_responsive_control(
            'description_margin',
            [
                'label' => esc_html__('Margin', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lc-contact-form-7-description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_inputs',
            [
                'label' => esc_html__('Input Fields', 'lc-addons-kit-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'input_background_color',
            [
                'label' => esc_html__('Background Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lc-contact-form-7 input[type="text"],
                     {{WRAPPER}} .lc-contact-form-7 input[type="email"],
                     {{WRAPPER}} .lc-contact-form-7 input[type="tel"],
                     {{WRAPPER}} .lc-contact-form-7 input[type="url"],
                     {{WRAPPER}} .lc-contact-form-7 input[type="number"],
                     {{WRAPPER}} .lc-contact-form-7 input[type="date"],
                     {{WRAPPER}} .lc-contact-form-7 textarea,
                     {{WRAPPER}} .lc-contact-form-7 select' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'input_color',
            [
                'label' => esc_html__('Text Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lc-contact-form-7 input[type="text"],
                     {{WRAPPER}} .lc-contact-form-7 input[type="email"],
                     {{WRAPPER}} .lc-contact-form-7 input[type="tel"],
                     {{WRAPPER}} .lc-contact-form-7 input[type="url"],
                     {{WRAPPER}} .lc-contact-form-7 input[type="number"],
                     {{WRAPPER}} .lc-contact-form-7 input[type="date"],
                     {{WRAPPER}} .lc-contact-form-7 textarea,
                     {{WRAPPER}} .lc-contact-form-7 select' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'input_typography',
                'selector' => '{{WRAPPER}} .lc-contact-form-7 input[type="text"],
                               {{WRAPPER}} .lc-contact-form-7 input[type="email"],
                               {{WRAPPER}} .lc-contact-form-7 input[type="tel"],
                               {{WRAPPER}} .lc-contact-form-7 input[type="url"],
                               {{WRAPPER}} .lc-contact-form-7 input[type="number"],
                               {{WRAPPER}} .lc-contact-form-7 input[type="date"],
                               {{WRAPPER}} .lc-contact-form-7 textarea,
                               {{WRAPPER}} .lc-contact-form-7 select',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'input_border',
                'selector' => '{{WRAPPER}} .lc-contact-form-7 input[type="text"],
                               {{WRAPPER}} .lc-contact-form-7 input[type="email"],
                               {{WRAPPER}} .lc-contact-form-7 input[type="tel"],
                               {{WRAPPER}} .lc-contact-form-7 input[type="url"],
                               {{WRAPPER}} .lc-contact-form-7 input[type="number"],
                               {{WRAPPER}} .lc-contact-form-7 input[type="date"],
                               {{WRAPPER}} .lc-contact-form-7 textarea,
                               {{WRAPPER}} .lc-contact-form-7 select',
            ]
        );

        $this->add_control(
            'input_border_radius',
            [
                'label' => esc_html__('Border Radius', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lc-contact-form-7 input[type="text"],
                     {{WRAPPER}} .lc-contact-form-7 input[type="email"],
                     {{WRAPPER}} .lc-contact-form-7 input[type="tel"],
                     {{WRAPPER}} .lc-contact-form-7 input[type="url"],
                     {{WRAPPER}} .lc-contact-form-7 input[type="number"],
                     {{WRAPPER}} .lc-contact-form-7 input[type="date"],
                     {{WRAPPER}} .lc-contact-form-7 textarea,
                     {{WRAPPER}} .lc-contact-form-7 select' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'input_padding',
            [
                'label' => esc_html__('Padding', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lc-contact-form-7 input[type="text"],
                     {{WRAPPER}} .lc-contact-form-7 input[type="email"],
                     {{WRAPPER}} .lc-contact-form-7 input[type="tel"],
                     {{WRAPPER}} .lc-contact-form-7 input[type="url"],
                     {{WRAPPER}} .lc-contact-form-7 input[type="number"],
                     {{WRAPPER}} .lc-contact-form-7 input[type="date"],
                     {{WRAPPER}} .lc-contact-form-7 textarea,
                     {{WRAPPER}} .lc-contact-form-7 select' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'input_margin',
            [
                'label' => esc_html__('Margin', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lc-contact-form-7 .wpcf7-form-control-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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

        $this->add_control(
            'button_background_color',
            [
                'label' => esc_html__('Background Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lc-contact-form-7 input[type="submit"],
                     {{WRAPPER}} .lc-contact-form-7 button[type="submit"]' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_color',
            [
                'label' => esc_html__('Text Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lc-contact-form-7 input[type="submit"],
                     {{WRAPPER}} .lc-contact-form-7 button[type="submit"]' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'button_typography',
                'selector' => '{{WRAPPER}} .lc-contact-form-7 input[type="submit"],
                               {{WRAPPER}} .lc-contact-form-7 button[type="submit"]',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'button_border',
                'selector' => '{{WRAPPER}} .lc-contact-form-7 input[type="submit"],
                               {{WRAPPER}} .lc-contact-form-7 button[type="submit"]',
            ]
        );

        $this->add_control(
            'button_border_radius',
            [
                'label' => esc_html__('Border Radius', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lc-contact-form-7 input[type="submit"],
                     {{WRAPPER}} .lc-contact-form-7 button[type="submit"]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_padding',
            [
                'label' => esc_html__('Padding', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lc-contact-form-7 input[type="submit"],
                     {{WRAPPER}} .lc-contact-form-7 button[type="submit"]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    private function get_contact_form_7_forms() {
        $forms = [];
        
        if (class_exists('WPCF7_ContactForm')) {
            $cf7_forms = get_posts([
                'post_type' => 'wpcf7_contact_form',
                'numberposts' => -1,
            ]);
            
            foreach ($cf7_forms as $form) {
                $forms[$form->ID] = $form->post_title;
            }
        }
        
        if (empty($forms)) {
            $forms[''] = esc_html__('No forms found', 'lc-addons-kit-for-elementor');
        }
        
        return $forms;
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        if (empty($settings['form_id'])) {
            echo '<div class="lc-contact-form-7-error">' . esc_html__('Please select a Contact Form 7 form.', 'lc-addons-kit-for-elementor') . '</div>';
            return;
        }

        $this->add_render_attribute('wrapper', 'class', 'lc-contact-form-7');

        echo '<div ' . $this->get_render_attribute_string('wrapper') . '>';

        if ($settings['show_form_title'] === 'yes' && !empty($settings['form_title'])) {
            echo '<h3 class="lc-contact-form-7-title">' . esc_html($settings['form_title']) . '</h3>';
        }

        if ($settings['show_form_description'] === 'yes' && !empty($settings['form_description'])) {
            echo '<div class="lc-contact-form-7-description">' . esc_html($settings['form_description']) . '</div>';
        }

        if (function_exists('wpcf7_contact_form')) {
            echo do_shortcode('[contact-form-7 id="' . esc_attr($settings['form_id']) . '"]');
        } else {
            echo '<div class="lc-contact-form-7-error">' . esc_html__('Contact Form 7 plugin is not installed or activated.', 'lc-addons-kit-for-elementor') . '</div>';
        }

        echo '</div>';
    }

    protected function content_template() {
        ?>
        <div class="lc-contact-form-7">
            <# if (settings.show_form_title === 'yes' && settings.form_title) { #>
                <h3 class="lc-contact-form-7-title">{{{ settings.form_title }}}</h3>
            <# } #>
            
            <# if (settings.show_form_description === 'yes' && settings.form_description) { #>
                <div class="lc-contact-form-7-description">{{{ settings.form_description }}}</div>
            <# } #>
            
            <# if (settings.form_id) { #>
                <div class="lc-contact-form-7-form">
                    [contact-form-7 id="{{ settings.form_id }}"]
                </div>
            <# } else { #>
                <div class="lc-contact-form-7-error">
                    <?php echo esc_html__('Please select a Contact Form 7 form.', 'lc-addons-kit-for-elementor'); ?>
                </div>
            <# } #>
        </div>
        <?php
    }
} 