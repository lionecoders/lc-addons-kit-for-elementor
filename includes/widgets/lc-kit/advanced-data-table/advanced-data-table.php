<?php
/**
 * Advanced Data Table Widget
 *
 * @package LC_Elementor_Addons_Kit
 */

if (!defined('ABSPATH')) {
    exit;
}

class LCAKE_Kit_Advanced_Data_Table extends \Elementor\Widget_Base {

    public function get_name() {
        return 'lcake-kit-advanced-data-table';
    }

    public function get_categories() {
        return ['lcake-page-kit'];
    }

    public function get_title() {
        return esc_html__('LC Advanced Data Table', 'lc-addons-kit-for-elementor');
    }

    public function get_icon() {
        return 'eicon-table';
    }

    public function get_style_depends() {
        return ['lcake-kit-advanced-data-table-css'];
    }

    public function get_script_depends() {
        return ['lcake-kit-advanced-data-table-js'];
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
                    ['column_label' => esc_html__('Name', 'lc-addons-kit-for-elementor')],
                    ['column_label' => esc_html__('Role', 'lc-addons-kit-for-elementor')],
                    ['column_label' => esc_html__('Location', 'lc-addons-kit-for-elementor')],
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
                'default' => '',
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
                    ['row_cells' => 'John Smith, Designer, New York'],
                    ['row_cells' => 'Amy Chen, Developer, Toronto'],
                    ['row_cells' => 'Omar Ali, Manager, London'],
                ],
                'title_field' => '{{{ row_cells }}}',
            ]
        );

        $this->add_control(
            'enable_search',
            [
                'label' => esc_html__('Enable Search', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'enable_sort',
            [
                'label' => esc_html__('Enable Column Sorting', 'lc-addons-kit-for-elementor'),
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
                'selectors' => ['{{WRAPPER}} .lcake-adv-table thead th' => 'background-color: {{VALUE}};'],
            ]
        );

        $this->add_control(
            'header_color',
            [
                'label' => esc_html__('Header Text Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => ['{{WRAPPER}} .lcake-adv-table thead th' => 'color: {{VALUE}};'],
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
        <div class="lcake-adv-table-wrapper">
            <?php if ('yes' === $settings['enable_search']) : ?>
                <div class="lcake-adv-table-toolbar">
                    <input type="search" class="lcake-adv-table-search" placeholder="<?php echo esc_attr__('Search…', 'lc-addons-kit-for-elementor'); ?>">
                </div>
            <?php endif; ?>
            <div class="lcake-adv-table-scroller">
                <table class="lcake-adv-table" data-sortable="<?php echo esc_attr($settings['enable_sort']); ?>">
                    <thead>
                        <tr>
                            <?php foreach ($columns as $col) : ?>
                                <th><span><?php echo esc_html($col['column_label']); ?></span></th>
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
            <p class="lcake-adv-table-empty" style="display:none;"><?php esc_html_e('No matching records found.', 'lc-addons-kit-for-elementor'); ?></p>
        </div>
        <?php
    }
}
