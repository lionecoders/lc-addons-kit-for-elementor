(function () {
    function toggleAccordionItem(item, expand) {
        if (!item) return;
        item.classList.toggle("active", expand);
    }

    function closeAllItems(container) {
        container.querySelectorAll(".lc-accordion-item.active").forEach(item => {
            toggleAccordionItem(item, false);
        });
    }

    function initAccordion(scope) {
        const accordions = scope.querySelectorAll(".lc-accordion");

        accordions.forEach(accordion => {
            const allowMultiple = accordion.dataset.multiple === "yes" || accordion.dataset.multiple === "true";

            accordion.querySelectorAll(".lc-accordion-item").forEach(item => {
                toggleAccordionItem(item, item.classList.contains("active"));
            });

            accordion.addEventListener("click", event => {
                const header = event.target.closest(".lc-accordion-header");
                if (!header || !accordion.contains(header)) return;

                const item = header.closest(".lc-accordion-item");
                const isActive = item.classList.contains("active");

                if (!allowMultiple) {
                    closeAllItems(accordion);
                }

                toggleAccordionItem(item, !isActive);
            });
        });
    }

    document.addEventListener("DOMContentLoaded", () => initAccordion(document));

    if (window.elementorFrontend) {
        window.addEventListener("elementor/frontend/init", () => {
            elementorFrontend.hooks.addAction("frontend/element_ready/lc-kit-accordion.default", ($scope) => {
                initAccordion($scope[0]);
            });
        });
    }
})();
