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
document.addEventListener('DOMContentLoaded', function () {
    // Ambil elemen yang diperlukan
    const hamburgerButton = document.getElementById('hamburger-button');
    const navMenu = document.getElementById('nav-menu');

    // Toggle menu saat hamburger diklik
    hamburgerButton.addEventListener('click', function (e) {
        e.stopPropagation();
        navMenu.classList.toggle('active');
    });

    // Tutup menu saat mengklik di luar menu
    document.addEventListener('click', function (event) {
        if (!navMenu.contains(event.target) && !hamburgerButton.contains(event.target)) {
            navMenu.classList.remove('active');
        }
    });

    // Tutup menu saat ukuran window berubah ke desktop
    window.addEventListener('resize', function () {
        if (window.innerWidth >= 768) {
            navMenu.classList.remove('active');
        }
    });
});







function showCustomAlert() {
    const alertBox = document.getElementById('custom-alert');
    alertBox.classList.remove('hidden'); // Menampilkan alert

    // Sembunyikan alert setelah 3 detik
    setTimeout(() => {
        hideCustomAlert();
    }, 3000);
}

function hideCustomAlert() {
    const alertBox = document.getElementById('custom-alert');
    alertBox.classList.add('hidden'); // Menyembunyikan alert
}




// Modal JavaScript untuk membuka dan menutup modal
function openModal(modalId) {
    const modal = document.getElementById(modalId);
    modal.classList.remove('hidden');
    setTimeout(() => {
        modal.querySelector('.transform').classList.remove('scale-0');
        modal.querySelector('.transform').classList.add('scale-100');
    }, 100);
}

//untuk menutup modal
function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    modal.querySelector('.transform').classList.remove('scale-100');
    modal.querySelector('.transform').classList.add('scale-0');
    setTimeout(() => {
        modal.classList.add('hidden');
    }, 300);
}


// Tambahkan event listener untuk form kontak
// Tambahkan event listener untuk form kontak
document.getElementById("contactForm").addEventListener("submit", function (event) {
    event.preventDefault();

    // Ambil nilai dari inputan form
    let nama = document.getElementById("nama").value.trim();
    let pesan = document.getElementById("pesan").value.trim();
    let nomorWA = "6282267885262"; // Ganti dengan nomor WhatsApp tujuan

    // Validasi input agar tidak kosong
    if (nama === "" || pesan === "") {
        alert("Harap isi semua kolom sebelum mengirim pesan!");
        return;
    }

    // Format pesan WhatsApp dengan encoding
    let teksPesan = `Halo, saya ${nama}%0A%0A${pesan}`;
    let linkWA = `https://wa.me/${nomorWA}?text=${encodeURIComponent(`Halo, saya ${nama}\n\n${pesan}`)}`;

    // Buka WhatsApp di tab baru
    window.open(linkWA, "_blank");
});






