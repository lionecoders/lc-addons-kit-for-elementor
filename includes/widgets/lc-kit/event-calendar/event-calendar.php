<?php
/**
 * Event Calendar Widget
 *
 * @package LC_Elementor_Addons_Kit
 */

if (!defined('ABSPATH')) {
    exit;
}

class LCAKE_Kit_Event_Calendar extends \Elementor\Widget_Base {

    public function get_name() {
        return 'lcake-kit-event-calendar';
    }

    public function get_categories() {
        return ['lcake-page-kit'];
    }

    public function get_title() {
        return esc_html__('LC Event Calendar', 'lc-addons-kit-for-elementor');
    }

    public function get_icon() {
        return 'eicon-calendar';
    }

    public function get_style_depends() {
        return ['lcake-kit-event-calendar-css'];
    }

    public function get_script_depends() {
        return ['lcake-kit-event-calendar-js'];
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
            'event_date',
            [
                'label' => esc_html__('Date', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::DATE_TIME,
                'picker_options' => ['enableTime' => false],
            ]
        );

        $repeater->add_control(
            'event_title',
            [
                'label' => esc_html__('Title', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Event', 'lc-addons-kit-for-elementor'),
            ]
        );

        $repeater->add_control(
            'event_link',
            [
                'label' => esc_html__('Link', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::URL,
                'default' => ['url' => ''],
            ]
        );

        $this->add_control(
            'events',
            [
                'label' => esc_html__('Events', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'title_field' => '{{{ event_title }}} — {{{ event_date }}}',
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
            'event_color',
            [
                'label' => esc_html__('Event Marker Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#3b82f6',
                'selectors' => [
                    '{{WRAPPER}} .lcake-event-calendar-day.has-event' => 'background-color: {{VALUE}}; color: #ffffff;',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $events = [];

        foreach ($settings['events'] ?? [] as $event) {
            if (empty($event['event_date'])) {
                continue;
            }
            $events[] = [
                'date' => $event['event_date'],
                'title' => $event['event_title'],
                'link' => $event['event_link']['url'] ?? '',
            ];
        }
        ?>
        <div class="lcake-event-calendar" data-events="<?php echo esc_attr(wp_json_encode($events)); ?>">
            <div class="lcake-event-calendar-header">
                <button type="button" class="lcake-event-calendar-nav lcake-event-calendar-prev" aria-label="<?php echo esc_attr__('Previous Month', 'lc-addons-kit-for-elementor'); ?>">&#10094;</button>
                <span class="lcake-event-calendar-title"></span>
                <button type="button" class="lcake-event-calendar-nav lcake-event-calendar-next" aria-label="<?php echo esc_attr__('Next Month', 'lc-addons-kit-for-elementor'); ?>">&#10095;</button>
            </div>
            <div class="lcake-event-calendar-weekdays"></div>
            <div class="lcake-event-calendar-grid"></div>
            <ul class="lcake-event-calendar-list"></ul>
        </div>
        <?php
    }
}
