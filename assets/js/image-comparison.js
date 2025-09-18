(function ($) {

    const isTruthy = function (val) {
        return val === true || val === 1 || val === '1' || val === 'true' || val === 'yes' || val === 'on';
    };

    const initComparisonOnContainer = function ($container) {
        if ($container.data('lcake-twentytwenty-init') === true) return;

        let rawOffset     = $container.attr('data-offset');
        let offset        = rawOffset !== undefined ? parseFloat(rawOffset) : (parseFloat($container.data("offset")) || 0.5);
        let overlay       = isTruthy($container.attr('data-overlay') ?? $container.data("overlay"));
        let moveOnHover   = isTruthy($container.attr('data-move_slider_on_hover') ?? $container.data("move_slider_on_hover"));
        let clickToMove   = isTruthy($container.attr('data-click_to_move') ?? $container.data("click_to_move"));
        let orientation   = $container.hasClass("image-comparison-container-vertical") ? "vertical" : "horizontal";
        let labelBefore   = $container.data("label_before") || "Before";
        let labelAfter    = $container.data("label_after") || "After";

        if (typeof $container.twentytwenty !== 'function') {
            console.error('twentytwenty plugin not available');
            return;
        }

        $container.twentytwenty({
            default_offset_pct: offset,
            orientation: orientation
        });

        // Emulate unsupported options in this build
        if (overlay) {
            $container.find('.twentytwenty-overlay').remove();
        } else {
            $container.find('.twentytwenty-before-label').text(labelBefore);
            $container.find('.twentytwenty-after-label').text(labelAfter);
        }

        // Cache frequently used elements and dimensions
        const $before = $container.find('.twentytwenty-before');
        const $handle = $container.find('.twentytwenty-handle');
        let dims = { w: $before.width(), h: $before.height() };

        const computeDims = function () {
            dims.w = $before.width();
            dims.h = $before.height();
        };

        const setPosition = function (pct) {
            pct = Math.max(0, Math.min(1, pct));
            if (orientation === 'vertical') {
                const ch = pct * dims.h;
                $before.css('clip', 'rect(0,' + dims.w + 'px,' + ch + 'px,0)');
                $handle.css('top', ch + 'px');
            } else {
                const cw = pct * dims.w;
                $before.css('clip', 'rect(0,' + cw + 'px,' + dims.h + 'px,0)');
                $handle.css('left', cw + 'px');
            }
        };

        // Update on resize
        $(window).off('resize.lcakeTwty').on('resize.lcakeTwty', function () {
            computeDims();
            setPosition(offset);
        });

        $container.off('.lcakeTwty');
        if (moveOnHover) {
            let rafId = null;
            let nextPct = null;
            $container.on('mousemove.lcakeTwty', function (e) {
                const off = $container.offset();
                nextPct = orientation === 'vertical'
                    ? (e.pageY - off.top) / dims.h
                    : (e.pageX - off.left) / dims.w;
                if (rafId === null) {
                    rafId = requestAnimationFrame(function () {
                        setPosition(nextPct);
                        rafId = null;
                    });
                }
            });
        }

        if (clickToMove) {
            $container.on('click.lcakeTwty', function (e) {
                const off = $container.offset();
                const pct = orientation === 'vertical'
                    ? (e.pageY - off.top) / dims.h
                    : (e.pageX - off.left) / dims.w;
                setPosition(pct);
            });
        }

        $container.data('lcake-twentytwenty-init', true);
    };

    const whenImagesReady = function ($container, callback) {
        const $imgs = $container.find('img');
        if ($imgs.length === 0) {
            callback();
            return;
        }
        let remaining = $imgs.length;
        const done = function () {
            remaining--;
            if (remaining <= 0) callback();
        };
        $imgs.each(function () {
            if (this.complete && this.naturalWidth > 0) {
                done();
            } else {
                $(this).one('load error', done);
            }
        });
    };

    const initInScope = function ($scope) {
        const $containers = $scope.find('.lcake-image-comparison');
        if (!$containers.length) return;

        $containers.each(function () {
            const $container = $(this);
            whenImagesReady($container, function () {
                initComparisonOnContainer($container);
            });
        });
    };

    // Elementor frontend hook
    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/lcake-kit-image-comparison.default', initInScope);
    });

    // Fallback for non-Elementor render or cached content
    $(function () {
        initInScope($(document));
    });

})(jQuery);