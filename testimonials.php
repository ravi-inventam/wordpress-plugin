<?php
/**
 * Plugin Name: Testimonials-slider
 * Plugin URI: https://example.com/testimonials-plugin
 * Description: A testimonials slider system with custom post type, custom fields, smooth animations, and shortcode display.
 * Version: 1.0.0
 * Author: Your Name
 * Author URI: https://example.com
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: simple-testimonials
 * Domain Path: /languages
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('ST_PLUGIN_VERSION', '1.0.0');
define('ST_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('ST_PLUGIN_URL', plugin_dir_url(__FILE__));
define('ST_PLUGIN_BASENAME', plugin_basename(__FILE__));

/**
 * Main plugin class
 */
class Simple_Testimonials {
    
    /**
     * Instance of this class
     */
    private static $instance = null;
    
    /**
     * Get instance of this class
     */
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    /**
     * Constructor
     */
    private function __construct() {
        $this->init();
    }
    
    /**
     * Initialize plugin
     */
    private function init() {
        // Load plugin files
        $this->load_dependencies();
        
        // Initialize classes
        $this->init_classes();
        
        // Load assets
        add_action('wp_enqueue_scripts', array($this, 'enqueue_assets'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_assets'));
    }
    
    /**
     * Load plugin dependencies
     */
    private function load_dependencies() {
        require_once ST_PLUGIN_DIR . 'includes/class-testimonials-post-type.php';
        require_once ST_PLUGIN_DIR . 'includes/class-testimonials-meta-boxes.php';
        require_once ST_PLUGIN_DIR . 'includes/class-testimonials-shortcode.php';
        
        // Load Elementor widget if Elementor is active
        if (did_action('elementor/loaded')) {
            require_once ST_PLUGIN_DIR . 'includes/class-testimonials-elementor-register.php';
        }
    }
    
    /**
     * Initialize classes
     */
    private function init_classes() {
        ST_Testimonials_Post_Type::get_instance();
        ST_Testimonials_Meta_Boxes::get_instance();
        ST_Testimonials_Shortcode::get_instance();
    }
    
    /**
     * Enqueue frontend assets
     */
    public function enqueue_assets() {
        wp_enqueue_style(
            'simple-testimonials-style',
            ST_PLUGIN_URL . 'assets/css/testimonials.css',
            array(),
            ST_PLUGIN_VERSION
        );
        
        wp_enqueue_script(
            'simple-testimonials-script',
            ST_PLUGIN_URL . 'assets/js/testimonials.js',
            array('jquery'),
            ST_PLUGIN_VERSION,
            true
        );
    }
    
    /**
     * Enqueue admin assets
     */
    public function enqueue_admin_assets($hook) {
        global $post_type;
        
        if ('testimonial' === $post_type) {
            wp_enqueue_style(
                'simple-testimonials-admin-style',
                ST_PLUGIN_URL . 'assets/css/admin.css',
                array(),
                ST_PLUGIN_VERSION
            );
        }
    }
}

/**
 * Initialize the plugin
 */
function simple_testimonials_init() {
    return Simple_Testimonials::get_instance();
}

// Start the plugin
add_action('plugins_loaded', 'simple_testimonials_init');

