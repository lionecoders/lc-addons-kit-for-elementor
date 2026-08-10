<?php
/**
 * Contact Info Widget
 *
 * @package LC_Elementor_Addons_Kit
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class LC_Header_Footer_Contact_Info extends \Elementor\Widget_Base {

	public function get_name() {
		return 'lc-header-footer-contact-info';
	}

	public function get_title() {
		return esc_html__( 'Contact Info', 'lc-addons-kit-for-elementor' );
	}

	public function get_icon() {
		return 'eicon-call-to-action';
	}

	public function get_categories() {
		return array( 'lc-header-footer-kit' );
	}

	public function get_style_depends() {
		return array( 'lc-header-footer-contact-info-css' );
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
			'icon',
			array(
				'label'   => esc_html__( 'Icon', 'lc-addons-kit-for-elementor' ),
				'type'    => \Elementor\Controls_Manager::ICONS,
				'default' => array(
					'value'   => 'fas fa-phone',
					'library' => 'fa-solid',
				),
			)
		);

		$repeater->add_control(
			'text',
			array(
				'label'       => esc_html__( 'Text', 'lc-addons-kit-for-elementor' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( '+1 234 567 890', 'lc-addons-kit-for-elementor' ),
				'label_block' => true,
			)
		);

		$repeater->add_control(
			'link',
			array(
				'label'       => esc_html__( 'Link', 'lc-addons-kit-for-elementor' ),
				'type'        => \Elementor\Controls_Manager::URL,
				'default'     => array( 'url' => '' ),
				'placeholder' => 'tel:+1234567890',
			)
		);

		$this->add_control(
			'items',
			array(
				'label'       => esc_html__( 'Items', 'lc-addons-kit-for-elementor' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array(
						'icon' => array(
							'value'   => 'fas fa-phone',
							'library' => 'fa-solid',
						),
						'text' => '+1 234 567 890',
						'link' => array( 'url' => 'tel:+1234567890' ),
					),
					array(
						'icon' => array(
							'value'   => 'fas fa-envelope',
							'library' => 'fa-solid',
						),
						'text' => 'hello@example.com',
						'link' => array( 'url' => 'mailto:hello@example.com' ),
					),
					array(
						'icon' => array(
							'value'   => 'fas fa-map-marker-alt',
							'library' => 'fa-solid',
						),
						'text' => '123 Main Street, City',
					),
				),
				'title_field' => '{{{ text }}}',
			)
		);

		$this->add_control(
			'layout',
			array(
				'label'        => esc_html__( 'Layout', 'lc-addons-kit-for-elementor' ),
				'type'         => \Elementor\Controls_Manager::SELECT,
				'default'      => 'horizontal',
				'options'      => array(
					'horizontal' => esc_html__( 'Horizontal', 'lc-addons-kit-for-elementor' ),
					'vertical'   => esc_html__( 'Vertical', 'lc-addons-kit-for-elementor' ),
				),
				'prefix_class' => 'lc-hf-contact-info--',
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
			'icon_color',
			array(
				'label'     => esc_html__( 'Icon Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#3b82f6',
				'selectors' => array(
					'{{WRAPPER}} .lc-hf-contact-icon i'   => 'color: {{VALUE}};',
					'{{WRAPPER}} .lc-hf-contact-icon svg' => 'fill: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'text_color',
			array(
				'label'     => esc_html__( 'Text Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#374151',
				'selectors' => array( '{{WRAPPER}} .lc-hf-contact-text' => 'color: {{VALUE}};' ),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'text_typography',
				'selector' => '{{WRAPPER}} .lc-hf-contact-text',
			)
		);

		$this->add_responsive_control(
			'item_spacing',
			array(
				'label'     => esc_html__( 'Spacing', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min' => 0,
						'max' => 60,
					),
				),
				'default'   => array(
					'size' => 24,
					'unit' => 'px',
				),
				'selectors' => array( '{{WRAPPER}} .lc-hf-contact-info' => 'gap: {{SIZE}}{{UNIT}};' ),
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$items    = $settings['items'] ?? array();

		if ( empty( $items ) ) {
			return;
		}
		?>
		<ul class="lc-hf-contact-info">
			<?php
			foreach ( $items as $item ) :
				$link = $item['link'] ?? array();
				$tag  = ! empty( $link['url'] ) ? 'a' : 'span';
				?>
				<li class="lc-hf-contact-item">
					<<?php echo $tag; ?> class="lc-hf-contact-link"
						<?php
						if ( 'a' === $tag ) :
							?>
							href="<?php echo esc_url( $link['url'] ); ?>"<?php endif; ?>>
						<span class="lc-hf-contact-icon">
							<?php \Elementor\Icons_Manager::render_icon( $item['icon'], array( 'aria-hidden' => 'true' ) ); ?>
						</span>
						<span class="lc-hf-contact-text"><?php echo esc_html( $item['text'] ); ?></span>
					</<?php echo $tag; ?>>
				</li>
			<?php endforeach; ?>
		</ul>
		<?php
	}
}
