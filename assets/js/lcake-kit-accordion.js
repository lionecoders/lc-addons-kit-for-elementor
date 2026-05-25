(function () {
    function toggleAccordionItem(item, expand) {
        if (!item) return;
        item.classList.toggle("active", expand);
    }

    function closeAllItems(container) {
        container.querySelectorAll(".lcake-accordion-item.active").forEach(item => {
            toggleAccordionItem(item, false);
        });
    }

    function initAccordion(scope) {
        const accordions = scope.querySelectorAll(".lcake-accordion");

        accordions.forEach(accordion => {
            const allowMultiple = accordion.dataset.multiple === "yes" || accordion.dataset.multiple === "true";

            accordion.querySelectorAll(".lcake-accordion-item").forEach(item => {
                toggleAccordionItem(item, item.classList.contains("active"));
            });

            accordion.addEventListener("click", event => {
                const header = event.target.closest(".lcake-accordion-header");
                if (!header || !accordion.contains(header)) return;

                const item = header.closest(".lcake-accordion-item");
                const isActive = item.classList.contains("active");

                if (!allowMultiple) {
                    closeAllItems(accordion);
                }

                toggleAccordionItem(item, !isActive);
            });
        });
    }

    let hasInitialized = false;

    document.addEventListener("DOMContentLoaded", () => {
        if (!hasInitialized) {
            initAccordion(document);
            hasInitialized = true;
        }
    });

    if (window.elementorFrontend) {
        window.addEventListener("elementor/frontend/init", () => {
            elementorFrontend.hooks.addAction("frontend/element_ready/lcake-kit-accordion.default", ($scope) => {
                if (!hasInitialized) {
                    initAccordion($scope[0]);
                    hasInitialized = true;
                }
            });
        });
    }
})();
