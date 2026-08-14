<?php
/**
 * Search Toggle Widget
 *
 * @package LC_Elementor_Addons_Kit
 */

if (!defined('ABSPATH')) {
	exit;
}

/**
 * Search Toggle Widget.
 *
 * Elementor widget that displays a Search Toggle.
 */
class LC_Header_Footer_Search_Toggle extends \Elementor\Widget_Base
{

	public function get_name()
	{
		return 'lc-header-footer-search-toggle';
	}

	public function get_title()
	{
		return esc_html__('Search Toggle', 'lc-addons-kit-for-elementor');
	}

	public function get_icon()
	{
		return 'eicon-search';
	}

	public function get_categories()
	{
		return array('lc-header-footer-kit');
	}

	public function get_keywords()
	{
		return array('lc', 'lcake', 'search', 'toggle');
	}

	public function get_style_depends()
	{
		return array('lc-header-footer-search-toggle-css');
	}

	public function get_script_depends()
	{
		return array('lc-header-footer-search-toggle-js');
	}

	protected function register_controls()
	{
		$this->start_controls_section(
			'content_section',
			array(
				'label' => esc_html__('Content', 'lc-addons-kit-for-elementor'),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'placeholder',
			array(
				'label' => esc_html__('Placeholder', 'lc-addons-kit-for-elementor'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__('Search…', 'lc-addons-kit-for-elementor'),
			)
		);

		$this->add_control(
			'button_type',
			array(
				'label' => esc_html__('Button Type', 'lc-addons-kit-for-elementor'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'icon',
				'options' => array(
					'icon' => esc_html__('Icon', 'lc-addons-kit-for-elementor'),
					'text' => esc_html__('Text', 'lc-addons-kit-for-elementor'),
				),
			)
		);

		$this->add_control(
			'button_text',
			array(
				'label' => esc_html__('Text', 'lc-addons-kit-for-elementor'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__('Search', 'lc-addons-kit-for-elementor'),
				'condition' => array(
					'button_type' => 'text',
				),
			)
		);

		$this->add_control(
			'button_icon',
			array(
				'label' => esc_html__('Icon', 'lc-addons-kit-for-elementor'),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => array(
					'value' => 'fas fa-search',
					'library' => 'fa-solid',
				),
				'condition' => array(
					'button_type' => 'icon',
				),
			)
		);

		$this->end_controls_section();

		// ==== STYLE: GENERAL ====
		$this->start_controls_section(
			'section_general_style',
			array(
				'label' => esc_html__('General', 'lc-addons-kit-for-elementor'),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'form_width',
			array(
				'label' => esc_html__('Form Width', 'lc-addons-kit-for-elementor'),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array('px', '%', 'vw'),
				'range' => array(
					'px' => array(
						'min' => 100,
						'max' => 1200,
					),
				),
				'default' => array(
					'size' => 30,
					'unit' => '%',
				),
				'selectors' => array(
					'{{WRAPPER}} .lc-hf-search-form' => 'width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'alignment',
			array(
				'label' => esc_html__('Alignment', 'lc-addons-kit-for-elementor'),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => array(
					'left' => array(
						'title' => esc_html__('Left', 'lc-addons-kit-for-elementor'),
						'icon' => 'eicon-text-align-left',
					),
					'center' => array(
						'title' => esc_html__('Center', 'lc-addons-kit-for-elementor'),
						'icon' => 'eicon-text-align-center',
					),
					'right' => array(
						'title' => esc_html__('Right', 'lc-addons-kit-for-elementor'),
						'icon' => 'eicon-text-align-right',
					),
				),
				'prefix_class' => 'elementor-align-%s',
			)
		);

		$this->end_controls_section();

		// ==== STYLE: INPUT ====
		$this->start_controls_section(
			'section_input_style',
			array(
				'label' => esc_html__('Input', 'lc-addons-kit-for-elementor'),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name' => 'input_typography',
				'selector' => '{{WRAPPER}} .lc-hf-search-input',
			)
		);

		$this->add_control(
			'input_color',
			array(
				'label' => esc_html__('Text Color', 'lc-addons-kit-for-elementor'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => array('{{WRAPPER}} .lc-hf-search-input' => 'color: {{VALUE}};'),
			)
		);

		$this->add_control(
			'input_bg_color',
			array(
				'label' => esc_html__('Background Color', 'lc-addons-kit-for-elementor'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => array('{{WRAPPER}} .lc-hf-search-input-wrapper' => 'background-color: {{VALUE}};'),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			array(
				'name' => 'input_border',
				'selector' => '{{WRAPPER}} .lc-hf-search-input-wrapper',
			)
		);

		$this->add_control(
			'input_border_radius',
			array(
				'label' => esc_html__('Border Radius', 'lc-addons-kit-for-elementor'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array('px', '%', 'em'),
				'selectors' => array(
					'{{WRAPPER}} .lc-hf-search-input-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'input_padding',
			array(
				'label' => esc_html__('Padding', 'lc-addons-kit-for-elementor'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array('px', '%', 'em'),
				'selectors' => array(
					'{{WRAPPER}} .lc-hf-search-input' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		// ==== STYLE: BUTTON ====
		$this->start_controls_section(
			'section_button_style',
			array(
				'label' => esc_html__('Button', 'lc-addons-kit-for-elementor'),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name' => 'button_typography',
				'selector' => '{{WRAPPER}} .lc-hf-search-submit',
				'condition' => array(
					'button_type' => 'text',
				),
			)
		);

		$this->start_controls_tabs('tabs_button_style');

		// NORMAL
		$this->start_controls_tab(
			'tab_button_normal',
			array(
				'label' => esc_html__('Normal', 'lc-addons-kit-for-elementor'),
			)
		);

		$this->add_control(
			'button_text_color',
			array(
				'label' => esc_html__('Text/Icon Color', 'lc-addons-kit-for-elementor'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => array('{{WRAPPER}} .lc-hf-search-submit' => 'color: {{VALUE}};'),
			)
		);

		$this->add_control(
			'button_bg_color',
			array(
				'label' => esc_html__('Background Color', 'lc-addons-kit-for-elementor'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => array('{{WRAPPER}} .lc-hf-search-submit' => 'background-color: {{VALUE}};'),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			array(
				'name' => 'button_border',
				'selector' => '{{WRAPPER}} .lc-hf-search-submit',
			)
		);

		$this->end_controls_tab();

		// HOVER
		$this->start_controls_tab(
			'tab_button_hover',
			array(
				'label' => esc_html__('Hover', 'lc-addons-kit-for-elementor'),
			)
		);

		$this->add_control(
			'button_hover_text_color',
			array(
				'label' => esc_html__('Text/Icon Color', 'lc-addons-kit-for-elementor'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => array('{{WRAPPER}} .lc-hf-search-submit:hover' => 'color: {{VALUE}};'),
			)
		);

		$this->add_control(
			'button_hover_bg_color',
			array(
				'label' => esc_html__('Background Color', 'lc-addons-kit-for-elementor'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => array('{{WRAPPER}} .lc-hf-search-submit:hover' => 'background-color: {{VALUE}};'),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			array(
				'name' => 'button_hover_border',
				'selector' => '{{WRAPPER}} .lc-hf-search-submit:hover',
			)
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_control(
			'button_border_radius',
			array(
				'label' => esc_html__('Border Radius', 'lc-addons-kit-for-elementor'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array('px', '%', 'em'),
				'separator' => 'before',
				'selectors' => array(
					'{{WRAPPER}} .lc-hf-search-submit' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'button_padding',
			array(
				'label' => esc_html__('Padding', 'lc-addons-kit-for-elementor'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array('px', '%', 'em'),
				'selectors' => array(
					'{{WRAPPER}} .lc-hf-search-submit' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; width: auto; height: auto;',
				),
			)
		);

		$this->end_controls_section();
	}

	protected function render()
	{
		$settings = $this->get_settings_for_display();
		?>
		<form role="search" method="get" class="lc-hf-search-form" action="<?php echo esc_url(home_url('/')); ?>">
			<div class="lc-hf-search-input-wrapper">
				<input type="search" name="s" class="lc-hf-search-input"
					placeholder="<?php echo esc_attr($settings['placeholder']); ?>"
					value="<?php echo esc_attr(get_search_query()); ?>">
				<button type="button" class="lc-hf-search-clear"
					aria-label="<?php echo esc_attr__('Clear search', 'lc-addons-kit-for-elementor'); ?>">
					<i class="eicon-close" aria-hidden="true"></i>
				</button>
			</div>
			<button type="submit" class="lc-hf-search-submit"
				aria-label="<?php echo esc_attr__('Submit search', 'lc-addons-kit-for-elementor'); ?>">
				<?php if ('text' === $settings['button_type']): ?>
					<?php echo esc_html($settings['button_text']); ?>
				<?php else: ?>
					<?php \Elementor\Icons_Manager::render_icon($settings['button_icon'], array('aria-hidden' => 'true')); ?>
				<?php endif; ?>
			</button>
		</form>
		<?php
	}
}
