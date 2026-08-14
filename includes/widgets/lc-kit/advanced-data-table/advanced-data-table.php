<?php
/**
 * Advanced Data Table Widget
 *
 * @package LC_Elementor_Addons_Kit
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Advanced Data Table Widget.
 *
 * Elementor widget that displays an Advanced Data Table.
 */
class LCAKE_Kit_Advanced_Data_Table extends \Elementor\Widget_Base {

	public function get_name() {
		return 'lcake-kit-advanced-data-table';
	}

	public function get_categories() {
		return array( 'lcake-page-kit' );
	}

	public function get_title() {
		return esc_html__( 'Advanced Data Table', 'lc-addons-kit-for-elementor' );
	}

	public function get_icon() {
		return 'eicon-table';
	}

	public function get_style_depends() {
		return array( 'lcake-kit-advanced-data-table-css' );
	}

	public function get_script_depends() {
		return array( 'lcake-kit-advanced-data-table-js' );
	}

	protected function register_controls() {
		$this->start_controls_section(
			'content_section',
			array(
				'label' => esc_html__( 'Content', 'lc-addons-kit-for-elementor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$col_repeater = new \Elementor\Repeater();
		$col_repeater->add_control(
			'column_label',
			array(
				'label'   => esc_html__( 'Column Label', 'lc-addons-kit-for-elementor' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Column', 'lc-addons-kit-for-elementor' ),
			)
		);

		$this->add_control(
			'columns',
			array(
				'label'       => esc_html__( 'Columns', 'lc-addons-kit-for-elementor' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $col_repeater->get_controls(),
				'default'     => array(
					array( 'column_label' => esc_html__( 'Status', 'lc-addons-kit-for-elementor' ) ),
					array( 'column_label' => esc_html__( 'Signal Name', 'lc-addons-kit-for-elementor' ) ),
					array( 'column_label' => esc_html__( 'Severity', 'lc-addons-kit-for-elementor' ) ),
					array( 'column_label' => esc_html__( 'Stage', 'lc-addons-kit-for-elementor' ) ),
					array( 'column_label' => esc_html__( 'Schedule', 'lc-addons-kit-for-elementor' ) ),
					array( 'column_label' => esc_html__( 'Team Lead', 'lc-addons-kit-for-elementor' ) ),
				),
				'title_field' => '{{{ column_label }}}',
			)
		);

		$row_repeater = new \Elementor\Repeater();
		$row_repeater->add_control(
			'row_cells',
			array(
				'label'       => esc_html__( 'Row Cells (comma separated)', 'lc-addons-kit-for-elementor' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => '',
				'label_block' => true,
			)
		);

		$this->add_control(
			'rows',
			array(
				'label'       => esc_html__( 'Rows', 'lc-addons-kit-for-elementor' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $row_repeater->get_controls(),
				'default'     => array(
					array( 'row_cells' => 'No signal, Astrid: NE shared managed, Medium, Triaged, 0:33, Chase Nguyen' ),
					array( 'row_cells' => 'Offline, Cosmo: prod shared ares, Huge, Triaged, 0:39, Brie Furman' ),
					array( 'row_cells' => 'Online, Phoenix: prod shared lyra-lists, Minor, Not triaged, 3:12, Jeremy Lake' ),
					array( 'row_cells' => 'Online, Sirius: NW prod shared locations, Negligible, Triaged, 13:18, Angelica Howards' ),
					array( 'row_cells' => 'Online, Sirius: prod independent account, Negligible, Triaged, 22:06, Diane Okuma' ),
				),
				'title_field' => '{{{ row_cells }}}',
			)
		);

		$this->add_control(
			'enable_search',
			array(
				'label'   => esc_html__( 'Enable Search', 'lc-addons-kit-for-elementor' ),
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'yes',
			)
		);

		$this->add_control(
			'enable_sort',
			array(
				'label'   => esc_html__( 'Enable Column Sorting', 'lc-addons-kit-for-elementor' ),
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'yes',
			)
		);

		$this->add_control(
			'enable_checkboxes',
			array(
				'label'   => esc_html__( 'Enable Selection Checkboxes', 'lc-addons-kit-for-elementor' ),
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'yes',
			)
		);

		$this->add_control(
			'enable_pagination',
			array(
				'label'   => esc_html__( 'Enable Pagination', 'lc-addons-kit-for-elementor' ),
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'yes',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style',
			array(
				'label' => esc_html__( 'Style', 'lc-addons-kit-for-elementor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		// Header controls group
		$this->add_control(
			'header_heading',
			array(
				'label' => esc_html__( 'Header', 'lc-addons-kit-for-elementor' ),
				'type'  => \Elementor\Controls_Manager::HEADING,
			)
		);

		$this->add_control(
			'header_bg',
			array(
				'label'     => esc_html__( 'Header Background', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#f8fafc',
				'selectors' => array( '{{WRAPPER}} .lcake-adv-table thead th' => 'background-color: {{VALUE}};' ),
			)
		);

		$this->add_control(
			'header_color',
			array(
				'label'     => esc_html__( 'Header Text Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#1e293b',
				'selectors' => array( '{{WRAPPER}} .lcake-adv-table thead th' => 'color: {{VALUE}};' ),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'header_typography',
				'selector' => '{{WRAPPER}} .lcake-adv-table thead th',
			)
		);

		// Body controls group
		$this->add_control(
			'body_heading',
			array(
				'label'     => esc_html__( 'Body Rows', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'row_bg_odd',
			array(
				'label'     => esc_html__( 'Odd Row Background', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array( '{{WRAPPER}} .lcake-adv-table tbody tr:nth-child(odd)' => 'background-color: {{VALUE}};' ),
			)
		);

		$this->add_control(
			'row_bg_even',
			array(
				'label'     => esc_html__( 'Even Row Background', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#fafbfc',
				'selectors' => array( '{{WRAPPER}} .lcake-adv-table tbody tr:nth-child(even)' => 'background-color: {{VALUE}};' ),
			)
		);

		$this->add_control(
			'row_bg_hover',
			array(
				'label'     => esc_html__( 'Row Hover Background', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => 'rgba(59, 130, 246, 0.04)',
				'selectors' => array( '{{WRAPPER}} .lcake-adv-table tbody tr:hover' => 'background-color: {{VALUE}};' ),
			)
		);

		$this->add_control(
			'body_color',
			array(
				'label'     => esc_html__( 'Text Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#475569',
				'selectors' => array( '{{WRAPPER}} .lcake-adv-table tbody td' => 'color: {{VALUE}};' ),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'body_typography',
				'selector' => '{{WRAPPER}} .lcake-adv-table tbody td',
			)
		);

		// Search bar controls group
		$this->add_control(
			'search_heading',
			array(
				'label'     => esc_html__( 'Search Bar', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'search_border_color',
			array(
				'label'     => esc_html__( 'Search Border Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => 'rgba(226, 232, 240, 0.8)',
				'selectors' => array( '{{WRAPPER}} .lcake-adv-table-search' => 'border-color: {{VALUE}};' ),
			)
		);

		$this->add_control(
			'search_focus_border_color',
			array(
				'label'     => esc_html__( 'Search Focus Border Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#3b82f6',
				'selectors' => array( '{{WRAPPER}} .lcake-adv-table-search:focus' => 'border-color: {{VALUE}};' ),
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$columns  = $settings['columns'] ?? array();
		$rows     = $settings['rows'] ?? array();

		if ( empty( $columns ) || empty( $rows ) ) {
			return;
		}

		$show_checkboxes = 'yes' === $settings['enable_checkboxes'];
		$show_pagination = 'yes' === $settings['enable_pagination'];

		$format_cell = function ( $value ) {
			$trimmed = trim( $value );
			if ( 'No signal' === $trimmed ) {
				return '<span class="lcake-table-status status-no-signal"><svg class="status-svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#f97316" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/></svg> ' . esc_html( $trimmed ) . '</span>';
			} elseif ( 'Offline' === $trimmed ) {
				return '<span class="lcake-table-status status-offline"><svg class="status-svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/></svg> ' . esc_html( $trimmed ) . '</span>';
			} elseif ( 'Online' === $trimmed ) {
				return '<span class="lcake-table-status status-online"><svg class="status-svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg> ' . esc_html( $trimmed ) . '</span>';
			}
			return esc_html( $value );
		};
		?>
		<div class="lcake-adv-table-wrapper">
			<?php if ( 'yes' === $settings['enable_search'] ) : ?>
				<div class="lcake-adv-table-toolbar">
					<div class="lcake-adv-table-search-container">
						<span class="lcake-adv-table-search-icon">
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-search"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
						</span>
						<input type="search" class="lcake-adv-table-search" placeholder="<?php echo esc_attr__( 'Search…', 'lc-addons-kit-for-elementor' ); ?>">
					</div>
				</div>
			<?php endif; ?>
			<div class="lcake-adv-table-scroller">
				<table class="lcake-adv-table" data-sortable="<?php echo esc_attr( $settings['enable_sort'] ); ?>">
					<thead>
						<tr>
							<?php if ( $show_checkboxes ) : ?>
								<th style="width: 50px;"><input type="checkbox" class="lcake-adv-table-select-all"></th>
							<?php endif; ?>
							<?php foreach ( $columns as $col ) : ?>
								<th><span><?php echo esc_html( $col['column_label'] ); ?></span></th>
							<?php endforeach; ?>
						</tr>
					</thead>
					<tbody>
						<?php
						foreach ( $rows as $row ) :
							$cells = array_map( 'trim', explode( ',', $row['row_cells'] ?? '' ) );
							?>
							<tr>
								<?php if ( $show_checkboxes ) : ?>
									<td><input type="checkbox" class="lcake-adv-table-row-select"></td>
								<?php endif; ?>
								<?php foreach ( $columns as $index => $col ) : ?>
									<td><?php echo isset( $cells[ $index ] ) ? wp_kses_post( $format_cell( $cells[ $index ] ) ) : ''; ?></td>
								<?php endforeach; ?>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
			<?php if ( $show_pagination ) : ?>
				<div class="lcake-adv-table-footer">
					<div class="lcake-adv-table-rows-per-page">
						<span><?php esc_html_e( 'Rows per page', 'lc-addons-kit-for-elementor' ); ?></span>
						<select class="lcake-adv-table-page-size">
							<option value="5">5</option>
							<option value="10" selected>10</option>
							<option value="25">25</option>
							<option value="50">50</option>
							<option value="100">100</option>
						</select>
					</div>
					<div class="lcake-adv-table-pagination-info">
						<span class="lcake-adv-table-pagination-range">0-0 of 0</span>
					</div>
					<div class="lcake-adv-table-pagination-buttons">
						<button class="lcake-adv-table-page-first" title="First Page"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m17 18-6-6 6-6M7 5v14"/></svg></button>
						<button class="lcake-adv-table-page-prev" title="Previous Page"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg></button>
						<button class="lcake-adv-table-page-next" title="Next Page"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg></button>
						<button class="lcake-adv-table-page-last" title="Last Page"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m7 18 6-6-6-6M17 5v14"/></svg></button>
					</div>
				</div>
			<?php endif; ?>
			<p class="lcake-adv-table-empty" style="display:none;"><?php esc_html_e( 'No matching records found.', 'lc-addons-kit-for-elementor' ); ?></p>
		</div>
		<?php
	}
}
