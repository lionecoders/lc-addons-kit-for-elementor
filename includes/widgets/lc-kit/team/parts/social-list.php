<?php \Elementor\Icons_Manager::enqueue_shim(); ?>
<ul class="lcake-team-social-list">
	<?php foreach ($lcake_team_social_icons as $icon) { ?>
		<li <?php echo $this->get_render_attribute_string('social_item_' . $icon['_id']); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Already escaped by elementor ?>>
			<a <?php echo $this->get_render_attribute_string('social_link_' . $icon['_id']); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Already escaped by elementor ?>>
				<?php \Elementor\Icons_Manager::render_icon( $icon['lcake_team_icons'], [ 'aria-hidden' => 'true' ] ); ?>
			</a>
		</li>
	<?php } ?>
</ul>