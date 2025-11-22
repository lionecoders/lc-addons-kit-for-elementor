// Use WordPress's global `wp.element` object for React dependencies.
const { render, useState, useEffect, useCallback } = wp.element;

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
const WidgetCard = ({ widget, onDragStart, onDragOver, isDragOver }) => (
    <div
        draggable="true"
        onDragStart={() => onDragStart(widget)}
        onDragOver={(e) => onDragOver(e, widget.id)}
        className={`lcake-kit-widget-card ${isDragOver ? 'is-drag-over' : ''}`}
    >
        <span className={`dashicons ${widget.icon}`}></span>
        <div className="lcake-kit-widget-info">
            <strong>
                {widget.label}
                {/* {widget.is_pro && <span className="lcake-kit-pro-badge">PRO</span>} */}
            </strong>
            <span>{widget.description}</span>
        </div>
    </div>
);

// --- Reusable Component: Sidebar ---
const Sidebar = ({ allWidgets, onDrop, onDragOver, onDragLeaveContainer, onDragStart, dragOverWidgetId }) => {
    const [searchTerm, setSearchTerm] = useState('');

    const filteredAvailable = allWidgets.filter(w =>
        w.label.toLowerCase().includes(searchTerm.toLowerCase())
    );

    return (
        <aside className="lcake-kit-sidebar">
            <h2>Available Widgets</h2>
            <div className="lcake-kit-search-wrapper">
                <input
                    type="text"
                    placeholder="Search widgets..."
                    value={searchTerm}
                    onChange={(e) => setSearchTerm(e.target.value)}
                />
            </div>
            <div
                className="lcake-kit-widget-list"
                onDrop={onDrop}
                onDragOver={onDragOver}
                onDragLeave={onDragLeaveContainer}
            >
                {filteredAvailable.map(widget => (
                    <WidgetCard
                        key={widget.id}
                        widget={widget}
                        onDragStart={onDragStart}
                        onDragOver={onDragOver}
                        isDragOver={dragOverWidgetId === widget.id}
                    />
                ))}
            </div>
        </aside>
    );
};

// --- Reusable Component: DropArea ---
const DropArea = ({ enabledWidgets, onDrop, onDragOver, onDragLeaveContainer, onDragStart, dragOverWidgetId }) => {
    return (
        <section
            className="lcake-kit-drop-area"
            onDrop={onDrop}
            onDragOver={onDragOver}
            onDragLeave={onDragLeaveContainer}
        >
            <h2>Enabled Widgets</h2>
            <div className="lcake-kit-widget-list lcake-kit-widget-dropzone">
                {enabledWidgets.map(widget => (
                    <WidgetCard
                        key={widget.id}
                        widget={widget}
                        onDragStart={onDragStart}
                        onDragOver={onDragOver}
                        isDragOver={dragOverWidgetId === widget.id}
                    />
                ))}
            </div>
            {enabledWidgets.length === 0 && (
                 <div className="lcake-kit-drop-placeholder visible">
                    <p>Drop widgets here</p>
                    <span>Drag widgets from the sidebar to enable them</span>
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

    // Initialize the widget lists on component mount
    useEffect(() => {
        const enabled = all_widgets.filter(w => initialEnabled.includes(w.id));
        const available = all_widgets.filter(w => !initialEnabled.includes(w.id));
        setEnabledWidgets(enabled);
        setAvailableWidgets(available);
    }, [all_widgets, initialEnabled]);

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
                    allWidgets={availableWidgets}
                    onDrop={() => handleDrop('available')}
                    onDragOver={handleDragOver}
                    onDragLeaveContainer={handleDragLeaveContainer}
                    onDragStart={handleDragStart}
                    dragOverWidgetId={dragOverWidgetId}
                />
                <DropArea
                    enabledWidgets={enabledWidgets}
                    onDrop={() => handleDrop('enabled')}
                    onDragOver={handleDragOver}
                    onDragLeaveContainer={handleDragLeaveContainer}
                    onDragStart={handleDragStart}
                    dragOverWidgetId={dragOverWidgetId}
                />
            </main>
        </>
    );
};


// Render the main App component into the root element.
render(<App />, document.getElementById('lcake-kit-react-root'));