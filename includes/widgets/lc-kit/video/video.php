<?php
/**
 * Video Widget
 *
 * @package LC_Elementor_Addons_Kit
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Video Widget.
 *
 * Elementor widget that displays a Video.
 */
class LCAKE_Kit_Video extends \Elementor\Widget_Base {

	public function get_name() {
		return 'lcake-kit-video';
	}

	public function get_title() {
		return esc_html__( 'Video', 'lc-addons-kit-for-elementor' );
	}

	public function get_icon() {
		return 'eicon-video-playlist lcake-mveous-badge';
	}

	public function get_categories() {
		return array( 'lcake-page-kit' );
	}

	public function get_keywords() {
		return array( 'video', 'player', 'youtube', 'vimeo', 'dailymotion', 'embed' );
	}

	public function get_style_depends() {
		return array( 'lcake-kit-video-css' );
	}

	protected function register_controls() {
		$this->start_controls_section(
			'content_section',
			array(
				'label' => esc_html__( 'Video Source', 'lc-addons-kit-for-elementor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'video_type',
			array(
				'label'   => esc_html__( 'Video Type', 'lc-addons-kit-for-elementor' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'youtube',
				'options' => array(
					'youtube'     => esc_html__( 'YouTube', 'lc-addons-kit-for-elementor' ),
					'vimeo'       => esc_html__( 'Vimeo', 'lc-addons-kit-for-elementor' ),
					'dailymotion' => esc_html__( 'Dailymotion', 'lc-addons-kit-for-elementor' ),
					'hosted'      => esc_html__( 'Self Hosted', 'lc-addons-kit-for-elementor' ),
				),
			)
		);

		$this->add_control(
			'video_url',
			array(
				'label'       => esc_html__( 'Video URL', 'lc-addons-kit-for-elementor' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'https://www.youtube.com/watch?v=...', 'lc-addons-kit-for-elementor' ),
				'description' => esc_html__( 'Paste your YouTube, Vimeo, or Dailymotion URL here.', 'lc-addons-kit-for-elementor' ),
				'condition'   => array(
					'video_type!' => 'hosted',
				),
				'dynamic'     => array(
					'active' => true,
				),
			)
		);

		$this->add_control(
			'video_file',
			array(
				'label'      => esc_html__( 'Video File', 'lc-addons-kit-for-elementor' ),
				'type'       => \Elementor\Controls_Manager::MEDIA,
				'media_type' => 'video',
				'condition'  => array(
					'video_type' => 'hosted',
				),
			)
		);

		$this->add_control(
			'poster',
			array(
				'label'       => esc_html__( 'Poster Image / Overlay', 'lc-addons-kit-for-elementor' ),
				'type'        => \Elementor\Controls_Manager::MEDIA,
				'description' => esc_html__( 'Used for Self Hosted videos as the background before playing.', 'lc-addons-kit-for-elementor' ),
				'condition'   => array(
					'video_type' => 'hosted',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'video_settings_section',
			array(
				'label' => esc_html__( 'Playback Settings', 'lc-addons-kit-for-elementor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'autoplay',
			array(
				'label'        => esc_html__( 'Autoplay', 'lc-addons-kit-for-elementor' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'lc-addons-kit-for-elementor' ),
				'label_off'    => esc_html__( 'No', 'lc-addons-kit-for-elementor' ),
				'return_value' => 'yes',
				'default'      => '',
			)
		);

		$this->add_control(
			'mute',
			array(
				'label'        => esc_html__( 'Mute', 'lc-addons-kit-for-elementor' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'lc-addons-kit-for-elementor' ),
				'label_off'    => esc_html__( 'No', 'lc-addons-kit-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes', // Moden default to ensure autoplay works on modern browsers
				'description'  => esc_html__( 'Muting the video usually allows Autoplay to work on modern browsers.', 'lc-addons-kit-for-elementor' ),
			)
		);

		$this->add_control(
			'loop',
			array(
				'label'        => esc_html__( 'Loop', 'lc-addons-kit-for-elementor' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'lc-addons-kit-for-elementor' ),
				'label_off'    => esc_html__( 'No', 'lc-addons-kit-for-elementor' ),
				'return_value' => 'yes',
				'default'      => '',
			)
		);

		$this->add_control(
			'controls',
			array(
				'label'        => esc_html__( 'Player Controls', 'lc-addons-kit-for-elementor' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'lc-addons-kit-for-elementor' ),
				'label_off'    => esc_html__( 'Hide', 'lc-addons-kit-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'modestbranding',
			array(
				'label'        => esc_html__( 'Modest Branding', 'lc-addons-kit-for-elementor' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'lc-addons-kit-for-elementor' ),
				'label_off'    => esc_html__( 'No', 'lc-addons-kit-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => array(
					'video_type' => 'youtube',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'content_details_section',
			array(
				'label' => esc_html__( 'Information Overlay', 'lc-addons-kit-for-elementor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'video_title',
			array(
				'label'       => esc_html__( 'Video Title', 'lc-addons-kit-for-elementor' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Optional Title', 'lc-addons-kit-for-elementor' ),
				'dynamic'     => array(
					'active' => true,
				),
			)
		);

		$this->add_control(
			'video_description',
			array(
				'label'       => esc_html__( 'Description', 'lc-addons-kit-for-elementor' ),
				'type'        => \Elementor\Controls_Manager::TEXTAREA,
				'placeholder' => esc_html__( 'Optional description underneath the video.', 'lc-addons-kit-for-elementor' ),
				'rows'        => 3,
				'dynamic'     => array(
					'active' => true,
				),
			)
		);

		$this->end_controls_section();

		// Style Tab
		$this->start_controls_section(
			'section_style_video',
			array(
				'label' => esc_html__( 'Video Container', 'lc-addons-kit-for-elementor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'aspect_ratio',
			array(
				'label'     => esc_html__( 'Aspect Ratio', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'options'   => array(
					'16/9' => '16:9',
					'21/9' => '21:9',
					'4/3'  => '4:3',
					'1/1'  => '1:1 (Square)',
					'9/16' => '9:16 (Vertical)',
				),
				'default'   => '16/9',
				'selectors' => array(
					'{{WRAPPER}} .lcake-video-container' => 'aspect-ratio: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'video_width',
			array(
				'label'      => esc_html__( 'Maximum Width', 'lc-addons-kit-for-elementor' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array(
						'min' => 100,
						'max' => 1200,
					),
				),
				'default'    => array(
					'unit' => '%',
					'size' => 100,
				),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-video-wrapper' => 'max-width: {{SIZE}}{{UNIT}}; margin: 0 auto;',
				),
			)
		);

		$this->add_control(
			'video_border_radius',
			array(
				'label'      => esc_html__( 'Corner Radius', 'lc-addons-kit-for-elementor' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'default'    => array(
					'top'      => '16',
					'right'    => '16',
					'bottom'   => '16',
					'left'     => '16',
					'unit'     => 'px',
					'isLinked' => true,
				),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-video-container' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .lcake-video-container iframe' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .lcake-video-container video' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			array(
				'name'     => 'video_border',
				'selector' => '{{WRAPPER}} .lcake-video-container',
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'video_box_shadow',
				'selector' => '{{WRAPPER}} .lcake-video-container',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_info',
			array(
				'label' => esc_html__( 'Text Information', 'lc-addons-kit-for-elementor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'title_color',
			array(
				'label'     => esc_html__( 'Title Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#111827',
				'selectors' => array(
					'{{WRAPPER}} .lcake-video-title' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .lcake-video-title',
			)
		);

		$this->add_control(
			'description_color',
			array(
				'label'     => esc_html__( 'Description Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#4b5563',
				'separator' => 'before',
				'selectors' => array(
					'{{WRAPPER}} .lcake-video-description' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'description_typography',
				'selector' => '{{WRAPPER}} .lcake-video-description',
			)
		);

		$this->end_controls_section();
	}

	private function get_video_url( $settings ) {
		$video_url = '';

		if ( $settings['video_type'] === 'hosted' && ! empty( $settings['video_file']['url'] ) ) {
			$video_url = $settings['video_file']['url'];
		} elseif ( ! empty( $settings['video_url'] ) ) {
			$video_url = $settings['video_url'];
		}

		return $video_url;
	}

	private function get_embed_url( $video_url, $settings ) {
		$embed_url = '';

		if ( $settings['video_type'] === 'youtube' ) {
			// Updated regex to support shortlinks, direct links, and standard links.
			$pattern = '/(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))([\w-]{11})/';
			if ( preg_match( $pattern, $video_url, $matches ) ) {
				$video_id   = $matches[1];
				$embed_url  = 'https://www.youtube.com/embed/' . $video_id;
				$embed_url .= '?autoplay=' . ( $settings['autoplay'] === 'yes' ? '1' : '0' );
				$embed_url .= '&mute=' . ( $settings['mute'] === 'yes' ? '1' : '0' );
				$embed_url .= '&loop=' . ( $settings['loop'] === 'yes' ? '1' : '0' );
				if ( $settings['loop'] === 'yes' ) {
					$embed_url .= '&playlist=' . $video_id; // Loop requires playlist parameter in YT natively
				}
				$embed_url .= '&controls=' . ( $settings['controls'] === 'yes' ? '1' : '0' );
				$embed_url .= '&modestbranding=' . ( $settings['modestbranding'] === 'yes' ? '1' : '0' );
				$embed_url .= '&rel=0';
			}
		} elseif ( $settings['video_type'] === 'vimeo' ) {
			$pattern = '/(?:www\.|player\.)?vimeo.com\/(?:channels\/(?:\w+\/)?|groups\/(?:[^\/]*)\/videos\/|album\/(?:\d+)\/video\/|video\/|)(\d+)(?:[a-zA-Z0-9_\-]+)?/i';
			if ( preg_match( $pattern, $video_url, $matches ) ) {
				$video_id   = $matches[1];
				$embed_url  = 'https://player.vimeo.com/video/' . $video_id;
				$embed_url .= '?autoplay=' . ( $settings['autoplay'] === 'yes' ? '1' : '0' );
				$embed_url .= '&muted=' . ( $settings['mute'] === 'yes' ? '1' : '0' );
				$embed_url .= '&loop=' . ( $settings['loop'] === 'yes' ? '1' : '0' );
				$embed_url .= '&controls=' . ( $settings['controls'] === 'yes' ? '1' : '0' );
			}
		} elseif ( $settings['video_type'] === 'dailymotion' ) {
			$pattern = '/^.+dailymotion.com\/(video|hub)\/([^_]+)[^#]*(#video=([^_&]+))?/';
			if ( preg_match( $pattern, $video_url, $matches ) ) {
				$video_id   = isset( $matches[4] ) ? $matches[4] : $matches[2];
				$embed_url  = 'https://www.dailymotion.com/embed/video/' . $video_id;
				$embed_url .= '?autoplay=' . ( $settings['autoplay'] === 'yes' ? '1' : '0' );
				$embed_url .= '&mute=' . ( $settings['mute'] === 'yes' ? '1' : '0' );
				$embed_url .= '&loop=' . ( $settings['loop'] === 'yes' ? '1' : '0' );
				$embed_url .= '&controls=' . ( $settings['controls'] === 'yes' ? '1' : '0' );
			}
		}

		return $embed_url;
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$video_url = $this->get_video_url( $settings );

		if ( empty( $video_url ) ) {
			echo '<div class="lcake-video-wrapper">';
			echo '<div class="lcake-video-container"><div class="lcake-video-placeholder"><div class="lcake-video-error">' . esc_html__( 'Please provide a valid video URL or file.', 'lc-addons-kit-for-elementor' ) . '</div></div></div>';
			echo '</div>';
			return;
		}

		$this->add_render_attribute( 'wrapper', 'class', 'lcake-video-wrapper' );

		echo '<div ' . $this->get_render_attribute_string( 'wrapper' ) . '>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Elementor pre-sanitizes render attribute strings.

		echo '<div class="lcake-video-container">';
		if ( $settings['video_type'] === 'hosted' ) {
			// Self-hosted video
			echo '<video';
			if ( $settings['autoplay'] === 'yes' ) {
				echo ' autoplay playsinline';
			}
			if ( $settings['mute'] === 'yes' ) {
				echo ' muted';
			}
			if ( $settings['loop'] === 'yes' ) {
				echo ' loop';
			}
			if ( $settings['controls'] === 'yes' ) {
				echo ' controls';
			}
			if ( ! empty( $settings['poster']['url'] ) ) {
				echo ' poster="' . esc_url( $settings['poster']['url'] ) . '"';
			}
			echo '>';
			echo '<source src="' . esc_url( $video_url ) . '" type="video/mp4">';
			echo esc_html__( 'Your browser does not support the video tag.', 'lc-addons-kit-for-elementor' );
			echo '</video>';
		} else {
			// Embedded video
			$embed_url = $this->get_embed_url( $video_url, $settings );
			if ( $embed_url ) {
				echo '<iframe src="' . esc_url( $embed_url ) . '" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>';
			} else {
				echo '<div class="lcake-video-placeholder"><div class="lcake-video-error">' . esc_html__( 'Invalid URL matching format.', 'lc-addons-kit-for-elementor' ) . '</div></div>';
			}
		}
		echo '</div>'; // end container

		if ( ! empty( $settings['video_title'] ) || ! empty( $settings['video_description'] ) ) {
			echo '<div class="lcake-video-info">';
			if ( ! empty( $settings['video_title'] ) ) {
				echo '<h3 class="lcake-video-title">' . wp_kses_post( $settings['video_title'] ) . '</h3>';
			}
			if ( ! empty( $settings['video_description'] ) ) {
				echo '<div class="lcake-video-description">' . wp_kses_post( $settings['video_description'] ) . '</div>';
			}
			echo '</div>';
		}

		echo '</div>';
	}
}
