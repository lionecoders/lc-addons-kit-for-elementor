/**
 * LC Kit Admin Scripts - Drag & Drop UI
 * Version: 2.0.0
 */
document.addEventListener('DOMContentLoaded', function() {

    const availableList = document.getElementById('lcake-kit-available-widgets');
    const enabledList = document.getElementById('lcake-kit-enabled-widgets');
    const enabledWidgetsInput = document.getElementById('lcake-kit-enabled-widgets-input');
    const placeholder = document.querySelector('.lcake-kit-drop-placeholder');

    if (!availableList || !enabledList || !enabledWidgetsInput) {
        console.error('Required elements for the LC Kit Widget Manager are missing.');
        return;
    }

    /**
     * Toggles the visibility of the "Drop widgets here" placeholder
     * based on whether the enabled list is empty.
     */
    function togglePlaceholder() {
        if (placeholder) {
            const hasChildren = enabledList.children.length > 0;
            placeholder.classList.toggle('visible', !hasChildren);
        }
    }

    /**
     * Updates the hidden input with a comma-separated list of enabled widget IDs.
     */
    function updateEnabledWidgetsInput() {
        const widgetCards = enabledList.querySelectorAll('.lcake-kit-widget-card');
        const widgetIds = Array.from(widgetCards).map(card => card.dataset.widgetId);
        enabledWidgetsInput.value = widgetIds.join(',');
    }

    // Initialize SortableJS on the "Available Widgets" list
    new Sortable(availableList, {
        group: 'shared-widgets', // Both lists must have the same group name
        animation: 150,
        sort: false // Do not allow sorting within the available list
    });

    // Initialize SortableJS on the "Enabled Widgets" list
    new Sortable(enabledList, {
        group: 'shared-widgets',
        animation: 150,
        onAdd: function() {
            // Fired when an item is dropped into this list from another
            togglePlaceholder();
            updateEnabledWidgetsInput();
        },
        onRemove: function() {
            // Fired when an item is dragged out of this list
            togglePlaceholder();
            updateEnabledWidgetsInput();
        },
        onUpdate: function() {
            // Fired when the order is changed within the list
            updateEnabledWidgetsInput();
        }
    });

    // Initial check to show/hide placeholder on page load
    togglePlaceholder();
});