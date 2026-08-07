<?php
/**
 * Code Snippet Widget
 *
 * @package LC_Elementor_Addons_Kit
 */

if (!defined('ABSPATH')) {
    exit;
}

class LCAKE_Kit_Code_Snippet extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'lcake-kit-code-snippet';
    }

    public function get_categories()
    {
        return ['lcake-page-kit'];
    }

    public function get_title()
    {
        return esc_html__('Code Snippet', 'lc-addons-kit-for-elementor');
    }

    public function get_icon()
    {
        return 'eicon-code';
    }

    public function get_style_depends()
    {
        return ['lcake-kit-code-snippet-css'];
    }

    public function get_script_depends()
    {
        return ['lcake-kit-code-snippet-js'];
    }

    protected function register_controls()
    {
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Content', 'lc-addons-kit-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'language_label',
            [
                'label' => esc_html__('Language Label', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'PHP',
            ]
        );

        $this->add_control(
            'code',
            [
                'label' => esc_html__('Code', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::CODE,
                'default' => "add_action( 'init', function() {\n\t// your code here\n} );",
                'rows' => 12,
            ]
        );

        $this->add_control(
            'show_copy_button',
            [
                'label' => esc_html__('Show Copy Button', 'lc-addons-kit-for-elementor'),
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

        $this->add_control(
            'background_color',
            [
                'label' => esc_html__('Background Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#0f172a',
                'selectors' => ['{{WRAPPER}} .lcake-code-snippet' => 'background-color: {{VALUE}};'],
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label' => esc_html__('Text Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#e2e8f0',
                'selectors' => ['{{WRAPPER}} .lcake-code-snippet-code' => 'color: {{VALUE}};'],
            ]
        );

        $this->add_control(
            'font_size',
            [
                'label' => esc_html__('Font Size', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => ['px' => ['min' => 10, 'max' => 24]],
                'default' => ['size' => 14, 'unit' => 'px'],
                'selectors' => ['{{WRAPPER}} .lcake-code-snippet-code' => 'font-size: {{SIZE}}{{UNIT}};'],
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $code = $settings['code'] ?? '';

        if ('' === trim($code)) {
            return;
        }
        ?>
        <div class="lcake-code-snippet">
            <div class="lcake-code-snippet-header">
                <?php if (!empty($settings['language_label'])): ?>
                    <span class="lcake-code-snippet-lang"><?php echo esc_html($settings['language_label']); ?></span>
                <?php endif; ?>
                <?php if ('yes' === $settings['show_copy_button']): ?>
                    <button type="button" class="lcake-code-snippet-copy">
                        <?php esc_html_e('Copy', 'lc-addons-kit-for-elementor'); ?>
                    </button>
                <?php endif; ?>
            </div>
            <pre
                class="lcake-code-snippet-pre"><code class="lcake-code-snippet-code"><?php echo esc_html($code); ?></code></pre>
        </div>
        <?php
    }
}
