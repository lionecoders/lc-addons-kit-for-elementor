# LC Kit Testimonial Widget JavaScript Documentation

## Overview
The `lc-kit-testimonial.js` file provides comprehensive Swiper slider functionality for the LC Kit Testimonial widget. It handles all slider interactions, responsive behavior, and integrates seamlessly with Elementor.

## Features

### Core Functionality
- **Swiper Integration**: Full Swiper.js integration with custom configuration
- **Responsive Design**: Automatic breakpoint handling for mobile, tablet, and desktop
- **Touch Support**: Full touch and gesture support for mobile devices
- **Keyboard Navigation**: Accessible keyboard navigation support
- **Mousewheel Support**: Optional mousewheel navigation

### Elementor Integration
- **Dynamic Loading**: Automatically initializes when widgets are added/updated
- **Editor Mode**: Special handling for Elementor editor mode
- **AJAX Support**: Handles dynamic content loading scenarios

### Customization Options
- **Configurable Settings**: All slider settings can be controlled via data attributes
- **CSS Variables**: Dynamic CSS variable injection for spacing and layout
- **Hover Effects**: Custom hover state management
- **Active States**: Automatic active state management for testimonials

## Usage

### Basic Implementation
The JavaScript automatically initializes when the DOM is ready and Swiper is available:

```javascript
// Automatic initialization
// No manual setup required
```

### Manual Control
You can manually control the testimonial functionality:

```javascript
// Refresh all testimonial sliders
LCKitTestimonial.init();

// Destroy all testimonial sliders
LCKitTestimonial.destroy();

// Get the main instance
const testimonialInstance = LCKitTestimonial.getInstance();
```

### Configuration
The widget configuration is passed via the `data-config` attribute on the slider container:

```html
<div class="lc-testimonial-slider" data-config='{"slidesPerView": 3, "autoplay": true}'>
    <!-- Slider content -->
</div>
```

## Configuration Options

### Basic Settings
- `slidesPerView`: Number of slides to show (default: 1)
- `slidesPerGroup`: Number of slides to scroll (default: 1)
- `spaceBetween`: Space between slides in pixels (default: 15)
- `speed`: Transition speed in milliseconds (default: 1000)
- `loop`: Enable infinite loop (default: false)
- `autoplay`: Enable autoplay (default: false)
- `arrows`: Show navigation arrows (default: false)
- `dots`: Show pagination dots (default: false)
- `pauseOnHover`: Pause autoplay on hover (default: true)

### Responsive Breakpoints
```javascript
{
    "breakpoints": {
        "320": {
            "slidesPerView": 1,
            "slidesPerGroup": 1,
            "spaceBetween": 10
        },
        "768": {
            "slidesPerView": 2,
            "slidesPerGroup": 1,
            "spaceBetween": 10
        },
        "1024": {
            "slidesPerView": 3,
            "slidesPerGroup": 1,
            "spaceBetween": 15
        }
    }
}
```

## CSS Classes

### Main Container
- `.lc-testimonial-slider`: Main slider container
- `.lc-testimonial-slider.swiper-initialized`: Applied when Swiper is initialized

### Slides
- `.lc-single-testimonial-slider`: Individual testimonial slide
- `.lc-testimonial-card`: Alternative testimonial card class
- `.testimonial-active`: Applied to active testimonial
- `.testimonial-hover`: Applied on hover

### Navigation
- `.swiper-button-prev`: Previous button
- `.swiper-button-next`: Next button
- `.swiper-pagination`: Pagination container
- `.swiper-pagination span`: Individual pagination dots

## Event Handling

### Swiper Events
The widget automatically handles these Swiper events:
- `init`: Adds initialization classes
- `slideChange`: Updates active testimonial states
- `beforeDestroy`: Cleans up classes

### Custom Events
- `mouseenter`: Pauses autoplay and adds hover classes
- `mouseleave`: Resumes autoplay and removes hover classes
- `resize`: Updates all Swiper instances on window resize

## Dependencies

### Required
- **jQuery**: For DOM manipulation and event handling
- **Swiper.js**: For slider functionality (swiper-bundle.min.js)

### Optional
- **Elementor Frontend**: For enhanced Elementor integration

## Browser Support
- **Modern Browsers**: Chrome 60+, Firefox 55+, Safari 12+, Edge 79+
- **Mobile**: iOS Safari 12+, Chrome Mobile 60+
- **Touch Devices**: Full touch gesture support

## Performance Features
- **Lazy Initialization**: Only initializes when needed
- **Debounced Resize**: Optimized window resize handling
- **Memory Management**: Proper cleanup of Swiper instances
- **CSS Variables**: Efficient dynamic styling updates

## Troubleshooting

### Common Issues
1. **Swiper not found**: Ensure swiper-bundle.min.js is loaded before this script
2. **Slides not showing**: Check that the slider container has the correct class
3. **Navigation not working**: Verify that navigation elements exist in the HTML

### Debug Mode
Enable console logging by checking the browser console for warnings and errors.

## Customization

### Extending Functionality
You can extend the widget by modifying the `LCKitTestimonial` class:

```javascript
class CustomTestimonial extends LCKitTestimonial {
    constructor() {
        super();
        this.customFeature();
    }
    
    customFeature() {
        // Your custom functionality
    }
}
```

### Adding New Effects
Modify the `initSwiper` method to add custom Swiper effects or options.

## Version History
- **1.0.0**: Initial release with full Swiper integration and Elementor support

## Support
For technical support or feature requests, please contact the development team.
