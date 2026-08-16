(function ($, window, document) {
    'use strict';

    var scriptLoaded = false;

    var loadTypeformEmbed = function (callback) {
        if (scriptLoaded) {
            callback();
            return;
        }

        var script = document.createElement('script');
        script.src = '//embed.typeform.com/next/embed.js';
        script.async = true;
        script.onload = function () {
            scriptLoaded = true;
            callback();
        };
        document.body.appendChild(script);
    };

    var WidgetLcakeTypeFormHandler = function ($scope) {
        var $target = $scope.find('[data-tf-widget], [data-tf-popup]');
        if (!$target.length) {
            return;
        }

        loadTypeformEmbed(function () {
            if (window.tf && typeof window.tf.createWidget === 'function') {
                window.tf.createWidget();
            }
        });
    };

    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/lcake-kit-type-form.default', WidgetLcakeTypeFormHandler);
    });

})(jQuery, window, document);
