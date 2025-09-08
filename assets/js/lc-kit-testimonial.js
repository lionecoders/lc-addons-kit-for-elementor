class LCTestimonialSlider {
    constructor(widgetEl) {
        this.widgetEl = widgetEl;
        this.containerEl = widgetEl.querySelector(".swiper");

        if (!this.containerEl) return; // exit if no swiper found

        // Find pagination + nav only inside this widget
        console.log(widgetEl);
        const paginationEl = widgetEl.querySelector(".swiper-pagination");
        const nextEl = widgetEl.querySelector(".swiper-button-next");
        const prevEl = widgetEl.querySelector(".swiper-button-prev");

        // Get config from the widget wrapper element (lc-testimonial-slider) where data-config is actually set
        let config = {};
        const configElement = widgetEl.querySelector(".lc-testimonial-slider");
        
        if (configElement && configElement.getAttribute("data-config")) {
            try {
                config = JSON.parse(configElement.getAttribute("data-config"));
            } catch (e) {
                console.error("Failed to parse data-config:", e);
                config = {};
            }
        } else {
            // Fallback: try to get config from the widget wrapper itself
            try {
                config = JSON.parse(widgetEl.getAttribute("data-config") || "{}");
            } catch (e) {
                console.error("Failed to parse fallback data-config:", e);
                config = {};
            }
        }

        // Debug logging
        console.log("Widget element:", widgetEl);
        console.log("Config element:", configElement);
        console.log("Primary data-config:", configElement?.getAttribute("data-config"));
        console.log("Fallback data-config:", widgetEl.getAttribute("data-config"));
        console.log("Final parsed config:", config);

        this.swiper = new Swiper(this.containerEl, {
            slidesPerView: 1,
            spaceBetween: config.spaceBetween || 10,
            loop: config.loop ?? true,
            speed: config.speed || 1000,
            // autoplay: config.autoplay ? {
            //     delay: config.autoplayDelay || 5000,
            //     disableOnInteraction: false,
            //     pauseOnMouseEnter: config.pauseOnHover || false,
            // } : false,
            pagination: paginationEl ? {
                el: paginationEl,
                clickable: true,
            } : false,
            navigation: (nextEl && prevEl) ? {
                nextEl: nextEl,
                prevEl: prevEl,
            } : false,
            breakpoints: config.breakpoints || {},
            rtl: config.rtl || false,
        });
    }
}

// --- INIT SYSTEM ---
function initLCTestimonialSliders(scope = document) {
    scope.querySelectorAll(".lc-main-wrapper").forEach((widgetEl) => {
        new LCTestimonialSlider(widgetEl);
    });
}

// ✅ On normal page load
document.addEventListener("DOMContentLoaded", function () {
    initLCTestimonialSliders();
});

// ✅ Elementor Editor live preview
jQuery(window).on("elementor/frontend/init", function () {
    elementorFrontend.hooks.addAction(
        "frontend/element_ready/lc-kit-testimonial.default",
        function ($scope) {
            initLCTestimonialSliders($scope[0]);
        }
    );
});
