
<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QuantumLeap Gallery</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/lightbox2@2.11.3/dist/css/lightbox.min.css">
    <link rel="stylesheet" href="galeri.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="icon" href="assets/images/favicon.ico" type="image/x-icon">
</head>
<body class="bg-gray-100 light">
    <!-- Header -->
    <header class="fixed w-full bg-white shadow-md z-50" id="main-header">
        <nav class="container mx-auto px-6 py-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <span class="text-2xl font-bold text-indigo-600">QuantumLeap Gallery</span>
                </div>

                <div id="nav-menu" class="nav-menu md:flex md:items-center hidden">
                    <a href="#home" class="block md:inline-block px-4 py-2 text-gray-700 hover:text-gray-900">Beranda</a>
                    <a href="#gallery" class="block md:inline-block px-4 py-2 text-gray-700 hover:text-gray-900">Galeri</a>
                    <a href="#contact" class="block md:inline-block px-4 py-2 text-gray-700 hover:text-gray-900">Kontak</a>
                    <a href="admin/login.php" class="block md:inline-block px-4 py-2 text-gray-700 hover:text-gray-900">Admin</a>

                    <div class="flex items-center">
                        <label class="toggle-switch">
                            <input type="checkbox" id="darkModeToggle">
                            <span class="toggle-slider">
                                <i class="fas fa-sun sun-icon"></i>
                                <i class="fas fa-moon moon-icon"></i>
                            </span>
                        </label>
                    </div>
                </div>

                <!-- Hamburger Button -->
                <button id="hamburger-button" class="md:hidden text-gray-500 hover:text-gray-700 focus:outline-none ml-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </nav>
    </header>

    <!-- Hero Banner dengan Slider -->
    <section id="home" class="pt-16">
        <div class="relative h-[600px]">
            <div class="absolute inset-0 bg-black/50 z-10"></div>
            <div class="absolute inset-0 z-20 flex items-center justify-center text-center">
                <div class="text-white">
                    <h1 class="text-5xl font-bold mb-4">Selamat Datang di QuantumLeap Gallery</h1>
                    <p class="text-xl">Menangkap momen, menciptakan kenangan</p>
                </div>
            </div>
            <div class="absolute inset-0 z-0">
                <div class="hero-slider h-full">
                    <?php
                    $slider_query = mysqli_query($conn, "SELECT * FROM slider WHERE status='aktif' ORDER BY id DESC");
                    $slide_count = 0;
                    while ($slider = mysqli_fetch_array($slider_query)):
                        $slide_count++;
                    ?>
                    <div class="slide" style="background-image: url('uploads/slider/<?php echo $slider['gambar']; ?>');">
                        <div class="slide-overlay"></div>
                    </div>
                    <?php endwhile; ?>
                    
                    <?php if ($slide_count == 0): ?>
                    <div class="slide" style="background-image: url('assets/images/default-slider.jpg');">
                        <div class="slide-overlay"></div>
                    </div>
                    <?php endif; ?>
                </div>
                
                <!-- Dots Navigation -->
                <?php if ($slide_count > 1): ?>
                <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2 z-30">
                    <?php for ($i = 0; $i < $slide_count; $i++): ?>
                    <button class="dot w-3 h-3 rounded-full bg-white/50 hover:bg-white transition-colors <?php echo $i === 0 ? 'active bg-white' : ''; ?>"></button>
                    <?php endfor; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Search Section -->
    <section class="py-8 bg-gray-300">
        <div class="container mx-auto px-6">
            <div class="max-w-md mx-auto">
                <div class="relative">
                    <input type="text" id="search" placeholder="Cari foto..." class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-600 search-input">
                    <button class="absolute right-3 top-2">
                        <i class="fas fa-search text-gray-400"></i>
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Gallery Section -->
    <section id="gallery" class="py-16">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-bold text-center mb-8">Galeri Foto Kami</h2>

            <!-- Gallery Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="gallery-grid">
                <?php
                $query = mysqli_query($conn, "SELECT * FROM galeri ORDER BY created_at DESC");
                if (mysqli_num_rows($query) > 0) {
                    while ($data = mysqli_fetch_array($query)) {
                        echo "<div class='gallery-item bg-white rounded-lg shadow-md overflow-hidden' data-category='photo' data-id='" . $data['id'] . "'>";
                        echo "<a href='uploads/galeri/" . $data['foto'] . "' data-lightbox='gallery' data-title='" . $data['judul'] . "'>";
                        echo "<img src='uploads/galeri/" . $data['foto'] . "' alt='" . $data['judul'] . "' class='w-full h-64 object-cover'>";
                        echo "</a>";
                        echo "<div class='p-4'>";
                        echo "<h3 class='text-lg font-semibold mb-2'>" . $data['judul'] . "</h3>";
                        echo "<p class='text-sm text-gray-600 mb-2'>" . $data['deskripsi'] . "</p>";
                        echo "<div class='flex justify-between items-center'>";
                        echo "<span class='text-sm text-gray-500'>" . date('d/m/Y', strtotime($data['created_at'])) . "</span>";
                        echo "<button onclick=\"downloadImage('uploads/galeri/" . $data['foto'] . "', " . $data['id'] . ")\" class='px-3 py-1 bg-indigo-600 text-white rounded-md hover:bg-indigo-700'>";
                        echo "<i class='fas fa-download'></i>";
                        echo "</button>";
                        echo "</div>";
                        echo "</div>";
                        echo "</div>";
                    }
                } else {
                    echo "<div class='col-span-full text-center py-8'>";
                    echo "<p class='text-gray-500 text-lg'>Belum ada foto di galeri.</p>";
                    echo "</div>";
                }
                ?>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="contact" class="bg-gray-800 text-white">
        <div class="container mx-auto px-6 py-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h3 class="text-xl font-bold mb-4">Tentang Kami</h3>
                    <p>QuantumLeap Gallery adalah platform untuk berbagi dan menikmati koleksi foto-foto terbaik.</p>
                </div>
                <div>
                    <h3 class="text-xl font-bold mb-4">Kontak</h3>
                    <p>Hubungi kami melalui WhatsApp untuk informasi lebih lanjut.</p>
                </div>
                <div>
                    <h3 class="text-xl font-bold mb-4">Ikuti Kami</h3>
                    <div class="flex space-x-4">
                        <a href="https://www.instagram.com/quantumleap_23/" class="hover:text-indigo-400"><i class="fab fa-instagram"></i></a>
                        <a href="https://www.tiktok.com/@quantumleap_23" class="hover:text-indigo-400"><i class="fab fa-tiktok"></i></a>
                        <a href="https://fatzdev.wuaze.com" target="_blank" class="hover:text-indigo-400" title="Portfolio"><i class="fas fa-user"></i></a>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-8 text-center">
                <p>&copy; 2024 QuantumLeap Gallery. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Floating Contact Button -->
    <?php include 'kontak.php'; ?>
    <!--  -->

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/lightbox2@2.11.3/dist/js/lightbox.min.js"></script>
    <script src="assets/js/script.js"></script>
    <script src="assets/js/slider.js"></script>
    <script>
        // Slide count for JavaScript
        window.slideCount = <?php echo $slide_count; ?>;
        
        // Download function
        function downloadImage(url, id) {
            const link = document.createElement('a');
            link.href = url;
            link.download = `quantum-leap-${id}.jpg`;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
        
        // Initialize lightbox
        lightbox.option({
            'resizeDuration': 200,
            'wrapAround': true,
            'albumLabel': 'Gambar %1 dari %2'
        });
    </script>
</body>
</html>
