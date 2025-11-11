<?php
$close_btn_align_class = 'lcake-team-close-btn-align-right';
if ( isset( $lcake_modal_close_align ) && 'left' === $lcake_modal_close_align ) {
    $close_btn_align_class = 'lcake-team-close-btn-align-left';
}
?>
<div class="modal fade lcake-team-popup lcake-team-modal team-popup-id-<?php echo esc_attr($this->get_id()); ?>" id="lcake_team_modal_<?php echo esc_attr($this->get_id() . '_' . get_the_ID()); ?>" tabindex="-1" role="dialog" aria-hidden="true" aria-modal="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="lcake-team-modal-close <?php echo esc_attr($close_btn_align_class); ?>" aria-label="Close" data-bs-dismiss="modal">
                <?php if ( !empty($lcake_team_close_icon_changes) && is_array($lcake_team_close_icon_changes) ) {
                \Elementor\Icons_Manager::render_icon($lcake_team_close_icon_changes, ['aria-hidden' => 'true']);
                } else { ?>
                <span aria-hidden="true">&times;</span>
                <?php } ?>
            </button>

            <div class="modal-body">

                <div class="lcake-team-modal-info<?php echo !empty($image_html) ? ' has-img' : ''; ?>">
                    <h2 class="lcake-team-modal-title"><?php echo esc_html($lcake_team_name); ?></h2>
                    <p class="lcake-team-modal-position"><?php echo esc_html($lcake_team_position); ?></p>

                    <div class="lcake-team-modal-content">
                        <?php echo wp_kses($lcake_team_description, \LCAKE_Kit_Utils::get_kses_array()); ?>
                    </div>

                    <?php if ($lcake_team_phone || $lcake_team_email) { ?>
                        <ul class="lcake-team-modal-list">
                            <?php if ($lcake_team_phone): ?>
                                <li><strong><?php esc_html_e('Phone', 'lc-addons-kit-for-elementor'); ?>:</strong><a href="tel:<?php echo esc_attr($lcake_team_phone); ?>"><?php echo esc_html($lcake_team_phone); ?></a></li>
                            <?php endif; ?>

                            <?php if ($lcake_team_email): ?>
                                <li><strong><?php esc_html_e('Email', 'lc-addons-kit-for-elementor'); ?>:</strong><a href="mailto:<?php echo esc_attr($lcake_team_email); ?>"><?php echo esc_html($lcake_team_email); ?></a></li>
                            <?php endif; ?>
                        </ul>
                    <?php } ?>

                    <?php
                    if (isset($lcake_team_social_enable) && $lcake_team_social_enable == 'yes' && !empty($lcake_team_social_icons) && is_array($lcake_team_social_icons)) {
                        foreach ($lcake_team_social_icons as $icon) {
                            $item_key = 'social_item_' . $icon['_id'];
                            $link_key = 'social_link_' . $icon['_id'];
                            $this->add_render_attribute($item_key, 'class', 'elementor-repeater-item-' . $icon['_id']);
                            if (!empty($icon['lcake_team_label'])) {
                                $this->add_render_attribute($link_key, 'aria-label', esc_attr($icon['lcake_team_label']));
                            }
                            if (!empty($icon['lcake_team_link']['url'])) {
                                $this->add_render_attribute($link_key, 'href', esc_url($icon['lcake_team_link']['url']));
                            } else {
                                $this->add_render_attribute($link_key, 'href', 'javascript:void(0)');
                            }
                            if (!empty($icon['lcake_team_link']['is_external'])) {
                                $this->add_render_attribute($link_key, 'target', '_blank');
                                $this->add_render_attribute($link_key, 'rel', 'noopener noreferrer');
                            }
                        }
                        require LCAKE_EAK_PATH . 'includes/widgets/lc-kit/team/parts/social-list.php';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>