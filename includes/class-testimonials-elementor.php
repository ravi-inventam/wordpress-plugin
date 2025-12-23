<?php
/**
 * Elementor Testimonials Widget
 *
 * @package Simple_Testimonials
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Check if Elementor is installed and activated
if (!did_action('elementor/loaded')) {
    return;
}

/**
 * Elementor Testimonials Widget Class
 */
class ST_Testimonials_Elementor_Widget extends \Elementor\Widget_Base {

    /**
     * Get widget name
     */
    public function get_name() {
        return 'st_testimonials';
    }

    /**
     * Get widget title
     */
    public function get_title() {
        return __('Testimonials', 'simple-testimonials');
    }

    /**
     * Get widget icon
     */
    public function get_icon() {
        return 'eicon-testimonial';
    }

    /**
     * Get widget categories
     */
    public function get_categories() {
        return ['general'];
    }

    /**
     * Get widget keywords
     */
    public function get_keywords() {
        return ['testimonial', 'review', 'feedback', 'quote'];
    }

    /**
     * Register widget controls
     */
    protected function register_controls() {

        // Content Section
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Content', 'simple-testimonials'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        // Section Title
        $this->add_control(
            'section_title',
            [
                'label' => __('Section Title', 'simple-testimonials'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('What Our Customers Say', 'simple-testimonials'),
                'placeholder' => __('Enter section title', 'simple-testimonials'),
                'label_block' => true,
            ]
        );

        // Section Description
        $this->add_control(
            'section_description',
            [
                'label' => __('Section Description', 'simple-testimonials'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __('Read what our satisfied customers have to say about us.', 'simple-testimonials'),
                'placeholder' => __('Enter section description', 'simple-testimonials'),
                'rows' => 3,
                'label_block' => true,
            ]
        );

        // Section Image
        $this->add_control(
            'section_image',
            [
                'label' => __('Section Image', 'simple-testimonials'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => '',
                ],
            ]
        );

        // Testimonials Selection
        $this->add_control(
            'testimonials',
            [
                'label' => __('Select Testimonials', 'simple-testimonials'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => $this->get_testimonials_options(),
                'default' => [],
                'label_block' => true,
                'description' => __('Select specific testimonials to display, or leave empty to show all. Go to Testimonials menu to add/edit testimonials.', 'simple-testimonials'),
            ]
        );

        // Limit
        $this->add_control(
            'limit',
            [
                'label' => __('Limit', 'simple-testimonials'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => -1,
                'min' => -1,
                'description' => __('Number of testimonials to display (-1 for all)', 'simple-testimonials'),
            ]
        );

        // Order By
        $this->add_control(
            'orderby',
            [
                'label' => __('Order By', 'simple-testimonials'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'date',
                'options' => [
                    'date' => __('Date', 'simple-testimonials'),
                    'title' => __('Title', 'simple-testimonials'),
                    'menu_order' => __('Menu Order', 'simple-testimonials'),
                    'rand' => __('Random', 'simple-testimonials'),
                ],
            ]
        );

        // Order
        $this->add_control(
            'order',
            [
                'label' => __('Order', 'simple-testimonials'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'DESC',
                'options' => [
                    'ASC' => __('Ascending', 'simple-testimonials'),
                    'DESC' => __('Descending', 'simple-testimonials'),
                ],
            ]
        );

        $this->end_controls_section();

        // Layout Section
        $this->start_controls_section(
            'layout_section',
            [
                'label' => __('Layout', 'simple-testimonials'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        // Layout Type
        $this->add_control(
            'layout',
            [
                'label' => __('Layout', 'simple-testimonials'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'slider',
                'options' => [
                    'list' => __('List', 'simple-testimonials'),
                    'slider' => __('Slider', 'simple-testimonials'),
                ],
            ]
        );

        // Cards Per View (for slider)
        $this->add_control(
            'cards',
            [
                'label' => __('Cards Per View', 'simple-testimonials'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 4,
                'min' => 1,
                'max' => 6,
                'condition' => [
                    'layout' => 'slider',
                ],
            ]
        );

        // Show Rating
        $this->add_control(
            'show_rating',
            [
                'label' => __('Show Rating', 'simple-testimonials'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'simple-testimonials'),
                'label_off' => __('No', 'simple-testimonials'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        // Show Image
        $this->add_control(
            'show_image',
            [
                'label' => __('Show Author Image', 'simple-testimonials'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'simple-testimonials'),
                'label_off' => __('No', 'simple-testimonials'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->end_controls_section();

        // Style Section - Section Title
        $this->start_controls_section(
            'style_title_section',
            [
                'label' => __('Section Title', 'simple-testimonials'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => __('Color', 'simple-testimonials'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#1a1a1a',
                'selectors' => [
                    '{{WRAPPER}} .st-section-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .st-section-title',
            ]
        );

        $this->add_responsive_control(
            'title_margin',
            [
                'label' => __('Margin', 'simple-testimonials'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .st-section-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Style Section - Section Description
        $this->start_controls_section(
            'style_description_section',
            [
                'label' => __('Section Description', 'simple-testimonials'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'description_color',
            [
                'label' => __('Color', 'simple-testimonials'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#666',
                'selectors' => [
                    '{{WRAPPER}} .st-section-description' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'description_typography',
                'selector' => '{{WRAPPER}} .st-section-description',
            ]
        );

        $this->end_controls_section();

        // Style Section - Cards
        $this->start_controls_section(
            'style_card_section',
            [
                'label' => __('Cards', 'simple-testimonials'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'card_background',
            [
                'label' => __('Background Color', 'simple-testimonials'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .st-testimonial-item' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'card_border_color',
            [
                'label' => __('Border Color', 'simple-testimonials'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#f0f0f0',
                'selectors' => [
                    '{{WRAPPER}} .st-testimonial-item' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'card_border_radius',
            [
                'label' => __('Border Radius', 'simple-testimonials'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .st-testimonial-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'card_padding',
            [
                'label' => __('Padding', 'simple-testimonials'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .st-testimonial-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Get testimonials options for select control
     */
    private function get_testimonials_options() {
        $testimonials = get_posts([
            'post_type' => 'testimonial',
            'posts_per_page' => -1,
            'post_status' => 'publish',
        ]);

        $options = [];
        foreach ($testimonials as $testimonial) {
            $author_name = get_post_meta($testimonial->ID, 'st_author_name', true);
            $display_name = !empty($author_name) ? $author_name : $testimonial->post_title;
            $options[$testimonial->ID] = $display_name . ' (ID: ' . $testimonial->ID . ')';
        }

        return $options;
    }

    /**
     * Render widget output
     */
    protected function render() {
        $settings = $this->get_settings_for_display();

        // Build query args
        $args = [
            'post_type' => 'testimonial',
            'posts_per_page' => intval($settings['limit']) > 0 ? intval($settings['limit']) : -1,
            'orderby' => $settings['orderby'],
            'order' => $settings['order'],
            'post_status' => 'publish',
        ];

        // If specific testimonials are selected
        if (!empty($settings['testimonials']) && is_array($settings['testimonials'])) {
            $args['post__in'] = $settings['testimonials'];
            $args['orderby'] = 'post__in';
        }

        $testimonials_query = new WP_Query($args);

        if (!$testimonials_query->have_posts()) {
            echo '<p>' . __('No testimonials found.', 'simple-testimonials') . '</p>';
            return;
        }

        // Determine layout
        $layout = $settings['layout'];
        $wrapper_class = 'st-testimonials st-testimonials-' . esc_attr($layout);
        
        // Add cards attribute for slider
        $data_attrs = 'data-layout="' . esc_attr($layout) . '"';
        if ($layout === 'slider') {
            $data_attrs .= ' data-cards="' . esc_attr($settings['cards']) . '"';
        }

        ?>
        <div class="st-testimonials-wrapper">
            <?php if (!empty($settings['section_image']['url'])) : ?>
                <div class="st-section-image">
                    <img src="<?php echo esc_url($settings['section_image']['url']); ?>" alt="<?php echo esc_attr($settings['section_title']); ?>" />
                </div>
            <?php endif; ?>

            <?php if (!empty($settings['section_title'])) : ?>
                <h2 class="st-section-title"><?php echo esc_html($settings['section_title']); ?></h2>
            <?php endif; ?>

            <?php if (!empty($settings['section_description'])) : ?>
                <p class="st-section-description"><?php echo esc_html($settings['section_description']); ?></p>
            <?php endif; ?>

            <div class="<?php echo esc_attr($wrapper_class); ?>" <?php echo $data_attrs; ?>>
                <?php
                while ($testimonials_query->have_posts()) {
                    $testimonials_query->the_post();
                    $this->render_testimonial_item($settings);
                }
                wp_reset_postdata();
                ?>
            </div>
        </div>
        <?php
    }

    /**
     * Render single testimonial item
     */
    private function render_testimonial_item($settings) {
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
            <?php if ($settings['show_image'] === 'yes' && !empty($thumbnail)) : ?>
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
                
                <?php if ($settings['show_rating'] === 'yes' && !empty($rating)) : ?>
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

