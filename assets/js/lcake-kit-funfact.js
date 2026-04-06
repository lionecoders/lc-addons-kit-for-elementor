(function ($) {
    "use strict";

    var WidgetFunfactHandler = function ($scope, $) {
        var $counter = $scope.find('.number-percentage');
        if (!$counter.length) {
            return;
        }

        // Only run animation once by adding a class 
        if ($counter.hasClass('animated')) {
            return;
        }

        var target = parseInt($counter.data('value'), 10) || 0;
        var duration = parseInt($counter.data('animation-duration'), 10) || 2000;

        var startAnimation = function() {
            $counter.addClass('animated');
            $counter.prop('Counter', 0).animate({
                Counter: target
            }, {
                duration: duration,
                easing: 'swing',
                step: function (now) {
                    $counter.text(Math.ceil(now));
                }
            });
        };

        // Use Elementor's native waypoint (fires when element is in view)
        if (typeof elementorFrontend !== 'undefined' && elementorFrontend.waypoint) {
            elementorFrontend.waypoint($scope, startAnimation);
        } else {
            // Fallback if waypoint not available immediately
            startAnimation();
        }
    };

    var initializeWidget = function() {
        elementorFrontend.hooks.addAction('frontend/element_ready/lcake-kit-funfact.default', WidgetFunfactHandler);
    };

    // Race-condition safe init:
    // If elementorFrontend is already fully active, bind immediately.
    // Otherwise, wait for the initialization event.
    $(window).on('elementor/frontend/init', initializeWidget);

    // Also run for already loaded widgets immediately if the script was deferred
    if (typeof elementorFrontend !== 'undefined' && elementorFrontend.isEditMode()) {
        // In editor mode, elementorFrontend is immediately available, but we rely on the hooks anyway.
    } else if (typeof elementorFrontend !== 'undefined') {
        // Directly trigger for items already in the DOM natively if hook missed
        $('.elementor-widget-lcake-kit-funfact').each(function() {
            WidgetFunfactHandler($(this), $);
        });
    }

})(jQuery);
