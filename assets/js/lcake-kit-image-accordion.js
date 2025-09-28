/**
 * Image Accordion Widget JavaScript
 * Handles click and hover behaviors
 */
(function($) {
    'use strict';

    var ImageAccordion = {
        init: function() {
            this.bindEvents();
        },

        bindEvents: function() {
            // Click behavior: expand item and optionally open wrap link if active
            $(document).on('click', '.lcake-image-accordion-click .lcake-single-image-accordion', function(e) {
                var $this = $(this);
                var $wrapper = $this.closest('.lcake-image-accordion-wraper');

                // Toggle the associated radio input
                var inputId = $this.attr('for');
                if (!inputId) {
                    return;
                }
                var $input = $('#' + inputId);

                // Uncheck all radios in same wrapper, then check the target
                $wrapper.find('input[type="radio"]').prop('checked', false);
                $input.prop('checked', true);

                // Handle wrap link when behavior is click
                var wrapLink = $this.data('link');
                var behavior = $this.data('behavior');
                var isActive = $this.data('active');

                if (wrapLink && wrapLink.url && behavior === 'click' && isActive === 'yes') {
                    e.preventDefault();
                    window.open(wrapLink.url, wrapLink.is_external ? '_blank' : '_self');
                } else {
                    // Prevent default to avoid navigating when label has href-like behavior
                    e.preventDefault();
                }
            });

            // Hover behavior: expand item on hover
            $(document).on('mouseenter', '.lcake-image-accordion-hover .lcake-single-image-accordion', function() {
                var $this = $(this);
                var $wrapper = $this.closest('.lcake-image-accordion-wraper');

                var inputId = $this.attr('for');
                if (!inputId) {
                    return;
                }
                var $input = $('#' + inputId);

                $wrapper.find('input[type="radio"]').prop('checked', false);
                $input.prop('checked', true);
            });

            // On hover layout, allow clicking active item to open wrap link
            $(document).on('click', '.lcake-image-accordion-hover .lcake-single-image-accordion', function(e) {
                var $this = $(this);
                var wrapLink = $this.data('link');
                var behavior = $this.data('behavior');
                var isActive = $this.data('active');

                if (wrapLink && wrapLink.url && behavior === 'hover' && isActive === 'yes') {
                    e.preventDefault();
                    window.open(wrapLink.url, wrapLink.is_external ? '_blank' : '_self');
                } else {
                    e.preventDefault();
                }
            });

            // Allow buttons and action icons to work without toggling the accordion
            $(document).on('click', '.lcake-image-accordion--btn, .lcake-image-accordion-actions a', function(e) {
                e.stopPropagation();
            });
        }
    };

    $(document).ready(function() {
        ImageAccordion.init();
    });

    // Re-initialize for Elementor live preview
    if (typeof elementor !== 'undefined') {
        elementor.hooks.addAction('frontend/element_ready/lcake-kit-image-accordion.default', function() {
            ImageAccordion.init();
        });
    }

    // Ensure behaviors also work when content is injected into Elementor popups
    if (window.jQuery) {
        jQuery(document).on('elementor/popup/show', function() {
            ImageAccordion.init();
        });
        jQuery(document).on('elementor/lightbox/show', function() {
            ImageAccordion.init();
        });
    }

})(jQuery);
