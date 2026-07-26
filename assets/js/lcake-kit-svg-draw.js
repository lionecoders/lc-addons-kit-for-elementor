(function ($, window, document) {
    'use strict';

    var WidgetLcakeSvgDrawHandler = function ($scope) {
        var $draw = $scope.find('.lcake-svg-draw');
        if (!$draw.length) {
            return;
        }

        var duration = parseInt($draw.attr('data-duration'), 10) || 2000;
        var trigger = $draw.attr('data-trigger') || 'viewport';

        $draw.find('path, polyline, circle, line').each(function () {
            var length = 1000;
            try {
                if (typeof this.getTotalLength === 'function') {
                    length = this.getTotalLength();
                }
            } catch (e) {
                length = 1000;
            }
            this.style.setProperty('--lcake-svg-length', length);
        });

        $draw[0].style.setProperty('--lcake-svg-duration', duration + 'ms');

        var startDraw = function () {
            $draw.addClass('is-drawn');
        };

        if ('load' === trigger || typeof window.IntersectionObserver === 'undefined') {
            startDraw();
            return;
        }

        var observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    startDraw();
                    observer.disconnect();
                }
            });
        }, { threshold: 0.3 });

        observer.observe($draw[0]);
    };

    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/lcake-kit-svg-draw.default', WidgetLcakeSvgDrawHandler);
    });

})(jQuery, window, document);
