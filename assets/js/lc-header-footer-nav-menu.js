(function ($, window) {
    'use strict';

    class LC_Header_Footer_Nav_Menu_Handler extends elementorModules.frontend.handlers.Base {
        getDefaultSettings() {
            return {
                selectors: {
                    menu: '.lc-hf-nav-menu--main',
                    menuToggle: '.lc-hf-menu-toggle',
                    dropdownMenu: '.lc-hf-nav-menu--dropdown',
                    toggleWrapper: '.lc-hf-nav-menu-container'
                },
                classes: {
                    active: 'lc-hf-active',
                }
            };
        }

        getDefaultElements() {
            const selectors = this.getSettings('selectors');
            return {
                $menu: this.$element.find(selectors.menu),
                $menuToggle: this.$element.find(selectors.menuToggle),
                $dropdownMenu: this.$element.find(selectors.dropdownMenu),
                $toggleWrapper: this.$element.find(selectors.toggleWrapper),
            };
        }

        bindEvents() {
            if (this.elements.$menu.length) {
                this.initSmartmenus();
            }

            if (this.elements.$menuToggle.length) {
                this.elements.$menuToggle.on('click', this.toggleMenu.bind(this));
            }
        }

        initSmartmenus() {
            const $smartmenus = this.elements.$menu.find('ul.lc-hf-nav-menu');
            if ($.fn.smartmenus) {
                $smartmenus.smartmenus({
                    subIndicators: false,
                    subIndicatorsPos: 'append',
                    subIndicatorsText: '',
                    selectTimeout: 250,
                    hideTimeout: 250,
                });
            }
        }

        toggleMenu() {
            const classes = this.getSettings('classes');
            const isActive = this.elements.$menuToggle.hasClass(classes.active);

            if (isActive) {
                this.elements.$menuToggle.removeClass(classes.active);
                this.elements.$menuToggle.attr('aria-expanded', 'false');
            } else {
                this.elements.$menuToggle.addClass(classes.active);
                this.elements.$menuToggle.attr('aria-expanded', 'true');
            }
        }
    }

    $(window).on('elementor/frontend/init', () => {
        const addHandler = ($element) => {
            elementorFrontend.elementsHandler.addHandler(LC_Header_Footer_Nav_Menu_Handler, {
                $element,
            });
        };

        elementorFrontend.hooks.addAction('frontend/element_ready/lc-header-footer-nav-menu.default', addHandler);
    });

})(jQuery, window);
