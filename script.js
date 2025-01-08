// JavaScript for smooth scrolling 
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        document.querySelector(this.getAttribute('href')).scrollIntoView({
            behavior: 'smooth'
        });
    });
});






    var swiper = new Swiper(".mySwiper", {
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
        breakpoints: {
            // ketika window >= 640px
            640: {
                slidesPerView: 2,
            },
            // ketika window >= 1024px
            1024: {
                slidesPerView: 3,
            },
        },
    });



// Tunggu sampai DOM selesai dimuat
document.addEventListener('DOMContentLoaded', function() {
    // Ambil elemen yang diperlukan
    const hamburgerButton = document.getElementById('hamburger-button');
    const navMenu = document.getElementById('nav-menu');

    // Toggle menu saat hamburger diklik
    hamburgerButton.addEventListener('click', function(e) {
        e.stopPropagation();
        navMenu.classList.toggle('active');
    });

    // Tutup menu saat mengklik di luar menu
    document.addEventListener('click', function(event) {
        if (!navMenu.contains(event.target) && !hamburgerButton.contains(event.target)) {
            navMenu.classList.remove('active');
        }
    });

    // Tutup menu saat ukuran window berubah ke desktop
    window.addEventListener('resize', function() {
        if (window.innerWidth >= 768) {
            navMenu.classList.remove('active');
        }
    });
});
