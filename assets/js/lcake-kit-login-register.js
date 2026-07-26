(function ($, window) {
    'use strict';

    var WidgetLcakeLoginRegisterHandler = function ($scope) {
        var $wrapper = $scope.find('.lcake-login-register');
        if (!$wrapper.length) {
            return;
        }

        var $tabs = $wrapper.find('.lcake-login-register-tab');
        var $panels = $wrapper.find('.lcake-login-register-panel');

        $tabs.on('click', function () {
            var target = $(this).attr('data-target');

            $tabs.removeClass('is-active');
            $(this).addClass('is-active');

            $panels.removeClass('is-active');
            $wrapper.find('.lcake-login-register-panel[data-panel="' + target + '"]').addClass('is-active');
        });
    };

    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/lcake-kit-login-register.default', WidgetLcakeLoginRegisterHandler);
    });

})(jQuery, window);
