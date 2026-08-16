(function ($, window) {
    'use strict';

    var WidgetLcakeWooProductImagesHandler = function ($scope) {
        var $wrapper = $scope.find('.lcake-woo-images');
        if (!$wrapper.length) {
            return;
        }

        var $mainImages = $wrapper.find('.lcake-woo-images-main-image');
        var $thumbs = $wrapper.find('.lcake-woo-images-thumb');

        $thumbs.on('click', function () {
            var index = $(this).attr('data-index');

            $thumbs.removeClass('is-active');
            $(this).addClass('is-active');

            $mainImages.removeClass('is-active');
            $mainImages.eq(index).addClass('is-active');
        });
    };

    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/lcake-kit-woo-product-images.default', WidgetLcakeWooProductImagesHandler);
    });

})(jQuery, window);
