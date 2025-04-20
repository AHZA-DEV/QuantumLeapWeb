// Video stories data
const videoStories = [
    {
        id: 1,
        url: 'https://drive.google.com/file/d/1jw2YvN-kFcmIJjkreG95vqaSNxV45JX2/preview?embedded=true',
        thumbnail: 'Kegiatan/Bukber Family Quantum Leap5.jpg',
        title: 'Buka Bersama 2025'
    },
    {
        id: 2,
        url: 'https://drive.google.com/file/d/1Zhz4saJoARDo1FeEzznxpGYsemwRbfBC/preview?embedded=true',
        thumbnail: 'Kegiatan/Bukber Family Quantum Leap.jpg',
        title: 'Buka Bersama 2025'
    },
    {
        id: 3,
        url: 'https://drive.google.com/file/d/1bUgOZIctemt1Feg8r9PL6tweJJoe1aAq/preview?embedded=true',
        thumbnail: 'Kegiatan/FamilyGathering.jpg',
        title: 'Family Gathering'
    },
    {
        id: 4,
        url: 'https://drive.google.com/file/d/1Mwl9mz921ZVwIPuUlF561sClDW4hCxdc/preview?embedded=true',
        thumbnail: 'Kegiatan/FamilyGathering.jpg',
        title: 'Family Gathering'
    },
    {
        id: 5,
        url: 'https://drive.google.com/file/d/1BwluUMdMcSvDxIbmJdN_CC0oxYLSuxzZ/preview?embedded=true',
        thumbnail: 'Kegiatan/FamilyGathering.jpg',
        title: 'Family Gathering'
    },
    // {
    //     id: 3,
    //     url: 'kegiatan/videos/bukber.mp4',
    //     thumbnail: 'Kegiatan/Futsal1.jpg',
    //     title: 'Futsal'
    // },
    // {
    //     id: 4,
    //     url: 'https://assets.mixkit.co/videos/preview/mixkit-group-of-friends-partying-happily-4640-large.mp4',
    //     thumbnail: 'Kegiatan/Futsal1.jpg',
    //     title: 'Futsal'
    // },
    // {
    //     id: 5,
    //     url: 'https://assets.mixkit.co/videos/preview/mixkit-group-of-friends-partying-happily-4640-large.mp4',
    //     thumbnail: 'Kegiatan/Futsal1.jpg',
    //     title: 'Futsal'
    // },
    // {
    //     id: 6,
    //     url: 'https://assets.mixkit.co/videos/preview/mixkit-group-of-friends-partying-happily-4640-large.mp4',
    //     thumbnail: 'Kegiatan/Futsal1.jpg',
    //     title: 'Futsal'
    // }
];

// Function to create video story elements
function initializeVideoStories() {
    const storiesContainer = document.getElementById('video-stories');
    if (!storiesContainer) return;

    storiesContainer.innerHTML = '';
    videoStories.forEach(story => {
        const storyElement = document.createElement('div');
        storyElement.className = 'flex-shrink-0 cursor-pointer relative';
        storyElement.innerHTML = `
            <div class="w-20 h-20 rounded-full border-2 border-indigo-600 p-1 hover:scale-105 transition-transform">
                <img src="${story.thumbnail}" class="w-full h-full rounded-full object-cover" alt="${story.title}">
            </div>
            <p class="text-center mt-1 text-sm">${story.title}</p>
        `;

        storyElement.addEventListener('click', () => {
            const modal = document.createElement('div');
            modal.className = 'fixed inset-0 bg-black bg-opacity-90 flex items-center justify-center z-50';
            modal.innerHTML = `
                <div class="relative max-w-2xl w-full mx-4">
                    <iframe src="${story.url}" frameborder="0" allowfullscreen class="w-full h-96 rounded-lg shadow-lg"></iframe>
                    <div class="absolute top-4 right-4 flex gap-2">
                        <button class="text-white text-xl bg-gray-800 rounded-full p-2 hover:bg-gray-700" onclick="toggleFullscreen(this.parentElement.parentElement)">
                            <i class="fas fa-expand"></i>
                        </button>
                        <button class="text-white text-xl bg-gray-800 rounded-full p-2 hover:bg-gray-700" onclick="this.parentElement.parentElement.parentElement.remove()">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            `;

            document.body.appendChild(modal);
            const video = modal.querySelector('video');

            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    video.pause();
                    modal.remove();
                }
            });
        });

        storiesContainer.appendChild(storyElement);
    });
}

// Sample data - Replace with your actual data
const galleryItems = [
    {
        id: 1,
        title: 'Video Bukber Family Quantum Leap 23, 2025',
        category: 'videos',
        type: 'video',
        url: 'https://drive.google.com/file/d/1jw2YvN-kFcmIJjkreG95vqaSNxV45JX2/preview?embedded=true',
        downloads: 0,
        date: '2024-03-12'
    },
    {
        id: 2,
        title: 'Video Bukber Family Quantum Leap 23, 2025',
        category: 'videos',
        type: 'video',
        url: 'https://drive.google.com/file/d/1Zhz4saJoARDo1FeEzznxpGYsemwRbfBC/preview?embedded=true',
        downloads: 0,
        date: '2024-03-12'
    },
    {
        id: 3,
        title: 'Buka Bersama Family Quantum Leap 23, 2025',
        category: 'photo',
        imageUrl: 'Kegiatan/Bukber Family Quantum Leap.jpg',
        downloads: 0,
        date: '2024-02-01'
    },
    {
        id: 4,
        title: 'Buka Bersama Family Quantum Leap 23, 2025',
        category: 'photo',
        imageUrl: 'Kegiatan/Bukber Family Quantum Leap2.jpg',
        downloads: 0,
        date: '2024-02-01'
    },
    {
        id: 5,
        title: 'Buka Bersama Family Quantum Leap 23, 2025',
        category: 'photo',
        imageUrl: 'Kegiatan/Bukber Family Quantum Leap3.jpg',
        downloads: 0,
        date: '2024-02-01'
    },
    {
        id: 6,
        title: 'Buka Bersama Family Quantum Leap 23, 2025',
        category: 'photo',
        imageUrl: 'Kegiatan/Bukber Family Quantum Leap4.jpg',
        downloads: 0,
        date: '2024-02-01'
    },
    {
        id: 7,
        title: 'Buka Bersama Family Quantum Leap 23, 2025',
        category: 'photo',
        imageUrl: 'Kegiatan/Bukber Family Quantum Leap5.jpg',
        downloads: 0,
        date: '2024-02-01'
    },
    {
        id: 8,
        title: 'Buka Bersama Family Quantum Leap 23, 2025',
        category: 'photo',
        imageUrl: 'Kegiatan/Bukber Family Quantum Leap6.jpg',
        downloads: 0,
        date: '2024-02-01'
    },
    {
        id: 9,
        title: 'Buka Bersama Family Quantum Leap 23, 2025',
        category: 'photo',
        imageUrl: 'Kegiatan/Bukber Family Quantum Leap7.jpg',
        downloads: 0,
        date: '2024-02-01'
    },
    {
        id: 10,
        title: 'Buka Bersama Family Quantum Leap 2024',
        category: 'photo',
        imageUrl: 'Kegiatan/BukaBersama.jpg',
        downloads: 0,
        date: '2024-02-01'
    },
    {
        id: 11,
        title: 'Akreditasi',
        category: 'photo',
        imageUrl: 'Kegiatan/AkreditasiProdi.jpg',
        downloads: 0,
        date: '2024-02-15'
    },
    {
        id: 12,
        title: 'Futsal',
        category: 'photo',
        imageUrl: 'Kegiatan/Futsal1.jpg',
        downloads: 0,
        date: '2024-02-15'
    },
    {
        id: 13,
        title: 'Futsal',
        category: 'photo',
        imageUrl: 'Kegiatan/Futsal2.jpg',
        downloads: 0,
        date: '2024-02-15'
    },
    {
        id: 14,
        title: 'Futsal',
        category: 'photo',
        imageUrl: 'Kegiatan/Futsal3.jpg',
        downloads: 0,
        date: '2024-02-15'
    },
    {
        id: 15,
        title: 'Futsal',
        category: 'photo',
        imageUrl: 'Kegiatan/Futsal4.jpg',
        downloads: 0,
        date: '2024-02-15'
    },
    {
        id: 16,
        title: 'Futsal',
        category: 'photo',
        imageUrl: 'Kegiatan/Futsal5.jpg',
        downloads: 0,
        date: '2024-02-15'
    },
    {
        id: 17,
        title: 'Futsal',
        category: 'photo',
        imageUrl: 'Kegiatan/Futsal6.jpg',
        downloads: 0,
        date: '2024-02-15'
    },
    {
        id: 18,
        title: 'Futsal',
        category: 'photo',
        imageUrl: 'Kegiatan/Futsal7.jpg',
        downloads: 0,
        date: '2024-02-15'
    },
    {
        id: 19,
        title: 'Futsal',
        category: 'photo',
        imageUrl: 'Kegiatan/Futsal8.jpg',
        downloads: 0,
        date: '2024-02-15'
    },
    {
        id: 20,
        title: 'Futsal',
        category: 'photo',
        imageUrl: 'Kegiatan/Futsal9.jpg',
        downloads: 0,
        date: '2024-02-15'
    },
    {
        id: 21,
        title: 'Futsal',
        category: 'photo',
        imageUrl: 'Kegiatan/Futsal10.jpg',
        downloads: 0,
        date: '2024-02-15'
    },
    {
        id: 22,
        title: 'Maulid Nabi Muhammad',
        category: 'photo',
        imageUrl: 'Kegiatan/Maulid.jpg',
        downloads: 0,
        date: '2024-02-15'
    },
    {
        id: 23,
        title: 'Peusijuek',
        category: 'photo',
        imageUrl: 'Kegiatan/Peusijuek1.jpg',
        downloads: 0,
        date: '2024-02-15'
    },
    {
        id: 24,
        title: 'Salah satu keluarga quantum mengikuti DIKLATPIM',
        category: 'photo',
        imageUrl: 'Kegiatan/Diklat.jpg',
        downloads: 0,
        date: '2024-02-15'
    },
    {         
        id: 25,         
        title: 'Kegiatan Family Gathering Quantum Leap',         
        category: 'photo',         
        imageUrl: 'Kegiatan/familygatharing.jpg',         
        downloads: 0,         
        date: '2024-02-15'     
    },
    {         
        id: 26,         
        title: 'Kegiatan Family Gathering Quantum Leap',         
        category: 'photo',         
        imageUrl: 'Kegiatan/familygatharing2.jpg',         
        downloads: 0,         
        date: '2024-02-16'     
    },
    {         
        id: 27,         
        title: 'Kegiatan Family Gathering Quantum Leap',         
        category: 'photo',         
        imageUrl: 'Kegiatan/familygatharing3.jpg',         
        downloads: 0,         
        date: '2024-02-17'     
    },
    {         
        id: 28,         
        title: 'Kegiatan Family Gathering Quantum Leap',         
        category: 'photo',         
        imageUrl: 'Kegiatan/familygatharing4.jpg',         
        downloads: 0,         
        date: '2024-02-18'     
    },
    {         
        id: 29,         
        title: 'Kegiatan Family Gathering Quantum Leap',         
        category: 'photo',         
        imageUrl: 'Kegiatan/familygatharing5.jpg',         
        downloads: 0,         
        date: '2024-02-19'     
    },
    {         
        id: 30,         
        title: 'Kegiatan Family Gathering Quantum Leap',         
        category: 'photo',         
        imageUrl: 'Kegiatan/familygatharing6.jpg',         
        downloads: 0,         
        date: '2024-02-20'     
    },
    {         
        id: 31,         
        title: 'Kegiatan Family Gathering Quantum Leap',         
        category: 'photo',         
        imageUrl: 'Kegiatan/familygatharing7.jpg',         
        downloads: 0,         
        date: '2024-02-21'     
    },
    {         
        id: 32,         
        title: 'Kegiatan Family Gathering Quantum Leap',         
        category: 'photo',         
        imageUrl: 'Kegiatan/familygatharing8.jpg',         
        downloads: 0,         
        date: '2024-02-22'     
    },
    {         
        id: 33,         
        title: 'Kegiatan Family Gathering Quantum Leap',         
        category: 'photo',         
        imageUrl: 'Kegiatan/familygatharing9.jpg',         
        downloads: 0,         
        date: '2024-02-23'     
    },
    {         
        id: 34,         
        title: 'Kegiatan Family Gathering Quantum Leap',         
        category: 'photo',         
        imageUrl: 'Kegiatan/familygatharing10.jpg',         
        downloads: 0,         
        date: '2024-02-24'     
    },
    {         
        id: 35,         
        title: 'Kegiatan Family Gathering Quantum Leap',         
        category: 'photo',         
        imageUrl: 'Kegiatan/familygatharing11.jpg',         
        downloads: 0,         
        date: '2024-02-25'     
    }
];



// const albums = [
//     {
//         id: 1,
//         title: 'Annual Meetup 2024',
//         cover: 'https://source.unsplash.com/random/800x600/?conference',
//         count: 25
//     },
//     {
//         id: 2,
//         title: 'Workshop Series',
//         cover: 'https://source.unsplash.com/random/800x600/?workshop',
//         count: 15
//     },
//     {
//         id: 3,
//         title: 'Community Events',
//         cover: 'https://source.unsplash.com/random/800x600/?event',
//         count: 30
//     },
// ];

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
    div.setAttribute('data-category', item.category);
    div.setAttribute('data-id', item.id);

    let mediaContent;
    if (item.type === 'video') {
        mediaContent = `<div class="cursor-pointer video-preview relative" onclick="openVideoModal('${item.url}', '${item.title}')">
            <div class="w-full h-64 bg-black">
                <iframe src="${item.url}" frameborder="0" class="w-full h-full"></iframe>
            </div>
            <div class="absolute inset-0 flex items-center justify-center">
                <i class="fas fa-play-circle text-4xl text-white opacity-80"></i>
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




