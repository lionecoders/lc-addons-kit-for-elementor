<?php
/**
 * Data Table Widget
 *
 * @package LC_Elementor_Addons_Kit
 */

if (!defined('ABSPATH')) {
    exit;
}

class LCAKE_Kit_Data_Table extends \Elementor\Widget_Base {

    public function get_name() {
        return 'lcake-kit-data-table';
    }

    public function get_categories() {
        return ['lcake-page-kit'];
    }

    public function get_title() {
        return esc_html__('LC Data Table', 'lc-addons-kit-for-elementor');
    }

    public function get_icon() {
        return 'eicon-table';
    }

    public function get_style_depends() {
        return ['lcake-kit-data-table-css'];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Content', 'lc-addons-kit-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $col_repeater = new \Elementor\Repeater();
        $col_repeater->add_control(
            'column_label',
            [
                'label' => esc_html__('Column Label', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Column', 'lc-addons-kit-for-elementor'),
            ]
        );

        $this->add_control(
            'columns',
            [
                'label' => esc_html__('Columns', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $col_repeater->get_controls(),
                'default' => [
                    ['column_label' => esc_html__('Plan', 'lc-addons-kit-for-elementor')],
                    ['column_label' => esc_html__('Price', 'lc-addons-kit-for-elementor')],
                    ['column_label' => esc_html__('Storage', 'lc-addons-kit-for-elementor')],
                ],
                'title_field' => '{{{ column_label }}}',
            ]
        );

        $row_repeater = new \Elementor\Repeater();
        $row_repeater->add_control(
            'row_cells',
            [
                'label' => esc_html__('Row Cells (comma separated)', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Basic, $10, 10GB', 'lc-addons-kit-for-elementor'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'rows',
            [
                'label' => esc_html__('Rows', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $row_repeater->get_controls(),
                'default' => [
                    ['row_cells' => esc_html__('Basic, $10/mo, 10GB', 'lc-addons-kit-for-elementor')],
                    ['row_cells' => esc_html__('Pro, $25/mo, 100GB', 'lc-addons-kit-for-elementor')],
                    ['row_cells' => esc_html__('Enterprise, $50/mo, 1TB', 'lc-addons-kit-for-elementor')],
                ],
                'title_field' => '{{{ row_cells }}}',
            ]
        );

        $this->add_control(
            'striped',
            [
                'label' => esc_html__('Striped Rows', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style',
            [
                'label' => esc_html__('Style', 'lc-addons-kit-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'header_bg',
            [
                'label' => esc_html__('Header Background', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#3b82f6',
                'selectors' => ['{{WRAPPER}} .lcake-data-table thead th' => 'background-color: {{VALUE}};'],
            ]
        );

        $this->add_control(
            'header_color',
            [
                'label' => esc_html__('Header Text Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => ['{{WRAPPER}} .lcake-data-table thead th' => 'color: {{VALUE}};'],
            ]
        );

        $this->add_control(
            'stripe_color',
            [
                'label' => esc_html__('Stripe Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#f9fafb',
                'selectors' => ['{{WRAPPER}} .lcake-data-table.is-striped tbody tr:nth-child(even)' => 'background-color: {{VALUE}};'],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $columns = $settings['columns'] ?? [];
        $rows = $settings['rows'] ?? [];

        if (empty($columns) || empty($rows)) {
            return;
        }
        ?>
        <div class="lcake-data-table-wrapper">
            <table class="lcake-data-table<?php echo 'yes' === $settings['striped'] ? ' is-striped' : ''; ?>">
                <thead>
                    <tr>
                        <?php foreach ($columns as $col) : ?>
                            <th><?php echo esc_html($col['column_label']); ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rows as $row) :
                        $cells = array_map('trim', explode(',', $row['row_cells'] ?? ''));
                        ?>
                        <tr>
                            <?php foreach ($columns as $index => $col) : ?>
                                <td><?php echo isset($cells[$index]) ? esc_html($cells[$index]) : ''; ?></td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php
    }
}
