(function ($, window) {
    'use strict';

    $(document).on('click', '.lc-hf-nav-menu .lc-hf-has-submenu > a', function (e) {
        var $container = $(this).closest('.lc-hf-nav-menu-container');
        var breakpoint = $container.length ? parseInt($container.attr('data-breakpoint')) : 800;

        if (window.innerWidth > breakpoint) {
            return;
        }

        var $parent = $(this).parent();
        if (!$parent.hasClass('lc-hf-submenu-open')) {
            e.preventDefault();
            $parent.addClass('lc-hf-submenu-open');
        } else {
            // Optional: allow toggling it closed if they click again
            e.preventDefault();
            $parent.removeClass('lc-hf-submenu-open');
        }
    });

    $(document).on('click', '.lc-hf-nav-menu-container .lc-hf-menu-toggle', function (e) {
        e.preventDefault();
        var $container = $(this).closest('.lc-hf-nav-menu-container');
        var isOpen = $container[0].classList.toggle('lc-hf-menu-open');
        $(this).attr('aria-expanded', isOpen ? 'true' : 'false');
    });

})(jQuery, window);
