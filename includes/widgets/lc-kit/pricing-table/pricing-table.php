<?php
/**
 * Pricing Table Widget
 * 
 * @package LC_Elementor_Addons_Kit
 */

if (!defined('ABSPATH')) {
    exit;
}

class LCAKE_Kit_Pricing_Table extends \Elementor\Widget_Base {

    public function get_name() {
        return 'lcake-kit-pricing-table';
    }

    public function get_title() {
        return esc_html__('LC Pricing Table', 'lc-addons-kit-for-elementor');
    }

    public function get_icon() {
        return 'eicon-price-table';
    }

    public function get_categories() {
        return ['lcake-page-kit'];
    }

    public function get_keywords() {
        return ['pricing', 'table', 'price', 'plan', 'subscription', 'billing'];
    }

    public function get_style_depends() {
        return ['lcake-kit-pricing-table'];
    }

    protected function register_controls() {

        $this->start_controls_section(
            'lcake_pricing_pricing_plan',
            [
                'label' => esc_html__('Header', 'lc-addons-kit-for-elementor'),
            ]
        );


        $this->add_control(
			'lcake_pricing_table_title', [
				'type' => \Elementor\Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
                'label' => esc_html__('Table Title', 'lc-addons-kit-for-elementor'),
                'default'   =>  esc_html__('Starter','lc-addons-kit-for-elementor'),
				'label_block' => true,
			]
		);
		$this->add_control(
            'lcake_pricing_title_size',
            [
                'label' => esc_html__( 'Title HTML Tag', 'lc-addons-kit-for-elementor' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'h1' => 'H1',
                    'h2' => 'H2',
                    'h3' => 'H3',
                    'h4' => 'H4',
                    'h5' => 'H5',
                    'h6' => 'H6',
                    'div' => 'div',
                    'span' => 'span',
                    'p' => 'p',
                ],
                'default' => 'h3',
                'separator' => 'after',
            ]
        );
        $this->add_control(
			'lcake_pricing_table_subtitle', [
				'type' => \Elementor\Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
                'label' => esc_html__('Table Subtitle', 'lc-addons-kit-for-elementor'),
                'default'   =>  esc_html__('A small river named Duden flows by their place and supplies','lc-addons-kit-for-elementor'),
				'label_block' => true,
			]
		);
		$this->add_control(
            'lcake_pricing_icon_type',
            [
                'label' => esc_html__( 'Header Icon or Image? ', 'lc-addons-kit-for-elementor' ),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'none' => [
                        'title' => esc_html__( 'None', 'lc-addons-kit-for-elementor' ),
                        'icon' => 'fa fa-stop-circle',
					],
					'icon' => [
                        'title' => esc_html__( 'Icon', 'lc-addons-kit-for-elementor' ),
                        'icon' => 'fa fa-star',
                    ],
                    'image' => [
                        'title' => esc_html__( 'Image', 'lc-addons-kit-for-elementor' ),
                        'icon' => 'fa fa-image',
                    ],
                ],
				'default' => 'none',
				'separator' => 'before',
				'toggle' => true,
            ]
		);
		
		$this->add_control(
            'lcake_pricing_switch_icon',
            [
                'label' => esc_html__('Add icon? ', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
                'label_on' =>esc_html__( 'Yes', 'lc-addons-kit-for-elementor' ),
				'label_off' =>esc_html__( 'No', 'lc-addons-kit-for-elementor' ),
				'condition' => [
                    'lcake_pricing_icon_type' => 'icon',
                ]
            ]
		);

        $this->add_control(
            'lcake_pricing_icons',
            [
                'label' => esc_html__( 'Icon', 'lc-addons-kit-for-elementor' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'fa4compatibility' => 'lcake_pricing_icon',
                'default' => [
                    'value' => 'fab fa-amazon',
                    'library' => 'brands',
                ],
                'condition' => [
					'lcake_pricing_icon_type' => 'icon',
					'lcake_pricing_switch_icon'	=> 'yes'
                ]
            ]
        );

        $this->add_control(
            'lcake_pricing_image',
            [
                'label' => esc_html__( 'Choose Image', 'lc-addons-kit-for-elementor' ),
                'type' => \Elementor\Controls_Manager::MEDIA,
				'dynamic' => [
					'active' => true,
				],
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                    'id'    => -1
                ],
                'condition' => [
                    'lcake_pricing_icon_type' => 'image',
				],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Image_Size::get_type(),
            [
                'name' => 'lcake_pricing_thumbnail',
                'default' => 'thumbnail',
                'separator' => 'none',
                'condition' => [
                    'lcake_pricing_icon_type' => 'image',
                ]
            ]
        );
		$this->end_controls_section();
        $this->start_controls_section(
            'lcake_pricing_pricing_tag',
            [
                'label' => esc_html__('Price Tag', 'lc-addons-kit-for-elementor'),
            ]
        );

	    $this->add_control(
			'lcake_pricing_currency_icon', [
				'type' => \Elementor\Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
                'label' => esc_html__('Currency', 'lc-addons-kit-for-elementor'),
				'default'   => '$',
			]
		);
        $this->add_control(
			'lcake_pricing_table_price', [
				'type' => \Elementor\Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
                'label' => esc_html__('Price', 'lc-addons-kit-for-elementor'),
				'default'   => esc_html__('5.99', 'lc-addons-kit-for-elementor'),
			]
		);
        $this->add_control(
			'lcake_pricing_table_duration', [
				'type' => \Elementor\Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
                'label' => esc_html__('Duration', 'lc-addons-kit-for-elementor'),
				'default'   => esc_html__('Month', 'lc-addons-kit-for-elementor'),
			]
		);
		$this->end_controls_section();
        $this->start_controls_section(
            'lcake_pricing_features_tab',
            [
                'label' =>esc_html__('Features', 'lc-addons-kit-for-elementor'),
            ]
        );
        $this->add_control(
            'lcake_pricing_content_style',
            [
                'label' => esc_html__( 'Features style', 'lc-addons-kit-for-elementor' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'paragraph',
                'options' => [
                    'paragraph'  => esc_html__( 'Paragraph', 'lc-addons-kit-for-elementor' ),
                    'list' => esc_html__( 'List', 'lc-addons-kit-for-elementor' ),
                ],
            ]
        );

        $this->add_control(
			'lcake_pricing_table_content', [
                'type' => \Elementor\Controls_Manager::TEXTAREA,
				'dynamic' => [
					'active' => true,
				],
                'label' => esc_html__('Table Content', 'lc-addons-kit-for-elementor'),
				'label_block' => true,
				'default' => esc_html__('Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam','lc-addons-kit-for-elementor'),
                'condition' => [
                    'lcake_pricing_content_style' => 'paragraph',
				],
			]
        );
		$repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'lcake_pricing_list', [
                'label' => esc_html__('List text', 'lc-addons-kit-for-elementor'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'default' => esc_html__( '15 Email Account' , 'lc-addons-kit-for-elementor' ),
				'label_block' => true,
            ]
        );

        $repeater->add_control(
            'lcake_pricing_check_icons', [
				'label' =>esc_html__( 'Icon', 'lc-addons-kit-for-elementor' ),
				'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => '',
                ],
				'label_block' => true,
            ]
        );

        $repeater->add_control(
            'lcake_pricing_list_icon_color', [
				'label' =>esc_html__( 'Icon Color', 'lc-addons-kit-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .lcake-single-pricing .lcake-pricing-lists {{CURRENT_ITEM}} > :is(i, svg)' => 'color: {{VALUE}}; fill: {{VALUE}};',
				],
            ]
		);
		
		$repeater->add_responsive_control(
            'lcake_pricing_list_content_typography_group',
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
                    '{{WRAPPER}} .lcake-single-pricing .lcake-pricing-lists {{CURRENT_ITEM}} > :is(i, svg)' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

		$repeater->add_control(
			'lcake_pricing_list_info',
			[
				'label'	=> esc_html__( 'Info Text', 'lc-addons-kit-for-elementor' ),
				'type'	=> \Elementor\Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$repeater->add_control(
			'lcake_pricing_list_info_icon_color',
			[
				'label' =>esc_html__( 'Info Icon Color', 'lc-addons-kit-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .lcake-pricing-list-info :is(i, svg)' => 'color: {{VALUE}}; fill: {{VALUE}};',
				],
				'condition' => [
					'lcake_pricing_list_info!' => '',
				],
			]
		);

        $this->add_control(
            'lcake_pricing_table_content_repeater',
            [
                'label' => esc_html__( 'Pricing Content List', 'lc-addons-kit-for-elementor' ),
                'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'title_field' => '{{lcake_pricing_list}}',
                'default' => [
                    [
                        'item' => esc_html__( '15 Email Account', 'lc-addons-kit-for-elementor' ),
                        'check_icon' => 'icon icon-tick',
                    ],
                    [
						'item' => esc_html__( '100 GB Space', 'lc-addons-kit-for-elementor' ),
						'check_icon' => 'icon icon-tick',
                    ],
                    [
						'item' => esc_html__( '1 Domain Name', 'lc-addons-kit-for-elementor' ),
						'check_icon' => 'icon icon-tick',
                    ],
                ],
                'title_field' => '{{{ lcake_pricing_list }}}',
                'condition' => [
                    'lcake_pricing_content_style' => 'list',
				],
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'lcake_pricing_button_style_tab',
            [
                'label' =>esc_html__('Button', 'lc-addons-kit-for-elementor'),
            ]
        );
        $this->add_control(
			'lcake_pricing_btn_text',
			[
				'label' =>esc_html__( 'Label', 'lc-addons-kit-for-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'default' =>esc_html__( 'Learn more ', 'lc-addons-kit-for-elementor' ),
				'placeholder' =>esc_html__( 'Learn more ', 'lc-addons-kit-for-elementor' ),
			]
		);

		$this->add_control(
			'lcake_pricing_btn_link',
			[
				'label' =>esc_html__( 'Link', 'lc-addons-kit-for-elementor' ),
				'type' => \Elementor\Controls_Manager::URL,
				'dynamic' => [
					'active' => true,
				],
				'placeholder' =>esc_url('https://wpmet.com'),
				'default' => [
					'url' => '#',
				],
			]
		);

		$this->add_control(
            'lcake_pricing_btn_icons__switch',
            [
                'label' => esc_html__('Add icon? ', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
                'label_on' =>esc_html__( 'Yes', 'lc-addons-kit-for-elementor' ),
                'label_off' =>esc_html__( 'No', 'lc-addons-kit-for-elementor' ),
            ]
		);

		$this->add_control(
			'lcake_pricing_btn_icons',
			[
				'label' =>esc_html__( 'Icon', 'lc-addons-kit-for-elementor' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'fa4compatibility' => 'lcake_pricing_btn_icon',
                'default' => [
                    'value' => '',
                ],
				'label_block' => true,
				'condition'		=> [
					'lcake_pricing_btn_icons__switch'	=> 'yes'
				]
			]
		);

		$this->add_control(
			'lcake_pricing_icon_align',
			[
				'label' =>esc_html__( 'Icon Position', 'lc-addons-kit-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'left',
				'options' => [
					'left' =>esc_html__( 'Before', 'lc-addons-kit-for-elementor' ),
					'right' =>esc_html__( 'After', 'lc-addons-kit-for-elementor' ),
				],
				'condition' => [
					'lcake_pricing_btn_icons__switch'	=> 'yes'
				],
			]
		);

		$this->add_responsive_control(
            'lcake_pricing_icon_spacing',
            [
                'label' => esc_html__( 'Icon Spacing', 'lc-addons-kit-for-elementor' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'default' => [
                    'size' => 10,
                    'unit' => 'px',
                ],
                'range' => [
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .lcake-single-pricing a.lcake-pricing-btn-icon-pos-left i' => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .lcake-single-pricing a.lcake-pricing-btn-icon-pos-right i' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .lcake-single-pricing a.lcake-pricing-btn-icon-pos-left svg' => 'margin-right: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .lcake-single-pricing a.lcake-pricing-btn-icon-pos-right svg' => 'margin-left: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'lcake_pricing_btn_icons__switch'	=> 'yes'
                ],
            ]
        );

	    $this->add_control(
		    'lcake_pricing_button_class',
		    [
			    'label' => esc_html__( 'Class', 'lc-addons-kit-for-elementor' ),
			    'type' => \Elementor\Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
			    'placeholder' => esc_html__( 'Class Name', 'lc-addons-kit-for-elementor' ),
		    ]
	    );

	    $this->add_control(
		    'lcake_pricing_button_id',
		    [
			    'label' => esc_html__( 'id', 'lc-addons-kit-for-elementor' ),
			    'type' => \Elementor\Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
			    'placeholder' => esc_html__( 'ID', 'lc-addons-kit-for-elementor' ),
		    ]
	    );


        $this->end_controls_section();


        //Body style start
        $this->start_controls_section(
			'lcake_pricing_section_body_style',
			[
				'label' =>esc_html__( 'Pricing Body', 'lc-addons-kit-for-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'lcake_pricing_pricing_body_bg_sp', [
				'type' => \Elementor\Controls_Manager::COLOR,
                'label' => esc_html__('Background Color', 'lc-addons-kit-for-elementor'),
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .lcake-single-pricing' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'lcake_pricing_pricing_content_align',
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
                    '{{WRAPPER}} .lcake-single-pricing' => 'text-align: {{VALUE}};'
                ],
				'default' => 'center',
			]
		);

		$this->end_controls_section();



        //Price Title style start
        $this->start_controls_section(
			'slcake_pricing_ection_title_style',
			[
				'label' =>esc_html__( 'Table Title', 'lc-addons-kit-for-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_responsive_control(
			'lcake_pricing_title_align',
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
                    '{{WRAPPER}} .lcake-single-pricing .lcake-pricing-header .lcake-pricing-title' => 'text-align: {{VALUE}};'
                ],
				'default' => '',
			]
		);
        $this->start_controls_tabs( 'lcake_pricing_tabs_title_style' );

        $this->start_controls_tab(
            'lcake_pricing_tab_title_normal',
            [
                'label' =>esc_html__( 'Normal', 'lc-addons-kit-for-elementor' ),
            ]
        );
        $this->add_control(
            'lcake_pricing_title_text_color',
            [
                'label' =>esc_html__( 'Title Color', 'lc-addons-kit-for-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .lcake-single-pricing .lcake-pricing-header .lcake-pricing-title' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'lcake_pricing_tab_title_hover',
            [
                'label' =>esc_html__( 'Hover', 'lc-addons-kit-for-elementor' ),
            ]
        );
        $this->add_control(
            'lcake_pricing_title_hover_color',
            [
                'label' =>esc_html__( 'Color', 'lc-addons-kit-for-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}:hover .lcake-pricing-header .lcake-pricing-title' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'lcake_pricing_title_typography_group',
                'label' =>esc_html__( 'Title Typography', 'lc-addons-kit-for-elementor' ),
                'selector' => '{{WRAPPER}} .lcake-single-pricing .lcake-pricing-header .lcake-pricing-title',
            ]
        );
		$this->add_responsive_control(
			'lcake_pricing_title_text_padding',
			[
				'label' =>esc_html__( 'Padding', 'lc-addons-kit-for-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .lcake-single-pricing .lcake-pricing-header .lcake-pricing-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'lcake_pricing_title_wraper_margin',
			[
				'label' =>esc_html__( 'Margin', 'lc-addons-kit-for-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .lcake-single-pricing .lcake-pricing-header' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
        $this->add_control(
			'lcake_pricing_titlehr12',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);

        $this->add_responsive_control(
			'lcake_pricing_title_border_style',
			[
				'label' => esc_html_x( 'Border Type', 'Border Control', 'lc-addons-kit-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'' => esc_html__( 'None', 'lc-addons-kit-for-elementor' ),
					'solid' => esc_html_x( 'Solid', 'Border Control', 'lc-addons-kit-for-elementor' ),
					'double' => esc_html_x( 'Double', 'Border Control', 'lc-addons-kit-for-elementor' ),
					'dotted' => esc_html_x( 'Dotted', 'Border Control', 'lc-addons-kit-for-elementor' ),
					'dashed' => esc_html_x( 'Dashed', 'Border Control', 'lc-addons-kit-for-elementor' ),
					'groove' => esc_html_x( 'Groove', 'Border Control', 'lc-addons-kit-for-elementor' ),
				],
				'selectors' => [
					'{{WRAPPER}} .lcake-single-pricing .lcake-pricing-header .lcake-pricing-title' => 'border-style: {{VALUE}};',
				],
			]
		);
		$this->add_responsive_control(
			'lcake_pricing_title_border_dimensions',
			[
				'label' => esc_html_x( 'Border Width', 'Border Control', 'lc-addons-kit-for-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .lcake-single-pricing .lcake-pricing-header .lcake-pricing-title' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'condition' => [
                    'lcake_pricing_title_border_style!' => '',
                ],

            ]
		);
		$this->start_controls_tabs( 'lcake_pricing_tabs_title_border_style' );
		$this->start_controls_tab(
			'lcake_pricing_title_border_normal',
			[
				'label' =>esc_html__( 'Normal', 'lc-addons-kit-for-elementor' ),
                'condition' => [
                    'lcake_pricing_title_border_style!' => '',
                ],

            ]
		);
		$this->add_control(
			'lcake_pricing_title_border_color',
			[
				'label' => esc_html_x( 'Border Color', 'Border Control', 'lc-addons-kit-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .lcake-single-pricing .lcake-pricing-header .lcake-pricing-title' => 'border-color: {{VALUE}};',
				],
                'condition' => [
                    'lcake_pricing_title_border_style!' => '',
                ],

            ]
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'lcake_pricing_title_tab_border_hover',
			[
				'label' =>esc_html__( 'Hover', 'lc-addons-kit-for-elementor' ),
                'condition' => [
                    'lcake_pricing_title_border_style!' => '',
                ],

            ]
		);
		$this->add_control(
			'lcake_pricing_title_hover_border_color',
			[
				'label' => esc_html_x( 'Border Color', 'Border Control', 'lc-addons-kit-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}}:hover .lcake-single-pricing .lcake-pricing-header .lcake-pricing-title' => 'border-color: {{VALUE}};',
				],
                'condition' => [
                    'lcake_pricing_title_border_style!' => '',
                ],
            ]
		);
		$this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_responsive_control(
			'lcake_pricing_title_border_radius',
			[
				'label' =>esc_html__( 'Border Radius', 'lc-addons-kit-for-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px'],
				'default' => [
					'top' => '',
					'right' => '',
					'bottom' => '' ,
					'left' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .lcake-single-pricing .lcake-pricing-header .lcake-pricing-title' =>  'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'lcake_pricing_title_box_shadow_group',
                'selector' => '{{WRAPPER}} .lcake-single-pricing .lcake-pricing-header .lcake-pricing-title',
            ]
        );
		$this->end_controls_section();

        //Price Subtitle style start
        $this->start_controls_section(
			'lcake_pricing_section_subtitle_style',
			[
				'label' =>esc_html__( 'Table Subtitle', 'lc-addons-kit-for-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'lcake_pricing_table_subtitle!' => '',
                ]
			]
		);
		$this->add_responsive_control(
			'lcake_pricing_subtitle_align',
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
                    '{{WRAPPER}} .lcake-single-pricing .lcake-pricing-header .lcake-pricing-subtitle' => 'text-align: {{VALUE}};'
                ],
                'conditions' => [
                    'terms' => [
                        [
                            'name' => 'lcake_pricing_table_subtitle',
                            'operator' => '!in',
                            'value' => [''],
                        ],
                    ],
                ],
				'default' => '',
			]
		);
        $this->start_controls_tabs( 'lcake_pricing_tabs_subtitle_style' );

        $this->start_controls_tab(
            'lcake_pricing_tab_subtitle_normal',
            [
                'label' =>esc_html__( 'Normal', 'lc-addons-kit-for-elementor' ),
            ]
        );
        $this->add_control(
            'lcake_pricing_subtitle_text_color',
            [
                'label' =>esc_html__( 'Color', 'lc-addons-kit-for-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .lcake-single-pricing .lcake-pricing-header .lcake-pricing-subtitle' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'lcake_pricing_tab_subtitle_hover',
            [
                'label' =>esc_html__( 'Hover', 'lc-addons-kit-for-elementor' ),
            ]
        );
        $this->add_control(
            'lcake_pricing_subtitle_hover_color',
            [
                'label' =>esc_html__( 'Color', 'lc-addons-kit-for-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}:hover .lcake-single-pricing .lcake-pricing-header .lcake-pricing-subtitle' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'lcake_pricing_subtitle_typography_group',
                'label' =>esc_html__( 'Typography', 'lc-addons-kit-for-elementor' ),
                'selector' => '{{WRAPPER}} .lcake-single-pricing .lcake-pricing-header .lcake-pricing-subtitle',
            ]
        );
		$this->add_responsive_control(
			'lcake_pricing_subtitle_text_padding',
			[
				'label' =>esc_html__( 'Padding', 'lc-addons-kit-for-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .lcake-single-pricing .lcake-pricing-header .lcake-pricing-subtitle' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);


        $this->add_responsive_control(
			'lcake_pricing_subtitlehr12',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);

        $this->add_responsive_control(
			'lcake_pricing_subtitle_border_style',
			[
				'label' => esc_html_x( 'Border Type', 'Border Control', 'lc-addons-kit-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'' => esc_html__( 'None', 'lc-addons-kit-for-elementor' ),
					'solid' => esc_html_x( 'Solid', 'Border Control', 'lc-addons-kit-for-elementor' ),
					'double' => esc_html_x( 'Double', 'Border Control', 'lc-addons-kit-for-elementor' ),
					'dotted' => esc_html_x( 'Dotted', 'Border Control', 'lc-addons-kit-for-elementor' ),
					'dashed' => esc_html_x( 'Dashed', 'Border Control', 'lc-addons-kit-for-elementor' ),
					'groove' => esc_html_x( 'Groove', 'Border Control', 'lc-addons-kit-for-elementor' ),
				],
				'selectors' => [
					'{{WRAPPER}} .lcake-single-pricing .lcake-pricing-header .lcake-pricing-subtitle' => 'border-style: {{VALUE}};',
				],
			]
		);
		$this->add_responsive_control(
			'lcake_pricing_subtitle_border_dimensions',
			[
				'label' => esc_html_x( 'Width', 'Border Control', 'lc-addons-kit-for-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .lcake-single-pricing .lcake-pricing-header .lcake-pricing-subtitle' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'condition' => [
                    'lcake_pricing_subtitle_border_style!' => '',
                ],
			]
		);
		$this->start_controls_tabs( 'lcake_pricing_tabs_subtitle_border_style' );
		$this->start_controls_tab(
			'lcake_pricing_subtitle_border_normal',
			[
				'label' =>esc_html__( 'Normal', 'lc-addons-kit-for-elementor' ),
                'condition' => [
                    'lcake_pricing_subtitle_border_style!' => '',
                ],
			]
		);

		$this->add_control(
			'lcake_pricing_subtitle_border_color',
			[
				'label' => esc_html_x( 'Color', 'Border Control', 'lc-addons-kit-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .lcake-single-pricing .lcake-pricing-header .lcake-pricing-subtitle' => 'border-color: {{VALUE}};',
				],
                'condition' => [
                    'lcake_pricing_subtitle_border_style!' => '',
                ],
			]
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'lcake_pricing_subtitle_tab_border_hover',
			[
				'label' =>esc_html__( 'Hover', 'lc-addons-kit-for-elementor' ),
                'condition' => [
                    'lcake_pricing_subtitle_border_style!' => '',
                ],
			]
		);
		$this->add_control(
			'lcake_pricing_subtitle_hover_border_color',
			[
				'label' => esc_html_x( 'Color', 'Border Control', 'lc-addons-kit-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}}:hover .lcake-pricing-header .lcake-pricing-subtitle' => 'border-color: {{VALUE}};',
				],
                'condition' => [
                    'lcake_pricing_subtitle_border_style!' => '',
                ],
			]
		);
		$this->end_controls_tab();
        $this->end_controls_tabs();



        $this->add_control(
			'lcake_pricing_subtitlehr13',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);
        $this->add_responsive_control(
			'lcake_pricing_subtitle_border_radius',
			[
				'label' =>esc_html__( 'Border Radius', 'lc-addons-kit-for-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px'],
				'default' => [
					'top' => '',
					'right' => '',
					'bottom' => '' ,
					'left' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .lcake-single-pricing .lcake-pricing-header .lcake-pricing-subtitle' =>  'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'lcake_pricing_subtitle_box_shadow_group',
                'selector' => '{{WRAPPER}} .lcake-single-pricing .lcake-pricing-header .lcake-pricing-subtitle',
            ]
        );
		$this->end_controls_section();

        //Image Style Start
        $this->start_controls_section(
            'lcake_pricing_style_image',
            [
                'label' => esc_html__( 'Header Image', 'lc-addons-kit-for-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'lcake_pricing_icon_type' => 'image',

                ],
            ]
        );
        $this->add_responsive_control(
            'lcake_pricing_image_space',
            [
                'label' => esc_html__( 'Margin Bottom', 'lc-addons-kit-for-elementor' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'size' => 10,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .lcake-single-pricing .elementor-pricing-img img' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->start_controls_tabs(
            'lcake_pricing_style_tabs_image'
        );

        $this->start_controls_tab(
            'lcake_pricing_style_img_normal_tab',
            [
                'label' => esc_html__( 'Normal', 'lc-addons-kit-for-elementor' ),
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'lcake_pricing_imge_border_group',
                'label' => esc_html__( 'Border', 'lc-addons-kit-for-elementor' ),
                'selector' => '{{WRAPPER}} .lcake-single-pricing .elementor-pricing-img img',
            ]
        );
        $this->add_responsive_control(
            'lcake_pricing_image_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'lc-addons-kit-for-elementor' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .lcake-single-pricing .elementor-pricing-img img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'lcake_pricing_iamge_box_shadow_group',
                'label' => esc_html__( 'Box Shadow', 'lc-addons-kit-for-elementor' ),
                'selector' => '{{WRAPPER}} .lcake-single-pricing .elementor-pricing-img img',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'lcake_pricing_style_img_hover_tab',
            [
                'label' => esc_html__( 'Hover', 'lc-addons-kit-for-elementor' ),
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'lcake_pricing_imge_border_hover_group',
                'label' => esc_html__( 'Border', 'lc-addons-kit-for-elementor' ),
                'selector' => '{{WRAPPER}}:hover .elementor-pricing-img img',
            ]
        );
        $this->add_responsive_control(
            'lcake_pricing_image_hover_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'lc-addons-kit-for-elementor' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .lcake-single-pricing .elementor-pricing-img img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'lcake_pricing_iamge_box_shadow_hv_group',
                'label' => esc_html__( 'Box Shadow', 'lc-addons-kit-for-elementor' ),
                'selector' => '{{WRAPPER}}:hover .elementor-pricing-img img',
            ]
        );

        $this->add_control(
            'lcake_pricing_image_hover_animation',
            [
                'label' => esc_html__( 'Animation', 'lc-addons-kit-for-elementor' ),
                'type' => \Elementor\Controls_Manager::HOVER_ANIMATION,
            ]
        );


        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        //Icon Style Start
        $this->start_controls_section(
            'lcake_pricing_section_style_icon',
            [
                'label' => esc_html__( 'Header Icon', 'lc-addons-kit-for-elementor' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
					'lcake_pricing_switch_icon'	=> 'yes',
                    'lcake_pricing_icon_type' => 'icon',

                ],
            ]
        );

        $this->start_controls_tabs( 'icon_colors' );

        $this->start_controls_tab(
            'lcake_pricing_icon_colors_normal',
            [
                'label' => esc_html__( 'Normal', 'lc-addons-kit-for-elementor' ),
            ]
        );

        $this->add_control(
            'lcake_pricing_icon_primary_color',
            [
                'label' => esc_html__( 'Color', 'lc-addons-kit-for-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
					'{{WRAPPER}} .lcake-single-pricing .elementkit-pricing-icon' => 'color: {{VALUE}};',
					'{{WRAPPER}} .lcake-pricing-header svg path'	=> 'stroke: {{VALUE}}; fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'lcake_pricing_icon_secondary_color_normal',
            [
                'label' => esc_html__( 'BG Color', 'lc-addons-kit-for-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .lcake-single-pricing .elementkit-pricing-icon, {{WRAPPER}} .lcake-pricing-header svg' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'lcake_pricing_border_group',
                'label' => esc_html__( 'Border', 'lc-addons-kit-for-elementor' ),
                'selector' => '{{WRAPPER}} .elementkit-pricing-icon, {{WRAPPER}} .lcake-pricing-header svg',
            ]
        );

        $this->add_responsive_control(
            'lcake_pricing_icon_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'lc-addons-kit-for-elementor' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .lcake-single-pricing .elementkit-pricing-icon, {{WRAPPER}} .lcake-pricing-header svg' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'lcake_pricing_icon_colors_hover',
            [
                'label' => esc_html__( 'Hover', 'lc-addons-kit-for-elementor' ),
            ]
        );

        $this->add_control(
            'lcake_pricing_hover_primary_color',
            [
                'label' => esc_html__( 'Primary Color', 'lc-addons-kit-for-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
					'{{WRAPPER}}:hover .elementkit-pricing-icon' => 'color: {{VALUE}};',
					'{{WRAPPER}}:hover .lcake-pricing-header svg path' => 'stroke: {{VALUE}}; fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'lcake_pricing_hover_secondary_color',
            [
                'label' => esc_html__( 'Secondary Color', 'lc-addons-kit-for-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
					'{{WRAPPER}}:hover .elementkit-pricing-icon, {{WRAPPER}}:hover .lcake-pricing-header svg' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'lcake_pricing_border_icon_group',
                'label' => esc_html__( 'Border', 'lc-addons-kit-for-elementor' ),
                'selector' => '{{WRAPPER}}:hover .elementkit-pricing-icon, {{WRAPPER}}:hover .lcake-pricing-header svg',
                'condition' => [
                    'view!' => 'Stacked',
                ],
            ]
        );
        $this->add_responsive_control(
            'lcake_pricing_icon_hover_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'lc-addons-kit-for-elementor' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}}:hover .elementkit-pricing-icon, {{WRAPPER}}:hover .lcake-pricing-header svg' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'lcake_pricing_icons_hover_animation',
            [
                'label' => esc_html__( 'Hover Animation', 'lc-addons-kit-for-elementor' ),
                'type' =>   \Elementor\Controls_Manager::HOVER_ANIMATION,
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->add_responsive_control(
            'lcake_pricing_icon_size',
            [
                'label' => esc_html__( 'Size', 'lc-addons-kit-for-elementor' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 6,
                        'max' => 300,
                    ],
                ],
                'default' => [
                    'size' => 40,
                    'unit' => 'px',
                ],
                'selectors' => [
					'{{WRAPPER}} .elementkit-pricing-icon' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .lcake-pricing-header svg'	=> 'max-width: {{SIZE}}{{UNIT}};',
                ],
                'separator' => 'before',
            ]
        );
        $this->add_responsive_control(
            'lcake_pricing_icon_space',
            [
                'label' => esc_html__( 'Margin Bottom', 'lc-addons-kit-for-elementor' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -20,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'size' => 15,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementkit-pricing-icon, {{WRAPPER}} .lcake-pricing-header svg' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'lcake_pricing_icon_padding',
            [
                'label' => esc_html__( 'Padding', 'lc-addons-kit-for-elementor' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'size' => 15,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementkit-pricing-icon, {{WRAPPER}} .lcake-pricing-header svg' => 'padding: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'lcake_pricing_rotate',
            [
                'label' => esc_html__( 'Rotate', 'lc-addons-kit-for-elementor' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'default' => [
                    'size' => 0,
                    'unit' => 'deg',
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementkit-pricing-icon, {{WRAPPER}} .lcake-pricing-header svg' => 'transform: rotate({{SIZE}}{{UNIT}});',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'lcake_pricing_icon_box_shadow_group',
                'selector' => '{{WRAPPER}} .elementkit-pricing-icon, {{WRAPPER}} .lcake-pricing-header svg',
            ]
        );

        $this->end_controls_section();

        //Price Tag style start
        $this->start_controls_section(
			'lcake_pricing_section_tag_style',
			[
				'label' =>esc_html__( 'Price Tag', 'lc-addons-kit-for-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'lcake_pricing_tag_right',
			[
				'label' => esc_html__( 'Right', 'lc-addons-kit-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => -200,
						'max' => 200,
						'step' => 1,
					],
					'%' => [
						'min' => -100,
						'max' => 100,
					],
				],
				// 'default' => [
				// 	'unit' => 'px',
				// 	'size' => 0,
				// ],
				'selectors' => [
					'{{WRAPPER}} .lcake-pricing-tag' => 'right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'lcake_pricing_tag_width_width',
			[
				'label' => esc_html__( 'Width', 'lc-addons-kit-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .lcake-pricing-tag' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'lcake_pricing_tag_text_padding',
			[
				'label' =>esc_html__( 'Padding', 'lc-addons-kit-for-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default' => 	[
					'top' => '8',
					'right' => '0',
					'bottom' => '8',
					'left' => '0',
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .lcake-single-pricing .lcake-pricing-price-wraper.has-tag' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'lcake_pricing_tag_text_margin',
			[
				'label' =>esc_html__( 'Margin', 'lc-addons-kit-for-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default' => 	[
					'top' => '0',
					'right' => '0',
					'bottom' => '50',
					'left' => '0',
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .lcake-single-pricing .lcake-pricing-price-wraper.has-tag' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'lcake_pricing_price_typography_group',
				'label' =>esc_html__( 'Typography', 'lc-addons-kit-for-elementor' ),
				'selector' => '{{WRAPPER}} .lcake-single-pricing .lcake-pricing-price-wraper.has-tag .lcake-pricing-price span',
			]
		);
		$this->add_control(
			'lcake_pricing_heading_period_style',
			[
				'label' => esc_html__( 'Duration', 'lc-addons-kit-for-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_control(
			'lcake_pricing_period_text_color',
			[
				'label' =>esc_html__( 'Text Color', 'lc-addons-kit-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .lcake-single-pricing .lcake-pricing-price-wraper.has-tag .lcake-pricing-price .period' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'lcake_pricing_period_text_color_hover',
			[
				'label' =>esc_html__( 'Text Hover Color', 'lc-addons-kit-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}}:hover .lcake-pricing-price-wraper.has-tag .lcake-pricing-price .period' => 'color: {{VALUE}};',
				],
			]
		);

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'lcake_pricing_period_typography_group',
                'label' =>esc_html__( 'Typography', 'lc-addons-kit-for-elementor' ),
                'selector' => '{{WRAPPER}} .lcake-single-pricing .lcake-pricing-price-wraper.has-tag .lcake-pricing-price sub.period',
            ]
        );
		$this->add_responsive_control(
			'lcake_pricing_period_vertical_position',
			[
				'label' => esc_html__( 'Vertical Position', 'lc-addons-kit-for-elementor' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'label_block' => false,
				'options' => [
					'top' => [
						'title' => esc_html__( 'Top', 'lc-addons-kit-for-elementor' ),
						'icon' => 'eicon-v-align-top',
					],
					'middle' => [
						'title' => esc_html__( 'Middle', 'lc-addons-kit-for-elementor' ),
						'icon' => 'eicon-v-align-middle',
					],
					'bottom' => [
						'title' => esc_html__( 'Bottom', 'lc-addons-kit-for-elementor' ),
						'icon' => 'eicon-v-align-bottom',
					],
				],
				'default' => 'top',
				'selectors_dictionary' => [
					'top' => 'super',
					'middle' => 'baseline',
					'bottom' => 'sub',
				],
				'selectors' => [
					'{{WRAPPER}} .lcake-single-pricing .lcake-pricing-price-wraper.has-tag .lcake-pricing-price sub.period' => 'vertical-align: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'lcake_pricing_heading_currency_style',
			[
				'label' => esc_html__( 'Currency Symbol', 'lc-addons-kit-for-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'lcake_pricing_currency_size',
                'label' =>esc_html__( 'Typography', 'lc-addons-kit-for-elementor' ),
                'selector' => '{{WRAPPER}} .lcake-single-pricing .lcake-pricing-price-wraper.has-tag .lcake-pricing-price sup.currency',
            ]
        );

		$this->add_control(
			'lcake_pricing_currency_position',
			[
				'label' => esc_html__( 'Position', 'lc-addons-kit-for-elementor' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'label_block' => false,
				'default' => 'before',
				'options' => [
					'before' => [
						'title' => esc_html__( 'Before', 'lc-addons-kit-for-elementor' ),
						'icon' => 'eicon-h-align-left',
					],
					'after' => [
						'title' => esc_html__( 'After', 'lc-addons-kit-for-elementor' ),
						'icon' => 'eicon-h-align-right',
					],
				],
			]
		);

		$this->add_responsive_control(
			'lcake_pricing_currency_vertical_position',
			[
				'label' => esc_html__( 'Vertical Position', 'lc-addons-kit-for-elementor' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'label_block' => false,
				'options' => [
					'top' => [
						'title' => esc_html__( 'Top', 'lc-addons-kit-for-elementor' ),
						'icon' => 'eicon-v-align-top',
					],
					'middle' => [
						'title' => esc_html__( 'Middle', 'lc-addons-kit-for-elementor' ),
						'icon' => 'eicon-v-align-middle',
					],
					'bottom' => [
						'title' => esc_html__( 'Bottom', 'lc-addons-kit-for-elementor' ),
						'icon' => 'eicon-v-align-bottom',
					],
				],
				'default' => 'top',
				'selectors_dictionary' => [
					'top' => 'super',
					'middle' => 'baseline',
					'bottom' => 'sub',
				],
				'selectors' => [
					'{{WRAPPER}} .lcake-single-pricing .lcake-pricing-price-wraper.has-tag .lcake-pricing-price sup.currency' => 'vertical-align: {{VALUE}}',
				],
			]
		);

        $this->add_control(
			'lcake_pricing_taghr1',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);
		$this->start_controls_tabs( 'lcake_pricing_tabs_price_style' );

		$this->start_controls_tab(
			'lcake_pricing_tab_tag_normal',
			[
				'label' =>esc_html__( 'Normal', 'lc-addons-kit-for-elementor' ),
			]
		);

		$this->add_control(
			'lcake_pricing_tag_text_color',
			[
				'label' =>esc_html__( 'Color', 'lc-addons-kit-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .lcake-single-pricing .lcake-pricing-price-wraper.has-tag .lcake-pricing-price' => 'color: {{VALUE}};',
				],
			]
		);
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            array(
				'name'     => 'lcake_pricing_tag_bg_color',
				'selector' => '{{WRAPPER}} .lcake-single-pricing .lcake-pricing-price-wraper.has-tag .lcake-pricing-tag',
            )
        );

		$this->end_controls_tab();

		$this->start_controls_tab(
			'lcake_pricing_tag_tab_hover',
			[
				'label' =>esc_html__( 'Hover', 'lc-addons-kit-for-elementor' ),
			]
		);

		$this->add_control(
			'lcake_pricing_tag_hover_color',
			[
				'label' =>esc_html__( 'Color', 'lc-addons-kit-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}:hover .lcake-pricing-price-wraper.has-tag .lcake-pricing-price' => 'color: {{VALUE}};',
				],
			]
		);

	    $this->add_group_control(
		    \Elementor\Group_Control_Background::get_type(),
		    array(
			    'name'     => 'lcake_pricing_tag_bg_hover_color_group',
			    'selector' => '{{WRAPPER}}:hover .lcake-pricing-price-wraper.has-tag .lcake-pricing-tag',
		    )
	    );

		$this->end_controls_tab();
        $this->end_controls_tabs();


        $this->add_control(
			'lcake_pricing_taghr2',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);

        $this->add_responsive_control(
			'lcake_pricing_tag_border_style',
			[
				'label' => esc_html_x( 'Border Type', 'Border Control', 'lc-addons-kit-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'' => esc_html__( 'None', 'lc-addons-kit-for-elementor' ),
					'solid' => esc_html_x( 'Solid', 'Border Control', 'lc-addons-kit-for-elementor' ),
					'double' => esc_html_x( 'Double', 'Border Control', 'lc-addons-kit-for-elementor' ),
					'dotted' => esc_html_x( 'Dotted', 'Border Control', 'lc-addons-kit-for-elementor' ),
					'dashed' => esc_html_x( 'Dashed', 'Border Control', 'lc-addons-kit-for-elementor' ),
					'groove' => esc_html_x( 'Groove', 'Border Control', 'lc-addons-kit-for-elementor' ),
				],
				'selectors' => [
					'{{WRAPPER}} .lcake-single-pricing .lcake-pricing-price-wraper.has-tag .lcake-pricing-tag' => 'border-style: {{VALUE}};',
				],
			]
		);
		$this->add_responsive_control(
			'lcake_pricing_tag_border_dimensions',
			[
				'label' => esc_html_x( 'Width', 'Border Control', 'lc-addons-kit-for-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .lcake-single-pricing .lcake-pricing-price-wraper.has-tag .lcake-pricing-tag' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->start_controls_tabs( 'lcake_pricing_tabs_tag_border_style' );
		$this->start_controls_tab(
			'lcake_pricing_tag_border_normal',
			[
				'label' =>esc_html__( 'Normal', 'lc-addons-kit-for-elementor' ),
			]
		);

		$this->add_control(
			'lcake_pricing_tag_border_color',
			[
				'label' => esc_html_x( 'Color', 'Border Control', 'lc-addons-kit-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .lcake-single-pricing .lcake-pricing-price-wraper.has-tag .lcake-pricing-tag' => 'border-color: {{VALUE}};',
				],
			]
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'lcake_pricing_tag_tab_border_hover',
			[
				'label' =>esc_html__( 'Hover', 'lc-addons-kit-for-elementor' ),
			]
		);
		$this->add_control(
			'lcake_pricing_tag_hover_border_color',
			[
				'label' => esc_html_x( 'Color', 'Border Control', 'lc-addons-kit-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}}:hover .lcake-pricing-price-wraper.has-tag .lcake-pricing-tag' => 'border-color: {{VALUE}};',
				],
			]
		);
		$this->end_controls_tab();
        $this->end_controls_tabs();



        $this->add_control(
			'lcake_pricing_taghr3',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);
        $this->add_responsive_control(
			'lcake_pricing_tag_border_radius',
			[
				'label' =>esc_html__( 'Border Radius', 'lc-addons-kit-for-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px'],
				'default' => [
					'top' => '',
					'right' => '',
					'bottom' => '' ,
					'left' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .lcake-single-pricing .lcake-pricing-price-wraper.has-tag .lcake-pricing-tag' =>  'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
        );
		$this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'lcake_pricing_tag_box_shadow_group',
                'selector' => '{{WRAPPER}} .lcake-single-pricing .lcake-pricing-price-wraper.has-tag .lcake-pricing-tag',
            ]
        );

		$this->end_controls_section();




        //Price Features style start
        $this->start_controls_section(
			'lcake_pricing_section_content_style',
			[
				'label' =>esc_html__( 'Features', 'lc-addons-kit-for-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'lcake_pricing_btn_align',
			[
				'label' =>esc_html__( 'Content Alignment', 'lc-addons-kit-for-elementor' ),
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
					'{{WRAPPER}} .lcake-single-pricing .lcake-pricing-content' => 'text-align: {{VALUE}};',
				],
				'default' => '',

			]
		);
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'lcake_pricing_content_typography_group',
				'label' =>esc_html__( 'List Typography', 'lc-addons-kit-for-elementor' ),
				'selector' => '{{WRAPPER}} .lcake-single-pricing .lcake-pricing-content p,  {{WRAPPER}} .lcake-single-pricing .lcake-pricing-lists > li',
			]
		);

        $this->add_control(
            'lcake_pricing_content_li_type',
            [
                'label'     => esc_html__( 'List Type', 'lc-addons-kit-for-elementor' ),
                'type'      => \Elementor\Controls_Manager::SELECT,
                'default'   => 'none',
                'options'   => [
                    'none'          => esc_html__( 'None', 'lc-addons-kit-for-elementor' ),
                    'disc'          => esc_html__( 'Disc', 'lc-addons-kit-for-elementor' ),
                    'decimal'       => esc_html__( 'Number', 'lc-addons-kit-for-elementor' ),
                    'lower-alpha'   => esc_html__( 'Alphabet', 'lc-addons-kit-for-elementor' ),
                    'lower-roman'   => esc_html__( 'Roman', 'lc-addons-kit-for-elementor' ),
                ],
                'selectors' => [
                    '{{WRAPPER}} .lcake-single-pricing .lcake-pricing-lists > li' => 'list-style: {{VALUE}};',
                ],
                'condition' => [
                    'lcake_pricing_content_style' => 'list',
                ],
            ]
        );

        $this->add_control(
			'lcake_pricing_fhr1',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);
		$this->start_controls_tabs( 'lcake_pricing_tabs_content_style' );

		$this->start_controls_tab(
			'lcake_pricing_content_tab',
			[
				'label' =>esc_html__( 'Normal', 'lc-addons-kit-for-elementor' ),
			]
		);
			$this->add_control(
				'lcake_pricing_content_text_color',
				[
					'label' =>esc_html__( 'Color', 'lc-addons-kit-for-elementor' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} .lcake-single-pricing .lcake-pricing-content p' => 'color: {{VALUE}};',
						'{{WRAPPER}} .lcake-single-pricing .lcake-pricing-lists > li' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_group_control(
				\Elementor\Group_Control_Border::get_type(),
				[
					'name' 		=> 'lcake_pricing_features_n_bd',
					'selector'	=> '{{WRAPPER}} .lcake-single-pricing .lcake-pricing-content',
				]
			);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'lcake_pricing_content_tab_hover',
			[
				'label' =>esc_html__( 'Hover', 'lc-addons-kit-for-elementor' ),
			]
		);
        $this->add_control(
            'lcake_pricing_content_hover_color',
            [
                'label' =>esc_html__( 'Color', 'lc-addons-kit-for-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}:hover .lcake-pricing-content p' => 'color: {{VALUE}};',
                    '{{WRAPPER}}:hover .lcake-pricing-lists li' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' 		=> 'lcake_pricing_features_h_bd',
                'selector'	=> '{{WRAPPER}}:hover .lcake-single-pricing .lcake-pricing-content',
            ]
        );
		$this->end_controls_tab();
		$this->end_controls_tabs();


		$this->add_control(
			'lcake_pricing_list_divider',
			[
				'label' => esc_html__( 'Divider', 'lc-addons-kit-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'no',
				'separator' => 'before',
				'condition' => [
                    'lcake_pricing_content_style' => 'list',
                ]
			]
		);

		$this->add_responsive_control(
			'lcake_pricing_divider_style',
			[
				'label' => esc_html__( 'Style', 'lc-addons-kit-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'solid' => esc_html__( 'Solid', 'lc-addons-kit-for-elementor' ),
					'double' => esc_html__( 'Double', 'lc-addons-kit-for-elementor' ),
					'dotted' => esc_html__( 'Dotted', 'lc-addons-kit-for-elementor' ),
					'dashed' => esc_html__( 'Dashed', 'lc-addons-kit-for-elementor' ),
				],
				'default' => 'solid',
				'condition' => [
					'list_divider' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} .lcake-single-pricing .lcake-pricing-lists li' => 'border-top-style: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'lcake_pricing_divider_color',
			[
				'label' => esc_html__( 'Color', 'lc-addons-kit-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#ddd',
				'condition' => [
					'lcake_pricing_list_divider' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} .lcake-single-pricing .lcake-pricing-lists li' => 'border-top-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'lcake_pricing_divider_weight',
			[
				'label' => esc_html__( 'Weight', 'lc-addons-kit-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'default' => [
					'size' => 2,
					'unit' => 'px',
				],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 10,
					],
				],
				'condition' => [
					'lcake_pricing_list_divider' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} .lcake-single-pricing .lcake-pricing-lists li' => 'border-top-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'lcake_pricing_divider_width',
			[
				'label' => esc_html__( 'Width', 'lc-addons-kit-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'condition' => [
					'lcake_pricing_list_divider' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} .lcake-single-pricing .lcake-pricing-lists li:before' => 'margin-left: calc((100% - {{SIZE}}%)/2); margin-right: calc((100% - {{SIZE}}%)/2)',
				],
			]
		);

		$this->add_responsive_control(
			'lcake_pricing_divider_gap',
			[
				'label' => esc_html__( 'List Gap', 'lc-addons-kit-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'default' => [
					'size' => 15,
					'unit' => 'px',
				],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .lcake-single-pricing .lcake-pricing-lists li:before' => 'margin-top: {{SIZE}}{{UNIT}}; margin-bottom: {{SIZE}}{{UNIT}}',
				],
                'condition' => [
                    'lcake_pricing_content_style' => 'list',
                ]
			]
		);

        $this->add_control(
			'lcake_pricing_fhr5',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);
		$this->add_responsive_control(
			'lcake_pricing_features_body_margin',
			[
				'label' =>esc_html__( 'Margin', 'lc-addons-kit-for-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default' => [
					'top' => 0,
					'left' => 0,
					'right' => 0,
					'bottom' => 50,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .lcake-single-pricing .lcake-pricing-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'lcake_pricing_features_body_padding',
			[
				'label' =>esc_html__( 'Padding', 'lc-addons-kit-for-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .lcake-single-pricing .lcake-pricing-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'features_icon_heading',
			[
				'label'		=> esc_html__( 'Icon', 'lc-addons-kit-for-elementor' ),
				'type'		=> \Elementor\Controls_Manager::HEADING,
				'separator'	=> 'before',
			]
		);

		$this->add_responsive_control(
			'features_icon_spacing',
			[
				'label'		=> esc_html__( 'Spacing', 'lc-addons-kit-for-elementor' ),
				'type'		=> \Elementor\Controls_Manager::SLIDER,
                'default' => [
                    'size' => 10,
                    'unit' => 'px',
                ],
				'selectors'	=> [
					'{{WRAPPER}} .lcake-pricing-lists > li > i' => 'padding-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .lcake-pricing-lists > li > svg' => 'margin-right: {{SIZE}}{{UNIT}};',
				]
			]
		);

		$this->add_responsive_control(
			'features_icon_align',
			[
				'label'		=> esc_html__( 'Vertical Align', 'lc-addons-kit-for-elementor' ),
				'type'		=> \Elementor\Controls_Manager::NUMBER,
				'selectors'	=> [
					'{{WRAPPER}} .lcake-pricing-lists > li > i, {{WRAPPER}} .lcake-pricing-lists > li > svg' => 'vertical-align: {{SIZE}}px;',
				]
			]
		);

		$this->end_controls_section();


        //Button style start
        $this->start_controls_section(
			'lcake_pricing_section_btn_style',
			[
				'label' =>esc_html__( 'Button', 'lc-addons-kit-for-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'lcake_pricing_btn_typography_group',
                'label' =>esc_html__( 'Typography', 'lc-addons-kit-for-elementor' ),
                'selector' => '{{WRAPPER}} .lcake-single-pricing a.lcake-pricing-btn',
            ]
		);
		$this->add_responsive_control(
            'lcake_pricing_btn_icon_size',
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
                    '{{WRAPPER}} .lcake-single-pricing .lcake-pricing-btn i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .lcake-single-pricing .lcake-pricing-btn svg path' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
		);

		$this->add_responsive_control(
			'pricing_btn_width',
			[
				'label'		=> __( 'Width (%)', 'lc-addons-kit-for-elementor' ),
				'type'		=> \Elementor\Controls_Manager::SLIDER,
				'selectors'	=> [
					'{{WRAPPER}} .lcake-pricing-btn' => 'width: {{SIZE}}%;',
				],
			]
		);

		$this->add_responsive_control(
			'pricing_btn_align',
			[
				'label'		=> __( 'Alignment', 'lc-addons-kit-for-elementor' ),
				'type'		=> \Elementor\Controls_Manager::CHOOSE,
				'options'	=> [
					'left' => [
						'title' => __( 'Left', 'lc-addons-kit-for-elementor' ),
						'icon'	=> 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'lc-addons-kit-for-elementor' ),
						'icon'	=> 'eicon-text-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'lc-addons-kit-for-elementor' ),
						'icon'	=> 'eicon-text-align-right',
					],
				],
				'selectors'	=> [
					'{{WRAPPER}} .lcake-pricing-btn-wraper' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'lcake_pricing_text_padding',
			[
				'label' =>esc_html__( 'Padding', 'lc-addons-kit-for-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .lcake-single-pricing a.lcake-pricing-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
        $this->add_control(
            'lcake_pricing_hr1',
            [
                'type' => \Elementor\Controls_Manager::DIVIDER,
                'style' => 'thick',
            ]
        );

        $this->start_controls_tabs( 'lcake_pricing_tabs_button_style' );

        $this->start_controls_tab(
            'lcake_pricing_tab_button_normal',
            [
                'label' =>esc_html__( 'Normal', 'lc-addons-kit-for-elementor' ),
            ]
        );

        $this->add_control(
            'lcake_pricing_btn_text_color',
            [
                'label' =>esc_html__( 'Text Color', 'lc-addons-kit-for-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
					'{{WRAPPER}} .lcake-single-pricing a.lcake-pricing-btn' => 'color: {{VALUE}};',
					'{{WRAPPER}} .lcake-single-pricing a.lcake-pricing-btn svg path'	=> 'stroke: {{VALUE}}; fill: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            array(
                'name'     => 'lcake_pricing_btn_bg_color_group',
				'exclude' => ['image'], // PHPCS:ignore WordPressVIPMinimum.Performance.WPQueryParams.PostNotIn_exclude
                'selector' => '{{WRAPPER}} .lcake-single-pricing a.lcake-pricing-btn',
            )
        );

        $this->add_responsive_control(
			'lcake_pricing_btn_border_style',
			[
				'label' => esc_html_x( 'Border Type', 'Border Control', 'lc-addons-kit-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'' => esc_html__( 'None', 'lc-addons-kit-for-elementor' ),
					'solid' => esc_html_x( 'Solid', 'Border Control', 'lc-addons-kit-for-elementor' ),
					'double' => esc_html_x( 'Double', 'Border Control', 'lc-addons-kit-for-elementor' ),
					'dotted' => esc_html_x( 'Dotted', 'Border Control', 'lc-addons-kit-for-elementor' ),
					'dashed' => esc_html_x( 'Dashed', 'Border Control', 'lc-addons-kit-for-elementor' ),
					'groove' => esc_html_x( 'Groove', 'Border Control', 'lc-addons-kit-for-elementor' ),
				],
				'selectors' => [
					'{{WRAPPER}} .lcake-single-pricing a.lcake-pricing-btn' => 'border-style: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'lcake_pricing_btn_border_dimensions',
			[
				'label' => esc_html_x( 'Width', 'Border Control', 'lc-addons-kit-for-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .lcake-single-pricing a.lcake-pricing-btn' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'condition' => [
                    'lcake_pricing_btn_border_style!' => '',
                ]
			]
		);

		$this->add_control(
			'lcake_pricing_btn_border_color',
			[
				'label' => esc_html_x( 'Border Color', 'Border Control', 'lc-addons-kit-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .lcake-single-pricing a.lcake-pricing-btn' => 'border-color: {{VALUE}};',
				],
                'condition' => [
                    'lcake_pricing_btn_border_style!' => '',
                ]
			]
		);

        $this->add_responsive_control(
			'lcake_pricing_btn_border_radius',
			[
				'label' =>esc_html__( 'Border Radius', 'lc-addons-kit-for-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px'],
				'default' => [
					'top' => '',
					'right' => '',
					'bottom' => '' ,
					'left' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .lcake-single-pricing a.lcake-pricing-btn' =>  'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
        );

		$this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'lcake_pricing_button_box_shadow_group',
                'selector' => '{{WRAPPER}} .lcake-single-pricing .lcake-pricing-btn',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'lcake_pricing_btn_tab_button_hover',
            [
                'label' =>esc_html__( 'Hover', 'lc-addons-kit-for-elementor' ),
            ]
        );

        $this->add_control(
            'lcake_pricing_btn_hover_color',
            [
                'label' =>esc_html__( 'Text Color', 'lc-addons-kit-for-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
					'{{WRAPPER}} .lcake-single-pricing a.lcake-pricing-btn:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}} .lcake-single-pricing a.lcake-pricing-btn:hover svg path'	=> 'stroke: {{VALUE}}; fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            array(
                'name'     => 'lcake_pricing_btn_bg_hover_color_group',
				'exclude' => ['image'], // PHPCS:ignore WordPressVIPMinimum.Performance.WPQueryParams.PostNotIn_exclude
                'selector' => '{{WRAPPER}} .lcake-single-pricing a.lcake-pricing-btn:hover',
            )
        );

        $this->add_responsive_control(
			'lcake_pricing_btn_hover_border_style',
			[
				'label' => esc_html_x( 'Border Type', 'Border Control', 'lc-addons-kit-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'' => esc_html__( 'None', 'lc-addons-kit-for-elementor' ),
					'solid' => esc_html_x( 'Solid', 'Border Control', 'lc-addons-kit-for-elementor' ),
					'double' => esc_html_x( 'Double', 'Border Control', 'lc-addons-kit-for-elementor' ),
					'dotted' => esc_html_x( 'Dotted', 'Border Control', 'lc-addons-kit-for-elementor' ),
					'dashed' => esc_html_x( 'Dashed', 'Border Control', 'lc-addons-kit-for-elementor' ),
					'groove' => esc_html_x( 'Groove', 'Border Control', 'lc-addons-kit-for-elementor' ),
				],
				'selectors' => [
					'{{WRAPPER}} .lcake-single-pricing a.lcake-pricing-btn:hover' => 'border-style: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'lcake_pricing_btn_hover_border_dimensions',
			[
				'label' => esc_html_x( 'Width', 'Border Control', 'lc-addons-kit-for-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .lcake-single-pricing a.lcake-pricing-btn:hover' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'condition' => [
                    'lcake_pricing_btn_hover_border_style!' => '',
                ]
			]
		);

		$this->add_control(
			'lcake_pricing_btn_hover_border_color',
			[
				'label' => esc_html_x( 'Border Color', 'Border Control', 'lc-addons-kit-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} a.lcake-pricing-btn:hover' => 'border-color: {{VALUE}};',
				],
                'condition' => [
                    'lcake_pricing_btn_hover_border_style!' => '',
                ]
			]
		);

        $this->add_responsive_control(
			'lcake_pricing_btn_hover_border_radius',
			[
				'label' =>esc_html__( 'Border Radius', 'lc-addons-kit-for-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px'],
				'default' => [
					'top' => '',
					'right' => '',
					'bottom' => '' ,
					'left' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .lcake-single-pricing a.lcake-pricing-btn:hover' =>  'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
        );

		$this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'lcake_pricing_button_box_shadow_hover_group',
                'selector' => '{{WRAPPER}} .lcake-single-pricing .lcake-pricing-btn:hover',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

		$this->end_controls_section();

		// Custom Order Style Start
		$this->start_controls_section(
			'lcake_pricing_order',
			[
				'label' =>esc_html__( 'Custom Ordering', 'lc-addons-kit-for-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
			$this->add_control(
				'lcake_pricing_order_enable',
				[
					'label' 		=> esc_html__( 'Enable Ordering', 'lc-addons-kit-for-elementor' ),
					'type' 			=> \Elementor\Controls_Manager::SWITCHER,
					'label_block'	=> false,
					'return_value' 	=> 'yes',
					'default' 		=> 'no',
				]
			);

			$this->add_control(
				'lcake_pricing_order_header',
				[
					'label' 		=> esc_html__( 'Header', 'lc-addons-kit-for-elementor' ),
					'type' 			=> \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px'],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 4,
							'step' => 1,
						],
					],
					'condition'		=> [
						'lcake_pricing_order_enable'	=> 'yes',
					]
				]
			);

			$this->add_control(
				'lcake_pricing_order_price',
				[
					'label' 		=> esc_html__( 'Price Tag', 'lc-addons-kit-for-elementor' ),
					'type' 			=> \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px'],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 4,
							'step' => 1,
						],
					],
					'condition'		=> [
						'lcake_pricing_order_enable'	=> 'yes',
					]
				]
			);

			$this->add_control(
				'lcake_pricing_order_features',
				[
					'label' 		=> esc_html__( 'Features', 'lc-addons-kit-for-elementor' ),
					'type' 			=> \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px'],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 4,
							'step' => 1,
						],
					],
					'condition'		=> [
						'lcake_pricing_order_enable'	=> 'yes',
					]
				]
			);

			$this->add_control(
				'lcake_pricing_order_button',
				[
					'label' 		=> esc_html__( 'Button', 'lc-addons-kit-for-elementor' ),
					'type' 			=> \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px'],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 4,
							'step' => 1,
						],
					],
					'condition'		=> [
						'lcake_pricing_order_enable'	=> 'yes',
					]
				]
			);
		$this->end_controls_section();
		
    }

    protected function render( ) {
        echo '<div class="lcake-main-wrapper" >';
            $this->render_raw();
        echo '</div>';
    }

    protected function render_raw( ) {

		$settings = $this->get_settings_for_display();
		extract($settings);


		$options_lcake_pricing_title_size = array_keys([
			'h1' => 'H1',
			'h2' => 'H2',
			'h3' => 'H3',
			'h4' => 'H4',
			'h5' => 'H5',
			'h6' => 'H6',
			'div' => 'div',
			'span' => 'span',
			'p' => 'p',
		]);

        $lcake_pricing_title_size_validate = \LCAKE_Kit_Utils::esc_options( $lcake_pricing_title_size, $options_lcake_pricing_title_size, 'h3');

        $table_title = $settings[ 'lcake_pricing_table_title' ];
        $table_subtitle = $settings[ 'lcake_pricing_table_subtitle' ];
		$table_content = $settings[ 'lcake_pricing_table_content' ];
		$currency_icon = $settings[ 'lcake_pricing_currency_icon' ];
		$table_price = $settings[ 'lcake_pricing_table_price' ];
		$table_duration = $settings[ 'lcake_pricing_table_duration' ];
		$table_content_repeater = $settings[ 'lcake_pricing_table_content_repeater' ];
        $content_style = $settings[ 'lcake_pricing_content_style' ];

        //For button
        $btn_text = $settings['lcake_pricing_btn_text'];
        $btn_class = ($settings['lcake_pricing_button_class'] != '') ? $settings['lcake_pricing_button_class'] : '';
        $btn_id = ($settings['lcake_pricing_button_id'] != '') ? $settings['lcake_pricing_button_id'] : '';
        $icon_align = $settings['lcake_pricing_icon_align'];

		if ( ! empty( $settings['lcake_pricing_btn_link']['url'] ) ) {
			$this->add_link_attributes( 'button', $settings['lcake_pricing_btn_link'] );
		}


		// $tag_align = $settings['lcake_pricing_tag_align'];
		$currency_position = $settings['lcake_pricing_currency_position'];
		$this->add_render_attribute( 'icon-align', 'class', 'xs-button-icon xs-align-icon-' . $settings['lcake_pricing_icon_align'] );

		$image = '';
        if ( ! empty( $settings['lcake_pricing_image']['url'] ) ) {
            $this->add_render_attribute( 'image', 'src', $settings['lcake_pricing_image']['url'] );
            $this->add_render_attribute( 'image', 'alt', \Elementor\Control_Media::get_image_alt( $settings['lcake_pricing_image'] ) );

            $image_html = \Elementor\Group_Control_Image_Size::get_attachment_image_html( $settings, 'lcake_pricing_thumbnail', 'lcake_pricing_image' );


            $image = '<figure class="elementor-pricing-img">' . $image_html . '</figure>';
        }


		// Custom Orders
		$header_order = !empty($lcake_pricing_order_header) ? $lcake_pricing_order_header['size'] : '';
		$price_order = !empty($lcake_pricing_order_price) ? $lcake_pricing_order_price['size']: '';
		$features_order = !empty($lcake_pricing_order_features) ? $lcake_pricing_order_features['size'] : '';
		$button_order = !empty($lcake_pricing_order_button) ? $lcake_pricing_order_button['size'] : '';
		?>


        <div class="lcake-single-pricing <?php echo esc_attr($settings['lcake_pricing_order_enable'] == 'yes' ? 'd-flex flex-column' : ''); ?>" >
            <div class="lcake-pricing-header <?php echo esc_attr($header_order ? 'order-'. $header_order : ''); ?>">
				<?php if($settings['lcake_pricing_icon_type'] == 'image') : ?>
                    <?php echo wp_kses($image, \LCAKE_Kit_Utils::get_kses_array());?>
                <?php endif; ?>
				<?php if($settings['lcake_pricing_icon_type'] == 'icon') : ?>					
					<?php
						// new icon
						$migrated = isset( $settings['__fa4_migrated']['lcake_pricing_icons'] );
						// Check if its a new widget without previously selected icon using the old Icon control
						$is_new = empty( $settings['lcake_pricing_icon'] );
						if ( $is_new || $migrated ) {
							// new icon
							\Elementor\Icons_Manager::render_icon( $settings['lcake_pricing_icons'], [ 'aria-hidden' => 'true', 'class'    => [
								'elementkit-pricing-icon',
								'elementor-animation-'. esc_attr($settings['lcake_pricing_icons_hover_animation'])
							] ] );
						} else {
							?>
							<i class="<?php echo esc_attr($settings['lcake_pricing_icon']); ?> elementkit-pricing-icon <?php echo 'elementor-animation-'. esc_attr($settings['lcake_pricing_icons_hover_animation']); ?>" aria-hidden="true"></i>
							<?php
						}
					?>
									
				<?php endif; ?>

				<?php if($table_title != ''): ?>
                    <<?php echo wp_kses($lcake_pricing_title_size_validate, \LCAKE_Kit_Utils::get_kses_array());?>
					class=" lcake-pricing-title"><?php echo esc_html($table_title); ?>
                    </<?php echo wp_kses($lcake_pricing_title_size_validate, \LCAKE_Kit_Utils::get_kses_array()); ?>>
				<?php endif; ?>
				<?php if($table_subtitle != ''): ?>
                	<p class=" lcake-pricing-subtitle"><?php echo esc_html($table_subtitle); ?></p>
				<?php endif; ?>
            </div>
			<?php if ($currency_icon != '' && $table_price !== '') { ?>
            <div class=" lcake-pricing-price-wraper has-tag <?php echo esc_attr($price_order ? 'order-'. $price_order : ''); ?>">
                <div class="lcake-pricing-tag"></div>
                <span class="lcake-pricing-price">
					<?php if($currency_position == 'before'): ?>
						<sup class="currency"><?php echo esc_html($currency_icon); ?></sup>
					<?php endif; ?>
					<span><?php echo esc_html($table_price); ?></span>
					<?php if($currency_position == 'after'): ?>
						<sup class="currency"><?php echo esc_html($currency_icon); ?></sup>
					<?php endif; ?>

					<?php if ( $table_duration !== '' ): ?>
					<sub class="period"><?php echo esc_html($table_duration); ?></sub>
					<?php endif; ?>
				</span>
            </div>
			<?php } ?>
            <div class="lcake-pricing-content <?php echo esc_attr($features_order ? 'order-'. $features_order : ''); ?>">

                <?php if($content_style == 'paragraph'){ ?>
                    <p> <?php echo wp_kses($table_content, \LCAKE_Kit_Utils::get_kses_array()); ?></p>
                <?php } ?>
                <?php if($content_style == 'list'){ ?>
                    <ul class="lcake-pricing-lists">
                        <?php foreach($table_content_repeater as $repeat){  ?>
							<li class="elementor-repeater-item-<?php echo esc_attr( $repeat[ '_id' ] ); ?>">
								<?php \Elementor\Icons_Manager::render_icon( $repeat['lcake_pricing_check_icons'], [ 'aria-hidden' => 'true' ] ); ?>
								<?php // echo esc_html($repeat['lcake_pricing_list']); ?>

								<?php echo esc_html($repeat['lcake_pricing_list']); ?>
								
								<?php if ( !empty( $repeat[ 'lcake_pricing_list_info' ] ) ): ?>
									<div class="lcake-pricing-list-info" data-info-tip="true">
										<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"><path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16m.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2"/></svg>
										<span></span>
										<p class="lcake-pricing-list-info-content lcake-pricing-<?php echo esc_attr( $this->get_ID() ); ?> lcake-pricing-list-info-<?php echo esc_attr( $repeat[ '_id' ] ); ?>" data-info-tip-content="true"><?php echo esc_attr( $repeat[ 'lcake_pricing_list_info' ] ); ?></p>
									</div>
								<?php endif; ?>
							</li>
                        <?php } ?>
                    </ul>
                <?php } ?>
            </div>
            <div class="lcake-pricing-btn-wraper <?php echo esc_attr($button_order ? 'order-'. $button_order : ''); ?>">
				<a <?php echo $this->get_render_attribute_string( 'button' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Already escaped by elementor ?> class="lcake-pricing-btn <?php echo esc_attr( $btn_class ); ?> lcake-pricing-btn-icon-pos-<?php echo esc_attr($icon_align); ?>" <?php if($settings['lcake_pricing_button_id'] != '') { ?> id="<?php echo esc_attr( $btn_id ); ?>" <?php } ?>>
					<?php
					if ( $settings['lcake_pricing_btn_icons'] != '' && $icon_align == 'left' ):
						// new icon
						$migrated = isset( $settings['__fa4_migrated']['lcake_pricing_btn_icons'] );
						// Check if its a new widget without previously selected icon using the old Icon control
						$is_new = empty( $settings['lcake_pricing_btn_icon'] );
						if ( $is_new || $migrated ) {
							// new icon
							\Elementor\Icons_Manager::render_icon( $settings['lcake_pricing_btn_icons'], [ 'aria-hidden' => 'true' ] );
						} else {
							?>
							<i class="<?php echo esc_attr($settings['lcake_pricing_btn_icon']); ?>" aria-hidden="true"></i>
							<?php
						}
					endif;

					echo esc_html( $btn_text );
					
					if ( $settings['lcake_pricing_btn_icons'] != '' && $icon_align == 'right' ):
						// new icon
						$migrated = isset( $settings['__fa4_migrated']['lcake_pricing_btn_icons'] );
						// Check if its a new widget without previously selected icon using the old Icon control
						$is_new = empty( $settings['lcake_pricing_btn_icon'] );
						if ( $is_new || $migrated ) {
							// new icon
							\Elementor\Icons_Manager::render_icon( $settings['lcake_pricing_btn_icons'], [ 'aria-hidden' => 'true' ] );
						} else {
							?>
							<i class="<?php echo esc_attr($settings['lcake_pricing_btn_icon']); ?>" aria-hidden="true"></i>
							<?php
						}
					endif;
					?>
				</a>
            </div>
        </div>

    <?php
    }
} 