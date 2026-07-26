(function ($, window, document) {
    'use strict';

    var WidgetLcHfMobileMenuToggleHandler = function ($scope) {
        var $toggle = $scope.find('.lc-hf-menu-toggle');
        if (!$toggle.length) {
            return;
        }

        $toggle.on('click', function () {
            var isOpen = document.body.classList.toggle('lcake-mobile-menu-open');
            $toggle.attr('aria-expanded', isOpen ? 'true' : 'false');
        });
    };

    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/lc-header-footer-mobile-menu-toggle.default', WidgetLcHfMobileMenuToggleHandler);
    });

})(jQuery, window, document);
