// Sample data - Replace with your actual data
const galleryItems = [
    {
        id: 1,
        title: 'Peusijuk',
        category: 'events',
        imageUrl: 'Kegiatan/Peusijuek2.jpg',
        downloads: 0,
        date: '2024-01-15'
    },
    {
        id: 2,
        title: 'Buka Bersama',
        category: 'activities',
        imageUrl: 'Kegiatan/BukaBersama.jpg',
        downloads: 0,
        date: '2024-02-01'
    },
    {
        id: 3,
        title: 'Akreditasi',
        category: 'activities',
        imageUrl: 'Kegiatan/AkreditasiProdi.jpg',
        downloads: 0,
        date: '2024-02-15'
    },
    {
        id: 4,
        title: 'Futsal',
        category: 'activities',
        imageUrl: 'Kegiatan/Futsal1.jpg',
        downloads: 0,
        date: '2024-02-15'
    },
    {
        id: 5,
        title: 'futsal',
        category: 'activities',
        imageUrl: 'Kegiatan/Futsal2.jpg',
        downloads: 0,
        date: '2024-02-15'
    },
    {
        id: 6,
        title: 'Futsal',
        category: 'activities',
        imageUrl: 'Kegiatan/Futsal3.jpg',
        downloads: 0,
        date: '2024-02-15'
    },
    {
        id: 7,
        title: 'Futsal',
        category: 'activities',
        imageUrl: 'Kegiatan/Futsal4.jpg',
        downloads: 0,
        date: '2024-02-15'
    },
    {
        id: 8,
        title: 'Futsal',
        category: 'activities',
        imageUrl: 'Kegiatan/Futsal5.jpg',
        downloads: 0,
        date: '2024-02-15'
    },
    {
        id: 8,
        title: 'Futsal',
        category: 'activities',
        imageUrl: 'Kegiatan/Futsal6.jpg',
        downloads: 0,
        date: '2024-02-15'
    },
    {
        id: 9,
        title: 'Futsal',
        category: 'activities',
        imageUrl: 'Kegiatan/Futsal7.jpg',
        downloads: 0,
        date: '2024-02-15'
    },
    {
        id: 10,
        title: 'Futsal',
        category: 'activities',
        imageUrl: 'Kegiatan/Futsal8.jpg',
        downloads: 0,
        date: '2024-02-15'
    },
    {
        id: 11,
        title: 'Futsal',
        category: 'activities',
        imageUrl: 'Kegiatan/Futsal9.jpg',
        downloads: 0,
        date: '2024-02-15'
    },
    {
        id: 12,
        title: 'Futsal',
        category: 'activities',
        imageUrl: 'Kegiatan/Futsal10.jpg',
        downloads: 0,
        date: '2024-02-15'
    },
    {
        id: 13,
        title: 'Maulid Nabi Muhammad',
        category: 'activities',
        imageUrl: 'Kegiatan/Maulid.jpg',
        downloads: 0,
        date: '2024-02-15'
    },
    {
        id: 14,
        title: 'Peusijuek',
        category: 'activities',
        imageUrl: 'Kegiatan/Peusijuek1.jpg',
        downloads: 0,
        date: '2024-02-15'
    },
    {
        id: 15,
        title: 'Salah satu keluarga quantum mengikuti DIKLATPIM',
        category: 'activities',
        imageUrl: 'Kegiatan/Diklat.jpg',
        downloads: 0,
        date: '2024-02-15'
    },
    // Add more items as needed
];

const albums = [
    {
        id: 1,
        title: 'Annual Meetup 2024',
        cover: 'https://source.unsplash.com/random/800x600/?conference',
        count: 25
    },
    {
        id: 2,
        title: 'Workshop Series',
        cover: 'https://source.unsplash.com/random/800x600/?workshop',
        count: 15
    },
    {
        id: 3,
        title: 'Community Events',
        cover: 'https://source.unsplash.com/random/800x600/?event',
        count: 30
    },
];

// Initialize the gallery
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
    div.innerHTML = `
        <a href="${item.imageUrl}" data-lightbox="gallery" data-title="${item.title}">
            <img src="${item.imageUrl}" alt="${item.title}" class="w-full h-64 object-cover">
        </a>
        <div class="p-4">
            <h3 class="text-lg font-semibold mb-2">${item.title}</h3>
            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-500">${item.date}</span>
                <div class="flex items-center space-x-2">
                    <span class="text-sm text-gray-500">${item.downloads} downloads</span>
                    <button onclick="downloadImage('${item.imageUrl}', ${item.id})" 
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
async function downloadImage(url, id) {
    try {
        const response = await fetch(url);
        const blob = await response.blob();
        const downloadUrl = window.URL.createObjectURL(blob);
        const link = document.createElement('a');
        link.href = downloadUrl;
        link.download = `quantum-leap-${id}.jpg`;
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

// Initialize everything when the page loads
document.addEventListener('DOMContentLoaded', () => {
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
