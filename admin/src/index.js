// Use WordPress's global `wp.element` object for React dependencies.
const { render, useState, useEffect, useCallback, useMemo } = wp.element;

// --- Reusable Component: Header ---
const Header = ({ saveStatus, isDirty, onSaveChanges }) => {
    const getButtonText = () => {
        if (saveStatus === 'saving') return 'Saving...';
        if (saveStatus === 'success') return 'Saved!';
        if (saveStatus === 'error') return 'Error!';
        return 'Save Changes';
    };

    return (
        <header className="lcake-kit-header">
            <div className="lcake-kit-header-text">
                <h1>Widget Manager</h1>
                <p>Customize your WordPress widgets</p>
            </div>
            <div className="lcake-kit-header-actions">
                <button
                    className={`button button-primary lcake-kit-save-button ${saveStatus}`}
                    onClick={onSaveChanges}
                    disabled={!isDirty || saveStatus === 'saving'}
                >
                    {getButtonText()}
                </button>
            </div>
        </header>
    );
};

// --- Reusable Component: WidgetCard ---
const WidgetCard = ({ widget, onDragStart, onDragOver, isDragOver, listType, onToggleWidget, isSelected, onSelect }) => (
    <div
        draggable="true"
        onDragStart={() => onDragStart(widget)}
        onDragOver={(e) => onDragOver(e, widget.id)}
        className={`lcake-kit-widget-card ${isDragOver ? 'is-drag-over' : ''} ${isSelected ? 'is-selected' : ''}`}
    >
        <div className="lcake-kit-card-select" onClick={(e) => e.stopPropagation()}>
            <input
                type="checkbox"
                checked={isSelected}
                onChange={() => onSelect(widget.id)}
            />
        </div>
        <span className={`lcake-kit-widget-icon ${widget.icon}`}></span>
        <div className="lcake-kit-widget-info">
            <strong>
                {widget.label}
            </strong>
            <span>{widget.description}</span>
            <div className="lcake-kit-card-meta">
                <span className="lcake-kit-category-badge">{widget.category}</span>
                {widget.setup_url && (
                    <a
                        href={widget.setup_url}
                        target="_blank"
                        rel="noopener noreferrer"
                        className="lcake-kit-widget-setup-link"
                        onClick={(e) => e.stopPropagation()}
                    >
                        <span className="dashicons dashicons-admin-generic" style={{ fontSize: '12px', margin: '0 4px 0 0', width: 'auto', height: 'auto' }}></span>
                        {widget.setup_label || 'Setup'}
                    </a>
                )}
            </div>
            {widget.plugin_name && widget.plugin_link && (
                <div className="lcake-kit-widget-notice">
                    <span className="dashicons dashicons-warning" style={{ fontSize: '12px', margin: '0 4px 0 0', width: 'auto', height: 'auto' }}></span>
                    Requires {widget.plugin_name}. Get it{' '}
                    <a href={widget.plugin_link} target="_blank" rel="noopener noreferrer" onClick={(e) => e.stopPropagation()}>
                        here
                    </a>.
                </div>
            )}
        </div>
        <button
            type="button"
            className={`lcake-kit-widget-action-btn ${listType}`}
            onClick={(e) => {
                e.stopPropagation();
                onToggleWidget(widget, listType);
            }}
            title={listType === 'enabled' ? 'Disable Widget' : 'Enable Widget'}
        >
            <span className={`dashicons ${listType === 'enabled' ? 'dashicons-no' : 'dashicons-plus'}`}></span>
        </button>
    </div>
);

// --- Reusable Component: CategoryFilter ---
const CategoryFilter = ({ categories, activeCategory, onChange }) => (
    <div className="lcake-kit-category-filter">
        <button
            className={`lcake-kit-category-pill ${activeCategory === '' ? 'is-active' : ''}`}
            onClick={() => onChange('')}
            type="button"
        >
            All
        </button>
        {categories.map((cat) => (
            <button
                key={cat}
                className={`lcake-kit-category-pill ${activeCategory === cat ? 'is-active' : ''}`}
                onClick={() => onChange(cat)}
                type="button"
            >
                {cat}
            </button>
        ))}
    </div>
);

// --- Reusable Component: Sidebar ---
const Sidebar = ({
    allWidgets,
    categories,
    activeCategory,
    onCategoryChange,
    onDrop,
    onDragOver,
    onDragLeaveContainer,
    onDragStart,
    dragOverWidgetId,
    onEnableAll,
    searchTerm,
    onSearchChange,
    onToggleWidget,
    selectedWidgetIds,
    onSelectWidget,
    onSelectAll,
    onBulkEnable,
}) => {
    const selectedWidgets = allWidgets.filter(w => selectedWidgetIds.includes(w.id));
    const selectedCount = selectedWidgets.length;
    const isAllSelected = allWidgets.length > 0 && allWidgets.every(w => selectedWidgetIds.includes(w.id));

    return (
        <aside className="lcake-kit-sidebar">
            <h2>
                Available Widgets ({allWidgets.length})
                {allWidgets.length > 0 && (
                    <button
                        type="button"
                        className="lcake-kit-bulk-action"
                        onClick={() => onEnableAll(allWidgets)}
                    >
                        Enable {activeCategory ? `all in "${activeCategory}"` : 'all'} ({allWidgets.length})
                    </button>
                )}
            </h2>
            <CategoryFilter categories={categories} activeCategory={activeCategory} onChange={onCategoryChange} />
            <div className="lcake-kit-search-wrapper">
                <input
                    type="text"
                    placeholder="Search widgets..."
                    value={searchTerm}
                    onChange={(e) => onSearchChange(e.target.value)}
                />
            </div>
            <div className="lcake-kit-bulk-actions-bar">
                <label className="lcake-kit-select-all-label">
                    <input
                        type="checkbox"
                        checked={isAllSelected && allWidgets.length > 0}
                        onChange={() => onSelectAll(allWidgets, isAllSelected)}
                        disabled={allWidgets.length === 0}
                    />
                    Select All
                </label>
                {selectedCount > 0 && (
                    <button
                        type="button"
                        className="lcake-kit-bulk-action"
                        onClick={() => onBulkEnable(selectedWidgets)}
                    >
                        Enable Selected ({selectedCount})
                    </button>
                )}
            </div>
            <div
                className="lcake-kit-widget-list"
                onDrop={onDrop}
                onDragOver={onDragOver}
                onDragLeave={onDragLeaveContainer}
            >
                {allWidgets.map(widget => (
                    <WidgetCard
                        key={widget.id}
                        widget={widget}
                        onDragStart={onDragStart}
                        onDragOver={onDragOver}
                        isDragOver={dragOverWidgetId === widget.id}
                        listType="available"
                        onToggleWidget={onToggleWidget}
                        isSelected={selectedWidgetIds.includes(widget.id)}
                        onSelect={onSelectWidget}
                    />
                ))}
                {allWidgets.length === 0 && (
                    <p className="lcake-kit-empty-hint">No widgets match this filter.</p>
                )}
            </div>
        </aside>
    );
};

// --- Reusable Component: DropArea ---
const DropArea = ({
    enabledWidgets,
    onDrop,
    onDragOver,
    onDragLeaveContainer,
    onDragStart,
    dragOverWidgetId,
    onDisableAll,
    activeCategory,
    onToggleWidget,
    selectedWidgetIds,
    onSelectWidget,
    onSelectAll,
    onBulkDisable,
}) => {
    const selectedWidgets = enabledWidgets.filter(w => selectedWidgetIds.includes(w.id));
    const selectedCount = selectedWidgets.length;
    const isAllSelected = enabledWidgets.length > 0 && enabledWidgets.every(w => selectedWidgetIds.includes(w.id));

    return (
        <section
            className="lcake-kit-drop-area"
            onDrop={onDrop}
            onDragOver={onDragOver}
            onDragLeave={onDragLeaveContainer}
        >
            <h2>
                Enabled Widgets ({enabledWidgets.length})
                {enabledWidgets.length > 0 && (
                    <button
                        type="button"
                        className="lcake-kit-bulk-action lcake-kit-bulk-action--danger"
                        onClick={() => onDisableAll(enabledWidgets)}
                    >
                        Disable {activeCategory ? `all in "${activeCategory}"` : 'all'} ({enabledWidgets.length})
                    </button>
                )}
            </h2>
            <div className="lcake-kit-bulk-actions-bar">
                <label className="lcake-kit-select-all-label">
                    <input
                        type="checkbox"
                        checked={isAllSelected && enabledWidgets.length > 0}
                        onChange={() => onSelectAll(enabledWidgets, isAllSelected)}
                        disabled={enabledWidgets.length === 0}
                    />
                    Select All
                </label>
                {selectedCount > 0 && (
                    <button
                        type="button"
                        className="lcake-kit-bulk-action lcake-kit-bulk-action--danger"
                        onClick={() => onBulkDisable(selectedWidgets)}
                    >
                        Disable Selected ({selectedCount})
                    </button>
                )}
            </div>
            <div className="lcake-kit-widget-list lcake-kit-widget-dropzone">
                {enabledWidgets.map(widget => (
                    <WidgetCard
                        key={widget.id}
                        widget={widget}
                        onDragStart={onDragStart}
                        onDragOver={onDragOver}
                        isDragOver={dragOverWidgetId === widget.id}
                        listType="enabled"
                        onToggleWidget={onToggleWidget}
                        isSelected={selectedWidgetIds.includes(widget.id)}
                        onSelect={onSelectWidget}
                    />
                ))}
            </div>
            {enabledWidgets.length === 0 && (
                 <div className="lcake-kit-drop-placeholder visible">
                    <p>Drop widgets here</p>
                    <span>Drag widgets from the sidebar to enable them, or use "Enable all" on the left</span>
                </div>
            )}
        </section>
    );
};

// --- Main Application Component ---
const App = () => {
    // Get initial data passed from PHP
    const { all_widgets, enabled_widgets: initialEnabled } = window.LCAKE_SETTINGS;

    // State management
    const [availableWidgets, setAvailableWidgets] = useState([]);
    const [enabledWidgets, setEnabledWidgets] = useState([]);
    const [saveStatus, setSaveStatus] = useState(''); // '', 'saving', 'success', 'error'
    const [isDirty, setIsDirty] = useState(false);
    const [draggedWidget, setDraggedWidget] = useState(null);
    const [dragOverWidgetId, setDragOverWidgetId] = useState(null);
    const [activeCategory, setActiveCategory] = useState('');
    const [searchTerm, setSearchTerm] = useState('');
    const [selectedWidgetIds, setSelectedWidgetIds] = useState([]);

    const categories = useMemo(() => {
        const unique = Array.from(new Set(all_widgets.map((w) => w.category).filter(Boolean)));
        return unique.sort();
    }, [all_widgets]);

    // Initialize the widget lists on component mount
    useEffect(() => {
        const enabled = all_widgets.filter(w => initialEnabled.includes(w.id));
        const available = all_widgets.filter(w => !initialEnabled.includes(w.id));
        setEnabledWidgets(enabled);
        setAvailableWidgets(available);
    }, [all_widgets, initialEnabled]);

    const filterWidgets = (list) => {
        return list.filter((w) => {
            const matchesSearch = 
                w.label.toLowerCase().includes(searchTerm.toLowerCase()) ||
                w.id.toLowerCase().includes(searchTerm.toLowerCase()) ||
                w.category.toLowerCase().includes(searchTerm.toLowerCase());
            const matchesCategory = !activeCategory || w.category === activeCategory;
            return matchesSearch && matchesCategory;
        });
    };

    const filteredAvailable = useMemo(() => filterWidgets(availableWidgets), [availableWidgets, searchTerm, activeCategory]);
    const filteredEnabled = useMemo(() => filterWidgets(enabledWidgets), [enabledWidgets, searchTerm, activeCategory]);

    const handleSelectWidget = useCallback((id) => {
        setSelectedWidgetIds((prev) =>
            prev.includes(id) ? prev.filter((item) => item !== id) : [...prev, id]
        );
    }, []);

    const handleSelectAll = useCallback((widgetsList, isAllSelected) => {
        const listIds = widgetsList.map(w => w.id);
        if (isAllSelected) {
            setSelectedWidgetIds((prev) => prev.filter((id) => !listIds.includes(id)));
        } else {
            setSelectedWidgetIds((prev) => {
                const union = new Set([...prev, ...listIds]);
                return Array.from(union);
            });
        }
    }, []);

    const handleDragStart = useCallback((widget) => {
        setDraggedWidget(widget);
    }, []);

    const handleDrop = useCallback((targetListType) => {
        if (!draggedWidget) return;

        setIsDirty(true);
        const sourceListType = enabledWidgets.some(w => w.id === draggedWidget.id) ? 'enabled' : 'available';

        let sourceList = sourceListType === 'enabled' ? [...enabledWidgets] : [...availableWidgets];
        sourceList = sourceList.filter(w => w.id !== draggedWidget.id);

        let targetList = targetListType === 'enabled' ? [...enabledWidgets] : [...availableWidgets];
        if (sourceListType === targetListType) {
            targetList = sourceList;
        } else {
            targetList = targetList.filter(w => w.id !== draggedWidget.id);
        }

        const dropIndex = dragOverWidgetId ? targetList.findIndex(w => w.id === dragOverWidgetId) : -1;

        if (dropIndex !== -1) {
            targetList.splice(dropIndex, 0, draggedWidget);
        } else {
            targetList.push(draggedWidget);
        }

        if (targetListType === 'enabled') {
            setEnabledWidgets(targetList);
        } else {
            setAvailableWidgets(targetList);
        }

        if (sourceListType !== targetListType) {
             if (sourceListType === 'enabled') {
                setEnabledWidgets(sourceList);
            } else {
                setAvailableWidgets(sourceList);
            }
        }

        setDraggedWidget(null);
        setDragOverWidgetId(null);

    }, [draggedWidget, enabledWidgets, availableWidgets, dragOverWidgetId]);

    const handleDragOver = useCallback((e, widgetId = null) => {
        e.preventDefault();
        if (widgetId !== dragOverWidgetId) {
            setDragOverWidgetId(widgetId);
        }
    }, [dragOverWidgetId]);

    const handleDragLeaveContainer = useCallback(() => {
        setDragOverWidgetId(null);
    }, []);

    const handleEnableAll = useCallback((widgetsToEnable) => {
        if (!widgetsToEnable.length) return;
        setIsDirty(true);
        const idsToEnable = new Set(widgetsToEnable.map((w) => w.id));
        setEnabledWidgets((prev) => [...prev, ...widgetsToEnable]);
        setAvailableWidgets((prev) => prev.filter((w) => !idsToEnable.has(w.id)));
        setSelectedWidgetIds((prev) => prev.filter((id) => !idsToEnable.has(id)));
    }, []);

    const handleDisableAll = useCallback((widgetsToDisable) => {
        if (!widgetsToDisable.length) return;
        setIsDirty(true);
        const idsToDisable = new Set(widgetsToDisable.map((w) => w.id));
        setAvailableWidgets((prev) => [...prev, ...widgetsToDisable]);
        setEnabledWidgets((prev) => prev.filter((w) => !idsToDisable.has(w.id)));
        setSelectedWidgetIds((prev) => prev.filter((id) => !idsToDisable.has(id)));
    }, []);

    const handleToggleWidget = useCallback((widget, currentListType) => {
        if (currentListType === 'available') {
            handleEnableAll([widget]);
        } else {
            handleDisableAll([widget]);
        }
    }, [handleEnableAll, handleDisableAll]);

    const handleSaveChanges = async () => {
        setSaveStatus('saving');
        const { api_url, nonce } = window.LCAKE_SETTINGS;
        const enabledIds = enabledWidgets.map(w => w.id);

        try {
            const response = await fetch(api_url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-WP-Nonce': nonce,
                },
                body: JSON.stringify({ enabled_widgets: enabledIds }),
            });
            if (!response.ok) throw new Error('Network response was not ok.');

            setIsDirty(false);
            setSaveStatus('success');
        } catch (error) {
            console.error('Error saving settings:', error);
            setSaveStatus('error');
        } finally {
            setTimeout(() => setSaveStatus(''), 2000);
        }
    };

    return (
        <>
            <Header
                saveStatus={saveStatus}
                isDirty={isDirty}
                onSaveChanges={handleSaveChanges}
            />
            <main className="lcake-kit-main-content">
                <Sidebar
                    allWidgets={filteredAvailable}
                    categories={categories}
                    activeCategory={activeCategory}
                    onCategoryChange={setActiveCategory}
                    onDrop={() => handleDrop('available')}
                    onDragOver={handleDragOver}
                    onDragLeaveContainer={handleDragLeaveContainer}
                    onDragStart={handleDragStart}
                    dragOverWidgetId={dragOverWidgetId}
                    onEnableAll={handleEnableAll}
                    searchTerm={searchTerm}
                    onSearchChange={setSearchTerm}
                    onToggleWidget={handleToggleWidget}
                    selectedWidgetIds={selectedWidgetIds}
                    onSelectWidget={handleSelectWidget}
                    onSelectAll={handleSelectAll}
                    onBulkEnable={handleEnableAll}
                />
                <DropArea
                    enabledWidgets={filteredEnabled}
                    onDrop={() => handleDrop('enabled')}
                    onDragOver={handleDragOver}
                    onDragLeaveContainer={handleDragLeaveContainer}
                    onDragStart={handleDragStart}
                    dragOverWidgetId={dragOverWidgetId}
                    onDisableAll={handleDisableAll}
                    activeCategory={activeCategory}
                    onToggleWidget={handleToggleWidget}
                    selectedWidgetIds={selectedWidgetIds}
                    onSelectWidget={handleSelectWidget}
                    onSelectAll={handleSelectAll}
                    onBulkDisable={handleDisableAll}
                />
            </main>
        </>
    );
};

// Render the main App component into the root element.
render(<App />, document.getElementById('lcake-kit-react-root'));
