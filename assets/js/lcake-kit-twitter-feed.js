(function ($, window, document) {
    'use strict';

    var scriptLoaded = false;

    var loadTwitterWidgets = function (callback) {
        if (window.twttr && window.twttr.widgets) {
            callback();
            return;
        }

        if (scriptLoaded) {
            return;
        }
        scriptLoaded = true;

        var script = document.createElement('script');
        script.src = 'https://platform.twitter.com/widgets.js';
        script.async = true;
        script.onload = callback;
        document.body.appendChild(script);
    };

    var WidgetLcakeTwitterFeedHandler = function ($scope) {
        var $feed = $scope.find('.lcake-twitter-feed');
        if (!$feed.length) {
            return;
        }

        loadTwitterWidgets(function () {
            if (window.twttr && window.twttr.widgets) {
                window.twttr.widgets.load($feed[0]);
            }
        });
    };

    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/lcake-kit-twitter-feed.default', WidgetLcakeTwitterFeedHandler);
    });

})(jQuery, window, document);
