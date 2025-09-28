<?php
/**
 * Image Accordion Widget
 * 
 * @package LC_Elementor_Addons_Kit
 */

if (!defined('ABSPATH')) {
    exit;
}
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;

class LCAKE_Kit_Image_Accordion extends Widget_Base {

    public function get_name() {
        return 'lcake-kit-image-accordion';
    }

    public function get_title() {
        return esc_html__('Image Accordion Widget', 'lc-addons-kit-for-elementor');
    }

    public function get_icon() {
        return 'eicon-gallery-grid';
    }

    public function get_categories() {
        return ['lcake-page-kit'];
    }

    public function get_keywords() {
        return ['image', 'accordion', 'gallery', 'hover', 'effect'];
    }

    public function get_style_depends() {
        return ['lcake-kit-image-accordion'];
    }

	public function get_script_depends() {
		return ['lcake-kit-image-accordion'];
	}

    protected function register_controls() {

        $this->start_controls_section(
            'lcake_img_accordion_content_tab',
            [
                'label' => esc_html__('Content', 'lc-addons-kit-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
            $repeater = new \Elementor\Repeater();

            $repeater->add_control(
                'lcake_img_accordion_active',
                [
                    'label'     => esc_html__('Active ? ', 'lc-addons-kit-for-elementor'),
                    'type'      => \Elementor\Controls_Manager::SWITCHER,
                    'default'   => 'no',
                    'label_on'  => esc_html__( 'Yes', 'lc-addons-kit-for-elementor' ),
                    'label_off' => esc_html__( 'No', 'lc-addons-kit-for-elementor' ),
                ]
            );

            $repeater->add_control(
                'lcake_img_accordion_bg',
                [
                    'label'     => esc_html__( 'Background Image', 'lc-addons-kit-for-elementor' ),
                    'type'      => \Elementor\Controls_Manager::MEDIA,
					'dynamic'	=> [
						'active' => true,
					],
                    'default'   => [
                        'url' => \Elementor\Utils::get_placeholder_image_src(),
                        'id'    => -1
                    ],
                ]
            );

            $repeater->add_control(
                'lcake_img_accordion_title',
                [
                    'label'         => esc_html__('Title', 'lc-addons-kit-for-elementor'),
                    'type'          => \Elementor\Controls_Manager::TEXT,
					'dynamic'		=> [
						'active' => true,
					],
                    'label_block'   => true,
                    'default'       => esc_html__('Image accordion Title', 'lc-addons-kit-for-elementor'),
                ]
            );

            $repeater->add_control(
                'lcake_img_accordion_enable_icon',
                [
                    'label'         => esc_html__( 'Enable Icon', 'lc-addons-kit-for-elementor' ),
                    'type'          => \Elementor\Controls_Manager::SWITCHER,
                    'label_on'      => esc_html__( 'Yes', 'lc-addons-kit-for-elementor' ),
                    'label_off'     => esc_html__( 'No', 'lc-addons-kit-for-elementor' ),
                    'return_value'  => 'yes',
                    'default'       => '',
                ]
            );

            $repeater->add_control(
                'lcake_img_accordion_title_icons',
                [
                    'label'             => esc_html__('Icon for title', 'lc-addons-kit-for-elementor'),
                    'type'              => \Elementor\Controls_Manager::ICONS,
                    'fa4compatibility'  => 'lcake_img_accordion_title_icon',
                    'default'           => [
                        'value' => '',
                    ],
                    'condition'         => [
                        'lcake_img_accordion_enable_icon' => 'yes',
                    ]
                ]
            );

            $repeater->add_control(
                'lcake_img_accordion_title_icon_position',
                [
                    'label'     => esc_html__( 'Icon Position', 'lc-addons-kit-for-elementor' ),
                    'type'      => \Elementor\Controls_Manager::SELECT,
                    'default'   => 'left',
                    'options'   => [
                        'left'      => esc_html__( 'Before', 'lc-addons-kit-for-elementor' ),
                        'right'     => esc_html__( 'After', 'lc-addons-kit-for-elementor' ),
                    ],
                    'condition' => [
                        'lcake_img_accordion_title_icons!' => '',
                        'lcake_img_accordion_enable_icon' => 'yes',
                    ],
                ]
            );

            $repeater->add_control(
                'lcake_img_accordion_enable_wrap_link',
                [
                    'label'         => esc_html__( 'Enable Wrap Link', 'lc-addons-kit-for-elementor' ),
                    'type'          => \Elementor\Controls_Manager::SWITCHER,
                    'label_on'      => esc_html__( 'Yes', 'lc-addons-kit-for-elementor' ),
                    'label_off'     => esc_html__( 'No', 'lc-addons-kit-for-elementor' ),
                    'return_value'  => 'yes',
                    'default'       => 'no',
                    'separator'     => 'before',
                ]
            );

            $repeater->add_control(
                'lcake_img_accordion_wrap_link_url',
                [
                    'label'     => esc_html__('Wrap URL', 'lc-addons-kit-for-elementor'),
                    'type'      => \Elementor\Controls_Manager::URL,
					'dynamic'	=> [
						'active' => true,
					],
                    'condition' => [
                        'lcake_img_accordion_enable_wrap_link' => 'yes',
                    ],
                ]
            );

            $repeater->add_control(
                'lcake_img_accordion_enable_button',
                [
                    'label'         => esc_html__( 'Enable Button', 'lc-addons-kit-for-elementor' ),
                    'type'          => \Elementor\Controls_Manager::SWITCHER,
                    'label_on'      => esc_html__( 'Yes', 'lc-addons-kit-for-elementor' ),
                    'label_off'     => esc_html__( 'No', 'lc-addons-kit-for-elementor' ),
                    'return_value'  => 'yes',
                    'default'       => 'yes',
                    'separator'     => 'before',
                ]
            );

            $repeater->add_control(
                'lcake_img_accordion_button_label',
                [
                    'label'         => esc_html__('Button Label', 'lc-addons-kit-for-elementor'),
                    'type'          => \Elementor\Controls_Manager::TEXT,
					'dynamic'		=> [
						'active' => true,
					],
                    'label_block'   => true,
                    'default'       => esc_html__('Read More','lc-addons-kit-for-elementor'),
                    'condition'     => [
                        'lcake_img_accordion_enable_button' => 'yes',
                    ],
                ]
            );

            $repeater->add_control(
                'lcake_img_accordion_button_url',
                [
                    'label'     => esc_html__('Button URL', 'lc-addons-kit-for-elementor'),
                    'type'      => \Elementor\Controls_Manager::URL,
					'dynamic'	=> [
						'active' => true,
					],
                    'condition' => [
                        'lcake_img_accordion_enable_button' => 'yes',
                    ],
                ]
            );

            $repeater->add_control(
                'lcake_img_accordion_enable_pupup',
                [
                    'label'         => esc_html__( 'Enable Popup', 'lc-addons-kit-for-elementor' ),
                    'type'          => \Elementor\Controls_Manager::SWITCHER,
                    'label_on'      => esc_html__( 'Yes', 'lc-addons-kit-for-elementor' ),
                    'label_off'     => esc_html__( 'No', 'lc-addons-kit-for-elementor' ),
                    'return_value'  => 'yes',
                    'default'       => '',
                    'separator'     => 'before',
                ]
            );

            $repeater->add_control(
                'lcake_img_accordion_pup_up_icons',
                [
                    'label'             => esc_html__('Pupup Icon', 'lc-addons-kit-for-elementor'),
                    'type'              => \Elementor\Controls_Manager::ICONS,
                    'fa4compatibility'  => 'lcake_img_accordion_pup_up_icon',
                    'default'           => [
                        'value'     => 'icon icon-plus',
                        'library'   => 'lcakeicons'
                    ],
                    'label_block'       => true,
                    'condition'         => [
                        'lcake_img_accordion_enable_pupup' => 'yes'
                    ]
                ]
            );

            $repeater->add_control(
                'lcake_img_accordion_enable_project_link',
                [
                    'label'         => esc_html__( 'Enable Project Link', 'lc-addons-kit-for-elementor' ),
                    'type'          => \Elementor\Controls_Manager::SWITCHER,
                    'label_on'      => esc_html__( 'Yes', 'lc-addons-kit-for-elementor' ),
                    'label_off'     => esc_html__( 'No', 'lc-addons-kit-for-elementor' ),
                    'return_value'  => 'yes',
                    'separator'     => 'before',
                ]
            );

            $repeater->add_control(
                'lcake_img_accordion_project_link',
                [
                    'label'         => esc_html__( 'Project Link', 'lc-addons-kit-for-elementor' ),
                    'type'          => \Elementor\Controls_Manager::URL,
					'dynamic'		=> [
						'active' => true,
					],
                    'placeholder'   => esc_html__( 'https://wpmet.com', 'lc-addons-kit-for-elementor' ),
                    'condition'     => [
                        'lcake_img_accordion_enable_project_link' => 'yes'
                    ],
                ]
            );

            $repeater->add_control(
                'lcake_img_accordion_project_link_icons',
                [
                    'label'             => esc_html__('Project Link Icon', 'lc-addons-kit-for-elementor'),
                    'type'              => \Elementor\Controls_Manager::ICONS,
                    'fa4compatibility'  => 'lcake_img_accordion_project_link_icon',
                    'default'           => [
                        'value' => 'icon icon icon-link',
                        'library'   => 'lcakeicons'
                    ],
                    'label_block'       => true,
                    'condition'         => [
                        'lcake_img_accordion_enable_project_link' => 'yes'
                    ],
                ]
            );

            $this->add_control(
                'lcake_img_accordion_items',
                [
                    'label' => esc_html__('Accordion Items', 'lc-addons-kit-for-elementor'),
                    'type' => \Elementor\Controls_Manager::REPEATER,
                    'default' => [
                        [ 'lcake_img_accordion_title' => esc_html__('This is title','lc-addons-kit-for-elementor') ],
                        [ 'lcake_img_accordion_icon' => esc_attr('icon icon-minus') ],
                        [ 'lcake_img_accordion_link' => esc_url('#') ],
                        [ 'lcake_img_accordion_button_label' => esc_html__('Read More','lc-addons-kit-for-elementor') ],
                    ],
                    'fields' => $repeater->get_controls(),
                    'title_field' => '{{ lcake_img_accordion_title }}',
                ]
            );

            $this->add_responsive_control(
                'items_style',
                [
                    'label'         => esc_html__('Style', 'lc-addons-kit-for-elementor'),
                    'type'          => \Elementor\Controls_Manager::SELECT,
                    'options'       => [
                        ''              => esc_html__('Default', 'lc-addons-kit-for-elementor'),
                        'horizontal'    => esc_html__('Horizontal', 'lc-addons-kit-for-elementor'),
                        'vertical'      => esc_html__('Vertical', 'lc-addons-kit-for-elementor'),
                    ],
                    'default'       => 'horizontal',
                    'prefix_class'  => 'lcake-image-accordion%s-',
                ]
            );

            $this->add_control(
                'active_behavior',
                [
                    'label'         => esc_html__('Active Behaivor', 'lc-addons-kit-for-elementor'),
                    'type'          => \Elementor\Controls_Manager::SELECT,
                    'options'       => [
                        'click' => esc_html__('Click', 'lc-addons-kit-for-elementor'),
                        'hover' => esc_html__('Hover', 'lc-addons-kit-for-elementor'),
                    ],
                    'default'       => 'click',
                    'prefix_class'  => 'lcake-image-accordion-',
                ]
            );
        $this->end_controls_section();

        /** Tab Style (Image accordion General Style) */
      $this->start_controls_section(
        'lcake_img_accordion_general_settings',
        [
          'label' => esc_html__( 'General', 'lc-addons-kit-for-elementor' ),
          'tab' => \Elementor\Controls_Manager::TAB_STYLE
        ]
      );

      $this->add_responsive_control(
        'lcake_img_accordion_min_height',
        [
            'label' => esc_html__( 'Min Height', 'lc-addons-kit-for-elementor' ),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],

            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 1000,
                ],
            ],
            'default' => [
                'unit' => 'px',
                'size' => 460,
            ],
            'selectors' => [
                '{{WRAPPER}} .lcake-single-image-accordion' => 'min-height: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .lcake-image-accordion-wraper' => 'height: {{SIZE}}{{UNIT}};',
            ],
        ]
    );


      $this->add_responsive_control(
        'lcake_img_accordion_gutter',
        [
          'label' => esc_html__( 'Gutter', 'lc-addons-kit-for-elementor' ),
          'type' => \Elementor\Controls_Manager::SLIDER,
          'range' => [
            'px' => [
                'min' => 0,
                'max' => 100,
            ],
          ],
          'selectors' => [
              '{{WRAPPER}} .lcake-image-accordion-wraper .lcake-single-image-accordion' => 'margin-left: {{SIZE}}{{UNIT}}; margin-right: {{SIZE}}{{UNIT}};',
              '{{WRAPPER}} .lcake-image-accordion-wraper' => 'margin-left: -{{SIZE}}{{UNIT}}; margin-right: -{{SIZE}}{{UNIT}};',
          ],
        ]
      );
      
	   $this->add_control(
        'lcake_img_accordion_active_background_text',
        [
          'label' => esc_html__( 'Active Item Background', 'lc-addons-kit-for-elementor' ),
          'type' => \Elementor\Controls_Manager::HEADING,
          'separator' => 'before'
        ]
      );

      $this->add_group_control(
        \Elementor\Group_Control_Background::get_type(),
            array(
                'name'     => 'lcake_img_accordion_bg_active_color',
                'selector' => '{{WRAPPER}} .lcake-single-image-accordion:before',
			)
        );
      $this->add_responsive_control(
        'lcake_img_accordion_container_padding',
        [
          'label' => esc_html__( 'Padding', 'lc-addons-kit-for-elementor' ),
          'type' => \Elementor\Controls_Manager::DIMENSIONS,
          'size_units' => [ 'px', 'em', '%' ],
		  'separator' => 'before',
          'selectors' => [
              '{{WRAPPER}} .lcake-image-accordion-wraper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
          ],
        ]
      );

      $this->add_responsive_control(
        'lcake_img_accordion_container_margin',
        [
          'label' => esc_html__( 'Margin', 'lc-addons-kit-for-elementor' ),
          'type' => \Elementor\Controls_Manager::DIMENSIONS,
          'size_units' => [ 'px', 'em', '%' ],
          'selectors' => [
              '{{WRAPPER}} .lcake-image-accordion-wraper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
          ],
        ]
      );
      $this->add_group_control(
        \Elementor\Group_Control_Border::get_type(),
        [
          'name' => 'lcake_img_accordion_border_group',
          'label' => esc_html__( 'Border', 'lc-addons-kit-for-elementor' ),
          'selector' => '{{WRAPPER}} .lcake-image-accordion-wraper',
        ]
      );

      $this->add_control(
        'lcake_img_accordion_border_radius',
        [
          'label' => esc_html__( 'Border Radius', 'lc-addons-kit-for-elementor' ),
          'type' => \Elementor\Controls_Manager::SLIDER,
          'range' => [
            'px' => [
              'max' => 500,
            ],
          ],
          'selectors' => [
            '{{WRAPPER}} .lcake-image-accordion-wraper' => 'border-radius: {{SIZE}}px;',
          ],
        ]
      );
      $this->add_group_control(
        \Elementor\Group_Control_Box_Shadow::get_type(),
        [
          'name' => 'lcake_img_accordion_shadow',
          'selector' => '{{WRAPPER}} .lcake-image-accordion-wraper',
        ]
      );

      $this->end_controls_section();


        /** Tab Style (Image accordion Content Style) */
        $this->start_controls_section(
            'lcake_img_accordion_section_img_accordion_title_settings',
            [
            'label' => esc_html__( 'Title', 'lc-addons-kit-for-elementor' ),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'lcake_img_accordion_section_img_accordion_icon_title',
            [
                'label' => esc_html_x( 'Margin', 'Border Control', 'lc-addons-kit-for-elementor' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'default' => [
					'top' => '0',
					'bottom' => '20',
					'left' => '0',
					'right' => '0',
					'unit' => 'px',
				],
                'selectors' => [
                    '{{WRAPPER}} .lcake-single-image-accordion .lcake-accordion-title-wraper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'lcake_img_accordion_section_img_accordion_title_icon_spacing',
            [
                'label' => esc_html_x( 'Title Icon Spacing', 'Border Control', 'lc-addons-kit-for-elementor' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .lcake-single-image-accordion .lcake-accordion-title-wraper .icon-title > i, {{WRAPPER}} .lcake-single-image-accordion .lcake-accordion-title-wraper .icon-title > svg' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
		$this->add_control(
			'lcake_img_accordion_title_color',
			[
			  'label' => esc_html__( 'Color', 'lc-addons-kit-for-elementor' ),
			  'type' => \Elementor\Controls_Manager::COLOR,
			  'default' => '#fff',
			  'selectors' => [
                '{{WRAPPER}} .lcake-image-accordion-wraper .lcake-accordion-title-wraper .lcake-accordion-title ' => 'color: {{VALUE}};',
                '{{WRAPPER}} .lcake-image-accordion-wraper .lcake-accordion-title-wraper .lcake-accordion-title svg path' => 'stroke: {{VALUE}}; fill: {{VALUE}};',
			  ],
			]
          );
          
          $this->add_responsive_control(
            'lcake_img_accordion_title_icon_size',
            [
                'label' => esc_html__( 'Icon Size', 'lc-addons-kit-for-elementor' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 100,
                        'step' => 5,
                    ],
                    '%' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .lcake-image-accordion-wraper .lcake-accordion-title-wraper .lcake-accordion-title i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .lcake-image-accordion-wraper .lcake-accordion-title-wraper .lcake-accordion-title svg' => 'max-width: {{SIZE}}{{UNIT}}; height: auto',
                ],
            ]
        );

		  $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
			  'name' => 'lcake_img_accordion_title_typography_group',
			  'selector' => '{{WRAPPER}} .lcake-image-accordion-wraper .lcake-accordion-title-wraper .lcake-accordion-title',
			]
		  );

      $this->end_controls_section();

        /** Tab Style (Image accordion Content Style) */
        $this->start_controls_section(
            'lcake_img_accordion_section_img_accordion_content_settings',
            [
            'label' => esc_html__( 'Content', 'lc-addons-kit-for-elementor' ),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE
            ]
        );
        $this->add_responsive_control(
            'lcake_img_accordion_section_img_accordion_content_align',
            [
                'label' =>esc_html__( 'Alignment', 'lc-addons-kit-for-elementor' ),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left'    => [
                        'title' =>esc_html__( 'Left', 'lc-addons-kit-for-elementor' ),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' =>esc_html__( 'Center', 'lc-addons-kit-for-elementor' ),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' =>esc_html__( 'Right', 'lc-addons-kit-for-elementor' ),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .lcake-single-image-accordion .lcake-accordion-content' => 'text-align: {{VALUE}};'
                ],
                'default' => 'center',
            ]
        );
        $this->add_responsive_control(
            'lcake_img_accordion_section_img_accordion_content_padding',
            [
                'label' =>esc_html__( 'Padding', 'lc-addons-kit-for-elementor' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .lcake-single-image-accordion .lcake-accordion-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'lcake_img_accordion_section_img_accordion_content_position',
            [
                'label' => esc_html__( 'Vertical Position', 'lc-addons-kit-for-elementor' ),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'label_block' => false,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__( 'Top', 'lc-addons-kit-for-elementor' ),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'lc-addons-kit-for-elementor' ),
                        'icon' => 'eicon-v-align-middle',
                    ],
                    'flex-end' => [
                        'title' => esc_html__( 'Bottom', 'lc-addons-kit-for-elementor' ),
                        'icon' => 'eicon-v-align-bottom',
                    ],
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .lcake-image-accordion-wraper .lcake-single-image-accordion' => 'align-items: {{VALUE}}',
                ],
            ]
        );


      $this->end_controls_section();

        // Button
        $this->start_controls_section(
            'lcake_img_accordion_button_style_settings',
            [
                'label' => esc_html__( 'Button', 'lc-addons-kit-for-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'lcake_img_accordion_text_padding',
            [
                'label' =>esc_html__( 'Padding', 'lc-addons-kit-for-elementor' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'default' => [
                    'top' => 15,
                    'right' => 20,
                    'bottom' => 15,
                    'left' => 20,
                    'unit' => 'px',
                    'isLinked' => true,
                ],
                'selectors' => [
                    '{{WRAPPER}} .lcake-accordion-content .lcake-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'lcake_img_accordion_btn_typography',
                'label' =>esc_html__( 'Typography', 'lc-addons-kit-for-elementor' ),
                'selector' => '{{WRAPPER}} .lcake-accordion-content .lcake-btn',
            ]
        );

        $this->start_controls_tabs( 'lcake_img_accordion_tabs_button_style' );

        $this->start_controls_tab(
            'lcake_img_accordion_tab_button_normal',
            [
                'label' =>esc_html__( 'Normal', 'lc-addons-kit-for-elementor' ),
            ]
        );

        $this->add_control(
            'lcake_img_accordion_btn_text_color',
            [
                'label' =>esc_html__( 'Text Color', 'lc-addons-kit-for-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .lcake-accordion-content .lcake-btn' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            array(
                'name'     => 'lcake_img_accordion_btn_bg_color_group',
				'label' => esc_html__( 'Background', 'lc-addons-kit-for-elementor' ),
                'selector' => '{{WRAPPER}} .lcake-accordion-content .lcake-btn',
				'fields_options' => [
                    'background' => [
						'color' => [
								'default' => '#fff'
							],
                    ],

				],

            )
        );

		$this->add_control(
            'lcake_img_accordion_btn_border_color',
            [
                'label' => esc_html__( 'Border', 'lc-addons-kit-for-elementor' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',

            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'lcake_img_accordion_btn_border_group',
                'label' => esc_html__( 'Border', 'lc-addons-kit-for-elementor' ),
                'selector' => '{{WRAPPER}} .lcake-accordion-content .lcake-btn',
				'fields_options' => [
                    'border' => [
                        'default' => 'solid',
                    ],
                    'width' => [
                        'default' => [
                            'top' => '1',
                            'right' => '1',
                            'bottom' => '1',
                            'left' => '1',
                            'unit' => 'px'
                        ],
                    ],
                    'color' => [
                        'default' => '#ffffff',
                    ],
                ],
            ]
        );
        $this->add_control(
            'lcake_img_accordion_btn_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'lc-addons-kit-for-elementor' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
				'default' => ['top' => '5', 'bottom' => '5', 'left' => '5', 'right' => '5', 'unit' => 'px'],
                'selectors' => [
                    '{{WRAPPER}} .lcake-accordion-content .lcake-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'lcake_img_accordion_btn_tab_button_hover',
            [
                'label' =>esc_html__( 'Hover', 'lc-addons-kit-for-elementor' ),
            ]
        );

        $this->add_control(
            'lcake_img_accordion_btn_hover_color',
            [
                'label' =>esc_html__( 'Text Color', 'lc-addons-kit-for-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .lcake-accordion-content .lcake-btn:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            array(
                'name'     => 'lcake_img_accordion_btn_bg_hover_color_group',
                'selector' => '{{WRAPPER}} .lcake-accordion-content .lcake-btn:hover',
            )
        );
        $this->add_control(
            'lcake_img_accordion_btn_border_color_hover',
            [
                'label' => esc_html__( 'Border', 'lc-addons-kit-for-elementor' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'lcake_img_accordion_btn_border_hover_group',
                'label' => esc_html__( 'Border', 'lc-addons-kit-for-elementor' ),
                'selector' => '{{WRAPPER}} .lcake-accordion-content .lcake-btn:hover',
            ]
        );
        $this->add_control(
            'btn_border_radius_hover',
            [
                'label' => esc_html__( 'Border Radius', 'lc-addons-kit-for-elementor' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .lcake-accordion-content .lcake-btn:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
        // PopUp

        $this->start_controls_section(
            'lcake_img_accordion_style_section',
            [
                'label' => esc_html__( 'Action Icon', 'lc-addons-kit-for-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'actions_width',
            [
                'label'     => esc_html__( 'Width', 'lc-addons-kit-for-elementor' ),
                'type'      => \Elementor\Controls_Manager::SLIDER,
                'selectors' => [
                    '{{WRAPPER}} .lcake-image-accordion-actions > a' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->add_control(
            'lcake_img_accordion_section_img_accordion_icon_left_spacing',
            [
                'label' => esc_html__( 'Icon Left Spacing', 'lc-addons-kit-for-elementor' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .lcake-single-image-accordion .lcake-icon-wraper > a:not(:last-child)' => 'margin-right: {{SIZE}}px',
                ],
            ]
        );

        $this->add_control(
            'lcake_img_accordion_section_img_accordion_icon_spacing',
            [
                'label' => esc_html_x( 'Icon Container Spacing', 'Border Control', 'lc-addons-kit-for-elementor' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .lcake-single-image-accordion .lcake-icon-wraper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'actions_border_width',
            [
                'label'         => esc_html__( 'Border Width', 'lc-addons-kit-for-elementor' ),
                'type'          => \Elementor\Controls_Manager::NUMBER,
                'placeholder'   => '1',
                'selectors'     => [
                    '{{WRAPPER}} .lcake-image-accordion-actions > a' => 'border-width: {{VALUE}}px;',
                ],
            ]
        );

        $this->start_controls_tabs('lcake_img_accordion_pup_up_style_tabs');

        $this->start_controls_tab(
            'lcake_img_accordion_pupup_normal_tab',
            [
                'label' => esc_html__( 'Normal', 'lc-addons-kit-for-elementor' ),
            ]
        );
        $this->add_control(
            'lcake_img_accordion_pup_up_icon_color',
            [
                'label' => esc_html__( 'Popup Icon Color', 'lc-addons-kit-for-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lcake-icon-wraper a:first-child' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .lcake-icon-wraper a:first-child svg path' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'lcake_img_accordion_pup_up_project_color',
            [
                'label' => esc_html__( 'Link Icon Color', 'lc-addons-kit-for-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lcake-icon-wraper a:last-child' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .lcake-icon-wraper a:last-child svg path'   => 'fill: {{VALUE}};',
                ],
            ]
        );

            $this->add_control(
                'action_btn_bg',
                [
                    'label'     => esc_html__( 'Background Color', 'lc-addons-kit-for-elementor' ),
                    'type'      => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .lcake-image-accordion-actions > a' => 'background-color: {{VALUE}}; border-color: {{VALUE}};',
                    ],
                ]
            );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'lcake_img_accordion_pup_up_hover_tab',
            [
                'label' => esc_html__( 'Hover', 'lc-addons-kit-for-elementor' ),
            ]
        );

        $this->add_control(
            'lcake_img_accordion_pup_up_icon_color_hover',
            [
                'label' => esc_html__( 'Popup Icon color', 'lc-addons-kit-for-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lcake-icon-wraper a:first-child:hover' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .lcake-icon-wraper a:first-child:hover svg path'   => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'lcake_img_accordion_pup_up_project_color_hover',
            [
                'label' => esc_html__( 'Link Icon color', 'lc-addons-kit-for-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lcake-icon-wraper a:last-child:hover' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .lcake-icon-wraper a:last-child:hover svg path'   => 'fill: {{VALUE}};',
                ],
            ]
        );

            $this->add_control(
                'action_btn_bg_hover',
                [
                    'label'     => esc_html__( 'Background Color (Hover)', 'lc-addons-kit-for-elementor' ),
                    'type'      => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .lcake-image-accordion-actions > a:hover' => 'background-color: {{VALUE}}; border-color: {{VALUE}};',
                    ],
                ]
            );

        $this->end_controls_tab();

        $this->end_controls_tabs();

      $this->end_controls_section();

    }

    protected function render( ) {
        echo '<div class="lcake-wid-con" >';
            $this->render_raw();
        echo '</div>';
    }

	protected function render_raw( ) {
		$settings = $this->get_settings_for_display();
		extract($settings);
		?>
		<div class="lcake-image-accordion lcake-image-accordion-wraper">
			<?php foreach ( $lcake_img_accordion_items as $key => $item ) :

				$this->add_render_attribute( 'wrap-input-' . $key,[
					'type' => 'radio',
					'name' => 'lcake_ia_' . $this->get_id(),
					'id' => 'lcake_ia_' . $this->get_id() .'_'. $key,
					'class' => 'lcake-single-image-accordion--input',
				] );

				if($item['lcake_img_accordion_active'] == 'yes') {
					$this->add_render_attribute( 'wrap-input-' . $key, 'checked', 'checked' );
				}

				$this->add_render_attribute( 'wrap-link-' . $key, [
					'for' => 'lcake_ia_' . $this->get_id() .'_'. $key,
					'class' => 'lcake-single-image-accordion lcake-image-accordion-item',
					'style' => 'background-image: url('.esc_url($item['lcake_img_accordion_bg']['url']).')',
				] );

				// enabling wrap link
				if(isset($item['lcake_img_accordion_enable_wrap_link']) && $item['lcake_img_accordion_enable_wrap_link'] == 'yes') {
					$wrap_link = $item['lcake_img_accordion_wrap_link_url'] ?? [];
					$wrap_link['url'] = !empty($wrap_link['url']) ? esc_url($wrap_link['url']) : '';

					$this->add_render_attribute( 'wrap-link-' . $key, 'data-link', wp_json_encode($wrap_link) );
					$this->add_render_attribute( 'wrap-link-' . $key, 'data-behavior', $active_behavior );
					$this->add_render_attribute( 'wrap-link-' . $key, 'data-active', $item['lcake_img_accordion_active'] );
				}
                ?>
                <input <?php $this->print_render_attribute_string( 'wrap-input-' . $key ); ?> hidden>
                <label <?php $this->print_render_attribute_string( 'wrap-link-' . $key ); ?>>
                    <span class="lcake-accordion-content">
						<?php if($item['lcake_img_accordion_enable_pupup'] == 'yes' || $item['lcake_img_accordion_enable_project_link'] == 'yes') {
							if (!empty($item['lcake_img_accordion_project_link']['url'])) {
								$this->add_link_attributes( 'projectlink', $item['lcake_img_accordion_project_link'] );
							}
							?>
							<span class="lcake-icon-wraper lcake-image-accordion-actions">
							<?php if($item['lcake_img_accordion_enable_pupup'] == 'yes') { 

								$this->add_lightbox_data_attributes( 'link' . $key, 
									$item['lcake_img_accordion_bg']['id'], 
									$item['lcake_img_accordion_enable_pupup'], 
									$this->get_id() 
								);

								$this->add_render_attribute( 'link' . $key, 
									[
										'href' =>  esc_url($item['lcake_img_accordion_bg']['url']),
										'aria-label' => "pupup-button", 
										'class' => "icon-outline circle",
									]
								);
								?>
									<a <?php $this->print_render_attribute_string( 'link' . $key ); ?>>
									<?php 
										$migrated = isset( $item['__fa4_migrated']['lcake_img_accordion_pup_up_icons'] );
										// Check if its a new widget without previously selected icon using the old Icon control
										$is_new = empty( $item['lcake_img_accordion_pup_up_icon'] );
										if ( $is_new || $migrated ) {

											// new icon
											\Elementor\Icons_Manager::render_icon( $item['lcake_img_accordion_pup_up_icons'], [ 'aria-hidden' => 'true'] );
										} else {
											?>
											<i class="<?php echo esc_attr($item['lcake_img_accordion_pup_up_icon']); ?>" aria-hidden="true"></i>
											<?php
										}
									?>
									</a>
							<?php } ?>
							<?php if($item['lcake_img_accordion_enable_project_link'] == 'yes' && ! empty( $item['lcake_img_accordion_project_link']['url'] ) ) {
									$this->add_link_attributes( 'button-2' . $key, $item['lcake_img_accordion_project_link'] );
									$this->add_render_attribute( 'button-2' . $key, ['role' => "link", 'aria-label' => "button-link"] );
								?>
									<a <?php $this->print_render_attribute_string( 'button-2' . esc_attr($key) ); ?> class="icon-outline circle">
									<?php
										$migrated = isset( $item['__fa4_migrated']['lcake_img_accordion_project_link_icons'] );
										// Check if its a new widget without previously selected icon using the old Icon control
										$is_new = empty( $item['lcake_img_accordion_project_link_icon'] );
										if ( $is_new || $migrated ) {

											// new icon
											\Elementor\Icons_Manager::render_icon( $item['lcake_img_accordion_project_link_icons'], [ 'aria-hidden' => 'true'] );
										} else {
											?>
											<i class="<?php echo esc_attr($item['lcake_img_accordion_project_link_icon']); ?>" aria-hidden="true"></i>
											<?php
										}
									?>
									</a>
								<?php } ?>
							</span>
							<?php } ?>
							<span class="lcake-accordion-title-wraper">
								<span class="lcake-accordion-title <?php echo esc_attr($item['lcake_img_accordion_title_icons'] != '') ? 'icon-title' : ''?>">
								<?php if($item['lcake_img_accordion_enable_icon']  == 'yes'): ?>
									<?php if($item['lcake_img_accordion_title_icon_position'] == 'left'): ?>
										<!-- same-1 -->
										<?php

											$migrated = isset( $item['__fa4_migrated']['lcake_img_accordion_title_icons'] );
											// Check if its a new widget without previously selected icon using the old Icon control
											$is_new = empty( $item['lcake_img_accordion_title_icon'] );
											if ( $is_new || $migrated ) {

												// new icon
												\Elementor\Icons_Manager::render_icon( $item['lcake_img_accordion_title_icons'], [ 'aria-hidden' => 'true'] );
											} else {
												?>
												<i class="<?php echo esc_attr($item['lcake_img_accordion_title_icon']); ?>" aria-hidden="true"></i>
												<?php
											}
										?>
									<?php endif; ?>
								<?php endif; ?>

								<?php echo esc_html($item['lcake_img_accordion_title']); ?>

								<?php if($item['lcake_img_accordion_enable_icon']  == 'yes'): ?>
									<?php if($item['lcake_img_accordion_title_icon_position'] == 'right'): ?>
										<!-- same-1 -->
										<?php

											$migrated = isset( $item['__fa4_migrated']['lcake_img_accordion_title_icons'] );
											// Check if its a new widget without previously selected icon using the old Icon control
											$is_new = empty( $item['lcake_img_accordion_title_icon'] );
											if ( $is_new || $migrated ) {

												// new icon
												\Elementor\Icons_Manager::render_icon( $item['lcake_img_accordion_title_icons'], [ 'aria-hidden' => 'true'] );
											} else {
												?>
												<i class="<?php echo esc_attr($item['lcake_img_accordion_title_icon']); ?>" aria-hidden="true"></i>
												<?php
											}
										?>
									<?php endif; ?>
								<?php endif; ?>
								</span>
							</span>
							<?php if($item['lcake_img_accordion_enable_button'] == 'yes') :
							if ( ! empty( $item['lcake_img_accordion_button_url']['url'] ) ) {
								$this->add_link_attributes( 'button-' . $key, $item['lcake_img_accordion_button_url'] );
							}
							?>
							<span class="lcake-btn-wraper">
								<a class="lcake-image-accordion--btn lcake-btn whitespace--normal" <?php $this->print_render_attribute_string( 'button-' . esc_attr($key) ); ?>>
									<?php echo esc_html($item['lcake_img_accordion_button_label']); ?>
								</a>
							</span>
						<?php endif; ?>
                    </span>
                </label>
            <?php endforeach; ?>
        </div>
    <?php }
} 