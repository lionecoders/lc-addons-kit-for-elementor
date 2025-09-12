<div class="lcake-testimonial-slider arrow_inside lcake-default-testimonial <?php echo (!empty($lcake_testimonial_show_dot) && $lcake_testimonial_show_dot === 'yes') ? 'lcake-slider-dotted' : '' ?>" <?php $this->print_render_attribute_string('wrapper'); ?>>
	<div <?php $this->print_render_attribute_string('swiper-container'); ?>>
		<div class="swiper-wrapper">
			<?php
			// start foreach loop
			foreach ($testimonials as $testimonial):
				$wrapTag = 'div';

				if (!empty($testimonial['link']['url'])):
					$wrapTag = 'a';
					$this->add_link_attributes('link-' . $testimonial['_id'], $testimonial['link']);
				endif;
			?>
				<div class="swiper-slide">
					<div class="swiper-slide-inner">
						<<?php echo esc_attr($wrapTag); ?> class="lcake-testimonial-item" <?php echo $this->get_render_attribute_string('link-' . $testimonial['_id']); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Already escaped by elementor 
																						?>>
							<div class="lcake-single-testimonial-slider <?php echo esc_attr(!empty($testimonial['lcake_testimonial_active']) ? 'testimonial-active' : ''); ?>">
								<div class="row">
									<div class="col-lg-6 lcake-testimonial-col">
										<div class="lcake-commentor-content">
											<?php if (isset($testimonial['client_logo']) && !empty($testimonial['client_logo']['url']) && sizeof($testimonial['client_logo']) > 0) { ?>
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
											} ?>
											<?php if (isset($testimonial['review']) && !empty($testimonial['review'])) : ?>
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
									</div>
									<div class="col-lg-6 lcake-testimonial-col">
										<div class="lcake-profile-image-card">
											<?php if (isset($testimonial['client_photo']) && !empty($testimonial['client_photo']['url']) &&  sizeof($testimonial['client_photo']) > 0) {
												echo wp_kses(\LCAKE_Kit_Utils::get_attachment_image_html($testimonial, 'client_photo', 'full'), \LCAKE_Kit_Utils::get_kses_array());
											?>
											<?php } ?>
										</div>
									</div>
								</div>
							</div>
						</<?php echo esc_attr($wrapTag); ?>>
					</div>
				</div>
			<?php endforeach; // end foreach loop 
			?>
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