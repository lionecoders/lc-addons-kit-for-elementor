(function ($, window) {
    'use strict';

    var WidgetLcakeStickyVideoHandler = function ($scope) {
        var $video = $scope.find('.lcake-sticky-video');
        if (!$video.length || typeof window.IntersectionObserver === 'undefined') {
            return;
        }

        var closed = false;

        var observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (closed) {
                    return;
                }
                $video.toggleClass('is-docked', !entry.isIntersecting);
            });
        }, { threshold: 0 });

        observer.observe($video[0]);

        $video.find('.lcake-sticky-video-close').on('click', function () {
            closed = true;
            $video.removeClass('is-docked');
        });
    };

    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/lcake-kit-sticky-video.default', WidgetLcakeStickyVideoHandler);
    });

})(jQuery, window);
