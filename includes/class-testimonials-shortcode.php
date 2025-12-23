<?php
/**
 * Testimonials Shortcode
 *
 * @package Simple_Testimonials
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Testimonials Shortcode Class
 */
class ST_Testimonials_Shortcode {
    
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
        add_shortcode('testimonials', array($this, 'render_shortcode'));
    }
    
    /**
     * Render testimonials shortcode
     *
     * @param array $atts Shortcode attributes
     * @return string Shortcode output
     */
    public function render_shortcode($atts) {
        // Parse shortcode attributes
        $atts = shortcode_atts(array(
            'limit'      => -1,
            'orderby'    => 'date',
            'order'      => 'DESC',
            'layout'     => 'list', // list or slider
            'cards'      => '4', // Number of cards to show in slider (default: 4)
            'show_rating' => 'yes',
            'show_image' => 'yes',
            'class'      => '',
        ), $atts, 'testimonials');
        
        // Query arguments
        $args = array(
            'post_type'      => 'testimonial',
            'posts_per_page' => intval($atts['limit']),
            'orderby'        => $atts['orderby'],
            'order'          => $atts['order'],
            'post_status'    => 'publish',
        );
        
        $testimonials_query = new WP_Query($args);
        
        if (!$testimonials_query->have_posts()) {
            return '<p>' . __('No testimonials found.', 'simple-testimonials') . '</p>';
        }
        
        // Start output buffering
        ob_start();
        
        // Determine layout
        $layout = sanitize_text_field($atts['layout']);
        $wrapper_class = 'st-testimonials st-testimonials-' . esc_attr($layout);
        if (!empty($atts['class'])) {
            $wrapper_class .= ' ' . esc_attr($atts['class']);
        }
        
        // Add cards attribute for slider layout
        $data_attrs = 'data-layout="' . esc_attr($layout) . '"';
        if ($layout === 'slider') {
            $data_attrs .= ' data-cards="' . esc_attr($atts['cards']) . '"';
        }
        
        ?>
        <div class="<?php echo esc_attr($wrapper_class); ?>" <?php echo $data_attrs; ?>>
            <?php
            while ($testimonials_query->have_posts()) {
                $testimonials_query->the_post();
                $this->render_testimonial_item($atts);
            }
            wp_reset_postdata();
            ?>
        </div>
        <?php
        
        return ob_get_clean();
    }
    
    /**
     * Render single testimonial item
     *
     * @param array $atts Shortcode attributes
     */
    private function render_testimonial_item($atts) {
        $post_id = get_the_ID();
        $meta_boxes = ST_Testimonials_Meta_Boxes::get_instance();
        $meta_keys = $meta_boxes->get_meta_keys();
        
        // Get meta values
        $author_name = get_post_meta($post_id, $meta_keys['author_name'], true);
        $author_role = get_post_meta($post_id, $meta_keys['author_role'], true);
        $rating = get_post_meta($post_id, $meta_keys['rating'], true);
        $content = get_the_content();
        $thumbnail = has_post_thumbnail() ? get_the_post_thumbnail($post_id, 'thumbnail') : '';
        
        // Use post title as fallback for author name
        if (empty($author_name)) {
            $author_name = get_the_title();
        }
        
        ?>
        <div class="st-testimonial-item">
            <?php if ($atts['show_image'] === 'yes' && !empty($thumbnail)) : ?>
                <div class="st-testimonial-image">
                    <?php echo $thumbnail; ?>
                </div>
            <?php endif; ?>
            
            <div class="st-testimonial-content">
                <?php if (!empty($content)) : ?>
                    <div class="st-testimonial-text">
                        <?php echo wpautop(wp_kses_post($content)); ?>
                    </div>
                <?php endif; ?>
                
                <?php if ($atts['show_rating'] === 'yes' && !empty($rating)) : ?>
                    <div class="st-testimonial-rating">
                        <?php echo $this->render_rating_stars($rating); ?>
                    </div>
                <?php endif; ?>
                
                <div class="st-testimonial-author">
                    <?php if (!empty($author_name)) : ?>
                        <span class="st-author-name"><?php echo esc_html($author_name); ?></span>
                    <?php endif; ?>
                    <?php if (!empty($author_role)) : ?>
                        <span class="st-author-role"><?php echo esc_html($author_role); ?></span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php
    }
    
    /**
     * Render rating stars
     *
     * @param int $rating Rating value (1-5)
     * @return string HTML for stars
     */
    private function render_rating_stars($rating) {
        $rating = intval($rating);
        $rating = max(1, min(5, $rating));
        
        $output = '<div class="st-rating-stars" data-rating="' . esc_attr($rating) . '">';
        
        for ($i = 1; $i <= 5; $i++) {
            $class = $i <= $rating ? 'st-star-filled' : 'st-star-empty';
            $output .= '<span class="st-star ' . esc_attr($class) . '">★</span>';
        }
        
        $output .= '</div>';
        
        return $output;
    }
}

