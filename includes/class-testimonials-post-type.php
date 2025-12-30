<?php
/**
 * Custom Post Type: Testimonials
 *
 * @package Testimonials_Slider
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Testimonials Post Type Class
 */
class ST_Testimonials_Post_Type {
    
    /**
     * Instance of this class
     */
    private static $instance = null;
    
    /**
     * Post type slug
     */
    private $post_type = 'testimonial';
    
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
        add_action('init', array($this, 'register_post_type'));
    }
    
    /**
     * Register custom post type
     */
    public function register_post_type() {
        $labels = array(
            'name'                  => _x('Testimonials', 'Post Type General Name', 'simple-testimonials'),
            'singular_name'         => _x('Testimonial', 'Post Type Singular Name', 'simple-testimonials'),
            'menu_name'             => __('Testimonials', 'simple-testimonials'),
            'name_admin_bar'        => __('Testimonial', 'simple-testimonials'),
            'archives'              => __('Testimonial Archives', 'simple-testimonials'),
            'attributes'            => __('Testimonial Attributes', 'simple-testimonials'),
            'parent_item_colon'     => __('Parent Testimonial:', 'simple-testimonials'),
            'all_items'             => __('All Testimonials', 'simple-testimonials'),
            'add_new_item'          => __('Add New Testimonial', 'simple-testimonials'),
            'add_new'               => __('Add New', 'simple-testimonials'),
            'new_item'              => __('New Testimonial', 'simple-testimonials'),
            'edit_item'             => __('Edit Testimonial', 'simple-testimonials'),
            'update_item'           => __('Update Testimonial', 'simple-testimonials'),
            'view_item'             => __('View Testimonial', 'simple-testimonials'),
            'view_items'            => __('View Testimonials', 'simple-testimonials'),
            'search_items'          => __('Search Testimonial', 'simple-testimonials'),
            'not_found'             => __('Not found', 'simple-testimonials'),
            'not_found_in_trash'    => __('Not found in Trash', 'simple-testimonials'),
            'featured_image'        => __('Featured Image', 'simple-testimonials'),
            'set_featured_image'    => __('Set featured image', 'simple-testimonials'),
            'remove_featured_image' => __('Remove featured image', 'simple-testimonials'),
            'use_featured_image'    => __('Use as featured image', 'simple-testimonials'),
            'insert_into_item'      => __('Insert into testimonial', 'simple-testimonials'),
            'uploaded_to_this_item' => __('Uploaded to this testimonial', 'simple-testimonials'),
            'items_list'            => __('Testimonials list', 'simple-testimonials'),
            'items_list_navigation' => __('Testimonials list navigation', 'simple-testimonials'),
            'filter_items_list'     => __('Filter testimonials list', 'simple-testimonials'),
        );
        
        $args = array(
            'label'                 => __('Testimonial', 'simple-testimonials'),
            'description'           => __('Customer testimonials and reviews', 'simple-testimonials'),
            'labels'                => $labels,
            'supports'              => array('title', 'editor', 'thumbnail'),
            'hierarchical'          => false,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 20,
            'menu_icon'             => 'dashicons-format-quote',
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => true,
            'can_export'            => true,
            'has_archive'           => true,
            'exclude_from_search'   => false,
            'publicly_queryable'    => true,
            'capability_type'       => 'post',
            'show_in_rest'          => true,
        );
        
        register_post_type($this->post_type, $args);
    }
    
    /**
     * Get post type slug
     */
    public function get_post_type() {
        return $this->post_type;
    }
}

