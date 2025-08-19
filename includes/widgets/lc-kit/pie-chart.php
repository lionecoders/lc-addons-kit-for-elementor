<?php
/**
 * LC Kit - Pie Chart Widget
 *
 * @package LC_Elementor_Addons_Kit
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class LC_Kit_Pie_Chart extends \Elementor\Widget_Base {

    public function get_name() {
        return 'lc-kit-pie-chart';
    }

    public function get_title() {
        return esc_html__( 'Pie Chart', 'lc-elementor-addons-kit' );
    }

    public function get_icon() {
        return 'eicon-pie-chart';
    }

    public function get_categories() {
        return [ 'lc-page-kit' ];
    }

    public function get_keywords() {
        return [ 'pie', 'chart', 'graph', 'data', 'visualization' ];
    }

    // This must match your registered script handle in enqueue code (see below)
    public function get_script_depends() {
        return [ 'lc-kit-pie-chart' ];
    }

    protected function register_controls() {
        $this->add_content_controls();
        $this->add_style_controls();
    }

    protected function add_content_controls() {
        $this->start_controls_section(
            'lc_content_section',
            [
                'label' => esc_html__( 'Content', 'lc-elementor-addons-kit' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'label',
            [
                'label'   => esc_html__( 'Label', 'lc-elementor-addons-kit' ),
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__( 'Data Label', 'lc-elementor-addons-kit' ),
            ]
        );

        $repeater->add_control(
            'value',
            [
                'label'   => esc_html__( 'Value', 'lc-elementor-addons-kit' ),
                'type'    => \Elementor\Controls_Manager::NUMBER,
                'min'     => 0,
                'step'    => 1,
                'default' => 25,
            ]
        );

        $repeater->add_control(
            'color',
            [
                'label'   => esc_html__( 'Color', 'lc-elementor-addons-kit' ),
                'type'    => \Elementor\Controls_Manager::COLOR,
                'default' => '#61ce70',
            ]
        );

        $this->add_control(
            'lc_content_chart_data',
            [
                'label'       => esc_html__( 'Chart Data', 'lc-elementor-addons-kit' ),
                'type'        => \Elementor\Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default'     => [
                    [ 'label' => esc_html__( 'Profit', 'lc-elementor-addons-kit' ), 'value' => 50, 'color' => '#35c048' ],
                    [ 'label' => esc_html__( 'Lose', 'lc-elementor-addons-kit' ), 'value' => 30, 'color' => '#ed2424' ],
                    [ 'label' => esc_html__( 'Investment', 'lc-elementor-addons-kit' ), 'value' => 20, 'color' => '#7068ff' ],
                ],
                'title_field' => '{{{ label }}}',
            ]
        );

        $this->add_control(
            'lc_content_chart_title',
            [
                'label'       => esc_html__( 'Chart Title', 'lc-elementor-addons-kit' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'Enter chart title', 'lc-elementor-addons-kit' ),
            ]
        );

        $this->add_control(
            'lc_content_show_legend',
            [
                'label'        => esc_html__( 'Show Legend', 'lc-elementor-addons-kit' ),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Show', 'lc-elementor-addons-kit' ),
                'label_off'    => esc_html__( 'Hide', 'lc-elementor-addons-kit' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        $this->add_control(
            'lc_content_show_percentage',
            [
                'label'        => esc_html__( 'Show Percentage', 'lc-elementor-addons-kit' ),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Show', 'lc-elementor-addons-kit' ),
                'label_off'    => esc_html__( 'Hide', 'lc-elementor-addons-kit' ),
                'return_value' => 'yes',
                'default'      => 'yes',
                'condition'    => [
                    'lc_content_show_legend' => 'yes',
                ],
            ]
        );
       
        $this->end_controls_section();
    }

    protected function add_style_controls() {
        $this->start_controls_section(
            'lc_section_style_chart',
            [
                'label' => esc_html__( 'Chart', 'lc-elementor-addons-kit' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'lc_content_chart_size',
            [
                'label'      => esc_html__( 'Chart Size', 'lc-elementor-addons-kit' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range'      => [
                    'px' => [ 'min' => 100, 'max' => 500, 'step' => 10 ],
                    '%'  => [ 'min' => 10, 'max' => 100, 'step' => 1 ],
                ],
                'default' => [ 'unit' => 'px', 'size' => 180 ],
            ]
        );

        $this->add_responsive_control(
            'lc_chart_alignment',
            [
                'label'   => esc_html__( 'Alignment', 'lc-elementor-addons-kit' ),
                'type'    => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left'   => [
                        'title' => esc_html__( 'Left', 'lc-elementor-addons-kit' ),
                        'icon'  => 'eicon-text-align-left'
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'lc-elementor-addons-kit' ),
                        'icon'  => 'eicon-text-align-center'
                    ],
                    'right'  => [
                        'title' => esc_html__( 'Right', 'lc-elementor-addons-kit' ),
                        'icon'  => 'eicon-text-align-right'
                    ],
                ],
                    'selectors' => [
                        '{{WRAPPER}} .lc-pie-chart-wrapper' => 'text-align: {{VALUE}};',
                    ],
                'condition' => [
                    'lc_content_show_legend' => 'yes',
                ],
            ]
        );


        $this->add_control(
            'lc_chart_background_color',
            [
                'label'     => esc_html__( 'Background Color', 'lc-elementor-addons-kit' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lc-kit-pie-chart__box' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name'     => 'lc_chart_border',
                'selector' => '{{WRAPPER}} .lc-kit-pie-chart__box',
            ]
        );

        $this->add_control(
            'lc_style_chart_border_radius',
            [
                'label'      => esc_html__( 'Border Radius', 'lc-elementor-addons-kit' ),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .lc-kit-pie-chart__box' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'lc_section_style_legend',
            [
                'label'     => esc_html__( 'Legend', 'lc-elementor-addons-kit' ),
                'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'lc_content_show_legend' => 'yes',
                ],
            ]
        );

    // optional extra controls for legend font & color used by JS
        $this->add_control(
            'lc_legend_text_color',
            [
                'label'     => esc_html__( 'Legend Text Color', 'lc-elementor-addons-kit' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lc-pie-chart-legend-label' => 'color: {{VALUE}};',
                ],
            ]
        );

        // optional extra controls for legend marker size
        $this->add_control(
            'lc_legend_font_size',
            [
                'label'   => esc_html__( 'Legend Font Size', 'lc-elementor-addons-kit' ),
                'type'    => \Elementor\Controls_Manager::NUMBER,
                'default' => 22,
                'min'     => 8,
                'max'     => 48,
                'selectors' => [
                    // target both container and the inner label text
                    '{{WRAPPER}} .lc-pie-chart-legend-item, {{WRAPPER}} .lc-pie-chart-legend-item .lc-pie-chart-legend-label' => 'font-size: {{VALUE}}px;',
                ],
            ]
        );


        $this->end_controls_section();
    }

   protected function render() {
    $settings = $this->get_settings_for_display();

    if (empty($settings['lc_content_chart_data'])) {
        return;
    }

    $labels = [];
    $values = [];
    $colors = [];
    $total = 0;
    $has_values = false;

    // Collect chart data
    foreach ($settings['lc_content_chart_data'] as $i => $item) {
        $labels[] = !empty($item['label']) ? $item['label'] : 'Slice ' . ($i + 1);
        $values[] = (!empty($item['value']) && is_numeric($item['value'])) ? (float)$item['value'] : 0;
        $colors[] = !empty($item['color']) ? $item['color'] : '#ccc';

        if (!empty($item['value']) && is_numeric($item['value'])) {
            $total += $item['value'];
            $has_values = true;
        }
    }

    // If all values are zero, divide equally
    if (!$has_values && count($values) > 0) {
        $equal_value = 100 / count($values);
        $values = array_fill(0, count($values), $equal_value);
        $total = 100;
    }

    // Build conic-gradient string
    $gradient_parts = [];
    $current_deg = 0;
    foreach ($values as $index => $value) {
        $percentage = ($total > 0) ? ($value / $total) : 0;
        $slice_deg = $percentage * 360;
        $start_deg = $current_deg;
        $end_deg = $current_deg + $slice_deg;
        $gradient_parts[] = "{$colors[$index]} {$start_deg}deg {$end_deg}deg";
        $current_deg = $end_deg;
    }

    $gradient_css = implode(', ', $gradient_parts);

    // Output HTML
    echo '<div class="lc-pie-chart-wrapper lc-kit-pie-chart__box">';

    if (!empty($settings['lc_content_chart_title'])) {
        echo '<h3 class="lc-pie-chart-title">' . esc_html($settings['lc_content_chart_title']) . '</h3>';
    }
        $size = isset($settings['lc_content_chart_size']['size']) ? $settings['lc_content_chart_size']['size'] : 180;
        $unit = isset($settings['lc_content_chart_size']['unit']) ? $settings['lc_content_chart_size']['unit'] : 'px';

        echo '<div class="lc-pie-chart" style="width:' . esc_attr($size . $unit) . ';height:' . esc_attr($size . $unit) . ';background: conic-gradient(' . esc_attr($gradient_css) . ');"></div>';


    if ($settings['lc_content_show_legend'] === 'yes') {
        echo '<div class="lc-pie-chart-legend">';
        foreach ($labels as $index => $label) {
            $percentage = ($total > 0) ? round(($values[$index] / $total) * 100, 1) : 0;
            echo '<div class="lc-pie-chart-legend-item">';
            echo '<span class="lc-pie-chart-legend-marker" style="background-color:' . esc_attr($colors[$index]) . ';"></span>';
            echo '<span class="lc-pie-chart-legend-label">' . esc_html($label);
            if ($settings['lc_content_show_percentage'] === 'yes') {
                echo ' (' . esc_html($percentage) . '%)';
            }
            echo '</span>';
            echo '</div>';
        }
        echo '</div>';
    }
    echo '</div>';
}

}
