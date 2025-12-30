# Testimonials-slider WordPress Plugin

A testimonials slider system with custom post type, custom fields, smooth animations, and shortcode display.

## Folder Structure

```
Testimonials/
├── testimonials.php              # Main plugin file
├── readme.txt                    # WordPress plugin readme
├── README.md                     # Documentation
│
├── includes/                     # Core functionality classes
│   ├── class-testimonials-post-type.php    # Custom Post Type registration
│   ├── class-testimonials-meta-boxes.php   # Custom fields (meta boxes)
│   └── class-testimonials-shortcode.php    # Shortcode handler
│
└── assets/                       # Frontend and admin assets
    ├── css/
    │   ├── testimonials.css      # Frontend styles
    │   └── admin.css             # Admin styles
    └── js/
        └── testimonials.js       # Frontend JavaScript (slider functionality)
```

## Features

- ✅ Custom Post Type: "Testimonials"
- ✅ Custom Fields: Author Name, Role/Title, Rating (1-5 stars)
- ✅ Shortcode to display testimonials
- ✅ Two Layout Options: List and Slider
- ✅ Responsive Design
- ✅ Easy to extend

## Installation

1. Upload the plugin folder to `/wp-content/plugins/`
2. Activate the plugin through the WordPress admin panel
3. Go to **Testimonials > Add New** to create your first testimonial

## Usage

### Creating Testimonials

1. Navigate to **Testimonials > Add New** in WordPress admin
2. Enter the testimonial content in the editor
3. Fill in the custom fields:
   - **Author Name**: Name of the person giving the testimonial
   - **Author Role/Title**: Their role or title (e.g., "CEO, Company Name")
   - **Rating**: Select rating from 1-5 stars
4. Optionally add a featured image (author photo)
5. Publish the testimonial

### Displaying Testimonials

Use the shortcode `[testimonials]` anywhere on your site:

**Basic Usage:**

```
[testimonials]
```

**With Options:**

```
[testimonials limit="5" layout="slider" show_rating="yes" show_image="yes"]
```

### Shortcode Parameters

| Parameter     | Options           | Default | Description                                           |
| ------------- | ----------------- | ------- | ----------------------------------------------------- |
| `limit`       | Number            | -1      | Number of testimonials to display (-1 for all)        |
| `orderby`     | date, title, etc. | date    | Order testimonials by field                           |
| `order`       | ASC, DESC         | DESC    | Sort order                                            |
| `layout`      | list, slider      | list    | Display layout                                        |
| `cards`       | Number            | 4       | Number of cards to show in slider (for slider layout) |
| `show_rating` | yes, no           | yes     | Show/hide rating stars                                |
| `show_image`  | yes, no           | yes     | Show/hide author image                                |
| `class`       | CSS class         | -       | Additional CSS class for styling                      |

### Examples

**Display testimonials in 4-card slider:**

```
[testimonials layout="slider"]
```

**Display 3 testimonials in slider:**

```
[testimonials limit="3" layout="slider"]
```

**Display testimonials in custom card count slider:**

```
[testimonials layout="slider" cards="3"]
```

**Display all testimonials ordered by title:**

```
[testimonials orderby="title" order="ASC"]
```

**Display without images:**

```
[testimonials show_image="no"]
```

## Customization

### CSS Classes

The plugin uses semantic CSS classes for easy customization:

- `.st-testimonials` - Main container
- `.st-testimonial-item` - Individual testimonial
- `.st-testimonial-content` - Testimonial content wrapper
- `.st-testimonial-text` - Testimonial text
- `.st-testimonial-author` - Author information
- `.st-author-name` - Author name
- `.st-author-role` - Author role/title
- `.st-rating-stars` - Rating container
- `.st-star` - Individual star

### Override Styles

Add custom CSS to your theme's `style.css` or through the WordPress Customizer to override default styles.

## Development

### File Structure Explained

- **testimonials.php**: Main plugin file that initializes all components
- **includes/class-testimonials-post-type.php**: Registers the custom post type
- **includes/class-testimonials-meta-boxes.php**: Handles custom fields and meta boxes
- **includes/class-testimonials-shortcode.php**: Processes shortcode and renders testimonials
- **assets/css/testimonials.css**: Frontend styling
- **assets/css/admin.css**: Admin panel styling
- **assets/js/testimonials.js**: Slider functionality

## Requirements

- WordPress 5.0 or higher
- PHP 7.0 or higher

## License

GPL v2 or later

## Support

For issues and feature requests, please contact the plugin author.
"# wordpress-plugin" 
