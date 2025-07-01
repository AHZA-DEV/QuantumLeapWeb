
function initializeGallery() {
    const galleryGrid = document.getElementById('gallery-grid');
    galleryItems.forEach(item => {
        const galleryItem = createGalleryItem(item);
        galleryGrid.appendChild(galleryItem);
    });
}

// Create gallery item
function createGalleryItem(item) {
    const div = document.createElement('div');
    div.className = 'gallery-item bg-white rounded-lg shadow-md overflow-hidden';
    div.setAttribute('data-category', item.category);
    div.setAttribute('data-id', item.id);

    let mediaContent;
    if (item.type === 'video') {
        const thumbnail = item.thumbnail || 'Kegiatan/BukaBersama.jpg';
        mediaContent = `<div class="cursor-pointer video-preview relative" onclick="openVideoModal('${item.url}', '${item.title}')">
            <div class="w-full h-64 bg-black relative">
                <img src="${thumbnail}" class="w-full h-full object-cover opacity-80" alt="${item.title}">
                <div class="absolute inset-0 flex items-center justify-center">
                    <i class="fas fa-play-circle text-6xl text-white opacity-80 hover:opacity-100 transition-opacity"></i>
                </div>
            </div>
        </div>`;
    } else {
        mediaContent = `<a href="${item.imageUrl}" data-lightbox="gallery" data-title="${item.title}">
            <img src="${item.imageUrl}" alt="${item.title}" class="w-full h-64 object-cover">
        </a>`;
    }

    div.innerHTML = `
        ${mediaContent}
        <div class="p-4">
            <h3 class="text-lg font-semibold mb-2">${item.title}</h3>
            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-500">${item.date}</span>
                <div class="flex items-center space-x-2">
                    <span class="text-sm text-gray-500 download-count">${item.downloads} downloads</span>
                    <button onclick="downloadMedia('${item.type === 'video' ? item.url : item.imageUrl}', ${item.id})" 
                            class="px-3 py-1 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                        <i class="fas fa-download"></i>
                    </button>
                </div>
            </div>
        </div>
    `;
    return div;
}

// Initialize albums
function initializeAlbums() {
    const albumsGrid = document.getElementById('albums-grid');
    albums.forEach(album => {
        const albumItem = createAlbumItem(album);
        albumsGrid.appendChild(albumItem);
    });
}

// Create album item
function createAlbumItem(album) {
    const div = document.createElement('div');
    div.className = 'bg-white rounded-lg shadow-md overflow-hidden';
    div.innerHTML = `
        <img src="${album.cover}" alt="${album.title}" class="w-full h-48 object-cover">
        <div class="p-4">
            <h3 class="text-lg font-semibold mb-2">${album.title}</h3>
            <p class="text-sm text-gray-500">${album.count} photos</p>
        </div>
    `;
    return div;
}

// Filter gallery items
function filterGallery(category) {
    const items = document.querySelectorAll('.gallery-item');
    items.forEach(item => {
        const itemCategory = item.dataset.category;
        if (category === 'all' || itemCategory === category) {
            item.style.display = 'block';
        } else {
            item.style.display = 'none';
        }
    });
}

// Download image function
async function downloadMedia(url, id) {
    try {
        // Use relative path for images
        const response = await fetch(url);
        const blob = await response.blob();
        const downloadUrl = window.URL.createObjectURL(blob);
        const link = document.createElement('a');
        link.href = downloadUrl;

        // Extract filename from the URL path
        const filename = url.split('/').pop();
        link.download = filename || `quantum-leap-${id}.jpg`;

        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        window.URL.revokeObjectURL(downloadUrl);

        // Update download counter
        const item = galleryItems.find(item => item.id === id);
        if (item) {
            item.downloads++;
            updateDownloadCounter(id, item.downloads);
        }
    } catch (error) {
        console.error('Error downloading image:', error);
    }
}

// Update download counter in UI
function updateDownloadCounter(id, count) {
    const counterElement = document.querySelector(`[data-id="${id}"] .download-count`);
    if (counterElement) {
        counterElement.textContent = `${count} downloads`;
    }
}

// Search functionality
document.getElementById('search').addEventListener('input', (e) => {
    const searchTerm = e.target.value.toLowerCase();
    const items = document.querySelectorAll('.gallery-item');

    items.forEach(item => {
        const title = item.querySelector('h3').textContent.toLowerCase();
        const date = item.querySelector('.text-gray-500').textContent.toLowerCase();

        if (title.includes(searchTerm) || date.includes(searchTerm)) {
            item.style.display = 'block';
        } else {
            item.style.display = 'none';
        }
    });
});

// Filter button functionality
document.querySelectorAll('.filter-btn').forEach(btn => {
    btn.addEventListener('click', (e) => {
        document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
        e.target.classList.add('active');
        filterGallery(e.target.dataset.category);
    });
});

// Function to open video modal
function openVideoModal(videoUrl, title) {
    const modal = document.createElement('div');
    modal.className = 'fixed inset-0 bg-black bg-opacity-90 flex items-center justify-center z-50';
    modal.innerHTML = `
        <div class="relative max-w-4xl w-full mx-4">
            <iframe src="${videoUrl}" frameborder="0" allowfullscreen class="w-full h-[80vh] rounded-lg shadow-lg"></iframe>
            <div class="absolute top-4 right-4 flex gap-2">
                <button class="text-white text-xl bg-gray-800/50 rounded-full w-8 h-8 flex items-center justify-center hover:bg-gray-700/50 transition-colors" onclick="toggleFullscreen(this.parentElement.parentElement)">
                    <i class="fas fa-expand"></i>
                </button>
                <button class="text-white text-xl bg-gray-800/50 rounded-full w-8 h-8 flex items-center justify-center hover:bg-gray-700/50 transition-colors" onclick="this.parentElement.parentElement.parentElement.remove()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <h3 class="text-white text-xl mt-4">${title}</h3>
        </div>
    `;

    const video = modal.querySelector('video');
    const closeBtn = modal.querySelector('button');

    closeBtn.addEventListener('click', () => {
        video.pause();
        modal.remove();
    });

    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            video.pause();
            modal.remove();
        }
    });

    document.body.appendChild(modal);
    video.play();
}

// Initialize everything when the page loads
document.addEventListener('DOMContentLoaded', () => {
    initializeVideoStories();
    initializeGallery();
    initializeAlbums();

    // Initialize lightbox
    lightbox.option({
        'resizeDuration': 200,
        'wrapAround': true,
        'albumLabel': 'Image %1 of %2'
    });
});



// Tunggu sampai DOM selesai dimuat
document.addEventListener('DOMContentLoaded', function () {
    // Ambil elemen yang diperlukan
    const hamburgerButton = document.getElementById('hamburger-button');
    const navMenu = document.getElementById('nav-menu');
    const darkModeToggle = document.getElementById('darkModeToggle');


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
            localStorage.setItem('darkMode', 'enabled');
            adjustHeaderForDarkMode(true);
        } else {
            document.body.classList.remove('dark');
            document.body.classList.add('light');
            localStorage.setItem('darkMode', 'disabled');
            adjustHeaderForDarkMode(false);
        }
    }

    // Listen for toggle click
    darkModeToggle.addEventListener('change', toggleDarkMode);

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

function toggleFullscreen(element) {
    //Implement fullscreen functionality here using the browser's fullscreen API.  This is placeholder code.
    if (element.requestFullscreen) {
        element.requestFullscreen();
    } else if (element.mozRequestFullScreen) { /* Firefox */
        element.mozRequestFullScreen();
    } else if (element.webkitRequestFullscreen) { /* Chrome, Safari & Opera */
        element.webkitRequestFullscreen();
    } else if (element.msRequestFullscreen) { /* IE/Edge */
        element.msRequestFullscreen();
    }
}






// Alert
document.addEventListener('DOMContentLoaded', function() {
    const closeButtons = document.querySelectorAll('.close-btn, .understand-btn');

    closeButtons.forEach(button => {
        button.addEventListener('click', function() {
            const alertContainer = document.querySelector('.alert-container');
            alertContainer.style.animation = 'none';
            alertContainer.style.transform = 'translateY(100%)';
            alertContainer.style.opacity = '0';
            alertContainer.style.transition = 'all 0.5s ease-out';

            setTimeout(() => {
                alertContainer.remove();
            }, 500);
        });
    });

    // Auto close after 10 seconds
    setTimeout(() => {
        const closeBtn = document.querySelector('.close-btn');
        if (closeBtn) closeBtn.click();
    }, 10000);
});