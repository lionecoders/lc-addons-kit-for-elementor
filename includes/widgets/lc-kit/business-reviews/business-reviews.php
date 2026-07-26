<?php
/**
 * Business Reviews Widget
 *
 * @package LC_Elementor_Addons_Kit
 */

if (!defined('ABSPATH')) {
    exit;
}

class LCAKE_Kit_Business_Reviews extends \Elementor\Widget_Base {

    public function get_name() {
        return 'lcake-kit-business-reviews';
    }

    public function get_categories() {
        return ['lcake-page-kit'];
    }

    public function get_title() {
        return esc_html__('LC Business Reviews', 'lc-addons-kit-for-elementor');
    }

    public function get_icon() {
        return 'eicon-review';
    }

    public function get_style_depends() {
        return ['lcake-kit-business-reviews-css'];
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
            'avatar',
            [
                'label' => esc_html__('Avatar', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => ['url' => \Elementor\Utils::get_placeholder_image_src()],
            ]
        );

        $repeater->add_control(
            'name',
            [
                'label' => esc_html__('Reviewer Name', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Jane Doe', 'lc-addons-kit-for-elementor'),
            ]
        );

        $repeater->add_control(
            'source',
            [
                'label' => esc_html__('Review Source', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'google',
                'options' => [
                    'google' => 'Google',
                    'facebook' => 'Facebook',
                    'trustpilot' => 'Trustpilot',
                    'yelp' => 'Yelp',
                ],
            ]
        );

        $repeater->add_control(
            'rating',
            [
                'label' => esc_html__('Rating (1-5)', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 5,
                'min' => 1,
                'max' => 5,
            ]
        );

        $repeater->add_control(
            'review_text',
            [
                'label' => esc_html__('Review Text', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => esc_html__('Excellent service, highly recommended!', 'lc-addons-kit-for-elementor'),
            ]
        );

        $this->add_control(
            'reviews',
            [
                'label' => esc_html__('Reviews', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    ['name' => 'Jane Doe', 'source' => 'google', 'rating' => 5, 'review_text' => esc_html__('Excellent service, highly recommended!', 'lc-addons-kit-for-elementor')],
                    ['name' => 'Mike Ross', 'source' => 'facebook', 'rating' => 4, 'review_text' => esc_html__('Great experience overall.', 'lc-addons-kit-for-elementor')],
                    ['name' => 'Sara Lee', 'source' => 'trustpilot', 'rating' => 5, 'review_text' => esc_html__('Will definitely use again.', 'lc-addons-kit-for-elementor')],
                ],
                'title_field' => '{{{ name }}}',
            ]
        );

        $this->add_responsive_control(
            'columns',
            [
                'label' => esc_html__('Columns', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '3',
                'options' => ['1' => '1', '2' => '2', '3' => '3'],
                'selectors' => ['{{WRAPPER}} .lcake-business-reviews' => 'grid-template-columns: repeat({{VALUE}}, 1fr);'],
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
            'star_color',
            [
                'label' => esc_html__('Star Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#facc15',
                'selectors' => ['{{WRAPPER}} .lcake-business-review-star.is-filled' => 'color: {{VALUE}};'],
            ]
        );

        $this->add_control(
            'name_color',
            [
                'label' => esc_html__('Name Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#111827',
                'selectors' => ['{{WRAPPER}} .lcake-business-review-name' => 'color: {{VALUE}};'],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $reviews = $settings['reviews'] ?? [];

        if (empty($reviews)) {
            return;
        }
        ?>
        <div class="lcake-business-reviews">
            <?php foreach ($reviews as $review) :
                $rating = max(1, min(5, (int) ($review['rating'] ?? 5)));
                ?>
                <div class="lcake-business-review-card">
                    <div class="lcake-business-review-header">
                        <?php echo LCAKE_Kit_Utils::get_attachment_image_html($review, 'avatar', 'thumbnail', ['class' => 'lcake-business-review-avatar']); ?>
                        <div>
                            <span class="lcake-business-review-name"><?php echo esc_html($review['name']); ?></span>
                            <span class="lcake-business-review-source lcake-business-review-source--<?php echo esc_attr($review['source']); ?>">
                                <?php echo esc_html(ucfirst($review['source'])); ?>
                            </span>
                        </div>
                    </div>
                    <div class="lcake-business-review-stars">
                        <?php for ($i = 1; $i <= 5; $i++) : ?>
                            <span class="lcake-business-review-star<?php echo $i <= $rating ? ' is-filled' : ''; ?>">&#9733;</span>
                        <?php endfor; ?>
                    </div>
                    <?php if (!empty($review['review_text'])) : ?>
                        <p class="lcake-business-review-text"><?php echo wp_kses_post($review['review_text']); ?></p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
        <?php
    }
}
