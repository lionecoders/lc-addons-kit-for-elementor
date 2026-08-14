<?php
/**
 * Business Reviews Widget
 *
 * @package LC_Elementor_Addons_Kit
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Business Reviews Widget.
 *
 * Elementor widget that displays a Business Reviews.
 */
class LCAKE_Kit_Business_Reviews extends \Elementor\Widget_Base {

	public function get_name() {
		return 'lcake-kit-business-reviews';
	}

	public function get_categories() {
		return array( 'lcake-page-kit' );
	}

	public function get_title() {
		return esc_html__( 'Business Reviews', 'lc-addons-kit-for-elementor' );
	}

	public function get_icon() {
		return 'eicon-review';
	}

	public function get_style_depends() {
		return array( 'lcake-kit-business-reviews-css' );
	}

	protected function register_controls() {
		$this->start_controls_section(
			'content_section',
			array(
				'label' => esc_html__( 'Content', 'lc-addons-kit-for-elementor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'avatar',
			array(
				'label'   => esc_html__( 'Avatar', 'lc-addons-kit-for-elementor' ),
				'type'    => \Elementor\Controls_Manager::MEDIA,
				'default' => array( 'url' => \Elementor\Utils::get_placeholder_image_src() ),
			)
		);

		$repeater->add_control(
			'name',
			array(
				'label'   => esc_html__( 'Reviewer Name', 'lc-addons-kit-for-elementor' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Jane Doe', 'lc-addons-kit-for-elementor' ),
			)
		);

		$repeater->add_control(
			'source',
			array(
				'label'   => esc_html__( 'Review Source', 'lc-addons-kit-for-elementor' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'google',
				'options' => array(
					'google'     => 'Google',
					'facebook'   => 'Facebook',
					'trustpilot' => 'Trustpilot',
					'yelp'       => 'Yelp',
				),
			)
		);

		$repeater->add_control(
			'rating',
			array(
				'label'   => esc_html__( 'Rating (1-5)', 'lc-addons-kit-for-elementor' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'default' => 5,
				'min'     => 1,
				'max'     => 5,
			)
		);

		$repeater->add_control(
			'review_text',
			array(
				'label'   => esc_html__( 'Review Text', 'lc-addons-kit-for-elementor' ),
				'type'    => \Elementor\Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Excellent service, highly recommended!', 'lc-addons-kit-for-elementor' ),
			)
		);

		$this->add_control(
			'reviews',
			array(
				'label'       => esc_html__( 'Reviews', 'lc-addons-kit-for-elementor' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array(
						'name'        => 'Jane Doe',
						'source'      => 'google',
						'rating'      => 5,
						'review_text' => esc_html__( 'Excellent service, highly recommended!', 'lc-addons-kit-for-elementor' ),
					),
					array(
						'name'        => 'Mike Ross',
						'source'      => 'facebook',
						'rating'      => 4,
						'review_text' => esc_html__( 'Great experience overall.', 'lc-addons-kit-for-elementor' ),
					),
					array(
						'name'        => 'Sara Lee',
						'source'      => 'trustpilot',
						'rating'      => 5,
						'review_text' => esc_html__( 'Will definitely use again.', 'lc-addons-kit-for-elementor' ),
					),
				),
				'title_field' => '{{{ name }}}',
			)
		);

		$this->add_responsive_control(
			'columns',
			array(
				'label'     => esc_html__( 'Columns', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'default'   => '3',
				'options'   => array(
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
					'6' => '6',
				),
				'selectors' => array( '{{WRAPPER}} .lcake-business-reviews' => 'grid-template-columns: repeat({{VALUE}}, 1fr);' ),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style',
			array(
				'label' => esc_html__( 'Style', 'lc-addons-kit-for-elementor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'card_heading',
			array(
				'label' => esc_html__( 'Card Layout', 'lc-addons-kit-for-elementor' ),
				'type'  => \Elementor\Controls_Manager::HEADING,
			)
		);

		$this->add_control(
			'card_bg_color',
			array(
				'label'     => esc_html__( 'Card Background Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array( '{{WRAPPER}} .lcake-business-review-card' => 'background-color: {{VALUE}};' ),
			)
		);

		$this->add_responsive_control(
			'card_padding',
			array(
				'label'      => esc_html__( 'Card Padding', 'lc-addons-kit-for-elementor' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array( '{{WRAPPER}} .lcake-business-review-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ),
			)
		);

		$this->add_responsive_control(
			'card_border_radius',
			array(
				'label'      => esc_html__( 'Card Border Radius', 'lc-addons-kit-for-elementor' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array( '{{WRAPPER}} .lcake-business-review-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			array(
				'name'     => 'card_border',
				'selector' => '{{WRAPPER}} .lcake-business-review-card',
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'card_box_shadow',
				'selector' => '{{WRAPPER}} .lcake-business-review-card',
			)
		);

		// Header (Avatar / Name / Source) Section
		$this->add_control(
			'header_heading',
			array(
				'label'     => esc_html__( 'Header Details', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'avatar_size',
			array(
				'label'      => esc_html__( 'Avatar Size (px)', 'lc-addons-kit-for-elementor' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min' => 20,
						'max' => 150,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 44,
				),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-business-review-avatar' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'avatar_border_radius',
			array(
				'label'      => esc_html__( 'Avatar Border Radius', 'lc-addons-kit-for-elementor' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array( '{{WRAPPER}} .lcake-business-review-avatar' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ),
			)
		);

		$this->add_control(
			'name_color',
			array(
				'label'     => esc_html__( 'Name Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#111827',
				'selectors' => array( '{{WRAPPER}} .lcake-business-review-name' => 'color: {{VALUE}};' ),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'name_typography',
				'selector' => '{{WRAPPER}} .lcake-business-review-name',
			)
		);

		$this->add_control(
			'source_color',
			array(
				'label'     => esc_html__( 'Source Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#6b7280',
				'selectors' => array( '{{WRAPPER}} .lcake-business-review-source' => 'color: {{VALUE}};' ),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'source_typography',
				'selector' => '{{WRAPPER}} .lcake-business-review-source',
			)
		);

		// Rating & Review Text Section
		$this->add_control(
			'content_style_heading',
			array(
				'label'     => esc_html__( 'Rating & Text Content', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'star_color',
			array(
				'label'     => esc_html__( 'Star Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#facc15',
				'selectors' => array( '{{WRAPPER}} .lcake-business-review-star.is-filled' => 'color: {{VALUE}};' ),
			)
		);

		$this->add_control(
			'review_text_color',
			array(
				'label'     => esc_html__( 'Review Text Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#374151',
				'selectors' => array( '{{WRAPPER}} .lcake-business-review-text' => 'color: {{VALUE}};' ),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'review_text_typography',
				'selector' => '{{WRAPPER}} .lcake-business-review-text',
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$reviews  = $settings['reviews'] ?? array();

		if ( empty( $reviews ) ) {
			return;
		}
		?>
		<div class="lcake-business-reviews">
			<?php
			foreach ( $reviews as $review ) :
				$rating = max( 1, min( 5, (int) ( $review['rating'] ?? 5 ) ) );
				?>
				<div class="lcake-business-review-card">
					<div class="lcake-business-review-header">
						<?php echo wp_kses( LCAKE_Kit_Utils::get_attachment_image_html( $review, 'avatar', 'thumbnail', array( 'class' => 'lcake-business-review-avatar' ) ), LCAKE_Kit_Utils::get_kses_array() ); ?>
						<div>
							<span class="lcake-business-review-name"><?php echo esc_html( $review['name'] ); ?></span>
							<span class="lcake-business-review-source lcake-business-review-source--<?php echo esc_attr( $review['source'] ); ?>">
								<?php echo esc_html( ucfirst( $review['source'] ) ); ?>
							</span>
						</div>
					</div>
					<div class="lcake-business-review-stars">
						<?php for ( $i = 1; $i <= 5; $i++ ) : ?>
							<span class="lcake-business-review-star<?php echo $i <= $rating ? ' is-filled' : ''; ?>">&#9733;</span>
						<?php endfor; ?>
					</div>
					<?php if ( ! empty( $review['review_text'] ) ) : ?>
						<p class="lcake-business-review-text"><?php echo wp_kses_post( $review['review_text'] ); ?></p>
					<?php endif; ?>
				</div>
			<?php endforeach; ?>
		</div>
		<?php
	}
}
