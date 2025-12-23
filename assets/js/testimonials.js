/**
 * Simple Testimonials - Frontend JavaScript
 */

(function($) {
    'use strict';
    
    $(document).ready(function() {
        // Initialize slider if layout is slider
        $('.st-testimonials-slider').each(function() {
            initTestimonialSlider($(this));
        });
    });
    
    /**
     * Initialize testimonial slider
     */
    function initTestimonialSlider($container) {
        var $items = $container.find('.st-testimonial-item');
        var totalItems = $items.length;
        var cardsPerView = 4; // Default: show 4 cards
        
        // Check if container has cards attribute
        var cardsAttr = $container.data('cards');
        if (cardsAttr) {
            cardsPerView = parseInt(cardsAttr);
        }
        
        // Responsive cards per view
        function getCardsPerView() {
            var width = $(window).width();
            if (width <= 480) return 1;
            if (width <= 768) return 2;
            if (width <= 1024) return 3;
            return cardsPerView;
        }
        
        if (totalItems <= cardsPerView) {
            // If we have fewer items than cards per view, show all
            $container.addClass('st-cards-' + cardsPerView);
            $items.wrapAll('<div class="st-slider-wrapper"></div>');
            return;
        }
        
        // Add cards class
        $container.addClass('st-cards-' + cardsPerView);
        
        // Wrap items in slider wrapper
        var $wrapper = $('<div class="st-slider-wrapper"></div>');
        $items.wrapAll($wrapper);
        $wrapper = $container.find('.st-slider-wrapper');
        
        var currentSlide = 0;
        var actualCardsPerView = getCardsPerView();
        var totalSlides = Math.ceil(totalItems / actualCardsPerView);
        
        // Update cards per view on resize
        $(window).on('resize', function() {
            actualCardsPerView = getCardsPerView();
            totalSlides = Math.ceil(totalItems / actualCardsPerView);
            updateSlider();
        });
        
        /**
         * Update slider position
         */
        function updateSlider() {
            var translateX = -(currentSlide * (100 / actualCardsPerView));
            $wrapper.css('transform', 'translateX(' + translateX + '%)');
            updateNavigation();
        }
        
        /**
         * Update navigation buttons and dots
         */
        function updateNavigation() {
            $prevBtn.prop('disabled', currentSlide === 0);
            $nextBtn.prop('disabled', currentSlide >= totalSlides - 1);
            
            $nav.find('.st-slider-dot').removeClass('st-active');
            $nav.find('.st-slider-dot[data-index="' + currentSlide + '"]').addClass('st-active');
        }
        
        // Create navigation dots
        var $nav = $('<div class="st-slider-nav"></div>');
        for (var i = 0; i < totalSlides; i++) {
            var $dot = $('<button class="st-slider-dot" data-index="' + i + '"></button>');
            if (i === 0) {
                $dot.addClass('st-active');
            }
            $nav.append($dot);
        }
        
        // Create prev/next buttons
        var $prevBtn = $('<button class="st-slider-prev">‹ Prev</button>');
        var $nextBtn = $('<button class="st-slider-next">Next ›</button>');
        
        $nav.prepend($prevBtn);
        $nav.append($nextBtn);
        
        $container.append($nav);
        
        /**
         * Go to next slide
         */
        function nextSlide() {
            if (currentSlide < totalSlides - 1) {
                currentSlide++;
                updateSlider();
            }
        }
        
        /**
         * Go to previous slide
         */
        function prevSlide() {
            if (currentSlide > 0) {
                currentSlide--;
                updateSlider();
            }
        }
        
        /**
         * Go to specific slide
         */
        function goToSlide(index) {
            if (index >= 0 && index < totalSlides) {
                currentSlide = index;
                updateSlider();
            }
        }
        
        // Event handlers
        $nextBtn.on('click', nextSlide);
        $prevBtn.on('click', prevSlide);
        
        $nav.find('.st-slider-dot').on('click', function() {
            var index = parseInt($(this).data('index'));
            goToSlide(index);
        });
        
        // Initialize
        updateNavigation();
        
        // Auto-play slider (optional - uncomment to enable)
        /*
        var autoPlayInterval = setInterval(function() {
            if (currentSlide < totalSlides - 1) {
                nextSlide();
            } else {
                goToSlide(0);
            }
        }, 5000);
        
        $container.on('mouseenter', function() {
            clearInterval(autoPlayInterval);
        }).on('mouseleave', function() {
            autoPlayInterval = setInterval(function() {
                if (currentSlide < totalSlides - 1) {
                    nextSlide();
                } else {
                    goToSlide(0);
                }
            }, 5000);
        });
        */
    }
    
})(jQuery);

