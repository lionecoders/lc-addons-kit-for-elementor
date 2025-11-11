<div class="lcake-testimonial-slider lcake_testimonial_style_2 arrow_inside <?php echo (!empty($lcake_testimonial_show_dot) && $lcake_testimonial_show_dot === 'yes') ? 'lcake-slider-dotted' : '' ?>" <?php $this->print_render_attribute_string('wrapper'); ?>>
	<div <?php $this->print_render_attribute_string('swiper-container'); ?>>
		<div class="swiper-wrapper">
			<?php
			foreach ($testimonials as $testimonial):
				$wrapTag = 'div';

				if (!empty($testimonial['link']['url'])):
					$wrapTag = 'a';
					$this->add_link_attributes('link-' . $testimonial['_id'], $testimonial['link']);
				endif;
			?>
				<div class="swiper-slide">
					<div class="swiper-slide-inner">
						<<?php echo esc_attr($wrapTag); ?> class="lcake-testimonial-item" <?php echo $this->get_render_attribute_string('link-' . esc_attr($testimonial['_id'])); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Already escaped by elementor 
																						?>>
							<div class="lcake-single-testimonial-slider">
								<div class="lcake-commentor-content">
									<?php
									if (isset($testimonial['client_logo']) && !empty($testimonial['client_logo']['url']) && sizeof($testimonial['client_logo']) > 0) {	?>
										<div class="lcake-client-logo">
											<?php if (isset($testimonial['client_logo_active']) && sizeof($testimonial['client_logo_active']) > 0 && $testimonial['use_hover_logo'] == 'yes') : ?>
												<?php echo wp_kses(\LCAKE_Kit_Utils::get_attachment_image_html($testimonial, 'client_logo_active', 'full', [
													'class'	=> 'lcake-testimonial-client-active-logo'
												]), \LCAKE_Kit_Utils::get_kses_array()); ?>
											<?php endif; ?>
											<?php echo wp_kses(\LCAKE_Kit_Utils::get_attachment_image_html($testimonial, 'client_logo', 'full', [
												'class'	=> 'lcake-testimonial-client-logo'
											]), \LCAKE_Kit_Utils::get_kses_array()); ?>
										</div>
									<?php
									}
									if (isset($testimonial['review']) && !empty($testimonial['review'])) : ?>
										<p><?php echo isset($testimonial['review']) ? wp_kses($testimonial['review'], \LCAKE_Kit_Utils::get_kses_array()) : ''; ?></p>
									<?php endif;  ?>
									<?php if ('yes' == $lcake_testimonial_title_separetor): ?>
										<span class="lcake-border-hr"></span>
									<?php endif; ?>
									<span class="lcake-profile-info">
										<strong class="lcake-author-name"><?php echo isset($testimonial['client_name']) ? esc_html($testimonial['client_name']) : ''; ?></strong>
										<span class="lcake-author-des"><?php echo isset($testimonial['designation']) ? wp_kses(\LCAKE_Kit_Utils::kspan($testimonial['designation']), \LCAKE_Kit_Utils::get_kses_array()) : ''; // phpcs:ignore WordPress.Security.EscapeOutput -- Already escaped by kspan method by lcake-kit
																	?></span>
									</span>
								</div>
								<?php if (isset($lcake_testimonial_wartermark_enable) && $lcake_testimonial_wartermark_enable == 'yes'): ?>
									<div class="lcake-watermark-icon <?php if ($lcake_testimonial_wartermark_custom_position == 'yes') : ?> lcake_watermark_icon_custom_position <?php endif; ?>">
										<?php \Elementor\Icons_Manager::render_icon($settings['lcake_testimonial_wartermarks'], ['aria-hidden' => 'true']); ?>
									</div>
								<?php endif; ?>
							</div>
						</<?php echo esc_attr($wrapTag); ?>>
					</div>
				</div>
			<?php endforeach; ?>
		</div>

		<?php if (!empty($lcake_testimonial_show_dot) && $lcake_testimonial_show_dot === 'yes') : ?>
			<div class="swiper-pagination"></div>
		<?php endif; ?>

		<?php if (!empty($lcake_testimonial_show_arrow) && $lcake_testimonial_show_arrow === 'yes') : ?>
			<div class="swiper-navigation-button swiper-button-prev">
				<?php \Elementor\Icons_Manager::render_icon($lcake_testimonial_left_arrows, ['aria-hidden' => 'true']); ?>
			</div>
			<div class="swiper-navigation-button swiper-button-next">
				<?php \Elementor\Icons_Manager::render_icon($lcake_testimonial_right_arrows, ['aria-hidden' => 'true']); ?>
			</div>
		<?php endif; ?>
	</div>
</div>