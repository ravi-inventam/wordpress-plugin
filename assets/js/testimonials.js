/**
 * Testimonials-slider - Frontend JavaScript
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
        
        // Add cards class
        $container.addClass('st-cards-' + cardsPerView);
        
        // Wrap items in slider wrapper
        var $wrapper = $('<div class="st-slider-wrapper"></div>');
        $items.wrapAll($wrapper);
        $wrapper = $container.find('.st-slider-wrapper');
        
        var currentSlide = 0;
        var actualCardsPerView = getCardsPerView();
        
        // Calculate total slides correctly
        // Example: 7 items, 6 per view = 2 slides (first 6, then 1)
        // Example: 6 items, 6 per view = 1 slide (all fit)
        // Example: 12 items, 6 per view = 2 slides (6 + 6)
        // Example: 13 items, 6 per view = 3 slides (6 + 6 + 1)
        var totalSlides = 0;
        if (totalItems > actualCardsPerView) {
            // Calculate how many slides needed: Math.ceil(totalItems / actualCardsPerView)
            totalSlides = Math.ceil(totalItems / actualCardsPerView);
        } else {
            totalSlides = 1; // All items fit in one view, no slider needed
        }
        
        // Update cards per view on resize with debounce
        var resizeTimer;
        $(window).on('resize', function() {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(function() {
                var oldCardsPerView = actualCardsPerView;
                actualCardsPerView = getCardsPerView();
                var oldTotalSlides = totalSlides;
                
                // Recalculate total slides
                if (totalItems > actualCardsPerView) {
                    totalSlides = Math.ceil(totalItems / actualCardsPerView);
                } else {
                    totalSlides = 1;
                }
                
                if (oldCardsPerView !== actualCardsPerView || oldTotalSlides !== totalSlides) {
                    currentSlide = Math.min(currentSlide, totalSlides - 1);
                    // Recreate navigation if needed
                    $nav.empty();
                    createNavigation();
                    updateSlider();
                }
            }, 250);
        });
        
        // Check if dots and arrows should be shown
        var showDotsAttr = $container.data('show-dots');
        var showArrowsAttr = $container.data('show-arrows');
        var showDots = showDotsAttr === undefined || showDotsAttr === 'yes' || showDotsAttr === true;
        var showArrows = showArrowsAttr === undefined || showArrowsAttr === 'yes' || showArrowsAttr === true;
        
        // Check autoplay settings
        var autoplayAttr = $container.data('autoplay');
        var autoplaySpeed = parseInt($container.data('autoplay-speed')) || 5000;
        var pauseOnHover = $container.data('pause-on-hover') === 'yes';
        var grabCursor = $container.data('grab-cursor') === 'yes';
        
        var autoplay = autoplayAttr === 'yes' || autoplayAttr === true;
        var autoplayInterval = null;
        
        // Create navigation container
        var $nav = $('<div class="st-slider-nav"></div>');
        
        // Create prev/next buttons
        var $prevBtn = $('<button class="st-slider-prev" type="button"><span>‹ Prev</span></button>');
        var $nextBtn = $('<button class="st-slider-next" type="button"><span>Next ›</span></button>');
        
        /**
         * Create navigation elements
         */
        function createNavigation() {
            $nav.empty();
            
            // Only show navigation if there are multiple slides
            if (totalSlides <= 1) {
                return;
            }
            
            // Add buttons if arrows are enabled
            if (showArrows) {
                var $prevBtnClone = $prevBtn.clone();
                var $nextBtnClone = $nextBtn.clone();
                $nav.prepend($prevBtnClone);
                $nav.append($nextBtnClone);
            }
            
            // Create navigation dots - one dot per slide
            // Example: 7 cards, 6 per view = 2 slides = 2 dots
            // Example: 3 cards, 3 per view = 1 slide = 0 dots (no navigation needed)
            if (showDots && totalSlides > 1) {
                for (var i = 0; i < totalSlides; i++) {
                    var $dot = $('<button class="st-slider-dot" type="button" data-index="' + i + '" aria-label="Go to slide ' + (i + 1) + '"></button>');
                    if (i === 0) {
                        $dot.addClass('st-active');
                    }
                    $nav.append($dot);
                }
            }
        }
        
        // Initial navigation creation
        createNavigation();
        
        // Only append nav if there are dots or arrows and multiple slides
        if ((showDots || showArrows) && totalSlides > 1 && $nav.children().length > 0) {
            $container.append($nav);
        }
        
        // Initialize slider position
        updateSlider();
        
        /**
         * Update navigation buttons and dots
         */
        function updateNavigation() {
            if (totalSlides <= 1) {
                // Hide navigation if only one slide
                if ($nav.length) {
                    $nav.hide();
                }
                return;
            }
            
            // Show navigation if multiple slides
            if ($nav.length) {
                $nav.show();
            }
            
            if (showArrows && $nav.length) {
                $nav.find('.st-slider-prev').prop('disabled', currentSlide === 0);
                $nav.find('.st-slider-next').prop('disabled', currentSlide >= totalSlides - 1);
            }
            
            if (showDots && $nav.length) {
                // Remove active class from all dots
                $nav.find('.st-slider-dot').removeClass('st-active');
                // Add active class to current slide dot
                var $activeDot = $nav.find('.st-slider-dot[data-index="' + currentSlide + '"]');
                if ($activeDot.length) {
                    $activeDot.addClass('st-active');
                } else {
                    // Fallback: activate first dot if current slide dot not found
                    $nav.find('.st-slider-dot').first().addClass('st-active');
                }
            }
        }
        
        /**
         * Update slider position with smooth animation
         */
        function updateSlider() {
            // Only update if we have multiple slides
            if (totalSlides <= 1) {
                $wrapper.css({
                    'transform': 'translateX(0%)',
                    'transition': 'none'
                });
                updateNavigation();
                return;
            }
            
            // Calculate translate percentage based on card width
            // Each slide moves by exactly one card width to show next set of cards
            var cardWidth = 100 / actualCardsPerView;
            var translateX = -(currentSlide * cardWidth);
            
            // For the last slide, ensure we can see all remaining cards
            // Example: 7 cards, 6 per view
            // Slide 0: cards 1-6 (translateX = 0)
            // Slide 1: card 7 (translateX = -16.666%)
            // But we need to ensure card 7 is fully visible
            if (currentSlide === totalSlides - 1 && totalItems > actualCardsPerView) {
                var remainingCards = totalItems - (currentSlide * actualCardsPerView);
                if (remainingCards > 0 && remainingCards < actualCardsPerView) {
                    // Calculate the exact position to show the last card(s)
                    // Total width needed minus viewport width
                    var totalCardWidth = (totalItems * cardWidth);
                    var viewportWidth = 100;
                    var maxScroll = totalCardWidth - viewportWidth;
                    translateX = -Math.max(0, maxScroll);
                }
            }
            
            // Clamp translateX to valid range
            var maxTranslate = -((totalSlides - 1) * cardWidth);
            if (totalItems > actualCardsPerView) {
                var totalWidth = (totalItems * cardWidth) - 100;
                maxTranslate = -Math.max(0, totalWidth);
            }
            translateX = Math.max(maxTranslate, Math.min(0, translateX));
            
            $wrapper.css({
                'transform': 'translateX(' + translateX + '%)',
                'transition': 'transform 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94)'
            });
            
            updateNavigation();
        }
        
        /**
         * Go to next slide
         */
        function nextSlide(e) {
            if (e) {
                e.preventDefault();
            }
            if (totalSlides <= 1) {
                return;
            }
            if (currentSlide < totalSlides - 1) {
                currentSlide++;
                updateSlider();
            }
        }
        
        /**
         * Go to previous slide
         */
        function prevSlide(e) {
            if (e) {
                e.preventDefault();
            }
            if (totalSlides <= 1) {
                return;
            }
            if (currentSlide > 0) {
                currentSlide--;
                updateSlider();
            }
        }
        
        /**
         * Go to specific slide
         */
        function goToSlide(index) {
            if (totalSlides <= 1) {
                return;
            }
            if (index >= 0 && index < totalSlides) {
                currentSlide = index;
                updateSlider();
            }
        }
        
        // Event handlers - use event delegation for dynamic elements
        if (showArrows && totalSlides > 1) {
            $nav.on('click', '.st-slider-next', nextSlide);
            $nav.on('click', '.st-slider-prev', prevSlide);
        }
        
        if (showDots && totalSlides > 1) {
            $nav.on('click', '.st-slider-dot', function() {
                var index = parseInt($(this).data('index'));
                goToSlide(index);
            });
        }
        
        // Apply grab cursor - check if enabled and we have multiple slides
        if (grabCursor !== undefined && grabCursor && totalSlides > 1) {
            $container.addClass('st-grab-cursor');
            // Also apply to wrapper for better cursor behavior
            $wrapper.css('cursor', 'grab');
            
            // Add mousedown/mouseup handlers for grabbing effect
            $container.on('mousedown', function() {
                $container.addClass('st-grabbing');
            });
            
            $(document).on('mouseup', function() {
                $container.removeClass('st-grabbing');
            });
        }
        
        /**
         * Start autoplay
         */
        function startAutoplay() {
            if (!autoplay || totalSlides <= 1) {
                return;
            }
            
            stopAutoplay();
            autoplayInterval = setInterval(function() {
                if (currentSlide < totalSlides - 1) {
                    nextSlide();
                } else {
                    goToSlide(0); // Loop back to first slide
                }
            }, autoplaySpeed);
        }
        
        /**
         * Stop autoplay
         */
        function stopAutoplay() {
            if (autoplayInterval) {
                clearInterval(autoplayInterval);
                autoplayInterval = null;
            }
        }
        
        // Start autoplay if enabled
        if (autoplay && totalSlides > 1) {
            startAutoplay();
        }
        
        // Pause on hover
        if (autoplay && pauseOnHover && totalSlides > 1) {
            $container.on('mouseenter', function() {
                stopAutoplay();
            }).on('mouseleave', function() {
                startAutoplay();
            });
        }
        
        // Stop autoplay when user interacts with navigation
        if (autoplay && totalSlides > 1) {
            $container.on('click', '.st-slider-prev, .st-slider-next, .st-slider-dot', function() {
                stopAutoplay();
                // Restart after delay
                setTimeout(function() {
                    if (autoplay) {
                        startAutoplay();
                    }
                }, autoplaySpeed);
            });
        }
        
        // Initialize
        updateNavigation();
        
        // Touch/swipe support for mobile
        var touchStartX = 0;
        var touchEndX = 0;
        
        $wrapper.on('touchstart', function(e) {
            touchStartX = e.originalEvent.touches[0].clientX;
        });
        
        $wrapper.on('touchend', function(e) {
            touchEndX = e.originalEvent.changedTouches[0].clientX;
            handleSwipe();
        });
        
        function handleSwipe() {
            var swipeThreshold = 50;
            var diff = touchStartX - touchEndX;
            
            if (Math.abs(diff) > swipeThreshold) {
                if (diff > 0) {
                    // Swipe left - next
                    nextSlide();
                } else {
                    // Swipe right - prev
                    prevSlide();
                }
            }
        }
        
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

