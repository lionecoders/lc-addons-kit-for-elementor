(function ($, window, document) {
    'use strict';

    // Initialize the Twitter / X widget loader queue
    window.twttr = (function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0],
            t = window.twttr || {};
        if (d.getElementById(id)) return t;
        js = d.createElement(s);
        js.id = id;
        js.src = 'https://platform.twitter.com/widgets.js';
        fjs.parentNode.insertBefore(js, fjs);

        t._e = [];
        t.ready = function (f) {
            t._e.push(f);
        };

        return t;
    }(document, 'script', 'twitter-wjs'));

    var WidgetLcakeTwitterFeedHandler = function ($scope) {
        var $feed = $scope.find('.lcake-twitter-feed');
        if (!$feed.length) {
            return;
        }

        window.twttr.ready(function (twttr) {
            if (twttr && twttr.widgets) {
                twttr.widgets.load($feed[0]);
            }
        });
    };

    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/lcake-kit-twitter-feed.default', WidgetLcakeTwitterFeedHandler);
    });

})(jQuery, window, document);
