<?php
/**
 * Twitter / X Feed Widget
 *
 * @package LC_Elementor_Addons_Kit
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * X (Twitter) Feed Widget.
 *
 * Elementor widget that displays a X (Twitter) Feed.
 */
class LCAKE_Kit_Twitter_Feed extends \Elementor\Widget_Base {

	public function get_name() {
		return 'lcake-kit-twitter-feed';
	}

	public function get_categories() {
		return array( 'lcake-page-kit' );
	}

	public function get_title() {
		return esc_html__( 'X (Twitter) Feed', 'lc-addons-kit-for-elementor' );
	}

	public function get_icon() {
		return 'eicon-x-twitter lcake-mveous-badge';
	}

	public function get_style_depends() {
		return array( 'lcake-kit-twitter-feed-css' );
	}

	public function get_script_depends() {
		return array( 'lcake-kit-twitter-feed-js' );
	}

	protected function register_controls() {
		$this->start_controls_section(
			'content_section',
			array(
				'label' => esc_html__( 'Content', 'lc-addons-kit-for-elementor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'username',
			array(
				'label'       => esc_html__( 'X (Twitter) Username', 'lc-addons-kit-for-elementor' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => 'WordPress',
				'placeholder' => 'username (without @)',
			)
		);

		$this->add_control(
			'tweet_limit',
			array(
				'label'   => esc_html__( 'Tweet Limit', 'lc-addons-kit-for-elementor' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'default' => 5,
				'min'     => 1,
				'max'     => 20,
			)
		);

		$this->add_control(
			'theme',
			array(
				'label'   => esc_html__( 'Theme', 'lc-addons-kit-for-elementor' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'light',
				'options' => array(
					'light' => esc_html__( 'Light', 'lc-addons-kit-for-elementor' ),
					'dark'  => esc_html__( 'Dark', 'lc-addons-kit-for-elementor' ),
				),
			)
		);

		$this->add_responsive_control(
			'height',
			array(
				'label'     => esc_html__( 'Height', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min' => 200,
						'max' => 1200,
					),
				),
				'default'   => array(
					'size' => 500,
					'unit' => 'px',
				),
				'selectors' => array( '{{WRAPPER}} .lcake-twitter-feed' => 'height: {{SIZE}}{{UNIT}};' ),
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$username = sanitize_text_field( ltrim( $settings['username'] ?? '', '@' ) );

		if ( empty( $username ) ) {
			return;
		}
		?>
		<div class="lcake-twitter-feed">
			<a class="twitter-timeline"
				data-height="<?php echo esc_attr( $settings['height']['size'] ?? 500 ); ?>"
				data-tweet-limit="<?php echo esc_attr( $settings['tweet_limit'] ); ?>"
				data-theme="<?php echo esc_attr( $settings['theme'] ); ?>"
				href="<?php echo esc_url( 'https://x.com/' . $username ); ?>">
				<?php
				/* translators: %s: x username */
				echo esc_html( sprintf( __( 'Tweets by %s', 'lc-addons-kit-for-elementor' ), '@' . $username ) );
				?>
			</a>
		</div>
		<?php
	}
}
