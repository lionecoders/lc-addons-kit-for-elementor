(function ($, window) {
    'use strict';

    var WidgetLcakeWooProductCarouselHandler = function ($scope) {
        var $carousel = $scope.find('.lcake-woo-carousel');
        if (!$carousel.length || typeof window.Swiper === 'undefined') {
            return;
        }

        var config = {};
        try {
            config = JSON.parse($carousel.attr('data-config') || '{}');
        } catch (e) {
            config = {};
        }

        new window.Swiper($carousel[0], {
            slidesPerView: config.slidesPerViewMobile || 1,
            spaceBetween: 20,
            loop: !!config.loop,
            autoplay: config.autoplay ? { delay: 3000 } : false,
            pagination: {
                el: $scope.find('.swiper-pagination')[0],
                clickable: true,
            },
            navigation: {
                prevEl: $scope.find('.lcake-woo-carousel-prev')[0],
                nextEl: $scope.find('.lcake-woo-carousel-next')[0],
            },
            breakpoints: {
                768: { slidesPerView: config.slidesPerViewTablet || 2 },
                1024: { slidesPerView: config.slidesPerView || 4 },
            },
        });
    };

    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/lcake-kit-woo-product-carousel.default', WidgetLcakeWooProductCarouselHandler);
    });

})(jQuery, window);
