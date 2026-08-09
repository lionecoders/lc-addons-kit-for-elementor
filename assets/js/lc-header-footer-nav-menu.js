(function ($, window) {
    'use strict';

    var WidgetLcHfNavMenuHandler = function ($scope) {
        var $menu = $scope.find('.lc-hf-nav-menu');
        if (!$menu.length) {
            return;
        }

        var $container = $scope.find('.lc-hf-nav-menu-container');
        var breakpoint = $container.length ? parseInt($container.attr('data-breakpoint')) : 800;

        $menu.find('.lc-hf-has-submenu > a').on('click', function (e) {
            if (window.innerWidth > breakpoint) {
                return;
            }
            var $parent = $(this).parent();
            if (!$parent.hasClass('lc-hf-submenu-open')) {
                e.preventDefault();
                $parent.addClass('lc-hf-submenu-open');
            }
        });
    };

    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/lc-header-footer-nav-menu.default', WidgetLcHfNavMenuHandler);
    });

})(jQuery, window);
