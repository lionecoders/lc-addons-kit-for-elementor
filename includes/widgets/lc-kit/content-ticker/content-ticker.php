<?php
/**
 * Content Ticker Widget
 *
 * @package LC_Elementor_Addons_Kit
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Content Ticker Widget.
 *
 * Elementor widget that displays a Content Ticker.
 */
class LCAKE_Kit_Content_Ticker extends \Elementor\Widget_Base {

	public function get_name() {
		return 'lcake-kit-content-ticker';
	}

	public function get_categories() {
		return array( 'lcake-page-kit' );
	}

	public function get_title() {
		return esc_html__( 'Content Ticker', 'lc-addons-kit-for-elementor' );
	}

	public function get_icon() {
		return 'eicon-post-slider lcake-mveous-badge';
	}

	public function get_style_depends() {
		return array( 'lcake-kit-content-ticker-css' );
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
			'label_text',
			array(
				'label'   => esc_html__( 'Label', 'lc-addons-kit-for-elementor' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Latest', 'lc-addons-kit-for-elementor' ),
			)
		);

		$repeater = new \Elementor\Repeater();
		$repeater->add_control(
			'ticker_text',
			array(
				'label'       => esc_html__( 'Text', 'lc-addons-kit-for-elementor' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'Announcement text goes here', 'lc-addons-kit-for-elementor' ),
				'label_block' => true,
			)
		);
		$repeater->add_control(
			'ticker_link',
			array(
				'label'   => esc_html__( 'Link', 'lc-addons-kit-for-elementor' ),
				'type'    => \Elementor\Controls_Manager::URL,
				'default' => array( 'url' => '' ),
			)
		);

		$this->add_control(
			'ticker_items',
			array(
				'label'       => esc_html__( 'Items', 'lc-addons-kit-for-elementor' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array( 'ticker_text' => esc_html__( 'Welcome to our new website!', 'lc-addons-kit-for-elementor' ) ),
					array( 'ticker_text' => esc_html__( 'Summer sale is now live.', 'lc-addons-kit-for-elementor' ) ),
					array( 'ticker_text' => esc_html__( 'New features shipped this week.', 'lc-addons-kit-for-elementor' ) ),
				),
				'title_field' => '{{{ ticker_text }}}',
			)
		);

		$this->add_control(
			'speed',
			array(
				'label'   => esc_html__( 'Speed (seconds)', 'lc-addons-kit-for-elementor' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'default' => 20,
				'min'     => 5,
				'max'     => 120,
			)
		);

		$this->add_control(
			'pause_on_hover',
			array(
				'label'     => esc_html__( 'Pause on Hover', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'selectors' => array(
					'{{WRAPPER}} .lcake-content-ticker:hover .lcake-content-ticker-track' => 'animation-play-state: paused;',
				),
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

		// Container Style Group
		$this->add_control(
			'container_style_heading',
			array(
				'label' => esc_html__( 'Ticker Container', 'lc-addons-kit-for-elementor' ),
				'type'  => \Elementor\Controls_Manager::HEADING,
			)
		);

		$this->add_control(
			'ticker_background',
			array(
				'label'     => esc_html__( 'Background Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#111827',
				'selectors' => array( '{{WRAPPER}} .lcake-content-ticker' => 'background-color: {{VALUE}};' ),
			)
		);

		$this->add_responsive_control(
			'container_padding',
			array(
				'label'      => esc_html__( 'Padding', 'lc-addons-kit-for-elementor' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array( '{{WRAPPER}} .lcake-content-ticker' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ),
			)
		);

		$this->add_responsive_control(
			'container_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'lc-addons-kit-for-elementor' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array( '{{WRAPPER}} .lcake-content-ticker' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			array(
				'name'     => 'container_border',
				'selector' => '{{WRAPPER}} .lcake-content-ticker',
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'container_box_shadow',
				'selector' => '{{WRAPPER}} .lcake-content-ticker',
			)
		);

		// Label Style Group
		$this->add_control(
			'label_style_heading',
			array(
				'label'     => esc_html__( 'Label Badge Style', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'label_bg_color',
			array(
				'label'     => esc_html__( 'Background Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#3b82f6',
				'selectors' => array( '{{WRAPPER}} .lcake-content-ticker-label' => 'background-color: {{VALUE}};' ),
			)
		);

		$this->add_control(
			'label_text_color',
			array(
				'label'     => esc_html__( 'Text Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array( '{{WRAPPER}} .lcake-content-ticker-label' => 'color: {{VALUE}};' ),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'label_typography',
				'selector' => '{{WRAPPER}} .lcake-content-ticker-label',
			)
		);

		$this->add_responsive_control(
			'label_padding',
			array(
				'label'      => esc_html__( 'Padding', 'lc-addons-kit-for-elementor' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array( '{{WRAPPER}} .lcake-content-ticker-label' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ),
			)
		);

		$this->add_responsive_control(
			'label_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'lc-addons-kit-for-elementor' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array( '{{WRAPPER}} .lcake-content-ticker-label' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ),
			)
		);

		// Content Text Style Group
		$this->add_control(
			'text_style_heading',
			array(
				'label'     => esc_html__( 'Ticker Text Style', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->start_controls_tabs( 'tabs_ticker_text_style' );

		$this->start_controls_tab(
			'tab_ticker_text_normal',
			array(
				'label' => esc_html__( 'Normal', 'lc-addons-kit-for-elementor' ),
			)
		);

		$this->add_control(
			'text_color',
			array(
				'label'     => esc_html__( 'Text Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} .lcake-content-ticker-item' => 'color: {{VALUE}};',
					'{{WRAPPER}} .lcake-content-ticker-item a' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_ticker_text_hover',
			array(
				'label' => esc_html__( 'Hover', 'lc-addons-kit-for-elementor' ),
			)
		);

		$this->add_control(
			'text_color_hover',
			array(
				'label'     => esc_html__( 'Text Color (Hover)', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#3b82f6',
				'selectors' => array(
					'{{WRAPPER}} .lcake-content-ticker-item a:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}} .lcake-content-ticker-item:hover' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'text_typography',
				'selector' => '{{WRAPPER}} .lcake-content-ticker-item',
			)
		);

		$this->add_control(
			'item_spacing',
			array(
				'label'     => esc_html__( 'Gap Between Items', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min' => 10,
						'max' => 150,
					),
				),
				'default'   => array(
					'unit' => 'px',
					'size' => 40,
				),
				'selectors' => array(
					'{{WRAPPER}} .lcake-content-ticker-item' => 'padding-right: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$items    = $settings['ticker_items'] ?? array();

		if ( empty( $items ) ) {
			return;
		}
		$speed = ! empty( $settings['speed'] ) ? (int) $settings['speed'] : 20;
		?>
		<div class="lcake-content-ticker">
			<?php if ( ! empty( $settings['label_text'] ) ) : ?>
				<span class="lcake-content-ticker-label"><?php echo esc_html( $settings['label_text'] ); ?></span>
			<?php endif; ?>
			<div class="lcake-content-ticker-viewport">
				<div class="lcake-content-ticker-track" style="animation-duration: <?php echo esc_attr( $speed ); ?>s;">
					<?php foreach ( array( 0, 1 ) as $repeat ) : ?>
						<?php
						foreach ( $items as $item ) :
							$link     = $item['ticker_link'] ?? array();
							$has_link = ! empty( $link['url'] );
							?>
							<span class="lcake-content-ticker-item" aria-hidden="<?php echo 1 === $repeat ? 'true' : 'false'; ?>">
								<?php if ( $has_link ) : ?>
									<a href="<?php echo esc_url( $link['url'] ); ?>"><?php echo esc_html( $item['ticker_text'] ); ?></a>
								<?php else : ?>
									<?php echo esc_html( $item['ticker_text'] ); ?>
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
