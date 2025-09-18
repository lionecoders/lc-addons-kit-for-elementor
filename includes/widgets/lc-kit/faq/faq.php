<?php
/**
 * FAQ Widget
 * 
 * @package LC_Elementor_Addons_Kit
 */

if (!defined('ABSPATH')) {
    exit;
}

class LC_Kit_FAQ extends \Elementor\Widget_Base {

    public function get_name() {
        return 'lc-kit-faq';
    }

    public function get_title() {
        return esc_html__('FAQ', 'lc-addons-kit-for-elementor');
    }

    public function get_icon() {
        return 'eicon-help-o';
    }

    public function get_categories() {
        return ['lc-page-kit'];
    }

    public function get_keywords() {
        return ['faq', 'questions', 'answers', 'accordion', 'help'];
    }

    protected function register_controls() {
        $this->add_content_controls();
        $this->add_style_controls();
    }

    protected function add_content_controls() {
    $this->start_controls_section(
        'lc_faq_content_section',
        [
            'label' => esc_html__('FAQ', 'lc-addons-kit-for-elementor'),
            'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ]
    );

    $repeater = new \Elementor\Repeater();

    $repeater->add_control(
        'title',
        [
            'label' => esc_html__('Title', 'lc-addons-kit-for-elementor'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => esc_html__('Accordion Title', 'lc-addons-kit-for-elementor'),
            'label_block' => true,
        ]
    );

    $repeater->add_control(
        'content',
        [
            'label' => esc_html__('Content', 'lc-addons-kit-for-elementor'),
            'type' => \Elementor\Controls_Manager::WYSIWYG,
            'default' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'lc-addons-kit-for-elementor'),
            'show_label' => false,
        ]
    );

    // Removed the icon and active icon controls
    /*
    $repeater->add_control(
        'icon',
        [
            'label' => esc_html__('Icon', 'lc-addons-kit-for-elementor'),
            'type' => \Elementor\Controls_Manager::ICONS,
            'default' => [
                'value' => 'fas fa-plus',
                'library' => 'fa-solid',
            ],
        ]
    );

    $repeater->add_control(
        'active_icon',
        [
            'label' => esc_html__('Active Icon', 'lc-addons-kit-for-elementor'),
            'type' => \Elementor\Controls_Manager::ICONS,
            'default' => [
                'value' => 'fas fa-minus',
                'library' => 'fa-solid',
            ],
        ]
    );
    */

    $this->add_control(
        'lc_faq_content_items',
        [
            'label' => esc_html__('Tab Content', 'lc-addons-kit-for-elementor'),
            'type' => \Elementor\Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),
            'default' => [
                [
                    'title' => esc_html__('Can I build a professional website without knowing how to code?', 'lc-addons-kit-for-elementor'),
                    'content' => esc_html__('Yes! With Elementor and WordPress, you can easily design stunning websites using drag-and-drop tools—no coding needed', 'lc-addons-kit-for-elementor'),
                ],
                [
                    'title' => esc_html__('What’s the difference between WordPress and Elementor?', 'lc-addons-kit-for-elementor'),
                    'content' => esc_html__('WordPress is a website platform, while Elementor is a page builder plugin that lets you customize your site visually. Learn how they work together here.', 'lc-addons-kit-for-elementor'),
                ],
                [
                    'title' => esc_html__('Is Elementor good for beginners?', 'lc-addons-kit-for-elementor'),
                    'content' => esc_html__('Absolutely! Elementor is designed for users of all skill levels. Start learning new design skills right from this platform.', 'lc-addons-kit-for-elementor'),
                ],
                [
                    'title' => esc_html__('How can I improve my website design using Elementor?', 'lc-addons-kit-for-elementor'),
                    'content' => esc_html__('From animations to responsive layouts, Elementor offers powerful tools. Explore tips and tutorials here to keep learning new things', 'lc-addons-kit-for-elementor'),
                ],
            ],
            'title_field' => '{{{ title }}}',
        ]
    );

        $this->add_control(
            'lc_faq_active_item',
            [
                'label' => esc_html__('Active Item', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 10,
                'default' => 1,
                'description' => esc_html__('Enter the number of the item that should be open by default. Leave empty to have all items closed.', 'lc-addons-kit-for-elementor'),
            ]
        );

        $this->add_control(
            'lc_faq_active_multiple',
            [
                'label' => esc_html__('Multiple Items Open', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'lc-addons-kit-for-elementor'),
                'label_off' => esc_html__('No', 'lc-addons-kit-for-elementor'),
                'return_value' => 'yes',
                'default' => '',
            ]
        );

        $this->end_controls_section();
    }

    protected function add_style_controls() {
        $this->start_controls_section(
            'lc_style_section',
            [
                'label' => esc_html__('Style', 'lc-addons-kit-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'lc_style_border_width',
            [
                'label' => esc_html__('Border Width', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 10,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'size' => 1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .lc-faq-item' => 'border-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'lc_style_border_color',
            [
                'label' => esc_html__('Border Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lc-faq-item' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'lc_style_border_radius',
            [
                'label' => esc_html__('Border Radius', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lc-faq-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'lc_style_item_spacing',
            [
                'label' => esc_html__('Item Spacing', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'size' => 10,
                ],
                'selectors' => [
                    '{{WRAPPER}} .lc-faq-item:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Question Style
        $this->start_controls_section(
            'lc_question_style_section',
            [
                'label' => esc_html__('Question', 'lc-addons-kit-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'question_typography',
                'selector' => '{{WRAPPER}} .lc-faq-question',
            ]
        );

        $this->start_controls_tabs('question_tabs');

        $this->start_controls_tab(
            'lc_question_normal_tab',
            [
                'label' => esc_html__('Normal', 'lc-addons-kit-for-elementor'),
            ]
        );

        $this->add_control(
            'lc_question_background_color',
            [
                'label' => esc_html__('Background Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lc-faq-question' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'lc_question_color',
            [
                'label' => esc_html__('Text Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lc-faq-question' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'lc_question_hover_tab',
            [
                'label' => esc_html__('Hover', 'lc-addons-kit-for-elementor'),
            ]
        );

        $this->add_control(
            'lc_question_background_color_hover',
            [
                'label' => esc_html__('Background Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lc-faq-question:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'lc_question_color_hover',
            [
                'label' => esc_html__('Text Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lc-faq-question:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'question_active_tab',
            [
                'label' => esc_html__('Active', 'lc-addons-kit-for-elementor'),
            ]
        );

        $this->add_control(
            'lc_question_background_color_active',
            [
                'label' => esc_html__('Background Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lc-faq-item.active .lc-faq-question' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'lc_question_color_active',
            [
                'label' => esc_html__('Text Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lc-faq-item.active .lc-faq-question' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'lc_question_padding',
            [
                'label' => esc_html__('Padding', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lc-faq-question' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'before',
            ]
        );

        $this->end_controls_section();

        // Answer Style
        $this->start_controls_section(
            'lc_answer_style_section',
            [
                'label' => esc_html__('Answer', 'lc-addons-kit-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'lc_answer_background_color',
            [
                'label' => esc_html__('Background Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lc-faq-answer' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'lc_answer_color',
            [
                'label' => esc_html__('Text Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lc-faq-answer-content' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'answer_typography',
                'selector' => '{{WRAPPER}} .lc-faq-answer-content',
            ]
        );

        $this->add_responsive_control(
            'lc_answer_padding',
            [
                'label' => esc_html__('Padding', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                 '{{WRAPPER}} .lc-faq-item.active .lc-faq-answer' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        if (empty($settings['lc_faq_content_items']) || !is_array($settings['lc_faq_content_items'])) {
            return;
        }

        $multiple = (!empty($settings['lc_faq_active_multiple']) && $settings['lc_faq_active_multiple'] === 'yes');

        $active_index = null;
        if (!$multiple && !empty($settings['lc_faq_active_item'])) {
            $i = intval($settings['lc_faq_active_item']) - 1;
            if ($i >= 0 && $i < count($settings['lc_faq_content_items'])) {
                $active_index = $i;
            }
        }

        $this->add_render_attribute('wrapper', 'class', 'lc-faq');
        $this->add_render_attribute('wrapper', 'data-multiple', $multiple ? 'true' : 'false');

        echo '<div ' . $this->get_render_attribute_string('wrapper') . '>';

        foreach ($settings['lc_faq_content_items'] as $index => $item) {
            $is_active = ($active_index !== null && $index === $active_index);
            $item_classes = 'lc-faq-item' . ($is_active ? ' active' : '');

            $question_id = 'lc-faq-q-' . esc_attr($this->get_id()) . '-' . $index;
            $answer_id   = 'lc-faq-a-' . esc_attr($this->get_id()) . '-' . $index;

            echo '<div class="' . esc_attr($item_classes) . '">';
            echo '<div class="lc-faq-question" role="button" tabindex="0" aria-expanded="' . ($is_active ? 'true' : 'false') . '" aria-controls="' . esc_attr($answer_id) . '" id="' . esc_attr($question_id) . '">';

            echo '<span class="lc-faq-question-text">' . esc_html($item['title']) . '</span>';

            echo '</div>'; // .lc-faq-question

            echo '<div class="lc-faq-answer" id="' . esc_attr($answer_id) . '" role="region" aria-labelledby="' . esc_attr($question_id) . '">';
            echo '<div class="lc-faq-answer-content">' . wp_kses_post($item['content']) . '</div>';
            echo '</div>';

            echo '</div>'; // .lc-faq-item
        }

        echo '</div>'; // .lc-faq
    }

}