<div class="lc-testimonial-slider arrow_inside <?php echo (!empty($lc_testimonial_show_dot) && $lc_testimonial_show_dot === 'yes') ? 'lc-slider-dotted' : '' ?>" <?php $this->print_render_attribute_string('wrapper'); ?>>
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
						<<?php echo esc_attr($wrapTag); ?> class="lc-testimonial-item" <?php echo $this->get_render_attribute_string('link-' . esc_attr($testimonial['_id'])); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Already escaped by elementor 
																						?>>
							<div class="lc-single-testimonial-slider <?php echo esc_attr(!empty($testimonial['lc_testimonial_active']) ? 'testimonial-active' : ''); ?>">
								<div class="lc-commentor-content">
									<?php
									if (isset($testimonial['client_logo']) && !empty($testimonial['client_logo']['url']) && sizeof($testimonial['client_logo']) > 0) {	?>
										<div class="lc-client-logo">
											<?php if (isset($testimonial['client_logo_active']) && sizeof($testimonial['client_logo_active']) > 0 && $testimonial['use_hover_logo'] == 'yes') : ?>
												<?php echo wp_kses(\LC_Kit_Utils::get_attachment_image_html($testimonial, 'client_logo_active', 'full', [
													'class'	=> 'lc-testimonial-client-active-logo'
												]), \LC_Kit_Utils::get_kses_array()); ?>
											<?php endif; ?>
											<?php echo wp_kses(\LC_Kit_Utils::get_attachment_image_html($testimonial, 'client_logo', 'full', [
												'class'	=> 'lc-testimonial-client-logo'
											]), \LC_Kit_Utils::get_kses_array()); ?>
										</div>
									<?php
									}
									if (isset($testimonial['review']) && !empty($testimonial['review'])) : ?>
										<p><?php echo isset($testimonial['review']) ? wp_kses($testimonial['review'], \LC_Kit_Utils::get_kses_array()) : ''; ?></p>
									<?php endif;  ?>
									<?php if ('yes' == $lc_testimonial_title_separetor): ?>
										<span class="lc-border-hr"></span>
									<?php endif; ?>
									<span class="lc-profile-info">
										<strong class="lc-author-name"><?php echo isset($testimonial['client_name']) ? esc_html($testimonial['client_name']) : ''; ?></strong>
										<span class="lc-author-des"><?php echo isset($testimonial['designation']) ? wp_kses(\LC_Kit_Utils::kspan($testimonial['designation']), \LC_Kit_Utils::get_kses_array()) : ''; // phpcs:ignore WordPress.Security.EscapeOutput -- Already escaped by kspan method by lc-kit
																	?></span>
									</span>
								</div>
								<?php if (isset($lc_testimonial_wartermark_enable) && $lc_testimonial_wartermark_enable == 'yes'): ?>
									<div class="lc-watermark-icon <?php if ($lc_testimonial_wartermark_custom_position == 'yes') : ?> lc_watermark_icon_custom_position <?php endif; ?>">
										<?php \Elementor\Icons_Manager::render_icon($settings['ekit_testimonial_wartermarks'], ['aria-hidden' => 'true']); ?>
									</div>
								<?php endif; ?>
							</div>
						</<?php echo esc_attr($wrapTag); ?>>
					</div>
				</div>
			<?php endforeach; ?>
		</div>

		<?php if (!empty($lc_testimonial_show_dot) && $lc_testimonial_show_dot === 'yes') : ?>
			<div class="swiper-pagination"></div>
		<?php endif; ?>

		<?php if (!empty($lc_testimonial_show_arrow) && $lc_testimonial_show_arrow === 'yes') : ?>
			<div class="swiper-navigation-button swiper-button-prev">
				<?php \Elementor\Icons_Manager::render_icon($lc_testimonial_left_arrows, ['aria-hidden' => 'true']); ?>
			</div>
			<div class="swiper-navigation-button swiper-button-next">
				<?php \Elementor\Icons_Manager::render_icon($lc_testimonial_right_arrows, ['aria-hidden' => 'true']); ?>
			</div>
		<?php endif; ?>
	</div>
</div>