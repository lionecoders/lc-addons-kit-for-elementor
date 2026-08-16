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
            var copyText = $button.attr('data-copy-text') || 'Copy';
            var copiedText = $button.attr('data-copied-text') || 'Copied!';

            var temp = $('<textarea>');
            $('body').append(temp);
            temp.val(text).select();
            document.execCommand('copy');
            temp.remove();

            $button.addClass('is-copied').text(copiedText);

            setTimeout(function () {
                $button.removeClass('is-copied').text(copyText);
            }, 2000);
        });
    };

    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/lcake-kit-code-snippet.default', WidgetLcakeCodeSnippetHandler);
    });

})(jQuery, window);
