=== Testimonials-slider ===
Contributors: yourname
Tags: testimonials, reviews, custom post type, shortcode, slider
Requires at least: 5.0
Tested up to: 6.4
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A testimonials slider system with custom post type, custom fields, smooth animations, and shortcode display.

== Description ==

Testimonials-slider is a WordPress plugin that allows you to easily manage and display customer testimonials with smooth slider animations on your website.

**Features:**

* Custom Post Type for Testimonials
* Custom Fields: Author Name, Role/Title, and Rating (1-5 stars)
* Shortcode to display testimonials anywhere
* Two layout options: List and Slider
* Smooth slider animations with touch/swipe support
* Responsive design
* Easy to customize

**Usage:**

1. Go to Testimonials > Add New in your WordPress admin
2. Add testimonial content, author name, role, and rating
3. Use the shortcode `[testimonials]` to display testimonials on any page or post

**Shortcode Options:**

* `limit` - Number of testimonials to show (default: -1 for all)
* `orderby` - Order by field (date, title, etc.)
* `order` - ASC or DESC (default: DESC)
* `layout` - list or slider (default: list)
* `show_rating` - yes or no (default: yes)
* `show_image` - yes or no (default: yes)
* `class` - Additional CSS class

**Examples:**

`[testimonials]` - Display all testimonials in list layout
`[testimonials limit="3" layout="slider"]` - Display 3 testimonials in slider layout
`[testimonials orderby="title" order="ASC"]` - Display testimonials ordered by title

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/testimonials` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress.
3. Go to Testimonials > Add New to create your first testimonial.

== Frequently Asked Questions ==

= How do I display testimonials? =

Use the shortcode `[testimonials]` on any page or post where you want to display testimonials.

= Can I customize the appearance? =

Yes, you can add custom CSS to override the default styles. The plugin uses semantic CSS classes that are easy to target.

= Can I use a slider layout? =

Yes, use `[testimonials layout="slider"]` to display testimonials in a slider format.

== Changelog ==

= 1.0.0 =
* Initial release
* Custom Post Type: Testimonials
* Custom fields: Author Name, Role, Rating
* Shortcode support with multiple options
* List and Slider layouts
* Responsive design

== Upgrade Notice ==

= 1.0.0 =
Initial release of Testimonials-slider plugin.

