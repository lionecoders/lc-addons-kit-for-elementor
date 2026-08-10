<?php
/**
 * Image Box Widget
 *
 * @package LC_Elementor_Addons_Kit
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class LCAKE_Kit_Image_Box extends \Elementor\Widget_Base {


	public function get_name() {
		return 'lcake-kit-image-box';
	}

	public function get_style_depends() {
		return array( 'lcake-kit-image-box-css' );
	}

	public function get_title() {
		return esc_html__( 'Image Box', 'lc-addons-kit-for-elementor' );
	}

	public function get_icon() {
		return 'eicon-image-box';
	}

	public function get_categories() {
		return array( 'lcake-page-kit' );
	}

	public function get_keywords() {
		return array( 'image', 'box', 'media', 'content', 'layout' );
	}

	protected function register_controls() {
		$this->add_content_controls();
		$this->add_style_controls();
	}

	protected function add_content_controls() {
		$this->start_controls_section(
			'content_section',
			array(
				'label' => esc_html__( 'Content', 'lc-addons-kit-for-elementor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'image',
			array(
				'label'   => esc_html__( 'Image', 'lc-addons-kit-for-elementor' ),
				'type'    => \Elementor\Controls_Manager::MEDIA,
				'default' => array(
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Image_Size::get_type(),
			array(
				'name'    => 'image',
				'default' => 'large',
			)
		);

		$this->add_control(
			'title',
			array(
				'label'       => esc_html__( 'Title', 'lc-addons-kit-for-elementor' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'Image Box Title', 'lc-addons-kit-for-elementor' ),
				'label_block' => true,
			)
		);

		$this->add_control(
			'description',
			array(
				'label'     => esc_html__( 'Description', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::TEXTAREA,
				'default'   => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'lc-addons-kit-for-elementor' ),
				'rows'      => 10,
				'separator' => 'none',
			)
		);

		$this->add_control(
			'link',
			array(
				'label'       => esc_html__( 'Link', 'lc-addons-kit-for-elementor' ),
				'type'        => \Elementor\Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'lc-addons-kit-for-elementor' ),
				'separator'   => 'before',
			)
		);

		$this->add_control(
			'link_text',
			array(
				'label'     => esc_html__( 'Link Text', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::TEXT,
				'default'   => esc_html__( 'Read More', 'lc-addons-kit-for-elementor' ),
				'condition' => array(
					'link[url]!' => '',
				),
			)
		);

		$this->add_control(
			'position',
			array(
				'label'        => esc_html__( 'Image Position', 'lc-addons-kit-for-elementor' ),
				'type'         => \Elementor\Controls_Manager::CHOOSE,
				'default'      => 'top',
				'options'      => array(
					'left'  => array(
						'title' => esc_html__( 'Left', 'lc-addons-kit-for-elementor' ),
						'icon'  => 'eicon-h-align-left',
					),
					'top'   => array(
						'title' => esc_html__( 'Top', 'lc-addons-kit-for-elementor' ),
						'icon'  => 'eicon-v-align-top',
					),
					'right' => array(
						'title' => esc_html__( 'Right', 'lc-addons-kit-for-elementor' ),
						'icon'  => 'eicon-h-align-right',
					),
				),
				'prefix_class' => 'lcake-image-box--image-',
				'render_type'  => 'template',
			)
		);

		$this->add_control(
			'title_size',
			array(
				'label'   => esc_html__( 'Title HTML Tag', 'lc-addons-kit-for-elementor' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					'h1'   => 'H1',
					'h2'   => 'H2',
					'h3'   => 'H3',
					'h4'   => 'H4',
					'h5'   => 'H5',
					'h6'   => 'H6',
					'div'  => 'div',
					'span' => 'span',
					'p'    => 'p',
				),
				'default' => 'h3',
			)
		);

		$this->end_controls_section();
	}

	protected function add_style_controls() {
		$this->start_controls_section(
			'section_style_image',
			array(
				'label' => esc_html__( 'Image', 'lc-addons-kit-for-elementor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'image_space',
			array(
				'label'      => esc_html__( 'Spacing', 'lc-addons-kit-for-elementor' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}}.lcake-image-box--image-left .lcake-image-box-wrapper' => 'gap: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.lcake-image-box--image-right .lcake-image-box-wrapper' => 'gap: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.lcake-image-box--image-top .lcake-image-box-img' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'image_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'lc-addons-kit-for-elementor' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-image-box-img img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'image_opacity',
			array(
				'label'     => esc_html__( 'Opacity', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'max'  => 1,
						'min'  => 0.1,
						'step' => 0.1,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .lcake-image-box-img img' => 'opacity: {{SIZE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			array(
				'name'     => 'image_border',
				'selector' => '{{WRAPPER}} .lcake-image-box-img img',
			)
		);

		$this->add_control(
			'image_hover_animation',
			array(
				'label' => esc_html__( 'Hover Animation', 'lc-addons-kit-for-elementor' ),
				'type'  => \Elementor\Controls_Manager::HOVER_ANIMATION,
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_content',
			array(
				'label' => esc_html__( 'Content', 'lc-addons-kit-for-elementor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'text_align',
			array(
				'label'     => esc_html__( 'Alignment', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::CHOOSE,
				'options'   => array(
					'left'    => array(
						'title' => esc_html__( 'Left', 'lc-addons-kit-for-elementor' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center'  => array(
						'title' => esc_html__( 'Center', 'lc-addons-kit-for-elementor' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right'   => array(
						'title' => esc_html__( 'Right', 'lc-addons-kit-for-elementor' ),
						'icon'  => 'eicon-text-align-right',
					),
					'justify' => array(
						'title' => esc_html__( 'Justified', 'lc-addons-kit-for-elementor' ),
						'icon'  => 'eicon-text-align-justify',
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .lcake-image-box-content' => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'content_vertical_alignment',
			array(
				'label'                => esc_html__( 'Vertical Alignment', 'lc-addons-kit-for-elementor' ),
				'type'                 => \Elementor\Controls_Manager::SELECT,
				'options'              => array(
					'top'    => esc_html__( 'Top', 'lc-addons-kit-for-elementor' ),
					'middle' => esc_html__( 'Middle', 'lc-addons-kit-for-elementor' ),
					'bottom' => esc_html__( 'Bottom', 'lc-addons-kit-for-elementor' ),
				),
				'default'              => 'top',
				'selectors_dictionary' => array(
					'top'    => 'flex-start',
					'middle' => 'center',
					'bottom' => 'flex-end',
				),
				'selectors'            => array(
					'{{WRAPPER}}.lcake-image-box--image-left .lcake-image-box-wrapper' => 'align-items: {{VALUE}};',
					'{{WRAPPER}}.lcake-image-box--image-right .lcake-image-box-wrapper' => 'align-items: {{VALUE}};',
				),
				'condition'            => array(
					'position' => array( 'left', 'right' ),
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_title',
			array(
				'label' => esc_html__( 'Title', 'lc-addons-kit-for-elementor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'title_color',
			array(
				'label'     => esc_html__( 'Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .lcake-image-box-title' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .lcake-image-box-title',
			)
		);

		$this->add_responsive_control(
			'title_bottom_space',
			array(
				'label'     => esc_html__( 'Spacing', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .lcake-image-box-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_description',
			array(
				'label' => esc_html__( 'Description', 'lc-addons-kit-for-elementor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'description_color',
			array(
				'label'     => esc_html__( 'Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .lcake-image-box-description' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'description_typography',
				'selector' => '{{WRAPPER}} .lcake-image-box-description',
			)
		);

		$this->add_responsive_control(
			'description_bottom_space',
			array(
				'label'     => esc_html__( 'Spacing', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .lcake-image-box-description' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_link',
			array(
				'label' => esc_html__( 'Link', 'lc-addons-kit-for-elementor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'link_color',
			array(
				'label'     => esc_html__( 'Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .lcake-image-box-link' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'link_typography',
				'selector' => '{{WRAPPER}} .lcake-image-box-link',
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$has_content = ! empty( $settings['title'] ) || ! empty( $settings['description'] ) || ! empty( $settings['link']['url'] );

		$html = '<div class="lcake-image-box-wrapper">';

		if ( ! empty( $settings['image']['url'] ) ) {
			$this->add_render_attribute( 'image', 'src', $settings['image']['url'] );
			$this->add_render_attribute( 'image', 'alt', \Elementor\Control_Media::get_image_alt( $settings['image'] ) );

			if ( ! empty( $settings['image_hover_animation'] ) ) {
				$this->add_render_attribute( 'image', 'class', 'elementor-animation-' . $settings['image_hover_animation'] );
			}

			$image_html  = '<div class="lcake-image-box-img">';
			$image_html .= '<img ' . $this->get_render_attribute_string( 'image' ) . '>';
			$image_html .= '</div>';

			$html .= $image_html;
		}

		if ( $has_content ) {
			$html .= '<div class="lcake-image-box-content">';

			if ( ! empty( $settings['title'] ) ) {
				$title_tag = isset( $settings['title_size'] ) ? tag_escape( $settings['title_size'] ) : 'h3';
				$html     .= '<' . $title_tag . ' class="lcake-image-box-title">';
				$html     .= wp_kses_post( $settings['title'] );
				$html     .= '</' . $title_tag . '>';
			}

			if ( ! empty( $settings['description'] ) ) {
				$html .= '<div class="lcake-image-box-description">' . $settings['description'] . '</div>';
			}

			if ( ! empty( $settings['link']['url'] ) ) {
				$this->add_link_attributes( 'link', $settings['link'] );
				$html .= '<a ' . $this->get_render_attribute_string( 'link' ) . ' class="lcake-image-box-link">';
				$html .= $settings['link_text'];
				$html .= '</a>';
			}

			$html .= '</div>';
		}

		$html .= '</div>';

		echo $html;
	}
}
