<?php
/**
 * Team Widget
 * 
 * @package LCAKE_Elementor_Addons_Kit
 */

if (!defined('ABSPATH')) {
    exit;
}

class LCAKE_Kit_Team extends \Elementor\Widget_Base {

    public function get_name() {
        return 'lcake-kit-team';
    }

    public function get_title() {
        return esc_html__('Team', 'lc-elementor-addons-kit');
    }

    public function get_icon() {
        return 'eicon-person';
    }

    public function get_categories() {
        return ['lcake-page-kit'];
    }

    public function get_keywords() {
        return ['team', 'member', 'staff', 'person', 'profile'];
    }

    protected function add_content_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Content', 'lc-elementor-addons-kit'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'image',
            [
                'label' => esc_html__('Image', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $repeater->add_control(
            'name',
            [
                'label' => esc_html__('Name', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('John Doe', 'lc-elementor-addons-kit'),
            ]
        );

        $repeater->add_control(
            'position',
            [
                'label' => esc_html__('Position', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('CEO', 'lc-elementor-addons-kit'),
            ]
        );

        $repeater->add_control(
            'description',
            [
                'label' => esc_html__('Description', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'lc-elementor-addons-kit'),
            ]
        );

        $repeater->add_control(
            'link',
            [
                'label' => esc_html__('Link', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => esc_html__('https://your-link.com', 'lc-elementor-addons-kit'),
            ]
        );

        $repeater->add_control(
            'facebook',
            [
                'label' => esc_html__('Facebook', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => esc_html__('https://facebook.com/username', 'lc-elementor-addons-kit'),
            ]
        );

        $repeater->add_control(
            'twitter',
            [
                'label' => esc_html__('Twitter', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => esc_html__('https://twitter.com/username', 'lc-elementor-addons-kit'),
            ]
        );

        $repeater->add_control(
            'linkedin',
            [
                'label' => esc_html__('LinkedIn', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => esc_html__('https://linkedin.com/in/username', 'lc-elementor-addons-kit'),
            ]
        );

        $repeater->add_control(
            'instagram',
            [
                'label' => esc_html__('Instagram', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => esc_html__('https://instagram.com/username', 'lc-elementor-addons-kit'),
            ]
        );

        $repeater->add_control(
            'email',
            [
                'label' => esc_html__('Email', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__('email@example.com', 'lc-elementor-addons-kit'),
            ]
        );

        $this->add_control(
            'team_members',
            [
                'label' => esc_html__('Team Members', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'name' => esc_html__('John Doe', 'lc-elementor-addons-kit'),
                        'position' => esc_html__('CEO', 'lc-elementor-addons-kit'),
                        'description' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'lc-elementor-addons-kit'),
                    ],
                    [
                        'name' => esc_html__('Jane Smith', 'lc-elementor-addons-kit'),
                        'position' => esc_html__('Manager', 'lc-elementor-addons-kit'),
                        'description' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'lc-elementor-addons-kit'),
                    ],
                    [
                        'name' => esc_html__('Mike Johnson', 'lc-elementor-addons-kit'),
                        'position' => esc_html__('Developer', 'lc-elementor-addons-kit'),
                        'description' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'lc-elementor-addons-kit'),
                    ],
                ],
                'title_field' => '{{{ name }}}',
            ]
        );

        $this->add_control(
            'layout',
            [
                'label' => esc_html__('Layout', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'grid',
                'options' => [
                    'grid' => esc_html__('Grid', 'lc-elementor-addons-kit'),
                    'carousel' => esc_html__('Carousel', 'lc-elementor-addons-kit'),
                    'list' => esc_html__('List', 'lc-elementor-addons-kit'),
                ],
            ]
        );

        $this->add_responsive_control(
            'columns',
            [
                'label' => esc_html__('Columns', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '3',
                'tablet_default' => '2',
                'mobile_default' => '1',
                'options' => [
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                ],
                'condition' => [
                    'layout' => 'grid',
                ],
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
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_social_icons',
            [
                'label' => esc_html__('Show Social Icons', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'lc-elementor-addons-kit'),
                'label_off' => esc_html__('Hide', 'lc-elementor-addons-kit'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'image_position',
            [
                'label' => esc_html__('Image Position', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'top',
                'options' => [
                    'top' => esc_html__('Top', 'lc-elementor-addons-kit'),
                    'left' => esc_html__('Left', 'lc-elementor-addons-kit'),
                    'right' => esc_html__('Right', 'lc-elementor-addons-kit'),
                ],
            ]
        );

        $this->end_controls_section();

        // Carousel Settings
        $this->start_controls_section(
            'carousel_section',
            [
                'label' => esc_html__('Carousel Settings', 'lc-elementor-addons-kit'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'layout' => 'carousel',
                ],
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
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'autoplay_speed',
            [
                'label' => esc_html__('Autoplay Speed', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 1000,
                'max' => 10000,
                'step' => 500,
                'default' => 3000,
                'condition' => [
                    'autoplay' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'show_arrows',
            [
                'label' => esc_html__('Show Arrows', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'lc-elementor-addons-kit'),
                'label_off' => esc_html__('Hide', 'lc-elementor-addons-kit'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_dots',
            [
                'label' => esc_html__('Show Dots', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'lc-elementor-addons-kit'),
                'label_off' => esc_html__('Hide', 'lc-elementor-addons-kit'),
                'return_value' => 'yes',
                'default' => '',
            ]
        );

        $this->end_controls_section();
    }

    protected function add_style_controls() {
        $this->start_controls_section(
            'section_style_team_member',
            [
                'label' => esc_html__('Team Member', 'lc-elementor-addons-kit'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'team_member_background_color',
            [
                'label' => esc_html__('Background Color', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lcake-team-member' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'team_member_border',
                'selector' => '{{WRAPPER}} .lcake-team-member',
            ]
        );

        $this->add_control(
            'team_member_border_radius',
            [
                'label' => esc_html__('Border Radius', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lcake-team-member' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'team_member_padding',
            [
                'label' => esc_html__('Padding', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lcake-team-member' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'team_member_margin',
            [
                'label' => esc_html__('Margin', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lcake-team-member' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_image',
            [
                'label' => esc_html__('Image', 'lc-elementor-addons-kit'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'image_border_radius',
            [
                'label' => esc_html__('Border Radius', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lcake-team-member-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'image_margin',
            [
                'label' => esc_html__('Margin', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lcake-team-member-image' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_name',
            [
                'label' => esc_html__('Name', 'lc-elementor-addons-kit'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'name_color',
            [
                'label' => esc_html__('Color', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lcake-team-member-name' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'name_typography',
                'selector' => '{{WRAPPER}} .lcake-team-member-name',
            ]
        );

        $this->add_responsive_control(
            'name_margin',
            [
                'label' => esc_html__('Margin', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lcake-team-member-name' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_position',
            [
                'label' => esc_html__('Position', 'lc-elementor-addons-kit'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'position_color',
            [
                'label' => esc_html__('Color', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lcake-team-member-position' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'position_typography',
                'selector' => '{{WRAPPER}} .lcake-team-member-position',
            ]
        );

        $this->add_responsive_control(
            'position_margin',
            [
                'label' => esc_html__('Margin', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lcake-team-member-position' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .lcake-team-member-description' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'description_typography',
                'selector' => '{{WRAPPER}} .lcake-team-member-description',
            ]
        );

        $this->add_responsive_control(
            'description_margin',
            [
                'label' => esc_html__('Margin', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lcake-team-member-description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_social_icons',
            [
                'label' => esc_html__('Social Icons', 'lc-elementor-addons-kit'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_social_icons' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'social_icons_color',
            [
                'label' => esc_html__('Color', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lcake-team-member-social a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'social_icons_background_color',
            [
                'label' => esc_html__('Background Color', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lcake-team-member-social a' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'social_icons_size',
            [
                'label' => esc_html__('Size', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 50,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'size' => 16,
                ],
                'selectors' => [
                    '{{WRAPPER}} .lcake-team-member-social a' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'social_icons_margin',
            [
                'label' => esc_html__('Margin', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lcake-team-member-social' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        if (empty($settings['team_members'])) {
            return;
        }

        $this->add_render_attribute('wrapper', 'class', 'lcake-team-wrapper');
        $this->add_render_attribute('wrapper', 'class', 'lcake-team--' . $settings['layout']);

        if ($settings['layout'] === 'carousel') {
            $this->add_render_attribute('wrapper', 'data-autoplay', $settings['autoplay']);
            $this->add_render_attribute('wrapper', 'data-autoplay-speed', $settings['autoplay_speed']);
            $this->add_render_attribute('wrapper', 'data-show-arrows', $settings['show_arrows']);
            $this->add_render_attribute('wrapper', 'data-show-dots', $settings['show_dots']);
        } else {
            $this->add_render_attribute('wrapper', 'data-columns', $settings['columns']);
        }

        echo '<div ' . $this->get_render_attribute_string('wrapper') . '>';

        if ($settings['layout'] === 'carousel' && $settings['show_arrows'] === 'yes') {
            echo '<div class="lcake-team-arrow lcake-team-arrow-prev">&lt;</div>';
        }

        echo '<div class="lcake-team-container">';
        
        foreach ($settings['team_members'] as $member) {
            echo '<div class="lcake-team-member">';
            
            if (!empty($member['image']['url'])) {
                echo '<div class="lcake-team-member-image">';
                if (!empty($member['link']['url'])) {
                    $this->add_link_attributes('link_' . $member['_id'], $member['link']);
                    echo '<a ' . $this->get_render_attribute_string('link_' . $member['_id']) . '>';
                }
                
                echo '<img src="' . esc_url($member['image']['url']) . '" alt="' . esc_attr($member['name']) . '">';
                
                if (!empty($member['link']['url'])) {
                    echo '</a>';
                }
                echo '</div>';
            }

            echo '<div class="lcake-team-member-content">';
            
            if (!empty($member['name'])) {
                echo '<h3 class="lcake-team-member-name">' . esc_html($member['name']) . '</h3>';
            }

            if (!empty($member['position'])) {
                echo '<div class="lcake-team-member-position">' . esc_html($member['position']) . '</div>';
            }

            if ($settings['show_description'] === 'yes' && !empty($member['description'])) {
                echo '<div class="lcake-team-member-description">' . esc_html($member['description']) . '</div>';
            }

            if ($settings['show_social_icons'] === 'yes') {
                echo '<div class="lcake-team-member-social">';
                
                if (!empty($member['facebook']['url'])) {
                    echo '<a href="' . esc_url($member['facebook']['url']) . '" target="_blank"><i class="fab fa-facebook-f"></i></a>';
                }
                
                if (!empty($member['twitter']['url'])) {
                    echo '<a href="' . esc_url($member['twitter']['url']) . '" target="_blank"><i class="fab fa-twitter"></i></a>';
                }
                
                if (!empty($member['linkedin']['url'])) {
                    echo '<a href="' . esc_url($member['linkedin']['url']) . '" target="_blank"><i class="fab fa-linkedin-in"></i></a>';
                }
                
                if (!empty($member['instagram']['url'])) {
                    echo '<a href="' . esc_url($member['instagram']['url']) . '" target="_blank"><i class="fab fa-instagram"></i></a>';
                }
                
                if (!empty($member['email'])) {
                    echo '<a href="mailto:' . esc_attr($member['email']) . '"><i class="fas fa-envelope"></i></a>';
                }
                
                echo '</div>';
            }

            echo '</div>';
            echo '</div>';
        }

        echo '</div>';

        if ($settings['layout'] === 'carousel' && $settings['show_arrows'] === 'yes') {
            echo '<div class="lcake-team-arrow lcake-team-arrow-next">&gt;</div>';
        }

        if ($settings['layout'] === 'carousel' && $settings['show_dots'] === 'yes') {
            echo '<div class="lcake-team-dots"></div>';
        }

        echo '</div>';
    }

    protected function content_template() {
        ?>
        <# if (settings.team_members.length > 0) { #>
            <div class="lcake-team-wrapper lcake-team--{{ settings.layout }}" data-columns="{{ settings.columns }}">
                <# if (settings.layout === 'carousel' && settings.show_arrows === 'yes') { #>
                    <div class="lcake-team-arrow lcake-team-arrow-prev">&lt;</div>
                <# } #>
                
                <div class="lcake-team-container">
                    <# _.each(settings.team_members, function(member) { #>
                        <div class="lcake-team-member">
                            <# if (member.image.url) { #>
                                <div class="lcake-team-member-image">
                                    <# if (member.link.url) { #>
                                        <a href="{{ member.link.url }}">
                                    <# } #>
                                    <img src="{{ member.image.url }}" alt="{{ member.name }}">
                                    <# if (member.link.url) { #>
                                        </a>
                                    <# } #>
                                </div>
                            <# } #>
                            <div class="lcake-team-member-content">
                                <# if (member.name) { #>
                                    <h3 class="lcake-team-member-name">{{{ member.name }}}</h3>
                                <# } #>
                                <# if (member.position) { #>
                                    <div class="lcake-team-member-position">{{{ member.position }}}</div>
                                <# } #>
                                <# if (settings.show_description === 'yes' && member.description) { #>
                                    <div class="lcake-team-member-description">{{{ member.description }}}</div>
                                <# } #>
                                <# if (settings.show_social_icons === 'yes') { #>
                                    <div class="lcake-team-member-social">
                                        <# if (member.facebook.url) { #>
                                            <a href="{{ member.facebook.url }}" target="_blank"><i class="fab fa-facebook-f"></i></a>
                                        <# } #>
                                        <# if (member.twitter.url) { #>
                                            <a href="{{ member.twitter.url }}" target="_blank"><i class="fab fa-twitter"></i></a>
                                        <# } #>
                                        <# if (member.linkedin.url) { #>
                                            <a href="{{ member.linkedin.url }}" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                                        <# } #>
                                        <# if (member.instagram.url) { #>
                                            <a href="{{ member.instagram.url }}" target="_blank"><i class="fab fa-instagram"></i></a>
                                        <# } #>
                                        <# if (member.email) { #>
                                            <a href="mailto:{{ member.email }}"><i class="fas fa-envelope"></i></a>
                                        <# } #>
                                    </div>
                                <# } #>
                            </div>
                        </div>
                    <# }); #>
                </div>
                
                <# if (settings.layout === 'carousel' && settings.show_arrows === 'yes') { #>
                    <div class="lcake-team-arrow lcake-team-arrow-next">&gt;</div>
                <# } #>
                
                <# if (settings.layout === 'carousel' && settings.show_dots === 'yes') { #>
                    <div class="lcake-team-dots"></div>
                <# } #>
                
            </div>
        <# } #>
        <?php
    }
} 