/**
 * Client Logo Widget JavaScript
 * Handles Swiper slider initialization for client logo carousel
 */

class LCClientLogoSlider {
    constructor(widgetEl) {
        this.widgetEl = widgetEl;
        this.containerEl = widgetEl.querySelector(".lcake-main-swiper");

        if (!this.containerEl) return console.warn("No swiper container in:", widgetEl);
        if (typeof Swiper === "undefined") return console.error("Swiper not loaded");

        // Prevent re-initialization
        if (this.containerEl.swiper) this.containerEl.swiper.destroy(true, true);

        // Parse config
        let config = {};
        const configEl = widgetEl.querySelector(".lcake-clients-slider") || widgetEl;
        try {
            config = JSON.parse(configEl.getAttribute("data-config") || "{}");
        } catch (e) {
            console.error("Invalid data-config:", e);
        }

        const paginationEl = widgetEl.querySelector(".swiper-pagination");
        const nextEl = widgetEl.querySelector(".swiper-button-next");
        const prevEl = widgetEl.querySelector(".swiper-button-prev");

        // Default configuration
        const defaultConfig = {
            slidesPerView: 4,
            spaceBetween: 15,
            loop: false,
            speed: 1000,
            slidesPerGroup: 1,
            breakpoints: {
                320: {
                    slidesPerView: 1,
                    spaceBetween: 10,
                },
                768: {
                    slidesPerView: 2,
                    spaceBetween: 10,
                },
                1024: {
                    slidesPerView: 4,
                    spaceBetween: 15,
                }
            }
        };

        // Merge configurations
        const swiperConfig = Object.assign({}, defaultConfig, config);

        // Handle breakpoints properly
        if (config && config.breakpoints) {
            swiperConfig.breakpoints = config.breakpoints;
        }

        // Handle grid mode if configured
        if (config && config.grid) {
            swiperConfig.grid = config.grid;
        }

        // Handle autoplay configuration
        if (swiperConfig.autoplay) {
            swiperConfig.autoplay = {
                delay: swiperConfig.speed || 1000,
                disableOnInteraction: false,
                pauseOnMouseEnter: swiperConfig.pauseOnHover || false,
            };
        }

        // Initialize Swiper
        this.swiper = new Swiper(this.containerEl, {
            slidesPerView: swiperConfig.slidesPerView,
            spaceBetween: swiperConfig.spaceBetween,
            loop: swiperConfig.loop,
            speed: swiperConfig.speed,
            slidesPerGroup: swiperConfig.slidesPerGroup,
            autoplay: swiperConfig.autoplay,
            pagination: paginationEl ? { el: paginationEl, clickable: true } : false,
            navigation: (nextEl && prevEl) ? { nextEl, prevEl } : false,
            breakpoints: swiperConfig.breakpoints,
            rtl: swiperConfig.rtl || false,
            observer: true,
            observeParents: true,
        });

        widgetEl.dataset.lcClientLogoInitialized = "true";
    }
}

function initLCClientLogoSliders(scope = document) {
    if (typeof Swiper === "undefined") {
        console.warn("Swiper not ready, retrying...");
        return setTimeout(() => initLCClientLogoSliders(scope), 100);
    }

    scope.querySelectorAll(".lcake-clients-slider").forEach((widgetEl) => {
        if (!widgetEl.dataset.lcClientLogoInitialized) {
            new LCClientLogoSlider(widgetEl);
        }
    });
}

// ---------------------
// Event Listeners
// ---------------------

// Frontend (non-Elementor)
document.addEventListener("DOMContentLoaded", () => initLCClientLogoSliders());

// Elementor frontend hook
jQuery(window).on("elementor/frontend/init", () => {
    elementorFrontend.hooks.addAction(
        "frontend/element_ready/lcake-kit-client-logo.default",
        ($scope) => initLCClientLogoSliders($scope[0])
    );
});

// Elementor editor (panel + live edit support)
jQuery(window).on("elementor/init", () => {
    elementor.hooks.addAction("panel/open_editor/widget/lcake-kit-client-logo", () => {
        setTimeout(initLCClientLogoSliders, 200);
    });
});

// MutationObserver (catch dynamically inserted widgets)
if ("MutationObserver" in window) {
    new MutationObserver((mutations) => {
        for (const m of mutations) {
            for (const node of m.addedNodes) {
                if (
                    node.nodeType === 1 &&
                    (node.matches?.(".lcake-clients-slider") ||
                        node.querySelector?.(".lcake-clients-slider"))
                ) {
                    setTimeout(() => initLCClientLogoSliders(node), 100);
                    return;
                }
            }
        }
    }).observe(document.body, { childList: true, subtree: true });
}