
// Navigation menu toggle
document.addEventListener('DOMContentLoaded', function() {
    const hamburgerButton = document.getElementById('hamburger-button');
    const navMenu = document.getElementById('nav-menu');
    const themeToggle = document.getElementById('theme-toggle');
    
    // Check for saved theme preference or use default dark theme
    const savedTheme = localStorage.getItem('theme') || 'dark';
    
    // Apply the saved theme
    if (savedTheme === 'light') {
        document.body.classList.add('light-mode');
        if (themeToggle) {
            const themeIcon = themeToggle.querySelector('.theme-icon');
            if (themeIcon) {
                themeIcon.classList.remove('fa-moon');
                themeIcon.classList.add('fa-sun');
            }
        }
    }
    
    // Theme toggle functionality
    if (themeToggle) {
        themeToggle.addEventListener('click', function() {
            document.body.classList.toggle('light-mode');
            
            // Update theme icon
            const themeIcon = themeToggle.querySelector('.theme-icon');
            if (themeIcon) {
                if (document.body.classList.contains('light-mode')) {
                    themeIcon.classList.remove('fa-moon');
                    themeIcon.classList.add('fa-sun');
                    localStorage.setItem('theme', 'light');
                    
                    // Update header background for light mode
                    if (header) {
                        if (window.scrollY > 50) {
                            header.style.backgroundColor = 'rgba(255, 255, 255, 0.95)';
                        } else {
                            header.style.backgroundColor = 'rgba(255, 255, 255, 0.92)';
                        }
                    }
                    
                    // Apply animation to theme change
                    document.querySelectorAll('.text-custom').forEach(el => {
                        el.style.transition = 'all 0.5s ease';
                    });
                    
                } else {
                    themeIcon.classList.remove('fa-sun');
                    themeIcon.classList.add('fa-moon');
                    localStorage.setItem('theme', 'dark');
                    
                    // Update header background for dark mode
                    if (header) {
                        if (window.scrollY > 50) {
                            header.style.backgroundColor = 'rgba(18, 18, 18, 0.95)';
                        } else {
                            header.style.backgroundColor = 'rgba(18, 18, 18, 0.9)';
                        }
                    }
                }
            }
            
            // Add a ripple effect on click
            const ripple = document.createElement('span');
            ripple.classList.add('ripple-effect');
            themeToggle.appendChild(ripple);
            
            setTimeout(() => {
                ripple.remove();
            }, 600);
        });
    }

    if (hamburgerButton && navMenu) {
        hamburgerButton.addEventListener('click', function() {
            navMenu.classList.toggle('active');
        });
    }

    // Close the menu when clicking outside
    document.addEventListener('click', function(event) {
        if (navMenu && !navMenu.contains(event.target) && !hamburgerButton.contains(event.target)) {
            navMenu.classList.remove('active');
        }
    });

    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            
            if (navMenu) {
                navMenu.classList.remove('active');
            }
            
            const targetId = this.getAttribute('href');
            const targetElement = document.querySelector(targetId);
            
            if (targetElement) {
                window.scrollTo({
                    top: targetElement.offsetTop - 70,
                    behavior: 'smooth'
                });
            }
        });
    });

    // Initialize swiper
    const swiper = new Swiper(".mySwiper", {
        slidesPerView: 1,
        spaceBetween: 30,
        loop: true,
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        autoplay: {
            delay: 3000,
            disableOnInteraction: false,
        },
        breakpoints: {
            640: {
                slidesPerView: 2,
                spaceBetween: 20,
            },
            1024: {
                slidesPerView: 3,
                spaceBetween: 30,
            },
        },
    });

    // Enhanced modal functionality with backdrop blur
    window.openModal = function(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            // Prevent body scrolling
            document.body.style.overflow = 'hidden';
            
            // Show modal with fancy transition
            modal.classList.remove('hidden');
            modal.style.backdropFilter = 'blur(0px)';
            
            // Animate both backdrop and content
            setTimeout(() => {
                modal.style.backdropFilter = 'blur(8px)';
                const modalContent = modal.querySelector('div');
                modalContent.classList.add('scale-100');
                modalContent.classList.remove('scale-0');
                modalContent.classList.add('opacity-100');
                modalContent.classList.remove('opacity-0');
            }, 50);
        }
    };

    window.closeModal = function(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            // Fade out animation
            const modalContent = modal.querySelector('div');
            modalContent.classList.remove('scale-100');
            modalContent.classList.add('scale-0');
            modalContent.classList.remove('opacity-100');
            modalContent.classList.add('opacity-0');
            modal.style.backdropFilter = 'blur(0px)';
            
            setTimeout(() => {
                modal.classList.add('hidden');
                // Restore body scrolling
                document.body.style.overflow = '';
            }, 300);
        }
    };
    
    // Close modal when clicking outside content
    document.querySelectorAll('[id^="modal"]').forEach(modal => {
        modal.addEventListener('click', function(e) {
            if (e.target === this) {
                const modalId = this.id;
                closeModal(modalId);
            }
        });
    });

    // Contact form handling
    const contactForm = document.getElementById('contactForm');
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const nama = document.getElementById('nama').value;
            const pesan = document.getElementById('pesan').value;
            
            if (nama && pesan) {
                // Format the message for WhatsApp
                const whatsappMessage = encodeURIComponent(`Nama: ${nama}\nPesan: ${pesan}`);
                const whatsappLink = `https://wa.me/6281234567890?text=${whatsappMessage}`;
                
                window.open(whatsappLink, '_blank');
                
                // Reset form
                contactForm.reset();
            }
        });
    }

    // Enhanced scroll animations
    const animateOnScroll = function() {
        const elements = document.querySelectorAll('.animate-on-scroll');
        
        elements.forEach(element => {
            const elementPosition = element.getBoundingClientRect().top;
            const windowHeight = window.innerHeight;
            
            if (elementPosition < windowHeight * 0.85) {
                // Check for specific animation classes
                if (element.classList.contains('fade-left')) {
                    element.classList.add('animated', 'fade-left');
                } else if (element.classList.contains('fade-right')) {
                    element.classList.add('animated', 'fade-right');
                } else if (element.classList.contains('zoom')) {
                    element.classList.add('animated', 'zoom');
                } else {
                    element.classList.add('animated');
                }
                
                // Add staggered delay to child elements if they exist
                const animatedChildren = element.querySelectorAll('.stagger-item');
                if (animatedChildren.length) {
                    animatedChildren.forEach((child, index) => {
                        child.style.animationDelay = `${index * 0.1}s`;
                        child.classList.add('animated');
                    });
                }
            }
        });
    };

    // Initial check for elements in view
    setTimeout(animateOnScroll, 300);
    
    // Listen for scroll events
    window.addEventListener('scroll', animateOnScroll);

    // Header scroll effect and parallax
    const header = document.getElementById('header');
    const heroSection = document.getElementById('beranda');
    const heroImage = document.querySelector('.hero-image');
    
    if (header) {
        window.addEventListener('scroll', function() {
            if (window.scrollY > 50) {
                header.classList.add('shadow-xl');
                if (document.body.classList.contains('light-mode')) {
                    header.style.backgroundColor = 'rgba(255, 255, 255, 0.95)';
                } else {
                    header.style.backgroundColor = 'rgba(18, 18, 18, 0.95)';
                }
            } else {
                header.classList.remove('shadow-xl');
                if (document.body.classList.contains('light-mode')) {
                    header.style.backgroundColor = 'rgba(255, 255, 255, 0.92)';
                } else {
                    header.style.backgroundColor = 'rgba(18, 18, 18, 0.9)';
                }
            }
            
            // Parallax effect for hero section
            if (heroSection && heroImage) {
                const scrollValue = window.scrollY;
                if (scrollValue < heroSection.offsetHeight) {
                    heroImage.style.transform = `translateY(${scrollValue * 0.3}px)`;
                }
            }
            
            // Add subtle parallax to sections
            document.querySelectorAll('.parallax-bg').forEach(bg => {
                const speed = bg.getAttribute('data-speed') || 0.2;
                const yPos = -(window.scrollY * speed);
                bg.style.transform = `translateY(${yPos}px)`;
            });
        });
    }

    // Glow effect for logo
    const logoImage = document.querySelector('.glow-effect');
    if (logoImage) {
        setInterval(() => {
            logoImage.style.filter = 'drop-shadow(0 0 10px rgba(187, 134, 252, 0.7))';
            setTimeout(() => {
                logoImage.style.filter = 'drop-shadow(0 0 5px rgba(187, 134, 252, 0.3))';
            }, 1500);
        }, 3000);
    }
});
