
// Main JavaScript functionality
document.addEventListener('DOMContentLoaded', function() {
    // Get elements
    const hamburgerButton = document.getElementById('hamburger-button');
    const navMenu = document.getElementById('nav-menu');
    const darkModeToggle = document.getElementById('darkModeToggle');

    // Check for saved theme preference or default to light mode
    const currentTheme = localStorage.getItem('theme') || 'light';
    document.body.className = currentTheme;

    if (currentTheme === 'dark') {
        darkModeToggle.checked = true;
        adjustHeaderForDarkMode(true);
    }

    // Function to adjust header background for dark mode
    function adjustHeaderForDarkMode(isDark) {
        const header = document.getElementById('main-header');
        if (isDark) {
            header.classList.remove('bg-white');
            header.classList.add('bg-gray-900');
        } else {
            header.classList.remove('bg-gray-900');
            header.classList.add('bg-white');
        }
    }

    // Dark mode toggle function
    function toggleDarkMode() {
        if (darkModeToggle.checked) {
            document.body.classList.remove('light');
            document.body.classList.add('dark');
            localStorage.setItem('theme', 'dark');
            adjustHeaderForDarkMode(true);
        } else {
            document.body.classList.remove('dark');
            document.body.classList.add('light');
            localStorage.setItem('theme', 'light');
            adjustHeaderForDarkMode(false);
        }
    }

    // Listen for toggle click
    if (darkModeToggle) {
        darkModeToggle.addEventListener('change', toggleDarkMode);
    }

    // Toggle menu when hamburger is clicked
    if (hamburgerButton && navMenu) {
        hamburgerButton.addEventListener('click', function(e) {
            e.stopPropagation();
            navMenu.classList.toggle('active');
        });

        // Close menu when clicking outside
        document.addEventListener('click', function(event) {
            if (!navMenu.contains(event.target) && !hamburgerButton.contains(event.target)) {
                navMenu.classList.remove('active');
            }
        });

        // Close menu when window resizes to desktop
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 768) {
                navMenu.classList.remove('active');
            }
        });
    }

    // Search functionality
    const searchInput = document.getElementById('search');
    if (searchInput) {
        searchInput.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const galleryItems = document.querySelectorAll('.gallery-item');

            galleryItems.forEach(item => {
                const title = item.querySelector('h3').textContent.toLowerCase();
                const description = item.querySelector('p').textContent.toLowerCase();

                if (title.includes(searchTerm) || description.includes(searchTerm)) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    }

    // Smooth scrolling for navigation links
    const navLinks = document.querySelectorAll('.nav-menu a[href^="#"]');
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = link.getAttribute('href');
            const targetElement = document.querySelector(targetId);
            
            if (targetElement) {
                const offsetTop = targetElement.offsetTop - 70; // Account for fixed navbar
                window.scrollTo({
                    top: offsetTop,
                    behavior: 'smooth'
                });
                
                // Close mobile menu if open
                if (navMenu.classList.contains('active')) {
                    navMenu.classList.remove('active');
                }
            }
        });
    });

    // Gallery image click modal functionality
    const galleryImages = document.querySelectorAll('.galeri-item img');
    galleryImages.forEach(img => {
        img.addEventListener('click', function() {
            const title = this.alt;
            const description = this.closest('.galeri-item').querySelector('p').textContent;
            
            // Create modal
            const modal = document.createElement('div');
            modal.className = 'image-modal';
            modal.innerHTML = `
                <div class="modal-content">
                    <span class="modal-close">&times;</span>
                    <img src="${img.src}" alt="${title}">
                    <div class="modal-info">
                        <h3>${title}</h3>
                        <p>${description}</p>
                    </div>
                </div>
            `;
            
            document.body.appendChild(modal);
            modal.style.display = 'flex';
            
            // Close modal functionality
            const closeModal = () => {
                modal.remove();
            };
            
            modal.querySelector('.modal-close').addEventListener('click', closeModal);
            modal.addEventListener('click', (e) => {
                if (e.target === modal) closeModal();
            });
            
            document.addEventListener('keydown', function escapeClose(e) {
                if (e.key === 'Escape') {
                    closeModal();
                    document.removeEventListener('keydown', escapeClose);
                }
            });
        });
    });

    // Add CSS for image modal if not already present
    if (!document.querySelector('#modal-styles')) {
        const modalStyles = document.createElement('style');
        modalStyles.id = 'modal-styles';
        modalStyles.textContent = `
            .image-modal {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.9);
                display: flex;
                justify-content: center;
                align-items: center;
                z-index: 2000;
            }
            
            .modal-content {
                position: relative;
                max-width: 90%;
                max-height: 90%;
                background: white;
                border-radius: 10px;
                overflow: hidden;
            }
            
            .modal-content img {
                width: 100%;
                height: auto;
                max-height: 70vh;
                object-fit: contain;
            }
            
            .modal-info {
                padding: 1rem;
            }
            
            .modal-close {
                position: absolute;
                top: 10px;
                right: 15px;
                font-size: 2rem;
                color: white;
                cursor: pointer;
                background: rgba(0, 0, 0, 0.5);
                width: 40px;
                height: 40px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                transition: background 0.3s;
            }
            
            .modal-close:hover {
                background: rgba(0, 0, 0, 0.7);
            }
        `;
        document.head.appendChild(modalStyles);
    }
});

// Floating contact functionality
document.addEventListener('DOMContentLoaded', function() {
    const contactBtn = document.querySelector('.contact-btn');
    const contactForm = document.querySelector('.contact-form');
    const closeBtn = document.querySelector('.close-btn');

    if (contactBtn && contactForm) {
        contactBtn.addEventListener('click', function(e) {
            e.preventDefault();
            contactForm.classList.toggle('active');
        });

        if (closeBtn) {
            closeBtn.addEventListener('click', function() {
                contactForm.classList.remove('active');
            });
        }

        // Close form when clicking outside
        document.addEventListener('click', function(e) {
            if (!contactForm.contains(e.target) && !contactBtn.contains(e.target)) {
                contactForm.classList.remove('active');
            }
        });
    }

    // Form preview functionality
    const namaInput = document.getElementById('nama');
    const pesanInput = document.getElementById('pesan');
    const previewBox = document.querySelector('.preview-box');

    function updatePreview() {
        const nama = namaInput ? namaInput.value : '';
        const pesan = pesanInput ? pesanInput.value : '';
        
        if (previewBox) {
            if (nama || pesan) {
                previewBox.innerHTML = `Halo, nama saya ${nama || '[Nama]'}. ${pesan || '[Pesan Anda]'}`;
            } else {
                previewBox.innerHTML = 'Preview pesan akan muncul di sini...';
            }
        }
    }

    if (namaInput) namaInput.addEventListener('input', updatePreview);
    if (pesanInput) pesanInput.addEventListener('input', updatePreview);
});
