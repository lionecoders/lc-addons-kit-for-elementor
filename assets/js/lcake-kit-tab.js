/* Lightweight tab behavior for LCAKE Tab widget */
(function ($) {
	'use strict';

	function activateTab($wrapper, $link) {
		var target = $link.attr('data-target');
		if (!target) return;

		// Deactivate all
		$wrapper.find('.lcake-nav-link').removeClass('active show');
		$wrapper.find('.lcake-tab-pane').removeClass('active show');

		// Activate current
		$link.addClass('active show');
		var $pane = $wrapper.find(target).addClass('active show');

		// Retrigger fade-in animation if present
		var $anim = $pane.find('.animated.fadeIn');
		if ($anim.length) {
			$anim.removeClass('animated fadeIn');
			// Force reflow to restart CSS animation
			void $anim[0].offsetWidth;
			$anim.addClass('animated fadeIn');
		}
	}

	function bindTab($wrapper) {
		var $links = $wrapper.find('.lcake-nav-link');
		if (!$links.length) return;

		$links.each(function () {
			var $link = $(this);
			var trigger = $link.attr('data-lcake-toggle-trigger') || 'click';
			var handler = function (e) {
				e.preventDefault();
				activateTab($wrapper, $link);
			};

			if (trigger === 'mouseenter') {
				$link.on('mouseenter', handler);
			} else {
				$link.on('click', handler);
			}
		});
	}

	$(document).on('ready elementor/frontend/init', function () {
		var init = function ($scope) {
			$scope.find('.lcake-tab-wraper').each(function () {
				bindTab($(this));
			});
		};

		// Init on page load
		init($(document));

		// Init when Elementor renders widgets
		if (window.elementorFrontend && elementorFrontend.hooks) {
			elementorFrontend.hooks.addAction('frontend/element_ready/lcake-kit-tab.default', init);
		}
	});
})(jQuery);


