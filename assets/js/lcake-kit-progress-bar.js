(function($){
	function animateBar($widget){
		if($widget.data('lcake-bar-animated')) return;
		$widget.data('lcake-bar-animated', true);

		$widget.find('.lcake-single-skill-bar').each(function(){
			var $item = $(this);
			var $track = $item.find('.lcake-bar-track');
			var $num = $item.find('.lcake-number-percentage');
			var target = parseInt($num.data('value'), 10) || 0;
			var duration = parseInt($num.data('animation-duration'), 10) || 1200;

			$track.css({ width: '0%' });
			$track.stop().animate({ width: target + '%' }, {
				duration: duration,
				easing: 'swing'
			});

			$({count: 0}).animate({count: target}, {
				duration: duration,
				easing: 'swing',
				step: function(now){
					$num.text(Math.floor(now));
				}
			});
		});
	}

	var WidgetHandler = function($scope){
		var $wrapper = $scope.find('.lcake-main-wrapper').first();
		if(!$wrapper.length){
			$wrapper = $scope;
		}

		// Trigger on load and when entering viewport
		var triggered = false;
		function maybeAnimate(){
			if(triggered) return;
			var rect = $wrapper[0].getBoundingClientRect();
			if(rect.top < window.innerHeight && rect.bottom > 0){
				triggered = true;
				animateBar($wrapper);
			}
		}

		maybeAnimate();
		$(window).on('scroll.lcakeBar resize.lcakeBar', maybeAnimate);
		$scope.on('destroy', function(){
			$(window).off('scroll.lcakeBar resize.lcakeBar', maybeAnimate);
		});
	};

	$(window).on('elementor/frontend/init', function(){
		var handler = WidgetHandler;
		if (window.elementorFrontend && window.elementorFrontend.hooks){
			window.elementorFrontend.hooks.addAction('frontend/element_ready/lcake-kit-progress-bar.default', handler);
		}
	});

	// Fallback for frontend (non-editor) where hooks may not fire
	$(function(){
		$('.elementor-widget-lcake-kit-progress-bar').each(function(){
			WidgetHandler($(this));
		});
	});
})(jQuery);


