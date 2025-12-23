<?php
/**
 * Register Elementor Widget
 *
 * @package Simple_Testimonials
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register Elementor Widget
 */
function st_register_elementor_widget($widgets_manager) {
    require_once ST_PLUGIN_DIR . 'includes/class-testimonials-elementor.php';
    $widgets_manager->register(new \ST_Testimonials_Elementor_Widget());
}
add_action('elementor/widgets/register', 'st_register_elementor_widget');

