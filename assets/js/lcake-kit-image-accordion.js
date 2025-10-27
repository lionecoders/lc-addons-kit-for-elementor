/**
 * Image Accordion Widget JavaScript
 * Handles click and hover behaviors
 */
(function($) {

    var ImageAccordion = {
        init: function() {
            this.bindEvents();
        },

        bindEvents: function() {
            $(document).on('click', '.lcake-image-accordion-click .lcake-single-image-accordion', function(e) {
                var $this = $(this);
                var $wrapper = $this.closest('.lcake-image-accordion-wraper');

                var inputId = $this.attr('for');
                if (!inputId) {
                    return;
                }
                var $input = $('#' + inputId);

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
