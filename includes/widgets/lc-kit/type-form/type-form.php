<?php
/**
 * Typeform Embed Widget
 *
 * @package LC_Elementor_Addons_Kit
 */

if (!defined('ABSPATH')) {
    exit;
}

class LCAKE_Kit_Type_Form extends \Elementor\Widget_Base {

    public function get_name() {
        return 'lcake-kit-type-form';
    }

    public function get_categories() {
        return ['lcake-page-kit'];
    }

    public function get_title() {
        return esc_html__('Typeform', 'lc-addons-kit-for-elementor');
    }

    public function get_icon() {
        return 'eicon-form-horizontal';
    }

    public function get_style_depends() {
        return ['lcake-kit-type-form-css'];
    }

    public function get_script_depends() {
        return ['lcake-kit-type-form-js'];
    }

    public function get_required_dependencies() {
        return [
            [
                'type' => 'plugin',
                'path' => 'typeform/typeform.php',
                'name' => 'Typeform',
            ],
        ];
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
            'form_id',
            [
                'label' => esc_html__('Typeform ID', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'description' => esc_html__('The ID found in your Typeform share link, e.g. abc123', 'lc-addons-kit-for-elementor'),
                'placeholder' => 'abc123',
            ]
        );

        $this->add_control(
            'embed_type',
            [
                'label' => esc_html__('Embed Type', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'widget',
                'options' => [
                    'widget' => esc_html__('Inline Widget', 'lc-addons-kit-for-elementor'),
                    'popup' => esc_html__('Popup Button', 'lc-addons-kit-for-elementor'),
                ],
            ]
        );

        $this->add_control(
            'button_text',
            [
                'label' => esc_html__('Button Text', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Open Form', 'lc-addons-kit-for-elementor'),
                'condition' => ['embed_type' => 'popup'],
            ]
        );

        $this->add_responsive_control(
            'widget_height',
            [
                'label' => esc_html__('Height', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => ['px' => ['min' => 200, 'max' => 1000]],
                'default' => ['size' => 500, 'unit' => 'px'],
                'condition' => ['embed_type' => 'widget'],
                'selectors' => ['{{WRAPPER}} .lcake-typeform-widget' => 'height: {{SIZE}}{{UNIT}};'],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style',
            [
                'label' => esc_html__('Style', 'lc-addons-kit-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => ['embed_type' => 'popup'],
            ]
        );

        $this->add_control(
            'button_color',
            [
                'label' => esc_html__('Text Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => ['{{WRAPPER}} .lcake-typeform-button' => 'color: {{VALUE}};'],
            ]
        );

        $this->add_control(
            'button_background',
            [
                'label' => esc_html__('Background', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#3b82f6',
                'selectors' => ['{{WRAPPER}} .lcake-typeform-button' => 'background-color: {{VALUE}};'],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $form_id = sanitize_text_field($settings['form_id'] ?? '');

        if (empty($form_id)) {
            if (current_user_can('manage_options')) {
                echo '<p class="lcake-plugin-notice">' . esc_html__('Please enter a Typeform ID.', 'lc-addons-kit-for-elementor') . '</p>';
            }
            return;
        }

        if ('popup' === $settings['embed_type']) : ?>
            <button type="button" class="lcake-typeform-button" data-tf-popup="<?php echo esc_attr($form_id); ?>">
                <?php echo esc_html($settings['button_text']); ?>
            </button>
        <?php else : ?>
            <div class="lcake-typeform-widget" data-tf-widget="<?php echo esc_attr($form_id); ?>"></div>
        <?php endif;
    }
}
