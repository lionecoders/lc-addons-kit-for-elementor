(function ($, window) {
    'use strict';

    var WidgetLcakeCodeSnippetHandler = function ($scope) {
        var $button = $scope.find('.lcake-code-snippet-copy');
        if (!$button.length) {
            return;
        }

        $button.on('click', function () {
            var $code = $scope.find('.lcake-code-snippet-code');
            var text = $code.text();

            var originalText = $button.text();

            var done = function () {
                $button.addClass('is-copied').text('Copied!');
                setTimeout(function () {
                    $button.removeClass('is-copied').text(originalText);
                }, 1500);
            };

            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(text).then(done);
            } else {
                var $temp = $('<textarea>').val(text).css({ position: 'fixed', left: '-9999px' }).appendTo('body');
                $temp.select();
                document.execCommand('copy');
                $temp.remove();
                done();
            }
        });
    };

    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/lcake-kit-code-snippet.default', WidgetLcakeCodeSnippetHandler);
    });

})(jQuery, window);
