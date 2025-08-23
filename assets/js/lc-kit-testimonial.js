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

        // Optional: load config from data-config
        const config = JSON.parse(this.containerEl.getAttribute("data-config") || "{}");

        this.swiper = new Swiper(this.containerEl, {
            slidesPerView: 1,   // 👈 Always 1 slide
            slidesPerGroup: 1,
            spaceBetween: config.spaceBetween || 10,
            loop: config.loop ?? true,
            autoplay: config.autoplay ? {
                delay: config.autoplayDelay || 5000,
                disableOnInteraction: false,
            } : false,
            pagination: paginationEl ? {
                el: paginationEl,
                clickable: true,
            } : false,
            navigation: (nextEl && prevEl) ? {
                nextEl: nextEl,
                prevEl: prevEl,
            } : false,
        });
    }
}

// --- INIT SYSTEM ---
function initLCTestimonialSliders(scope = document) {
    scope.querySelectorAll(".lc-kit-testimonial").forEach((widgetEl) => {
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
