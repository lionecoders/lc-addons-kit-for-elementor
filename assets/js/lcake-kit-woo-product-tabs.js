( function ( $ ) {
	'use strict';

	var WidgetWooProductTabsHandler = function ( $scope, $ ) {
		var $tabsWrapper = $scope.find( '.lcake-woo-tabs' );

		if ( ! $tabsWrapper.length ) {
			return;
		}

		var $tabs = $tabsWrapper.find( 'ul.tabs' );
		var $panels = $tabsWrapper.find( '.woocommerce-Tabs-panel' );

		// Initial state
		$panels.hide();
		
		var $activeTab = $tabs.find( 'li.active' );
		if ( ! $activeTab.length ) {
			$activeTab = $tabs.find( 'li:first' );
			$activeTab.addClass( 'active' );
		}
		
		var initialPanelId = $activeTab.find( 'a' ).attr( 'href' );
		$tabsWrapper.find( initialPanelId ).show();

		// Handle click event
		$tabs.on( 'click', 'a', function ( e ) {
			e.preventDefault();
			e.stopPropagation();
			
			var $this = $( this );
			var $li = $this.closest( 'li' );
			var panelId = $this.attr( 'href' );

			if ( $li.hasClass( 'active' ) ) {
				return;
			}

			// Update tabs
			$tabs.find( 'li' ).removeClass( 'active' );
			$li.addClass( 'active' );

			// Update panels
			$panels.filter( ':visible' ).fadeOut( 200, function() {
				$tabsWrapper.find( panelId ).fadeIn( 200 );
			} );
		} );
	};

	$( window ).on( 'elementor/frontend/init', function () {
		elementorFrontend.hooks.addAction(
			'frontend/element_ready/lcake-kit-woo-product-tabs.default',
			WidgetWooProductTabsHandler
		);
	} );

} )( jQuery );
