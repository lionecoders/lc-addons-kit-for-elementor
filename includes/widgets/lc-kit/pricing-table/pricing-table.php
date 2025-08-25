<?php
/**
 * Pricing Table Widget
 * 
 * @package LC_Elementor_Addons_Kit
 */

if (!defined('ABSPATH')) {
    exit;
}

class LC_Kit_Pricing_Table extends \Elementor\Widget_Base {

    public function get_name() {
        return 'lc-kit-pricing-table';
    }

    public function get_title() {
        return esc_html__('Pricing Table', 'lc-elementor-addons-kit');
    }

    public function get_icon() {
        return 'eicon-price-table';
    }

    public function get_categories() {
        return ['lc-page-kit'];
    }

    public function get_keywords() {
        return ['pricing', 'table', 'price', 'plan', 'subscription', 'billing'];
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
            'title',
            [
                'label' => esc_html__('Title', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Basic Plan', 'lc-elementor-addons-kit'),
            ]
        );

        $repeater->add_control(
            'subtitle',
            [
                'label' => esc_html__('Subtitle', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Perfect for small businesses', 'lc-elementor-addons-kit'),
            ]
        );

        $repeater->add_control(
            'price',
            [
                'label' => esc_html__('Price', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('29', 'lc-elementor-addons-kit'),
            ]
        );

        $repeater->add_control(
            'currency',
            [
                'label' => esc_html__('Currency', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('$', 'lc-elementor-addons-kit'),
            ]
        );

        $repeater->add_control(
            'period',
            [
                'label' => esc_html__('Period', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('/month', 'lc-elementor-addons-kit'),
            ]
        );

        $repeater->add_control(
            'features',
            [
                'label' => esc_html__('Features', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => [
                    [
                        'name' => 'feature_text',
                        'label' => esc_html__('Feature', 'lc-elementor-addons-kit'),
                        'type' => \Elementor\Controls_Manager::TEXT,
                        'default' => esc_html__('Feature 1', 'lc-elementor-addons-kit'),
                    ],
                    [
                        'name' => 'feature_icon',
                        'label' => esc_html__('Icon', 'lc-elementor-addons-kit'),
                        'type' => \Elementor\Controls_Manager::ICONS,
                        'default' => [
                            'value' => 'fas fa-check',
                            'library' => 'fa-solid',
                        ],
                    ],
                ],
                'default' => [
                    [
                        'feature_text' => esc_html__('Feature 1', 'lc-elementor-addons-kit'),
                    ],
                    [
                        'feature_text' => esc_html__('Feature 2', 'lc-elementor-addons-kit'),
                    ],
                    [
                        'feature_text' => esc_html__('Feature 3', 'lc-elementor-addons-kit'),
                    ],
                ],
                'title_field' => '{{{ feature_text }}}',
            ]
        );

        $repeater->add_control(
            'button_text',
            [
                'label' => esc_html__('Button Text', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Get Started', 'lc-elementor-addons-kit'),
            ]
        );

        $repeater->add_control(
            'button_link',
            [
                'label' => esc_html__('Button Link', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => esc_html__('https://your-link.com', 'lc-elementor-addons-kit'),
            ]
        );

        $repeater->add_control(
            'popular',
            [
                'label' => esc_html__('Popular', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'lc-elementor-addons-kit'),
                'label_off' => esc_html__('No', 'lc-elementor-addons-kit'),
                'return_value' => 'yes',
                'default' => '',
            ]
        );

        $repeater->add_control(
            'popular_text',
            [
                'label' => esc_html__('Popular Text', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Most Popular', 'lc-elementor-addons-kit'),
                'condition' => [
                    'popular' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'pricing_tables',
            [
                'label' => esc_html__('Pricing Tables', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'title' => esc_html__('Basic Plan', 'lc-elementor-addons-kit'),
                        'subtitle' => esc_html__('Perfect for small businesses', 'lc-elementor-addons-kit'),
                        'price' => esc_html__('29', 'lc-elementor-addons-kit'),
                        'currency' => esc_html__('$', 'lc-elementor-addons-kit'),
                        'period' => esc_html__('/month', 'lc-elementor-addons-kit'),
                        'button_text' => esc_html__('Get Started', 'lc-elementor-addons-kit'),
                    ],
                    [
                        'title' => esc_html__('Pro Plan', 'lc-elementor-addons-kit'),
                        'subtitle' => esc_html__('Perfect for growing businesses', 'lc-elementor-addons-kit'),
                        'price' => esc_html__('99', 'lc-elementor-addons-kit'),
                        'currency' => esc_html__('$', 'lc-elementor-addons-kit'),
                        'period' => esc_html__('/month', 'lc-elementor-addons-kit'),
                        'button_text' => esc_html__('Get Started', 'lc-elementor-addons-kit'),
                        'popular' => 'yes',
                    ],
                    [
                        'title' => esc_html__('Enterprise Plan', 'lc-elementor-addons-kit'),
                        'subtitle' => esc_html__('Perfect for large businesses', 'lc-elementor-addons-kit'),
                        'price' => esc_html__('199', 'lc-elementor-addons-kit'),
                        'currency' => esc_html__('$', 'lc-elementor-addons-kit'),
                        'period' => esc_html__('/month', 'lc-elementor-addons-kit'),
                        'button_text' => esc_html__('Get Started', 'lc-elementor-addons-kit'),
                    ],
                ],
                'title_field' => '{{{ title }}}',
            ]
        );

        $this->add_control(
            'columns',
            [
                'label' => esc_html__('Columns', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '3',
                'options' => [
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                ],
            ]
        );

        $this->add_control(
            'show_currency',
            [
                'label' => esc_html__('Show Currency', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'lc-elementor-addons-kit'),
                'label_off' => esc_html__('Hide', 'lc-elementor-addons-kit'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_period',
            [
                'label' => esc_html__('Show Period', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'lc-elementor-addons-kit'),
                'label_off' => esc_html__('Hide', 'lc-elementor-addons-kit'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->end_controls_section();
    }

    protected function add_style_controls() {
        $this->start_controls_section(
            'section_style_pricing_table',
            [
                'label' => esc_html__('Pricing Table', 'lc-elementor-addons-kit'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'pricing_table_background_color',
            [
                'label' => esc_html__('Background Color', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lc-pricing-table-item' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'pricing_table_border',
                'selector' => '{{WRAPPER}} .lc-pricing-table-item',
            ]
        );

        $this->add_control(
            'pricing_table_border_radius',
            [
                'label' => esc_html__('Border Radius', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lc-pricing-table-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'pricing_table_padding',
            [
                'label' => esc_html__('Padding', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lc-pricing-table-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'pricing_table_margin',
            [
                'label' => esc_html__('Margin', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lc-pricing-table-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_header',
            [
                'label' => esc_html__('Header', 'lc-elementor-addons-kit'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'header_background_color',
            [
                'label' => esc_html__('Background Color', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lc-pricing-table-header' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__('Title Color', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lc-pricing-table-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .lc-pricing-table-title',
            ]
        );

        $this->add_control(
            'subtitle_color',
            [
                'label' => esc_html__('Subtitle Color', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lc-pricing-table-subtitle' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'subtitle_typography',
                'selector' => '{{WRAPPER}} .lc-pricing-table-subtitle',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_price',
            [
                'label' => esc_html__('Price', 'lc-elementor-addons-kit'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'price_color',
            [
                'label' => esc_html__('Price Color', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lc-pricing-table-price' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'price_typography',
                'selector' => '{{WRAPPER}} .lc-pricing-table-price',
            ]
        );

        $this->add_control(
            'currency_color',
            [
                'label' => esc_html__('Currency Color', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lc-pricing-table-currency' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'period_color',
            [
                'label' => esc_html__('Period Color', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lc-pricing-table-period' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_features',
            [
                'label' => esc_html__('Features', 'lc-elementor-addons-kit'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'features_color',
            [
                'label' => esc_html__('Color', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lc-pricing-table-feature' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'features_typography',
                'selector' => '{{WRAPPER}} .lc-pricing-table-feature',
            ]
        );

        $this->add_control(
            'feature_icon_color',
            [
                'label' => esc_html__('Icon Color', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lc-pricing-table-feature-icon' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'feature_icon_size',
            [
                'label' => esc_html__('Icon Size', 'lc-elementor-addons-kit'),
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
                    '{{WRAPPER}} .lc-pricing-table-feature-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_button',
            [
                'label' => esc_html__('Button', 'lc-elementor-addons-kit'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'button_background_color',
            [
                'label' => esc_html__('Background Color', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lc-pricing-table-button' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_color',
            [
                'label' => esc_html__('Text Color', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lc-pricing-table-button' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'button_typography',
                'selector' => '{{WRAPPER}} .lc-pricing-table-button',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'button_border',
                'selector' => '{{WRAPPER}} .lc-pricing-table-button',
            ]
        );

        $this->add_control(
            'button_border_radius',
            [
                'label' => esc_html__('Border Radius', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lc-pricing-table-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_padding',
            [
                'label' => esc_html__('Padding', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lc-pricing-table-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_popular',
            [
                'label' => esc_html__('Popular Badge', 'lc-elementor-addons-kit'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'popular_background_color',
            [
                'label' => esc_html__('Background Color', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lc-pricing-table-popular' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'popular_color',
            [
                'label' => esc_html__('Text Color', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lc-pricing-table-popular' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'popular_typography',
                'selector' => '{{WRAPPER}} .lc-pricing-table-popular',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        if (empty($settings['pricing_tables'])) {
            return;
        }

        $this->add_render_attribute('wrapper', 'class', 'lc-pricing-table-wrapper');
        $this->add_render_attribute('wrapper', 'data-columns', $settings['columns']);

        echo '<div ' . $this->get_render_attribute_string('wrapper') . '>';
        
        foreach ($settings['pricing_tables'] as $table) {
            $item_class = 'lc-pricing-table-item';
            if ($table['popular'] === 'yes') {
                $item_class .= ' lc-pricing-table-popular-item';
            }

            echo '<div class="' . esc_attr($item_class) . '">';
            
            if ($table['popular'] === 'yes' && !empty($table['popular_text'])) {
                echo '<div class="lc-pricing-table-popular">' . esc_html($table['popular_text']) . '</div>';
            }

            echo '<div class="lc-pricing-table-header">';
            
            if (!empty($table['title'])) {
                echo '<div class="lc-pricing-table-title">' . esc_html($table['title']) . '</div>';
            }

            if (!empty($table['subtitle'])) {
                echo '<div class="lc-pricing-table-subtitle">' . esc_html($table['subtitle']) . '</div>';
            }

            echo '</div>';

            echo '<div class="lc-pricing-table-price-section">';
            
            if ($settings['show_currency'] === 'yes' && !empty($table['currency'])) {
                echo '<span class="lc-pricing-table-currency">' . esc_html($table['currency']) . '</span>';
            }

            if (!empty($table['price'])) {
                echo '<span class="lc-pricing-table-price">' . esc_html($table['price']) . '</span>';
            }

            if ($settings['show_period'] === 'yes' && !empty($table['period'])) {
                echo '<span class="lc-pricing-table-period">' . esc_html($table['period']) . '</span>';
            }

            echo '</div>';

            if (!empty($table['features'])) {
                echo '<div class="lc-pricing-table-features">';
                foreach ($table['features'] as $feature) {
                    echo '<div class="lc-pricing-table-feature">';
                    if (!empty($feature['feature_icon']['value'])) {
                        echo '<span class="lc-pricing-table-feature-icon">';
                        \Elementor\Icons_Manager::render_icon($feature['feature_icon'], ['aria-hidden' => 'true']);
                        echo '</span>';
                    }
                    echo '<span class="lc-pricing-table-feature-text">' . esc_html($feature['feature_text']) . '</span>';
                    echo '</div>';
                }
                echo '</div>';
            }

            if (!empty($table['button_text']) && !empty($table['button_link']['url'])) {
                $this->add_link_attributes('button_' . $table['_id'], $table['button_link']);
                echo '<div class="lc-pricing-table-button-wrapper">';
                echo '<a ' . $this->get_render_attribute_string('button_' . $table['_id']) . ' class="lc-pricing-table-button">';
                echo esc_html($table['button_text']);
                echo '</a>';
                echo '</div>';
            }

            echo '</div>';
        }

        echo '</div>';
    }

    protected function content_template() {
        ?>
        <# if (settings.pricing_tables.length > 0) { #>
            <div class="lc-pricing-table-wrapper" data-columns="{{ settings.columns }}">
                <# _.each(settings.pricing_tables, function(table) { #>
                    <div class="lc-pricing-table-item<# if (table.popular === 'yes') { #> lc-pricing-table-popular-item<# } #>">
                        <# if (table.popular === 'yes' && table.popular_text) { #>
                            <div class="lc-pricing-table-popular">{{{ table.popular_text }}}</div>
                        <# } #>
                        
                        <div class="lc-pricing-table-header">
                            <# if (table.title) { #>
                                <div class="lc-pricing-table-title">{{{ table.title }}}</div>
                            <# } #>
                            <# if (table.subtitle) { #>
                                <div class="lc-pricing-table-subtitle">{{{ table.subtitle }}}</div>
                            <# } #>
                        </div>
                        
                        <div class="lc-pricing-table-price-section">
                            <# if (settings.show_currency === 'yes' && table.currency) { #>
                                <span class="lc-pricing-table-currency">{{{ table.currency }}}</span>
                            <# } #>
                            <# if (table.price) { #>
                                <span class="lc-pricing-table-price">{{{ table.price }}}</span>
                            <# } #>
                            <# if (settings.show_period === 'yes' && table.period) { #>
                                <span class="lc-pricing-table-period">{{{ table.period }}}</span>
                            <# } #>
                        </div>
                        
                        <# if (table.features && table.features.length > 0) { #>
                            <div class="lc-pricing-table-features">
                                <# _.each(table.features, function(feature) { #>
                                    <div class="lc-pricing-table-feature">
                                        <# if (feature.feature_icon && feature.feature_icon.value) { #>
                                            <span class="lc-pricing-table-feature-icon">
                                                <i class="{{ feature.feature_icon.value }}" aria-hidden="true"></i>
                                            </span>
                                        <# } #>
                                        <span class="lc-pricing-table-feature-text">{{{ feature.feature_text }}}</span>
                                    </div>
                                <# }); #>
                            </div>
                        <# } #>
                        
                        <# if (table.button_text && table.button_link.url) { #>
                            <div class="lc-pricing-table-button-wrapper">
                                <a href="{{ table.button_link.url }}" class="lc-pricing-table-button">
                                    {{{ table.button_text }}}
                                </a>
                            </div>
                        <# } #>
                    </div>
                <# }); #>
            </div>
        <# } #>
        <?php
    }
} 