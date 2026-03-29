/* Premium Lottie Handler */
(function($, window) {
    'use strict';

    var WidgetLcakeLottieHandler = function($scope, $) {
        var $lottieWrapper = $scope.find('.lcake-lottie-wrapper');
        var $lottieContainer = $scope.find('.lcake-lottie-container');
        
        if (!$lottieContainer.length) {
            return;
        }

        var configStr = $lottieContainer.attr('data-lottie-config');
        if (!configStr) {
            return;
        }

        var config = JSON.parse(configStr);
        
        // Ensure Lottie is loaded (native elementor-frontend library)
        if (typeof window.lottie === 'undefined') {
            // fallback if lottie is missing
            console.error('LCAKE: Lottie native library is missing.');
            return;
        }

        var animInstance = window.lottie.loadAnimation({
            container: $lottieContainer[0],
            renderer: 'svg',
            loop: config.loop,
            autoplay: config.autoplay,
            path: config.path
        });

        // Set Speed & Direction
        animInstance.setSpeed(parseFloat(config.speed));
        animInstance.setDirection(parseInt(config.direction));

        // Handling Hover Controls
        if (config.pause_on_hover) {
            $lottieContainer.on('mouseenter', function() {
                animInstance.pause();
            }).on('mouseleave', function() {
                animInstance.play();
            });
        }

        // Custom External Player Controls Handling
        var $controls = $scope.find('.lcake-lottie-controls[data-target="' + config.container_id + '"]');
        if ($controls.length) {
            $controls.find('.lcake-lottie-play').on('click', function(e) {
                e.preventDefault();
                animInstance.play();
            });
            $controls.find('.lcake-lottie-pause').on('click', function(e) {
                e.preventDefault();
                animInstance.pause();
            });
            $controls.find('.lcake-lottie-stop').on('click', function(e) {
                e.preventDefault();
                animInstance.stop();
            });
            $controls.find('.lcake-lottie-restart').on('click', function(e) {
                e.preventDefault();
                animInstance.goToAndPlay(0, true);
            });
        }
    };

    // Initialize Handler natively when Elementor DOM is ready
    $(window).on('elementor/frontend/init', function() {
        elementorFrontend.hooks.addAction('frontend/element_ready/lcake-kit-lottie.default', WidgetLcakeLottieHandler);
    });

})(jQuery, window);
