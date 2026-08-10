<?php

/**
 * Registers custom icon sets within the Elementor editor.
 *
 * @since 1.0.0
 */
class LCAKE_Lib {

	/**
	 * Constructor.
	 * 
	 * Hooks into the Elementor icons manager to add additional icon tabs.
	 *
	 * @since 1.0.0
	 */
	function __construct() {
		// Register custom icon set with Elementor
		add_filter( 'elementor/icons_manager/additional_tabs', array( $this, 'lcake_icon_tab' ) );
	}

	/**
	 * Adds the "LCAKE Icons" tab to the Elementor Icon Library modal.
	 *
	 * @since 1.0.0
	 * @param array $tabs The existing icon tabs array.
	 * @return array The modified icon tabs array containing the new custom icons.
	 */
	function lcake_icon_tab( $tabs ) {
		// Ensure constants exist
		if ( ! defined( 'LCAKE_EAK_URL' ) ) {
			return $tabs;
		}

		$tabs['lcakeicons'] = array(
			'name'          => 'lcakeicons',
			'label'         => __( 'LCAKE Icons', 'lc-addons-kit-for-elementor' ),
			'labelIcon'     => 'eicon-favorite',
			'prefix'        => 'lcake-icon',
			'displayPrefix' => 'lcake-icon',
			'enqueue'       => array( LCAKE_EAK_URL . 'assets/icons/lcakeicons.css' ),
			'ver'           => '1.0.0',
			'native'        => true,
			'icons'         => array(
				'th',
				'mail',
				'chart-bar',
				'chart-pie-1',
				'chart-pie-outline',
				'chart',
				'chart-pie-2',
				'chart-pie-alt',
				'chart-pie-3',
				'comment',
				'chat',
				'chat-1',
				'chat-alt',
				'chat-2',
				'user',
				'user-1',
				'users',
				'user-outline',
				'user-2',
				'user-3',
				'user-pair',
				'user-4',
				'user-5',
				'location',
				'location-1',
				'location-outline',
				'location-inv',
				'location-alt',
				'location-2',
				'quote-left',
				'quote-right',
				'quote',
				'quote-1',
				'quote-left-alt',
				'quote-right-alt',
				'quote-circled',
				'thumbs-up',
				'thumbs-down',
				'comment-1',
				'headphones',
				'truck',
				'megaphone',
				'key',
				'clipboard',
				'credit-card',
				'air',
				'cc-nd',
				'stopwatch',
				'wristwatch',
				'scissors-outline',
				'bat2',
				'info',
				'rain',
				'minefield',
				'wordpress',
				'minus-circled',
				'tags',
				'tag',
				'bookmark',
				'indent-right',
				'right-dir',
				'right-circled',
				'left-circled',
				'down-circled',
				'left-bold',
				'up-bold',
				'down-bold',
				'right-thin',
				'up-thin',
				'up',
				'right',
				'left',
				'to-start',
				'fast-backward',
				'fast-forward',
				'to-end',
				'record',
				'pause',
				'stop',
				'play',
				'cloud-thunder',
				'moon',
				'paper-plane',
				'leaf',
				'contrast',
				'globe-outline',
				'fast-fw-outline',
				'pause-1',
				'pause-outline',
				'sort-alphabet-outline',
				'key-outline',
				'plane-outline',
				'wifi',
				'signal',
				'cloud',
				'rain-1',
				'gplus-circled',
				'check-empty',
				'bookmark-empty',
				'facebook',
				'tasks',
				'gplus',
				'sort-up',
				'mail-alt',
				'comment-empty',
				'chat-empty',
				'medkit',
				'quote-left-1',
				'quote-right-1',
				'circle',
				'minus-squared',
				'pencil-squared',
				'linux',
				'skype',
				'vkontakte',
				'weibo',
				'drupal',
				'cubes',
				'cab',
				'tree',
				'database',
				'bell-off-empty',
				'trash',
				'chart-area',
				'chart-pie',
				'toggle-on',
				'bus',
				'motorcycle',
				'facebook-official',
				'bed',
				'viacoin',
				'hourglass',
				'hand-scissors-o',
				'wikipedia-w',
				'opera',
				'fonticons',
				'reddit-alien',
				'user-o',
				'facebook-1',
				'facebook-rect',
				'facebook-squared',
				'linkedin-squared',
				'instagram',
				'spinner2',
			),
		);

		return $tabs;
	}
}
