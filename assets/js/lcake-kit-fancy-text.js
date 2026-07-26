(function ($, window) {
    'use strict';

    var WidgetLcakeFancyTextHandler = function ($scope) {
        var $rotator = $scope.find('.lcake-fancy-text-rotator');
        if (!$rotator.length) {
            return;
        }

        var $words = $rotator.find('.lcake-fancy-text-word');
        if ($words.length < 2) {
            return;
        }

        var interval = parseInt($rotator.attr('data-interval'), 10) || 2200;
        var current = $words.filter('.is-active').index();
        if (current < 0) {
            current = 0;
        }

        var timer = setInterval(function () {
            $words.eq(current).removeClass('is-active');
            current = (current + 1) % $words.length;
            $words.eq(current).addClass('is-active');
        }, interval);

        $scope.data('lcakeFancyTextTimer', timer);
    };

    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/lcake-kit-fancy-text.default', WidgetLcakeFancyTextHandler);
    });

})(jQuery, window);
