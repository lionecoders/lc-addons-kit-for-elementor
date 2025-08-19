# LC Elementor Addons Kit

[![License: GPL v2](https://img.shields.io/badge/License-GPL%20v2-blue.svg)](https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html)

A powerful Elementor addon plugin by Lionescoders that offers a wide range of widgets categorized into 'LC Kit' and 'LC Header & Footer kit'. Includes a dashboard settings panel to enable/disable individual widgets from appearing in Elementor editor.

## Features

### 🎯 Core Features
- **Two Widget Categories**: 'LC Kit' and 'LC Header & Footer kit'
- **Dashboard Control Panel**: Enable/disable individual widgets
- **Conditional Widget Loading**: Only loads enabled widgets in Elementor
- **Modern UI**: Beautiful and responsive admin interface
- **Performance Optimized**: Lightweight and fast loading

### 📦 LC Kit Widgets (32 Widgets)
- Image Accordion
- Accordion
- Button
- Heading
- Blog Posts
- Icon Box
- Image Box
- Countdown Timer
- Client Logo
- FAQ
- Funfact
- Image Comparison
- Lottie
- Testimonial
- Pricing Table
- Team
- Social Icons
- Progress Bar
- MailChimp
- Pie Chart
- Tab
- Contact Form 7
- Video
- Business Hours
- Drop Caps
- Social Share
- Dual Button
- Caldera Forms
- We Forms
- WP Forms
- Ninja Forms
- TablePress
- Fluent Forms

### 🏠 LC Header & Footer Kit Widgets (9 Widgets)
- Category List
- Page List
- Post Grid
- Post List
- Post Tab
- ElementsKit Nav Menu
- Header Info
- Header Search
- Header Offcanvas

## Installation

1. **Download** the plugin files
2. **Upload** to `/wp-content/plugins/lc-elementor-addons-kit/`
3. **Activate** the plugin through the 'Plugins' menu in WordPress
4. **Configure** widget settings via 'LC Kit' menu in admin dashboard

## Requirements

- WordPress 5.0 or higher
- Elementor 3.0.0 or higher
- PHP 7.4 or higher

## Usage

### Admin Dashboard
1. Go to **LC Kit** in your WordPress admin menu
2. Use the toggle switches to enable/disable widgets
3. Widgets are organized by category for easy management
4. Save settings to apply changes

### Elementor Editor
1. Open Elementor editor on any page/post
2. Look for **LC Kit** and **LC Header & Footer kit** categories
3. Drag and drop enabled widgets to your layout
4. Customize widget settings in the Elementor panel

### Widget Examples

#### Button Widget
```php
// Example button widget usage
[lc-kit-button]
- Button Text: "Click Here"
- Link: https://example.com
- Size: Medium
- Type: Primary
[/lc-kit-button]
```

#### Heading Widget
```php
// Example heading widget usage
[lc-kit-heading]
- Heading Text: "Welcome to Our Site"
- HTML Tag: H2
- Alignment: Center
[/lc-kit-heading]
```

#### Category List Widget
```php
// Example category list widget usage
[lc-header-footer-category-list]
- Title: "Categories"
- Number of Categories: 10
- Order By: Name
- Show Post Count: Yes
[/lc-header-footer-category-list]
```

## Development

### Plugin Structure
```
lc-elementor-addons-kit/
├── lc-elementor-addons-kit.php          # Main plugin file
├── admin/
│   └── settings-page.php                # Admin settings page
├── includes/
│   ├── class-base-widget.php            # Base widget class
│   ├── class-base-header-footer-widget.php # Base header/footer widget class
│   ├── class-widget-loader.php          # Widget loader
│   └── widgets/
│       ├── lc-kit/                      # LC Kit widgets
│       │   ├── button.php
│       │   ├── heading.php
│       │   └── ... (other widgets)
│       └── lc-header-footer/            # Header/Footer widgets
│           ├── category-list.php
│           └── ... (other widgets)
└── assets/
    ├── css/
    │   ├── admin.css                    # Admin styles
    │   ├── frontend.css                 # Frontend styles
    │   └── editor.css                   # Editor styles
    └── js/
        ├── admin.js                     # Admin JavaScript
        ├── frontend.js                  # Frontend JavaScript
        └── editor.js                    # Editor JavaScript
```

### Adding New Widgets

1. **Create Widget File**
   ```php
   // includes/widgets/lc-kit/your-widget.php
   <?php
   class LC_Kit_Your_Widget extends LC_Kit_Base_Widget {
       public function get_name() {
           return 'lc-kit-your-widget';
       }
       
       public function get_title() {
           return esc_html__('Your Widget', 'lc-elementor-addons-kit');
       }
       
       // Add your widget implementation
   }
   ```

2. **Register in Widget Loader**
   ```php
   // Add to includes/class-widget-loader.php
   $lc_kit_widgets = [
       // ... existing widgets
       'your-widget' => 'LC_Kit_Your_Widget',
   ];
   ```

3. **Add to Admin Settings**
   ```php
   // Add to admin/settings-page.php
   $lc_kit_widgets = [
       // ... existing widgets
       'your-widget' => 'Your Widget',
   ];
   ```

### Hooks and Filters

#### Available Actions
- `lc_kit_widget_loaded` - Fired when a widget is loaded
- `lc_kit_settings_saved` - Fired when settings are saved

#### Available Filters
- `lc_kit_widget_categories` - Modify widget categories
- `lc_kit_widget_settings` - Modify widget settings

## Customization

### Styling
- **Frontend**: Modify `assets/css/frontend.css`
- **Admin**: Modify `assets/css/admin.css`
- **Editor**: Modify `assets/css/editor.css`

### JavaScript
- **Frontend**: Modify `assets/js/frontend.js`
- **Admin**: Modify `assets/js/admin.js`
- **Editor**: Modify `assets/js/editor.js`

### Widget Templates
Create custom widget templates by extending the base classes:
- `LC_Kit_Base_Widget` for LC Kit widgets
- `LC_Header_Footer_Base_Widget` for Header/Footer widgets

## Performance

### Optimization Features
- Conditional widget loading (only enabled widgets are loaded)
- Lazy loading for widget content
- Optimized CSS and JavaScript
- Minimal database queries

### Best Practices
- Disable unused widgets to improve performance
- Use appropriate widget categories
- Optimize images and content within widgets

## Support

### Documentation
- [Elementor Developers Documentation](https://developers.elementor.com/docs/)
- [WordPress Plugin Development](https://developer.wordpress.org/plugins/)

### Troubleshooting
1. **Widgets not appearing**: Check if widgets are enabled in LC Kit settings
2. **Elementor compatibility**: Ensure Elementor 3.0.0+ is installed
3. **PHP errors**: Check PHP version (7.4+ required)

## Changelog

### Version 1.0.0
- Initial release
- 32 LC Kit widgets
- 9 LC Header & Footer widgets
- Dashboard control panel
- Conditional widget loading

## License

This project is licensed under the **GNU General Public License v2.0 or later**.

**GPL v2 or later** - This means you can use, modify, and distribute this software under the terms of the GNU General Public License version 2 or any later version published by the Free Software Foundation.

For the full license text, see the [LICENSE](LICENSE) file in this repository.

**License Compatibility**: This license is compatible with WordPress and Elementor plugin requirements.

## Credits

Developed by [Lionescoders](https://lionescoders.com)

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Test thoroughly
5. Submit a pull request

---

**Note**: This plugin requires Elementor to be installed and activated. Make sure you have a compatible version of Elementor before installing this plugin.