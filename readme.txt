=== LC Addons Kit for Elementor ===
Contributors: mandeepsingh
Tags: elementor, widgets, addons, page-builder, lc-kit
Requires at least: 5.0
Tested up to: 6.8
Requires PHP: 7.4
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A powerful Elementor addon plugin that offers 41+ widgets categorized into 'LC Kit' and 'LC Header & Footer kit' with a dashboard control panel.

== Description ==

**LC Elementor Addons Kit** is a comprehensive Elementor addon plugin developed by Lionecoders that provides a wide range of professional widgets to enhance your Elementor page building experience.

= 🎯 **Core Features** =

* **Two Widget Categories**: 'LC Kit' and 'LC Header & Footer kit'
* **Dashboard Control Panel**: Enable/disable individual widgets
* **Conditional Widget Loading**: Only loads enabled widgets in Elementor
* **Modern UI**: Beautiful and responsive admin interface
* **Performance Optimized**: Lightweight and fast loading

= 📦 **LC Kit Widgets (32 Widgets)** =

* Image Accordion
* Accordion
* Button
* Heading
* Blog Posts
* Icon Box
* Image Box
* Countdown Timer
* Client Logo
* FAQ
* Funfact
* Image Comparison
* Lottie
* Testimonial
* Pricing Table
* Team
* Social Icons
* Progress Bar
* MailChimp
* Pie Chart
* Tab
* Contact Form 7
* Video
* Business Hours
* Drop Caps
* Social Share
* Dual Button
* Caldera Forms
* We Forms
* WP Forms
* Ninja Forms
* TablePress
* Fluent Forms

= 🏠 **LC Header & Footer Kit Widgets (9 Widgets)** =

* Category List
* Page List
* Post Grid
* Post List
* Post Tab
* ElementsKit Nav Menu
* Header Info
* Header Search
* Header Offcanvas

= 🚀 **Key Benefits** =

* **Easy Management**: Control which widgets appear in Elementor editor
* **Performance**: Only loads enabled widgets for optimal speed
* **Professional**: High-quality widgets for modern websites
* **Flexible**: Works with all Elementor themes and layouts
* **Developer Friendly**: Clean code structure with hooks and filters

= 💡 **Perfect For** =

* Web developers and designers
* Marketing agencies
* Business websites
* E-commerce stores
* Portfolio sites
* Corporate websites
* Any site using Elementor

== Installation ==

1. **Download** the plugin files
2. **Upload** to `/wp-content/plugins/lc-addons-kit-for-elementor/`
3. **Activate** the plugin through the 'Plugins' menu in WordPress
4. **Configure** widget settings via 'LC Kit' menu in admin dashboard

== Frequently Asked Questions ==

= What is required to use this plugin? =

* WordPress 5.0 or higher
* Elementor 3.0.0 or higher
* PHP 7.4 or higher

= How do I enable/disable widgets? =

1. Go to **LC Kit** in your WordPress admin menu
2. Use the toggle switches to enable/disable widgets
3. Widgets are organized by category for easy management
4. Save settings to apply changes

= Can I use this with any Elementor theme? =

Yes! This plugin works with all Elementor themes and layouts. The widgets integrate seamlessly with Elementor's editor.

= Are the widgets mobile responsive? =

Absolutely! All widgets are built with responsive design principles and work perfectly on all devices.

= Can I customize the widget styles? =

Yes, you can customize widget styles through the Elementor editor or by modifying the CSS files in the plugin's assets folder.

= Is this plugin compatible with other page builders? =

This plugin is specifically designed for Elementor and requires Elementor to be installed and activated.

== Screenshots ==

1. Admin Dashboard - Widget management interface
2. Elementor Editor - Widgets in action
3. Frontend Display - How widgets look on the website
4. Settings Panel - Configuration options

== Changelog ==

= 1.0.0 =
* Initial release
* 32 LC Kit widgets
* 9 LC Header & Footer widgets
* Dashboard control panel
* Conditional widget loading
* Modern admin interface
* Performance optimization

== Upgrade Notice ==

= 1.0.0 =
Initial release with 41+ professional widgets and dashboard control panel.

== Development ==

### Plugin Structure
```
lc-addons-kit-for-elementor/
├── lc-addons-kit-for-elementor.php          # Main plugin file
├── admin/
│   └── settings-page.php                # Admin settings page
├── includes/
│   ├── class-base-widget.php            # Base widget class
│   ├── class-base-header-footer-widget.php # Base header/footer widget class
│   ├── class-widget-loader.php          # Widget loader
│   └── widgets/
│       ├── lc-kit/                      # LC Kit widgets
│       └── lc-header-footer/            # Header/Footer widgets
└── assets/
    ├── css/                             # Stylesheets
    └── js/                              # JavaScript files
```

### Hooks and Filters

#### Available Actions
* `lc_kit_widget_loaded` - Fired when a widget is loaded
* `lc_kit_settings_saved` - Fired when settings are saved

#### Available Filters
* `lc_kit_widget_categories` - Modify widget categories
* `lc_kit_widget_settings` - Modify widget settings

== Support ==

* **Documentation**: [Elementor Developers Documentation](https://developers.elementor.com/docs/)
* **WordPress Plugin Development**: [WordPress Developer Resources](https://developer.wordpress.org/plugins/)
* **Support**: Contact us through our website

== Credits ==

Developed by [Lionecoders](https://lionecoders.com)

== License ==

This project is licensed under the **GNU General Public License v2.0 or later**.

**GPL v2 or later** - This means you can use, modify, and distribute this software under the terms of the GNU General Public License version 2 or any later version published by the Free Software Foundation.

**License Compatibility**: This license is compatible with WordPress and Elementor plugin requirements.

---

**Note**: This plugin requires Elementor to be installed and activated. Make sure you have a compatible version of Elementor before installing this plugin.
