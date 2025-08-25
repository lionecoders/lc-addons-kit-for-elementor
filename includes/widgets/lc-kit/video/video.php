<?php
/**
 * Video Widget
 * 
 * @package LC_Elementor_Addons_Kit
 */

if (!defined('ABSPATH')) {
    exit;
}

class LC_Kit_Video extends \Elementor\Widget_Base {

    public function get_name() {
        return 'lc-kit-video';
    }

    public function get_title() {
        return esc_html__('Video', 'lc-elementor-addons-kit');
    }

    public function get_icon() {
        return 'eicon-video-playlist';
    }

    public function get_categories() {
        return ['lc-page-kit'];
    }

    public function get_keywords() {
        return ['video', 'player', 'youtube', 'vimeo', 'dailymotion', 'embed'];
    }

    protected function add_content_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Content', 'lc-elementor-addons-kit'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'video_type',
            [
                'label' => esc_html__('Video Type', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'youtube',
                'options' => [
                    'youtube' => esc_html__('YouTube', 'lc-elementor-addons-kit'),
                    'vimeo' => esc_html__('Vimeo', 'lc-elementor-addons-kit'),
                    'dailymotion' => esc_html__('Dailymotion', 'lc-elementor-addons-kit'),
                    'hosted' => esc_html__('Self Hosted', 'lc-elementor-addons-kit'),
                ],
            ]
        );

        $this->add_control(
            'video_url',
            [
                'label' => esc_html__('Video URL', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__('Enter video URL', 'lc-elementor-addons-kit'),
                'description' => esc_html__('Enter the video URL (YouTube, Vimeo, Dailymotion, or self-hosted video file)', 'lc-elementor-addons-kit'),
            ]
        );

        $this->add_control(
            'video_file',
            [
                'label' => esc_html__('Video File', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'media_type' => 'video',
                'condition' => [
                    'video_type' => 'hosted',
                ],
            ]
        );

        $this->add_control(
            'poster',
            [
                'label' => esc_html__('Poster Image', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_control(
            'video_title',
            [
                'label' => esc_html__('Video Title', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__('Enter video title', 'lc-elementor-addons-kit'),
            ]
        );

        $this->add_control(
            'video_description',
            [
                'label' => esc_html__('Video Description', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'placeholder' => esc_html__('Enter video description', 'lc-elementor-addons-kit'),
                'rows' => 3,
            ]
        );

        $this->add_control(
            'show_title',
            [
                'label' => esc_html__('Show Title', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'lc-elementor-addons-kit'),
                'label_off' => esc_html__('Hide', 'lc-elementor-addons-kit'),
                'return_value' => 'yes',
                'default' => '',
            ]
        );

        $this->add_control(
            'show_description',
            [
                'label' => esc_html__('Show Description', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'lc-elementor-addons-kit'),
                'label_off' => esc_html__('Hide', 'lc-elementor-addons-kit'),
                'return_value' => 'yes',
                'default' => '',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'video_settings_section',
            [
                'label' => esc_html__('Video Settings', 'lc-elementor-addons-kit'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'autoplay',
            [
                'label' => esc_html__('Autoplay', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'lc-elementor-addons-kit'),
                'label_off' => esc_html__('No', 'lc-elementor-addons-kit'),
                'return_value' => 'yes',
                'default' => '',
            ]
        );

        $this->add_control(
            'mute',
            [
                'label' => esc_html__('Mute', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'lc-elementor-addons-kit'),
                'label_off' => esc_html__('No', 'lc-elementor-addons-kit'),
                'return_value' => 'yes',
                'default' => '',
            ]
        );

        $this->add_control(
            'loop',
            [
                'label' => esc_html__('Loop', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'lc-elementor-addons-kit'),
                'label_off' => esc_html__('No', 'lc-elementor-addons-kit'),
                'return_value' => 'yes',
                'default' => '',
            ]
        );

        $this->add_control(
            'controls',
            [
                'label' => esc_html__('Show Controls', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'lc-elementor-addons-kit'),
                'label_off' => esc_html__('Hide', 'lc-elementor-addons-kit'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_info',
            [
                'label' => esc_html__('Show Info', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'lc-elementor-addons-kit'),
                'label_off' => esc_html__('Hide', 'lc-elementor-addons-kit'),
                'return_value' => 'yes',
                'default' => 'yes',
                'condition' => [
                    'video_type' => 'youtube',
                ],
            ]
        );

        $this->add_control(
            'modestbranding',
            [
                'label' => esc_html__('Modest Branding', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'lc-elementor-addons-kit'),
                'label_off' => esc_html__('No', 'lc-elementor-addons-kit'),
                'return_value' => 'yes',
                'default' => '',
                'condition' => [
                    'video_type' => 'youtube',
                ],
            ]
        );

        $this->add_control(
            'rel',
            [
                'label' => esc_html__('Show Related Videos', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'lc-elementor-addons-kit'),
                'label_off' => esc_html__('Hide', 'lc-elementor-addons-kit'),
                'return_value' => 'yes',
                'default' => '',
                'condition' => [
                    'video_type' => 'youtube',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function add_style_controls() {
        $this->start_controls_section(
            'section_style_video',
            [
                'label' => esc_html__('Video', 'lc-elementor-addons-kit'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'video_width',
            [
                'label' => esc_html__('Width', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 1200,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 10,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 100,
                ],
                'selectors' => [
                    '{{WRAPPER}} .lc-video-wrapper' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'video_height',
            [
                'label' => esc_html__('Height', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'vh'],
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 800,
                        'step' => 1,
                    ],
                    'vh' => [
                        'min' => 10,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 400,
                ],
                'selectors' => [
                    '{{WRAPPER}} .lc-video-wrapper' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'video_border_radius',
            [
                'label' => esc_html__('Border Radius', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lc-video-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'video_border',
                'selector' => '{{WRAPPER}} .lc-video-wrapper',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'video_box_shadow',
                'selector' => '{{WRAPPER}} .lc-video-wrapper',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_title',
            [
                'label' => esc_html__('Title', 'lc-elementor-addons-kit'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_title' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__('Color', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lc-video-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .lc-video-title',
            ]
        );

        $this->add_responsive_control(
            'title_margin',
            [
                'label' => esc_html__('Margin', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lc-video-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_description',
            [
                'label' => esc_html__('Description', 'lc-elementor-addons-kit'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_description' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'description_color',
            [
                'label' => esc_html__('Color', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lc-video-description' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'description_typography',
                'selector' => '{{WRAPPER}} .lc-video-description',
            ]
        );

        $this->add_responsive_control(
            'description_margin',
            [
                'label' => esc_html__('Margin', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lc-video-description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    private function get_video_url($settings) {
        $video_url = '';
        
        if ($settings['video_type'] === 'hosted' && !empty($settings['video_file']['url'])) {
            $video_url = $settings['video_file']['url'];
        } elseif (!empty($settings['video_url'])) {
            $video_url = $settings['video_url'];
        }
        
        return $video_url;
    }

    private function get_embed_url($video_url, $settings) {
        $embed_url = '';
        
        if ($settings['video_type'] === 'youtube') {
            $video_id = $this->get_youtube_video_id($video_url);
            if ($video_id) {
                $embed_url = 'https://www.youtube.com/embed/' . $video_id;
                $embed_url .= '?autoplay=' . ($settings['autoplay'] === 'yes' ? '1' : '0');
                $embed_url .= '&mute=' . ($settings['mute'] === 'yes' ? '1' : '0');
                $embed_url .= '&loop=' . ($settings['loop'] === 'yes' ? '1' : '0');
                $embed_url .= '&controls=' . ($settings['controls'] === 'yes' ? '1' : '0');
                $embed_url .= '&showinfo=' . ($settings['show_info'] === 'yes' ? '1' : '0');
                $embed_url .= '&modestbranding=' . ($settings['modestbranding'] === 'yes' ? '1' : '0');
                $embed_url .= '&rel=' . ($settings['rel'] === 'yes' ? '1' : '0');
            }
        } elseif ($settings['video_type'] === 'vimeo') {
            $video_id = $this->get_vimeo_video_id($video_url);
            if ($video_id) {
                $embed_url = 'https://player.vimeo.com/video/' . $video_id;
                $embed_url .= '?autoplay=' . ($settings['autoplay'] === 'yes' ? '1' : '0');
                $embed_url .= '&muted=' . ($settings['mute'] === 'yes' ? '1' : '0');
                $embed_url .= '&loop=' . ($settings['loop'] === 'yes' ? '1' : '0');
                $embed_url .= '&controls=' . ($settings['controls'] === 'yes' ? '1' : '0');
            }
        } elseif ($settings['video_type'] === 'dailymotion') {
            $video_id = $this->get_dailymotion_video_id($video_url);
            if ($video_id) {
                $embed_url = 'https://www.dailymotion.com/embed/video/' . $video_id;
                $embed_url .= '?autoplay=' . ($settings['autoplay'] === 'yes' ? '1' : '0');
                $embed_url .= '&mute=' . ($settings['mute'] === 'yes' ? '1' : '0');
                $embed_url .= '&loop=' . ($settings['loop'] === 'yes' ? '1' : '0');
                $embed_url .= '&controls=' . ($settings['controls'] === 'yes' ? '1' : '0');
            }
        }
        
        return $embed_url;
    }

    private function get_youtube_video_id($url) {
        $pattern = '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i';
        if (preg_match($pattern, $url, $matches)) {
            return $matches[1];
        }
        return false;
    }

    private function get_vimeo_video_id($url) {
        $pattern = '/(?:vimeo\.com\/)([0-9]+)/i';
        if (preg_match($pattern, $url, $matches)) {
            return $matches[1];
        }
        return false;
    }

    private function get_dailymotion_video_id($url) {
        $pattern = '/(?:dailymotion\.com\/video\/)([a-zA-Z0-9]+)/i';
        if (preg_match($pattern, $url, $matches)) {
            return $matches[1];
        }
        return false;
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        $video_url = $this->get_video_url($settings);
        
        if (empty($video_url)) {
            echo '<div class="lc-video-error">' . esc_html__('Please provide a valid video URL or file.', 'lc-elementor-addons-kit') . '</div>';
            return;
        }

        $this->add_render_attribute('wrapper', 'class', 'lc-video-wrapper');

        echo '<div ' . $this->get_render_attribute_string('wrapper') . '>';

        if ($settings['video_type'] === 'hosted') {
            // Self-hosted video
            echo '<video';
            if ($settings['autoplay'] === 'yes') echo ' autoplay';
            if ($settings['mute'] === 'yes') echo ' muted';
            if ($settings['loop'] === 'yes') echo ' loop';
            if ($settings['controls'] === 'yes') echo ' controls';
            if (!empty($settings['poster']['url'])) echo ' poster="' . esc_url($settings['poster']['url']) . '"';
            echo '>';
            echo '<source src="' . esc_url($video_url) . '" type="video/mp4">';
            echo esc_html__('Your browser does not support the video tag.', 'lc-elementor-addons-kit');
            echo '</video>';
        } else {
            // Embedded video
            $embed_url = $this->get_embed_url($video_url, $settings);
            if ($embed_url) {
                echo '<iframe src="' . esc_url($embed_url) . '" frameborder="0" allowfullscreen></iframe>';
            } else {
                echo '<div class="lc-video-error">' . esc_html__('Invalid video URL.', 'lc-elementor-addons-kit') . '</div>';
            }
        }

        echo '</div>';

        if ($settings['show_title'] === 'yes' && !empty($settings['video_title'])) {
            echo '<h3 class="lc-video-title">' . esc_html($settings['video_title']) . '</h3>';
        }

        if ($settings['show_description'] === 'yes' && !empty($settings['video_description'])) {
            echo '<div class="lc-video-description">' . esc_html($settings['video_description']) . '</div>';
        }
    }

    protected function content_template() {
        ?>
        <div class="lc-video-wrapper">
            <# if (settings.video_type === 'hosted' && settings.video_file.url) { #>
                <video<# if (settings.autoplay === 'yes') { #> autoplay<# } #><# if (settings.mute === 'yes') { #> muted<# } #><# if (settings.loop === 'yes') { #> loop<# } #><# if (settings.controls === 'yes') { #> controls<# } #><# if (settings.poster.url) { #> poster="{{ settings.poster.url }}"<# } #>>
                    <source src="{{ settings.video_file.url }}" type="video/mp4">
                    <?php echo esc_html__('Your browser does not support the video tag.', 'lc-elementor-addons-kit'); ?>
                </video>
            <# } else if (settings.video_url) { #>
                <iframe src="{{ settings.video_url }}" frameborder="0" allowfullscreen></iframe>
            <# } else { #>
                <div class="lc-video-error">
                    <?php echo esc_html__('Please provide a valid video URL or file.', 'lc-elementor-addons-kit'); ?>
                </div>
            <# } #>
        </div>
        
        <# if (settings.show_title === 'yes' && settings.video_title) { #>
            <h3 class="lc-video-title">{{{ settings.video_title }}}</h3>
        <# } #>
        
        <# if (settings.show_description === 'yes' && settings.video_description) { #>
            <div class="lc-video-description">{{{ settings.video_description }}}</div>
        <# } #>
        <?php
    }
} 