(function ($, window, document) {
    'use strict';

    var WidgetLcHfSearchToggleHandler = function ($scope) {
        var $wrapper = $scope.find('.lc-hf-search-toggle');
        if (!$wrapper.length) {
            return;
        }

        var $btn = $wrapper.find('.lc-hf-search-toggle-btn');
        var $input = $wrapper.find('.lc-hf-search-input');

        $btn.on('click', function () {
            var isOpen = $wrapper.toggleClass('is-open').hasClass('is-open');
            $btn.attr('aria-expanded', isOpen ? 'true' : 'false');
            if (isOpen) {
                setTimeout(function () {
                    $input.trigger('focus');
                }, 50);
            }
        });

        $(document).on('click', function (e) {
            if (!$wrapper.is(e.target) && $wrapper.has(e.target).length === 0) {
                $wrapper.removeClass('is-open');
                $btn.attr('aria-expanded', 'false');
            }
        });
    };

    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/lc-header-footer-search-toggle.default', WidgetLcHfSearchToggleHandler);
    });

})(jQuery, window, document);
