
// Logic slider header
document.addEventListener('DOMContentLoaded', function() {
    const slides = document.querySelectorAll('.slide');
    const dots = document.querySelectorAll('.dot');
    let currentSlide = 0;
    const slideCount = window.slideCount || slides.length;
    
    if (slideCount <= 1) return;
    
    // Initialize first slide
    if (slides.length > 0) {
        slides[0].classList.add('active');
    }
    if (dots.length > 0) {
        dots[0].classList.add('active');
    }
    
    // Function to show specific slide
    function showSlide(index) {
        // Hide all slides
        slides.forEach(slide => slide.classList.remove('active'));
        dots.forEach(dot => dot.classList.remove('active'));
        
        // Show current slide
        if (slides[index]) {
            slides[index].classList.add('active');
        }
        if (dots[index]) {
            dots[index].classList.add('active');
        }
        
        currentSlide = index;
    }
    
    // Function to go to next slide
    function nextSlide() {
        currentSlide = (currentSlide + 1) % slideCount;
        showSlide(currentSlide);
    }
    
    // Auto-advance slides every 3 seconds
    if (slideCount > 1) {
        setInterval(nextSlide, 3000);
    }
    
    // Dot navigation
    dots.forEach((dot, index) => {
        dot.addEventListener('click', () => {
            showSlide(index);
        });
    });
    
    // Keyboard navigation
    document.addEventListener('keydown', (e) => {
        if (slideCount > 1) {
            if (e.key === 'ArrowLeft') {
                currentSlide = (currentSlide - 1 + slideCount) % slideCount;
                showSlide(currentSlide);
            } else if (e.key === 'ArrowRight') {
                nextSlide();
            }
        }
    });
    
    // Touch/swipe support for mobile
    let startX = 0;
    let endX = 0;
    
    const slider = document.querySelector('.hero-slider');
    if (slider && slideCount > 1) {
        slider.addEventListener('touchstart', (e) => {
            startX = e.touches[0].clientX;
        });
        
        slider.addEventListener('touchend', (e) => {
            endX = e.changedTouches[0].clientX;
            handleSwipe();
        });
    }
    
    function handleSwipe() {
        const threshold = 50; // minimum distance for swipe
        const distance = startX - endX;
        
        if (Math.abs(distance) > threshold) {
            if (distance > 0) {
                // Swipe left - next slide
                nextSlide();
            } else {
                // Swipe right - previous slide
                currentSlide = (currentSlide - 1 + slideCount) % slideCount;
                showSlide(currentSlide);
            }
        }
    }
});
