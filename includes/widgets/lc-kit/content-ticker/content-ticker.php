<?php
/**
 * Content Ticker Widget
 *
 * @package LC_Elementor_Addons_Kit
 */

if (!defined('ABSPATH')) {
    exit;
}

class LCAKE_Kit_Content_Ticker extends \Elementor\Widget_Base {

    public function get_name() {
        return 'lcake-kit-content-ticker';
    }

    public function get_categories() {
        return ['lcake-page-kit'];
    }

    public function get_title() {
        return esc_html__('LC Content Ticker', 'lc-addons-kit-for-elementor');
    }

    public function get_icon() {
        return 'eicon-post-list';
    }

    public function get_style_depends() {
        return ['lcake-kit-content-ticker-css'];
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
            'label_text',
            [
                'label' => esc_html__('Label', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Latest', 'lc-addons-kit-for-elementor'),
            ]
        );

        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
            'ticker_text',
            [
                'label' => esc_html__('Text', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Announcement text goes here', 'lc-addons-kit-for-elementor'),
                'label_block' => true,
            ]
        );
        $repeater->add_control(
            'ticker_link',
            [
                'label' => esc_html__('Link', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::URL,
                'default' => ['url' => ''],
            ]
        );

        $this->add_control(
            'ticker_items',
            [
                'label' => esc_html__('Items', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    ['ticker_text' => esc_html__('Welcome to our new website!', 'lc-addons-kit-for-elementor')],
                    ['ticker_text' => esc_html__('Summer sale is now live.', 'lc-addons-kit-for-elementor')],
                    ['ticker_text' => esc_html__('New features shipped this week.', 'lc-addons-kit-for-elementor')],
                ],
                'title_field' => '{{{ ticker_text }}}',
            ]
        );

        $this->add_control(
            'speed',
            [
                'label' => esc_html__('Speed (seconds)', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 20,
                'min' => 5,
                'max' => 120,
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
            'ticker_background',
            [
                'label' => esc_html__('Background Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#111827',
                'selectors' => ['{{WRAPPER}} .lcake-content-ticker' => 'background-color: {{VALUE}};'],
            ]
        );

        $this->add_control(
            'label_color',
            [
                'label' => esc_html__('Label Background', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#3b82f6',
                'selectors' => ['{{WRAPPER}} .lcake-content-ticker-label' => 'background-color: {{VALUE}};'],
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label' => esc_html__('Text Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => ['{{WRAPPER}} .lcake-content-ticker-track a' => 'color: {{VALUE}};'],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $items = $settings['ticker_items'] ?? [];

        if (empty($items)) {
            return;
        }
        $speed = !empty($settings['speed']) ? (int) $settings['speed'] : 20;
        ?>
        <div class="lcake-content-ticker">
            <?php if (!empty($settings['label_text'])) : ?>
                <span class="lcake-content-ticker-label"><?php echo esc_html($settings['label_text']); ?></span>
            <?php endif; ?>
            <div class="lcake-content-ticker-viewport">
                <div class="lcake-content-ticker-track" style="animation-duration: <?php echo esc_attr($speed); ?>s;">
                    <?php foreach ([0, 1] as $repeat) : ?>
                        <?php foreach ($items as $item) :
                            $link = $item['ticker_link'] ?? [];
                            $has_link = !empty($link['url']);
                            ?>
                            <span class="lcake-content-ticker-item" aria-hidden="<?php echo 1 === $repeat ? 'true' : 'false'; ?>">
                                <?php if ($has_link) : ?>
                                    <a href="<?php echo esc_url($link['url']); ?>"><?php echo esc_html($item['ticker_text']); ?></a>
                                <?php else : ?>
                                    <?php echo esc_html($item['ticker_text']); ?>
                                <?php endif; ?>
                            </span>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <?php
    }
}
