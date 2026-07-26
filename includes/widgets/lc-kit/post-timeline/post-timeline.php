<?php
/**
 * Post Timeline Widget
 *
 * @package LC_Elementor_Addons_Kit
 */

if (!defined('ABSPATH')) {
    exit;
}

class LCAKE_Kit_Post_Timeline extends \Elementor\Widget_Base {

    public function get_name() {
        return 'lcake-kit-post-timeline';
    }

    public function get_categories() {
        return ['lcake-page-kit'];
    }

    public function get_title() {
        return esc_html__('LC Post Timeline', 'lc-addons-kit-for-elementor');
    }

    public function get_icon() {
        return 'eicon-time-line';
    }

    public function get_style_depends() {
        return ['lcake-kit-post-timeline-css'];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Content', 'lc-addons-kit-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'icon',
            [
                'label' => esc_html__('Icon', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => ['value' => 'fas fa-flag', 'library' => 'fa-solid'],
            ]
        );

        $repeater->add_control(
            'date',
            [
                'label' => esc_html__('Date', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Jan 2024', 'lc-addons-kit-for-elementor'),
            ]
        );

        $repeater->add_control(
            'title',
            [
                'label' => esc_html__('Title', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Milestone Title', 'lc-addons-kit-for-elementor'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'description',
            [
                'label' => esc_html__('Description', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'lc-addons-kit-for-elementor'),
            ]
        );

        $this->add_control(
            'timeline_items',
            [
                'label' => esc_html__('Timeline Items', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    ['date' => 'Jan 2023', 'title' => esc_html__('Company Founded', 'lc-addons-kit-for-elementor')],
                    ['date' => 'Jun 2023', 'title' => esc_html__('First Product Launch', 'lc-addons-kit-for-elementor')],
                    ['date' => 'Dec 2023', 'title' => esc_html__('1000 Customers', 'lc-addons-kit-for-elementor')],
                ],
                'title_field' => '{{{ title }}}',
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
            'line_color',
            [
                'label' => esc_html__('Line Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#e5e7eb',
                'selectors' => ['{{WRAPPER}} .lcake-post-timeline' => '--lcake-timeline-line: {{VALUE}};'],
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label' => esc_html__('Icon Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#3b82f6',
                'selectors' => [
                    '{{WRAPPER}} .lcake-post-timeline-icon' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__('Title Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#111827',
                'selectors' => ['{{WRAPPER}} .lcake-post-timeline-title' => 'color: {{VALUE}};'],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $items = $settings['timeline_items'] ?? [];

        if (empty($items)) {
            return;
        }
        ?>
        <div class="lcake-post-timeline">
            <?php foreach ($items as $item) : ?>
                <div class="lcake-post-timeline-item">
                    <div class="lcake-post-timeline-icon">
                        <?php \Elementor\Icons_Manager::render_icon($item['icon'], ['aria-hidden' => 'true']); ?>
                    </div>
                    <div class="lcake-post-timeline-content">
                        <?php if (!empty($item['date'])) : ?>
                            <span class="lcake-post-timeline-date"><?php echo esc_html($item['date']); ?></span>
                        <?php endif; ?>
                        <?php if (!empty($item['title'])) : ?>
                            <h4 class="lcake-post-timeline-title"><?php echo esc_html($item['title']); ?></h4>
                        <?php endif; ?>
                        <?php if (!empty($item['description'])) : ?>
                            <p class="lcake-post-timeline-description"><?php echo wp_kses_post($item['description']); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <?php
    }
}
