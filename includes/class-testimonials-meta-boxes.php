<?php
/**
 * Custom Meta Boxes for Testimonials
 *
 * @package Testimonials_Slider
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Testimonials Meta Boxes Class
 */
class ST_Testimonials_Meta_Boxes {
    
    /**
     * Instance of this class
     */
    private static $instance = null;
    
    /**
     * Meta box ID
     */
    private $meta_box_id = 'st_testimonial_details';
    
    /**
     * Meta keys
     */
    private $meta_keys = array(
        'author_name' => 'st_author_name',
        'author_role' => 'st_author_role',
        'rating'      => 'st_rating',
    );
    
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
        add_action('add_meta_boxes', array($this, 'add_meta_boxes'));
        add_action('save_post', array($this, 'save_meta_boxes'));
    }
    
    /**
     * Add meta boxes
     */
    public function add_meta_boxes() {
        add_meta_box(
            $this->meta_box_id,
            __('Testimonial Details', 'simple-testimonials'),
            array($this, 'render_meta_box'),
            'testimonial',
            'normal',
            'high'
        );
    }
    
    /**
     * Render meta box
     */
    public function render_meta_box($post) {
        // Add nonce for security
        wp_nonce_field('st_testimonial_meta_box', 'st_testimonial_meta_box_nonce');
        
        // Get current values
        $author_name = get_post_meta($post->ID, $this->meta_keys['author_name'], true);
        $author_role = get_post_meta($post->ID, $this->meta_keys['author_role'], true);
        $rating = get_post_meta($post->ID, $this->meta_keys['rating'], true);
        
        // Set default rating if empty
        if (empty($rating)) {
            $rating = 5;
        }
        
        ?>
        <table class="form-table">
            <tr>
                <th>
                    <label for="<?php echo esc_attr($this->meta_keys['author_name']); ?>">
                        <?php _e('Author Name', 'simple-testimonials'); ?>
                    </label>
                </th>
                <td>
                    <input 
                        type="text" 
                        id="<?php echo esc_attr($this->meta_keys['author_name']); ?>" 
                        name="<?php echo esc_attr($this->meta_keys['author_name']); ?>" 
                        value="<?php echo esc_attr($author_name); ?>" 
                        class="regular-text"
                        placeholder="<?php esc_attr_e('e.g., John Doe', 'simple-testimonials'); ?>"
                    />
                    <p class="description">
                        <?php _e('The name of the person giving the testimonial.', 'simple-testimonials'); ?>
                    </p>
                </td>
            </tr>
            <tr>
                <th>
                    <label for="<?php echo esc_attr($this->meta_keys['author_role']); ?>">
                        <?php _e('Author Role/Title', 'simple-testimonials'); ?>
                    </label>
                </th>
                <td>
                    <input 
                        type="text" 
                        id="<?php echo esc_attr($this->meta_keys['author_role']); ?>" 
                        name="<?php echo esc_attr($this->meta_keys['author_role']); ?>" 
                        value="<?php echo esc_attr($author_role); ?>" 
                        class="regular-text"
                        placeholder="<?php esc_attr_e('e.g., CEO, Company Name', 'simple-testimonials'); ?>"
                    />
                    <p class="description">
                        <?php _e('The role or title of the author (e.g., CEO, Marketing Manager).', 'simple-testimonials'); ?>
                    </p>
                </td>
            </tr>
            <tr>
                <th>
                    <label for="<?php echo esc_attr($this->meta_keys['rating']); ?>">
                        <?php _e('Rating', 'simple-testimonials'); ?>
                    </label>
                </th>
                <td>
                    <select 
                        id="<?php echo esc_attr($this->meta_keys['rating']); ?>" 
                        name="<?php echo esc_attr($this->meta_keys['rating']); ?>"
                    >
                        <?php for ($i = 1; $i <= 5; $i++) : ?>
                            <option value="<?php echo $i; ?>" <?php selected($rating, $i); ?>>
                                <?php echo $i; ?> <?php echo $i === 1 ? __('Star', 'simple-testimonials') : __('Stars', 'simple-testimonials'); ?>
                            </option>
                        <?php endfor; ?>
                    </select>
                    <p class="description">
                        <?php _e('Rating out of 5 stars.', 'simple-testimonials'); ?>
                    </p>
                </td>
            </tr>
        </table>
        <?php
    }
    
    /**
     * Save meta box data
     */
    public function save_meta_boxes($post_id) {
        // Check nonce
        if (!isset($_POST['st_testimonial_meta_box_nonce']) || 
            !wp_verify_nonce($_POST['st_testimonial_meta_box_nonce'], 'st_testimonial_meta_box')) {
            return;
        }
        
        // Check autosave
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }
        
        // Check permissions
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }
        
        // Check post type
        if (get_post_type($post_id) !== 'testimonial') {
            return;
        }
        
        // Save author name
        if (isset($_POST[$this->meta_keys['author_name']])) {
            update_post_meta(
                $post_id,
                $this->meta_keys['author_name'],
                sanitize_text_field($_POST[$this->meta_keys['author_name']])
            );
        }
        
        // Save author role
        if (isset($_POST[$this->meta_keys['author_role']])) {
            update_post_meta(
                $post_id,
                $this->meta_keys['author_role'],
                sanitize_text_field($_POST[$this->meta_keys['author_role']])
            );
        }
        
        // Save rating
        if (isset($_POST[$this->meta_keys['rating']])) {
            $rating = intval($_POST[$this->meta_keys['rating']]);
            // Ensure rating is between 1 and 5
            $rating = max(1, min(5, $rating));
            update_post_meta(
                $post_id,
                $this->meta_keys['rating'],
                $rating
            );
        }
    }
    
    /**
     * Get meta keys
     */
    public function get_meta_keys() {
        return $this->meta_keys;
    }
}

