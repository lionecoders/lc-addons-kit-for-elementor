(function ($, window) {
    'use strict';

    var WidgetLcakeFilterableGalleryHandler = function ($scope) {
        var $gallery = $scope.find('.lcake-filterable-gallery');
        if (!$gallery.length) {
            return;
        }

        var $filters = $gallery.find('.lcake-filterable-gallery-filter');
        var $items = $gallery.find('.lcake-filterable-gallery-item');

        $filters.on('click', function () {
            var filter = $(this).attr('data-filter');

            $filters.removeClass('is-active');
            $(this).addClass('is-active');

            $items.each(function () {
                var $item = $(this);
                var categories = ($item.attr('data-category') || '').split(' ');
                var show = 'all' === filter || categories.indexOf(filter) !== -1;
                $item.toggleClass('is-hidden', !show);
            });
        });
    };

    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/lcake-kit-filterable-gallery.default', WidgetLcakeFilterableGalleryHandler);
    });

})(jQuery, window);
