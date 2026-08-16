(function ($, window, document) {
    'use strict';

    var WidgetLcHfSearchToggleHandler = function ($scope) {
        var $form = $scope.find('.lc-hf-search-form');
        if (!$form.length) {
            return;
        }

        var $input = $form.find('.lc-hf-search-input');
        var $clearBtn = $form.find('.lc-hf-search-clear');

        if (!$input.length || !$clearBtn.length) {
            return;
        }

        // Show/hide clear button based on input value
        var toggleClearBtn = function () {
            if ($input.val().length > 0) {
                $clearBtn.addClass('is-visible');
            } else {
                $clearBtn.removeClass('is-visible');
            }
        };

        // Initialize state
        toggleClearBtn();

        // Listen for input changes
        $input.on('input propertychange', toggleClearBtn);

        // Clear input when clear button is clicked
        $clearBtn.on('click', function (e) {
            e.preventDefault();
            $input.val('').trigger('input').focus();
        });
    };

    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/lc-header-footer-search-toggle.default', WidgetLcHfSearchToggleHandler);
    });

})(jQuery, window, document);
