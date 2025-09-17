class LCTestimonialSlider {
    constructor(widgetEl) {
        this.widgetEl = widgetEl;
        this.containerEl = widgetEl.querySelector(".swiper");

        if (!this.containerEl) return console.warn("No swiper container in:", widgetEl);
        if (typeof Swiper === "undefined") return console.error("Swiper not loaded");

        // Prevent re-initialization
        if (this.containerEl.swiper) this.containerEl.swiper.destroy(true, true);

        // Parse config
        let config = {};
        const configEl = widgetEl.querySelector(".lcake-testimonial-slider") || widgetEl;
        try {
            config = JSON.parse(configEl.getAttribute("data-config") || "{}");
        } catch (e) {
            console.error("Invalid data-config:", e);
        }

        const paginationEl = widgetEl.querySelector(".swiper-pagination");
        const nextEl = widgetEl.querySelector(".swiper-button-next");
        const prevEl = widgetEl.querySelector(".swiper-button-prev");

        // Initialize Swiper
        this.swiper = new Swiper(this.containerEl, {
            slidesPerView: config.slidesPerView || 1,
            spaceBetween: config.spaceBetween || 10,
            loop: config.loop ?? true,
            speed: config.speed || 1000,
            autoplay: config.autoplay ? {
                delay: config.autoplayDelay || 5000,
                disableOnInteraction: false,
                pauseOnMouseEnter: config.pauseOnHover || false,
            } : false,
            pagination: paginationEl ? { el: paginationEl, clickable: true } : false,
            navigation: (nextEl && prevEl) ? { nextEl, prevEl } : false,
            breakpoints: config.breakpoints || {},
            rtl: config.rtl || false,
            observer: true,
            observeParents: true,
        });

        widgetEl.dataset.lcTestimonialInitialized = "true";
    }
}

function initLCTestimonialSliders(scope = document) {
    if (typeof Swiper === "undefined") {
        console.warn("Swiper not ready, retrying...");
        return setTimeout(() => initLCTestimonialSliders(scope), 100);
    }

    scope.querySelectorAll(".lcake-main-wrapper").forEach((widgetEl) => {
        if (!widgetEl.dataset.lcTestimonialInitialized) {
            new LCTestimonialSlider(widgetEl);
        }
    });
}

// ---------------------
// Event Listeners
// ---------------------

// Frontend (non-Elementor)
document.addEventListener("DOMContentLoaded", () => initLCTestimonialSliders());

// Elementor frontend hook
jQuery(window).on("elementor/frontend/init", () => {
    elementorFrontend.hooks.addAction(
        "frontend/element_ready/lcake-kit-testimonial.default",
        ($scope) => initLCTestimonialSliders($scope[0])
    );
});

// Elementor editor (panel + live edit support)
jQuery(window).on("elementor/init", () => {
    elementor.hooks.addAction("panel/open_editor/widget/lcake-kit-testimonial", () => {
        setTimeout(initLCTestimonialSliders, 200);
    });
});

// MutationObserver (catch dynamically inserted widgets)
if ("MutationObserver" in window) {
    new MutationObserver((mutations) => {
        for (const m of mutations) {
            for (const node of m.addedNodes) {
                if (
                    node.nodeType === 1 &&
                    (node.matches?.(".lcake-main-wrapper") ||
                        node.querySelector?.(".lcake-main-wrapper"))
                ) {
                    setTimeout(() => initLCTestimonialSliders(node), 100);
                    return;
                }
            }
        }
    }).observe(document.body, { childList: true, subtree: true });
}