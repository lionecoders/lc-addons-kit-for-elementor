(function ($, window, document) {
    'use strict';

    var WidgetLcHfCartIconHandler = function ($scope) {
        var $wrapper = $scope.find('.lc-hf-cart-icon');
        if (!$wrapper.length || !$wrapper.find('.lc-hf-cart-dropdown').length) {
            return;
        }

        var $btn = $wrapper.find('.lc-hf-cart-icon-btn');

        $btn.on('click', function (e) {
            e.preventDefault();
            $wrapper.toggleClass('is-open');
        });

        $(document).on('click', function (e) {
            if (!$wrapper.is(e.target) && $wrapper.has(e.target).length === 0) {
                $wrapper.removeClass('is-open');
            }
        });
    };

    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/lc-header-footer-cart-icon.default', WidgetLcHfCartIconHandler);
    });

})(jQuery, window, document);
