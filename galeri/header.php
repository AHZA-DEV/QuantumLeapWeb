
<?php
// Ambil data slider dari database
$slider_query = mysqli_query($conn, "SELECT * FROM slider WHERE status='aktif' ORDER BY id ASC");
?>
<header>
    <nav class="navbar">
        <div class="nav-container">
            <img src="assets/images/logo.png" alt="QuantumLeap Gallery" class="logo">
            <ul class="nav-menu">
                <li><a href="#beranda">Beranda</a></li>
                <li><a href="#galeri">Galeri</a></li>
                <li><a href="#kontak">Kontak</a></li>
            </ul>
        </div>
    </nav>
    
    <div class="slider-container" id="beranda">
        <div class="slider-wrapper">
            <?php
            $slides = [];
            if (mysqli_num_rows($slider_query) > 0) {
                $first = true;
                while ($slider = mysqli_fetch_array($slider_query)) {
                    $slides[] = $slider;
                    $active_class = $first ? 'active' : '';
                    echo "<div class='slide $active_class'>";
                    echo "<img src='uploads/slider/" . $slider['gambar'] . "' alt='" . $slider['judul'] . "'>";
                    echo "<div class='slide-content'>";
                    echo "<h2>" . $slider['judul'] . "</h2>";
                    echo "<p>" . $slider['deskripsi'] . "</p>";
                    echo "</div>";
                    echo "</div>";
                    $first = false;
                }
            } else {
                echo "<div class='slide active'>";
                echo "<div class='slide-content'>";
                echo "<h2>Selamat Datang di QuantumLeap Gallery</h2>";
                echo "<p>Galeri foto profesional untuk semua kebutuhan Anda</p>";
                echo "</div>";
                echo "</div>";
            }
            ?>
        </div>
        
        <?php if (count($slides) > 1): ?>
        <div class="slider-dots">
            <?php for ($i = 0; $i < count($slides); $i++): ?>
                <span class="dot <?php echo $i === 0 ? 'active' : ''; ?>" data-slide="<?php echo $i; ?>"></span>
            <?php endfor; ?>
        </div>
        <?php endif; ?>
    </div>
</header>

<script>
// Pass slide count to JavaScript
window.slideCount = <?php echo count($slides); ?>;
</script>
