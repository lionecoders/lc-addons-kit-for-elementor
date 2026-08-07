<?php
/**
 * Fancy Text Widget
 *
 * @package LC_Elementor_Addons_Kit
 */

if (!defined('ABSPATH')) {
    exit;
}

class LCAKE_Kit_Fancy_Text extends \Elementor\Widget_Base {

    public function get_name() {
        return 'lcake-kit-fancy-text';
    }

    public function get_categories() {
        return ['lcake-page-kit'];
    }

    public function get_title() {
        return esc_html__('Fancy Text', 'lc-addons-kit-for-elementor');
    }

    public function get_icon() {
        return 'eicon-animation-text';
    }

    public function get_style_depends() {
        return ['lcake-kit-fancy-text-css'];
    }

    public function get_script_depends() {
        return ['lcake-kit-fancy-text-js'];
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
            'before_text',
            [
                'label' => esc_html__('Before Text', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('We are', 'lc-addons-kit-for-elementor'),
                'label_block' => true,
            ]
        );

        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
            'word',
            [
                'label' => esc_html__('Word', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Creative', 'lc-addons-kit-for-elementor'),
            ]
        );

        $this->add_control(
            'words',
            [
                'label' => esc_html__('Rotating Words', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    ['word' => esc_html__('Creative', 'lc-addons-kit-for-elementor')],
                    ['word' => esc_html__('Modern', 'lc-addons-kit-for-elementor')],
                    ['word' => esc_html__('Reliable', 'lc-addons-kit-for-elementor')],
                ],
                'title_field' => '{{{ word }}}',
            ]
        );

        $this->add_control(
            'after_text',
            [
                'label' => esc_html__('After Text', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('for your business', 'lc-addons-kit-for-elementor'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'animation',
            [
                'label' => esc_html__('Animation', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'fade',
                'options' => [
                    'fade' => esc_html__('Fade', 'lc-addons-kit-for-elementor'),
                    'slide-up' => esc_html__('Slide Up', 'lc-addons-kit-for-elementor'),
                ],
                'prefix_class' => 'lcake-fancy-text--anim-',
            ]
        );

        $this->add_control(
            'interval',
            [
                'label' => esc_html__('Interval (ms)', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 2200,
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
            'text_color',
            [
                'label' => esc_html__('Text Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#111827',
                'selectors' => ['{{WRAPPER}} .lcake-fancy-text' => 'color: {{VALUE}};'],
            ]
        );

        $this->add_control(
            'highlight_color',
            [
                'label' => esc_html__('Highlight Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#3b82f6',
                'selectors' => ['{{WRAPPER}} .lcake-fancy-text-word' => 'color: {{VALUE}};'],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'typography',
                'selector' => '{{WRAPPER}} .lcake-fancy-text',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $words = wp_list_pluck($settings['words'] ?? [], 'word');
        $words = array_filter($words);

        if (empty($words)) {
            return;
        }
        ?>
        <div class="lcake-fancy-text-wrapper">
            <p class="lcake-fancy-text">
                <?php if (!empty($settings['before_text'])) : ?>
                    <span class="lcake-fancy-text-before"><?php echo esc_html($settings['before_text']); ?></span>
                <?php endif; ?>
                <span class="lcake-fancy-text-rotator" data-interval="<?php echo esc_attr($settings['interval']); ?>">
                    <?php foreach ($words as $index => $word) : ?>
                        <span class="lcake-fancy-text-word<?php echo 0 === $index ? ' is-active' : ''; ?>"><?php echo esc_html($word); ?></span>
                    <?php endforeach; ?>
                </span>
                <?php if (!empty($settings['after_text'])) : ?>
                    <span class="lcake-fancy-text-after"><?php echo esc_html($settings['after_text']); ?></span>
                <?php endif; ?>
            </p>
        </div>
        <?php
    }
}
