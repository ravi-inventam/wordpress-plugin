<?php
/**
 * Elementor Testimonials Widget
 *
 * @package Testimonials_Slider
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
        return 'custom_testimonials';
    }

    /**
     * Get widget title
     */
    public function get_title() {
        return __('custom-testimonials', 'simple-testimonials');
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

        $this->add_group_control(
            \Elementor\Group_Control_Image_Size::get_type(),
            [
                'name' => 'section_image_size',
                'default' => 'large',
                'separator' => 'none',
            ]
        );

        // Testimonials Source
        $this->add_control(
            'testimonials_source',
            [
                'label' => __('Testimonials Source', 'simple-testimonials'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'custom',
                'options' => [
                    'custom' => __('Custom Testimonials', 'simple-testimonials'),
                    'posts' => __('From Testimonials Posts', 'simple-testimonials'),
                ],
                'label_block' => true,
            ]
        );

        // Custom Testimonials Repeater
        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'author_image',
            [
                'label' => __('Author Image', 'simple-testimonials'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => '',
                ],
            ]
        );

        $repeater->add_group_control(
            \Elementor\Group_Control_Image_Size::get_type(),
            [
                'name' => 'author_image_size',
                'default' => 'thumbnail',
                'separator' => 'none',
            ]
        );

        $repeater->add_control(
            'author_name',
            [
                'label' => __('Author Name', 'simple-testimonials'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('John Doe', 'simple-testimonials'),
                'placeholder' => __('Enter author name', 'simple-testimonials'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'author_role',
            [
                'label' => __('Author Role/Title', 'simple-testimonials'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('CEO, Company Name', 'simple-testimonials'),
                'placeholder' => __('Enter author role', 'simple-testimonials'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'rating',
            [
                'label' => __('Rating', 'simple-testimonials'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 5,
                'min' => 1,
                'max' => 5,
                'step' => 1,
            ]
        );

        $repeater->add_control(
            'content',
            [
                'label' => __('Testimonial Content', 'simple-testimonials'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __('Enter testimonial content here...', 'simple-testimonials'),
                'placeholder' => __('Enter testimonial content', 'simple-testimonials'),
                'rows' => 5,
                'label_block' => true,
            ]
        );

        $this->add_control(
            'custom_testimonials',
            [
                'label' => __('Testimonials', 'simple-testimonials'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'author_name' => __('Sophia White', 'simple-testimonials'),
                        'author_role' => __('Assistant Backend Developer', 'simple-testimonials'),
                        'rating' => 4,
                        'content' => __('Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatu', 'simple-testimonials'),
                    ],
                    [
                        'author_name' => __('Scarlett Brown', 'simple-testimonials'),
                        'author_role' => __('Chief Executive Officer', 'simple-testimonials'),
                        'rating' => 4,
                        'content' => __('Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, to', 'simple-testimonials'),
                    ],
                    [
                        'author_name' => __('Jacob Moore', 'simple-testimonials'),
                        'author_role' => __('Senior Developer', 'simple-testimonials'),
                        'rating' => 4,
                        'content' => __('Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur ma', 'simple-testimonials'),
                    ],
                ],
                'title_field' => '{{{ author_name }}}',
                'condition' => [
                    'testimonials_source' => 'custom',
                ],
            ]
        );

        // Testimonials Selection (for posts source)
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
                'condition' => [
                    'testimonials_source' => 'posts',
                ],
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
                'condition' => [
                    'testimonials_source' => 'posts',
                ],
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
                'condition' => [
                    'testimonials_source' => 'posts',
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
                'condition' => [
                    'testimonials_source' => 'posts',
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
                'default' => 3,
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

        // Show Dots
        $this->add_control(
            'show_dots',
            [
                'label' => __('Show Navigation Dots', 'simple-testimonials'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'simple-testimonials'),
                'label_off' => __('No', 'simple-testimonials'),
                'return_value' => 'yes',
                'default' => 'yes',
                'condition' => [
                    'layout' => 'slider',
                ],
            ]
        );

        // Show Navigation Arrows
        $this->add_control(
            'show_arrows',
            [
                'label' => __('Show Navigation Arrows', 'simple-testimonials'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'simple-testimonials'),
                'label_off' => __('No', 'simple-testimonials'),
                'return_value' => 'yes',
                'default' => 'yes',
                'condition' => [
                    'layout' => 'slider',
                ],
            ]
        );

        // Autoplay
        $this->add_control(
            'autoplay',
            [
                'label' => __('Autoplay', 'simple-testimonials'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'simple-testimonials'),
                'label_off' => __('No', 'simple-testimonials'),
                'return_value' => 'yes',
                'default' => 'no',
                'condition' => [
                    'layout' => 'slider',
                ],
            ]
        );

        // Autoplay Speed
        $this->add_control(
            'autoplay_speed',
            [
                'label' => __('Autoplay Speed (ms)', 'simple-testimonials'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 5000,
                'min' => 1000,
                'max' => 10000,
                'step' => 500,
                'condition' => [
                    'layout' => 'slider',
                    'autoplay' => 'yes',
                ],
            ]
        );

        // Pause on Hover
        $this->add_control(
            'pause_on_hover',
            [
                'label' => __('Pause on Hover', 'simple-testimonials'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'simple-testimonials'),
                'label_off' => __('No', 'simple-testimonials'),
                'return_value' => 'yes',
                'default' => 'yes',
                'condition' => [
                    'layout' => 'slider',
                    'autoplay' => 'yes',
                ],
            ]
        );

        // Grab Cursor
        $this->add_control(
            'grab_cursor',
            [
                'label' => __('Grab Cursor', 'simple-testimonials'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'simple-testimonials'),
                'label_off' => __('No', 'simple-testimonials'),
                'return_value' => 'yes',
                'default' => 'yes',
                'condition' => [
                    'layout' => 'slider',
                ],
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

        // Style Section - Section Image
        $this->start_controls_section(
            'style_section_image_section',
            [
                'label' => __('Section Image', 'simple-testimonials'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'section_image_width',
            [
                'label' => __('Width', 'simple-testimonials'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 100,
                ],
                'selectors' => [
                    '{{WRAPPER}} .st-section-image img' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'section_image_max_width',
            [
                'label' => __('Max Width', 'simple-testimonials'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 2000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .st-section-image img' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'section_image_align',
            [
                'label' => __('Alignment', 'simple-testimonials'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'simple-testimonials'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'simple-testimonials'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'simple-testimonials'),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'center',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .st-section-image' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'section_image_border_radius',
            [
                'label' => __('Border Radius', 'simple-testimonials'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'default' => [
                    'top' => 8,
                    'right' => 8,
                    'bottom' => 8,
                    'left' => 8,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .st-section-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'section_image_box_shadow',
                'label' => __('Box Shadow', 'simple-testimonials'),
                'selector' => '{{WRAPPER}} .st-section-image img',
            ]
        );

        $this->add_responsive_control(
            'section_image_margin',
            [
                'label' => __('Margin', 'simple-testimonials'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .st-section-image' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Style Section - Author Image
        $this->start_controls_section(
            'style_author_image_section',
            [
                'label' => __('Author Image', 'simple-testimonials'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'author_image_size',
            [
                'label' => __('Size', 'simple-testimonials'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'range' => [
                    'px' => [
                        'min' => 30,
                        'max' => 200,
                        'step' => 1,
                    ],
                    'em' => [
                        'min' => 1,
                        'max' => 10,
                        'step' => 0.1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 90,
                ],
                'selectors' => [
                    '{{WRAPPER}} .st-testimonial-image img' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'author_image_border_radius',
            [
                'label' => __('Border Radius', 'simple-testimonials'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 200,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 50,
                ],
                'selectors' => [
                    '{{WRAPPER}} .st-testimonial-image img' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'author_image_border',
            [
                'label' => __('Border', 'simple-testimonials'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'author_image_border_width',
            [
                'label' => __('Border Width', 'simple-testimonials'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 20,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 4,
                ],
                'selectors' => [
                    '{{WRAPPER}} .st-testimonial-image img' => 'border-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'author_image_border_color',
            [
                'label' => __('Border Color', 'simple-testimonials'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#f8f9fa',
                'selectors' => [
                    '{{WRAPPER}} .st-testimonial-image img' => 'border-color: {{VALUE}}; border-style: solid;',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'author_image_box_shadow',
                'label' => __('Box Shadow', 'simple-testimonials'),
                'selector' => '{{WRAPPER}} .st-testimonial-image img',
            ]
        );

        $this->add_responsive_control(
            'author_image_margin',
            [
                'label' => __('Margin', 'simple-testimonials'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .st-testimonial-image' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'author_image_align',
            [
                'label' => __('Alignment', 'simple-testimonials'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'simple-testimonials'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'simple-testimonials'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'simple-testimonials'),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'center',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .st-testimonial-image' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Style Section - Slider Navigation Dots
        $this->start_controls_section(
            'style_dots_section',
            [
                'label' => __('Slider Dots', 'simple-testimonials'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'layout' => 'slider',
                ],
            ]
        );

        $this->add_control(
            'dots_color',
            [
                'label' => __('Color', 'simple-testimonials'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#cbd5e0',
                'selectors' => [
                    '{{WRAPPER}} .st-slider-dot' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'dots_active_color',
            [
                'label' => __('Active Color', 'simple-testimonials'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ff6b35',
                'selectors' => [
                    '{{WRAPPER}} .st-slider-dot.st-active' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'dots_hover_color',
            [
                'label' => __('Hover Color', 'simple-testimonials'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#a0aec0',
                'selectors' => [
                    '{{WRAPPER}} .st-slider-dot:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'dots_size',
            [
                'label' => __('Size', 'simple-testimonials'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 5,
                        'max' => 30,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 10,
                ],
                'selectors' => [
                    '{{WRAPPER}} .st-slider-dot' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'dots_active_width',
            [
                'label' => __('Active Width', 'simple-testimonials'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 50,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 28,
                ],
                'selectors' => [
                    '{{WRAPPER}} .st-slider-dot.st-active' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'dots_border_radius',
            [
                'label' => __('Border Radius', 'simple-testimonials'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 5,
                ],
                'selectors' => [
                    '{{WRAPPER}} .st-slider-dot.st-active' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'dots_spacing',
            [
                'label' => __('Spacing', 'simple-testimonials'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 30,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 10,
                ],
                'selectors' => [
                    '{{WRAPPER}} .st-slider-nav' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'dots_box_shadow',
                'label' => __('Box Shadow', 'simple-testimonials'),
                'selector' => '{{WRAPPER}} .st-slider-dot',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'dots_active_box_shadow',
                'label' => __('Active Box Shadow', 'simple-testimonials'),
                'selector' => '{{WRAPPER}} .st-slider-dot.st-active',
            ]
        );

        $this->add_responsive_control(
            'dots_margin',
            [
                'label' => __('Margin', 'simple-testimonials'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .st-slider-nav' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'dots_alignment',
            [
                'label' => __('Alignment', 'simple-testimonials'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'simple-testimonials'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'simple-testimonials'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'simple-testimonials'),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'center',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .st-slider-nav' => 'justify-content: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Style Section - Slider Navigation Arrows
        $this->start_controls_section(
            'style_arrows_section',
            [
                'label' => __('Slider Arrows', 'simple-testimonials'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'layout' => 'slider',
                ],
            ]
        );

        $this->add_control(
            'arrows_background',
            [
                'label' => __('Background Color', 'simple-testimonials'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ff6b35',
                'selectors' => [
                    '{{WRAPPER}} .st-slider-prev, {{WRAPPER}} .st-slider-next' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'arrows_hover_background',
            [
                'label' => __('Hover Background Color', 'simple-testimonials'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#e55a2b',
                'selectors' => [
                    '{{WRAPPER}} .st-slider-prev:hover, {{WRAPPER}} .st-slider-next:hover' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'arrows_text_color',
            [
                'label' => __('Text Color', 'simple-testimonials'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .st-slider-prev, {{WRAPPER}} .st-slider-next' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'arrows_padding',
            [
                'label' => __('Padding', 'simple-testimonials'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em'],
                'default' => [
                    'top' => 12,
                    'right' => 24,
                    'bottom' => 12,
                    'left' => 24,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .st-slider-prev, {{WRAPPER}} .st-slider-next' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'arrows_border_radius',
            [
                'label' => __('Border Radius', 'simple-testimonials'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 8,
                ],
                'selectors' => [
                    '{{WRAPPER}} .st-slider-prev, {{WRAPPER}} .st-slider-next' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'arrows_typography',
                'label' => __('Typography', 'simple-testimonials'),
                'selector' => '{{WRAPPER}} .st-slider-prev, {{WRAPPER}} .st-slider-next',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'arrows_box_shadow',
                'label' => __('Box Shadow', 'simple-testimonials'),
                'selector' => '{{WRAPPER}} .st-slider-prev, {{WRAPPER}} .st-slider-next',
            ]
        );

        $this->add_responsive_control(
            'arrows_spacing',
            [
                'label' => __('Spacing Between Arrows', 'simple-testimonials'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 10,
                ],
                'selectors' => [
                    '{{WRAPPER}} .st-slider-prev' => 'margin-right: {{SIZE}}{{UNIT}};',
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

        // Determine layout
        $layout = $settings['layout'];
        $wrapper_class = 'st-testimonials st-testimonials-' . esc_attr($layout);
        
        // Add cards attribute for slider
        $data_attrs = 'data-layout="' . esc_attr($layout) . '"';
        if ($layout === 'slider') {
            $data_attrs .= ' data-cards="' . esc_attr($settings['cards']) . '"';
            $data_attrs .= ' data-show-dots="' . (!empty($settings['show_dots']) && $settings['show_dots'] === 'yes' ? 'yes' : 'no') . '"';
            $data_attrs .= ' data-show-arrows="' . (!empty($settings['show_arrows']) && $settings['show_arrows'] === 'yes' ? 'yes' : 'no') . '"';
            $data_attrs .= ' data-autoplay="' . (!empty($settings['autoplay']) && $settings['autoplay'] === 'yes' ? 'yes' : 'no') . '"';
            $data_attrs .= ' data-autoplay-speed="' . (!empty($settings['autoplay_speed']) ? intval($settings['autoplay_speed']) : 5000) . '"';
            $data_attrs .= ' data-pause-on-hover="' . (!empty($settings['pause_on_hover']) && $settings['pause_on_hover'] === 'yes' ? 'yes' : 'no') . '"';
            $data_attrs .= ' data-grab-cursor="' . (!empty($settings['grab_cursor']) && $settings['grab_cursor'] === 'yes' ? 'yes' : 'no') . '"';
        }

        // Check testimonials source
        $testimonials_source = !empty($settings['testimonials_source']) ? $settings['testimonials_source'] : 'custom';
        $has_testimonials = false;
        $custom_testimonials = [];
        $testimonials_query = null;

        if ($testimonials_source === 'custom') {
            // Custom testimonials from repeater
            $custom_testimonials = !empty($settings['custom_testimonials']) ? $settings['custom_testimonials'] : [];
            $has_testimonials = !empty($custom_testimonials);
        } else {
            // Testimonials from posts
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
            $has_testimonials = $testimonials_query->have_posts();
        }

        if (!$has_testimonials) {
            echo '<p>' . __('No testimonials found.', 'simple-testimonials') . '</p>';
            return;
        }

        ?>
        <div class="st-testimonials-wrapper">
            <?php if (!empty($settings['section_image']['url'])) : ?>
                <div class="st-section-image">
                    <?php
                    $section_image_id = !empty($settings['section_image']['id']) ? $settings['section_image']['id'] : 0;
                    $section_image_size = !empty($settings['section_image_size_size']) ? $settings['section_image_size_size'] : 'large';
                    $section_image_size_custom = !empty($settings['section_image_size_custom_dimension']) ? $settings['section_image_size_custom_dimension'] : '';
                    
                    if ($section_image_id) {
                        if ($section_image_size === 'custom' && !empty($section_image_size_custom)) {
                            $custom_size = explode('x', $section_image_size_custom);
                            $width = !empty($custom_size[0]) ? intval($custom_size[0]) : 1200;
                            $height = !empty($custom_size[1]) ? intval($custom_size[1]) : 600;
                            echo wp_get_attachment_image($section_image_id, [$width, $height], false, ['alt' => esc_attr($settings['section_title'])]);
                        } else {
                            echo wp_get_attachment_image($section_image_id, $section_image_size, false, ['alt' => esc_attr($settings['section_title'])]);
                        }
                    } else {
                        echo '<img src="' . esc_url($settings['section_image']['url']) . '" alt="' . esc_attr($settings['section_title']) . '" />';
                    }
                    ?>
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
                if ($testimonials_source === 'custom') {
                    // Render custom testimonials
                    foreach ($custom_testimonials as $testimonial) {
                        $this->render_custom_testimonial_item($testimonial, $settings);
                    }
                } else {
                    // Render testimonials from posts
                    while ($testimonials_query->have_posts()) {
                        $testimonials_query->the_post();
                        $this->render_testimonial_item($settings);
                    }
                    wp_reset_postdata();
                }
                ?>
            </div>
        </div>
        <?php
    }

    /**
     * Render custom testimonial item from repeater
     */
    private function render_custom_testimonial_item($testimonial, $settings) {
        $author_name = !empty($testimonial['author_name']) ? $testimonial['author_name'] : '';
        $author_role = !empty($testimonial['author_role']) ? $testimonial['author_role'] : '';
        $rating = !empty($testimonial['rating']) ? intval($testimonial['rating']) : 5;
        $content = !empty($testimonial['content']) ? $testimonial['content'] : '';
        $author_image = !empty($testimonial['author_image']['url']) ? $testimonial['author_image']['url'] : '';
        $author_image_id = !empty($testimonial['author_image']['id']) ? $testimonial['author_image']['id'] : 0;
        
        // Get image size
        $image_size = !empty($testimonial['author_image_size_size']) ? $testimonial['author_image_size_size'] : 'thumbnail';
        $image_size_custom = !empty($testimonial['author_image_size_custom_dimension']) ? $testimonial['author_image_size_custom_dimension'] : '';

        ?>
        <div class="st-testimonial-item">
            <?php if ($settings['show_image'] === 'yes' && !empty($author_image)) : ?>
                <div class="st-testimonial-image">
                    <?php if ($author_image_id) : ?>
                        <?php 
                        if ($image_size === 'custom' && !empty($image_size_custom)) {
                            $custom_size = explode('x', $image_size_custom);
                            $width = !empty($custom_size[0]) ? intval($custom_size[0]) : 150;
                            $height = !empty($custom_size[1]) ? intval($custom_size[1]) : 150;
                            echo wp_get_attachment_image($author_image_id, [$width, $height], false, ['alt' => esc_attr($author_name)]);
                        } else {
                            echo wp_get_attachment_image($author_image_id, $image_size, false, ['alt' => esc_attr($author_name)]);
                        }
                        ?>
                    <?php else : ?>
                        <img src="<?php echo esc_url($author_image); ?>" alt="<?php echo esc_attr($author_name); ?>" />
                    <?php endif; ?>
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
     * Render single testimonial item from post
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

