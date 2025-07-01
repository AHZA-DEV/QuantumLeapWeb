
<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}
include '../koneksi.php';

// Get statistics
$slider_count = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM slider"));
$galeri_count = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM galeri"));
$kontak_query = mysqli_query($conn, "SELECT * FROM kontak LIMIT 1");
$kontak_data = mysqli_fetch_assoc($kontak_query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - QuantumLeap Gallery</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .sidebar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        .sidebar .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 0.75rem 1rem;
            margin: 0.25rem 0;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
        }
        .sidebar .nav-link:hover {
            color: white;
            background-color: rgba(255,255,255,0.1);
            transform: translateX(5px);
        }
        .sidebar .nav-link.active {
            color: white;
            background-color: rgba(255,255,255,0.2);
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        }
        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        .stat-card-2 {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
        }
        .stat-card-3 {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
        }
        .stat-card-4 {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
            color: white;
        }
        .welcome-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px;
            padding: 2rem;
            margin-bottom: 2rem;
        }
        .menu-card {
            border: 2px solid transparent;
            transition: all 0.3s ease;
        }
        .menu-card:hover {
            border-color: #667eea;
            transform: scale(1.02);
        }
        .btn-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
            transition: all 0.3s ease;
        }
        .btn-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(102, 126, 234, 0.3);
            color: white;
        }
        .navbar-brand {
            font-weight: bold;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <!-- <div class="col-md-3 col-lg-2 sidebar p-0">
                <div class="d-flex flex-column p-3">
                    <h4 class="text-white mb-4">
                        <i class="fas fa-tachometer-alt me-2"></i>
                        Admin Panel
                    </h4>
                    
                    <nav class="nav flex-column">
                        <a class="nav-link active" href="dashboard.php">
                            <i class="fas fa-home me-2"></i>
                            Dashboard
                        </a>
                        <a class="nav-link" href="kelola_slider/tambah_slider.php">
                            <i class="fas fa-images me-2"></i>
                            Kelola Slider
                        </a>
                        <a class="nav-link" href="kelola_galeri/tambah_foto.php">
                            <i class="fas fa-photo-video me-2"></i>
                            Kelola Galeri
                        </a>
                        <a class="nav-link" href="kelola_kontak/edit_kontak.php">
                            <i class="fas fa-phone me-2"></i>
                            Kelola Kontak
                        </a>
                        <hr class="text-white">
                        <a class="nav-link" href="../index.php" target="_blank">
                            <i class="fas fa-external-link-alt me-2"></i>
                            Lihat Website
                        </a>
                        <a class="nav-link" href="logout.php">
                            <i class="fas fa-sign-out-alt me-2"></i>
                            Logout
                        </a>
                    </nav>
                </div>
            </div> -->

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10">
                <!-- Top Navigation -->
                <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm mb-4">
                    <div class="container-fluid">
                        <span class="navbar-brand mb-0 h1">QuantumLeap Gallery</span>
                        <div class="d-flex align-items-center">
                            <span class="me-3">
                                <i class="fas fa-user-circle me-1"></i>
                                Selamat datang, Admin!
                            </span>
                            <span class="badge bg-primary">
                                <i class="fas fa-clock me-1"></i>
                                <?php echo date('d/m/Y H:i'); ?>
                            </span>
                        </div>
                    </div>
                </nav>

                <div class="container-fluid px-4">
                    <!-- Welcome Section -->
                    <div class="welcome-header text-center">
                        <h1><i class="fas fa-crown me-2"></i>Dashboard Admin</h1>
                        <p class="mb-0">Kelola konten website QuantumLeap Gallery dengan mudah</p>
                    </div>

                    <!-- Statistics Cards -->
                    <div class="row mb-4">
                        <div class="col-md-3 mb-3">
                            <div class="card stat-card">
                                <div class="card-body text-center">
                                    <i class="fas fa-images fa-2x mb-3"></i>
                                    <h3><?php echo $slider_count; ?></h3>
                                    <p class="mb-0">Total Slider</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="card stat-card-2">
                                <div class="card-body text-center">
                                    <i class="fas fa-photo-video fa-2x mb-3"></i>
                                    <h3><?php echo $galeri_count; ?></h3>
                                    <p class="mb-0">Total Galeri</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="card stat-card-3">
                                <div class="card-body text-center">
                                    <i class="fas fa-whatsapp fa-2x mb-3"></i>
                                    <h5 class="small"><?php echo $kontak_data ? substr($kontak_data['nomor_wa'], 0, 8) . '...' : 'Belum ada'; ?></h5>
                                    <p class="mb-0">WhatsApp</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="card stat-card-4">
                                <div class="card-body text-center">
                                    <i class="fas fa-eye fa-2x mb-3"></i>
                                    <h3>∞</h3>
                                    <p class="mb-0">Pengunjung</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <div class="card menu-card h-100">
                                <div class="card-body text-center">
                                    <i class="fas fa-images fa-3x text-primary mb-3"></i>
                                    <h5 class="card-title">Kelola Slider</h5>
                                    <p class="card-text">Tambah, edit, atau hapus gambar slider header website</p>
                                    <a href="kelola_slider/tambah_slider.php" class="btn btn-gradient">
                                        <i class="fas fa-cog me-1"></i>
                                        Kelola Slider
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4 mb-4">
                            <div class="card menu-card h-100">
                                <div class="card-body text-center">
                                    <i class="fas fa-photo-video fa-3x text-success mb-3"></i>
                                    <h5 class="card-title">Kelola Galeri</h5>
                                    <p class="card-text">Upload foto baru atau edit foto yang sudah ada di galeri</p>
                                    <a href="kelola_galeri/tambah_foto.php" class="btn btn-gradient">
                                        <i class="fas fa-plus me-1"></i>
                                        Kelola Galeri
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4 mb-4">
                            <div class="card menu-card h-100">
                                <div class="card-body text-center">
                                    <i class="fas fa-phone fa-3x text-info mb-3"></i>
                                    <h5 class="card-title">Kelola Kontak</h5>
                                    <p class="card-text">Update nomor WhatsApp untuk form kontak pengunjung</p>
                                    <a href="kelola_kontak/edit_kontak.php" class="btn btn-gradient">
                                        <i class="fas fa-edit me-1"></i>
                                        Kelola Kontak
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Activity -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">
                                        <i class="fas fa-chart-line me-2"></i>
                                        Informasi System
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h6><i class="fas fa-server me-2"></i>Status Server</h6>
                                            <span class="badge bg-success">
                                                <i class="fas fa-check-circle me-1"></i>
                                                Online
                                            </span>
                                        </div>
                                        <div class="col-md-6">
                                            <h6><i class="fas fa-database me-2"></i>Database</h6>
                                            <span class="badge bg-success">
                                                <i class="fas fa-check-circle me-1"></i>
                                                Terhubung
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Add some interactive features
        document.addEventListener('DOMContentLoaded', function() {
            // Animate cards on scroll
            const cards = document.querySelectorAll('.card');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            });

            cards.forEach(card => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                observer.observe(card);
            });

            // Update clock every minute
            setInterval(function() {
                const now = new Date();
                const timeString = now.toLocaleDateString('id-ID') + ' ' + 
                                 now.toLocaleTimeString('id-ID', {hour: '2-digit', minute: '2-digit'});
                const clockElement = document.querySelector('.badge .fa-clock').parentElement;
                clockElement.innerHTML = '<i class="fas fa-clock me-1"></i>' + timeString;
            }, 60000);
        });
    </script>
</body>
</html>
