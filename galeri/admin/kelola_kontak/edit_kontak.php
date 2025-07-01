
<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../login.php");
    exit();
}
include '../../koneksi.php';

$message = '';
$error = '';

// Get current contact data
$kontak_query = mysqli_query($conn, "SELECT * FROM kontak LIMIT 1");
$kontak = mysqli_fetch_assoc($kontak_query);

// Process form submission
if (isset($_POST['update'])) {
    $nomor_wa = mysqli_real_escape_string($conn, $_POST['nomor_wa']);
    
    if ($kontak) {
        $query = "UPDATE kontak SET nomor_wa='$nomor_wa' WHERE id=" . $kontak['id'];
    } else {
        $query = "INSERT INTO kontak (nomor_wa) VALUES ('$nomor_wa')";
    }
    
    if (mysqli_query($conn, $query)) {
        $message = "Nomor WhatsApp berhasil diupdate!";
        // Refresh data
        $kontak_query = mysqli_query($conn, "SELECT * FROM kontak LIMIT 1");
        $kontak = mysqli_fetch_assoc($kontak_query);
    } else {
        $error = "Error: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Kontak - QuantumLeap Gallery</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .sidebar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            position: fixed;
            top: 0;
            left: -250px;
            width: 250px;
            transition: left 0.3s ease;
            z-index: 1050;
        }
        .sidebar.show {
            left: 0;
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
        .main-content {
            margin-left: 0;
            transition: margin-left 0.3s ease;
            padding-top: 0;
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07);
        }
        .btn-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
        }
        .btn-gradient:hover {
            background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
            color: white;
        }
        .whatsapp-card {
            background: linear-gradient(135deg, #25d366 0%, #128c7e 100%);
            color: white;
        }
        @media (min-width: 768px) {
            .sidebar {
                position: fixed;
                left: 0;
                top: 0;
                height: 100vh;
                overflow-y: auto;
            }
            .main-content {
                margin-left: 250px;
                min-height: 100vh;
            }
            .mobile-toggle {
                display: none;
            }
        }
        @media (max-width: 767px) {
            .main-content {
                margin-left: 0;
                width: 100%;
            }
        }
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 1040;
            display: none;
        }
        .overlay.show {
            display: block;
        }
    </style>
</head>
<body>
    <!-- Overlay for mobile -->
    <div class="overlay" id="overlay"></div>
    
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="d-flex flex-column p-3">
            <h4 class="text-white mb-4">
                <i class="fas fa-tachometer-alt me-2"></i>
                Admin Panel
            </h4>
            
            <nav class="nav flex-column">
                <a class="nav-link" href="../dashboard.php">
                    <i class="fas fa-home me-2"></i>
                    Dashboard
                </a>
                <a class="nav-link" href="../kelola_slider/tambah_slider.php">
                    <i class="fas fa-images me-2"></i>
                    Kelola Slider
                </a>
                <a class="nav-link" href="../kelola_galeri/tambah_foto.php">
                    <i class="fas fa-photo-video me-2"></i>
                    Kelola Galeri
                </a>
                <a class="nav-link active" href="edit_kontak.php">
                    <i class="fas fa-phone me-2"></i>
                    Kelola Kontak
                </a>
                <hr class="text-white">
                <a class="nav-link" href="../../index.php" target="_blank">
                    <i class="fas fa-external-link-alt me-2"></i>
                    Lihat Website
                </a>
                <a class="nav-link" href="../logout.php">
                    <i class="fas fa-sign-out-alt me-2"></i>
                    Logout
                </a>
            </nav>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <!-- Top Navigation -->
        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm mb-4">
            <div class="container-fluid">
                <button class="btn btn-outline-primary mobile-toggle me-3" id="sidebarToggle">
                    <i class="fas fa-bars"></i>
                </button>
                <span class="navbar-brand mb-0 h1">Kelola Kontak</span>
                <div class="d-flex align-items-center">
                    <span class="me-3 d-none d-md-inline">
                        <i class="fas fa-user-circle me-1"></i>
                        Admin
                    </span>
                    <span class="badge bg-primary">
                        <i class="fas fa-clock me-1"></i>
                        <?php echo date('d/m/Y'); ?>
                    </span>
                </div>
            </div>
        </nav>

        <div class="container-fluid px-4">
            <?php if ($message): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    <?php echo $message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if ($error): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <?php echo $error; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <div class="row">
                <!-- Form Update Kontak -->
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0">
                                <i class="fab fa-whatsapp me-2"></i>
                                Pengaturan Kontak WhatsApp
                            </h5>
                        </div>
                        <div class="card-body">
                            <form method="POST">
                                <div class="mb-3">
                                    <label for="nomor_wa" class="form-label">
                                        <i class="fab fa-whatsapp me-1"></i>
                                        Nomor WhatsApp
                                    </label>
                                    <input type="text" class="form-control" id="nomor_wa" name="nomor_wa" 
                                           value="<?php echo $kontak ? $kontak['nomor_wa'] : ''; ?>" 
                                           placeholder="Contoh: 6281234567890" required>
                                    <div class="form-text">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Format: Kode negara (62 untuk Indonesia) + nomor tanpa awalan 0
                                        <br>
                                        <strong>Contoh:</strong> 081234567890 menjadi 6281234567890
                                    </div>
                                </div>
                                
                                <button type="submit" name="update" class="btn btn-gradient">
                                    <i class="fas fa-save me-2"></i>
                                    Update Nomor WhatsApp
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Info Panel -->
                <div class="col-md-4">
                    <div class="card whatsapp-card">
                        <div class="card-body text-center">
                            <i class="fab fa-whatsapp fa-3x mb-3"></i>
                            <h5>Status WhatsApp</h5>
                            <?php if ($kontak && $kontak['nomor_wa']): ?>
                                <div class="mb-3">
                                    <span class="badge bg-light text-dark">
                                        <i class="fas fa-check-circle me-1"></i>
                                        Terkonfigurasi
                                    </span>
                                </div>
                                <p class="mb-2"><strong>Nomor Aktif:</strong></p>
                                <p class="mb-3"><?php echo $kontak['nomor_wa']; ?></p>
                                <a href="https://wa.me/<?php echo $kontak['nomor_wa']; ?>?text=Test%20pesan%20dari%20admin" 
                                   target="_blank" class="btn btn-light btn-sm">
                                    <i class="fas fa-external-link-alt me-1"></i>
                                    Test WhatsApp
                                </a>
                            <?php else: ?>
                                <div class="mb-3">
                                    <span class="badge bg-warning">
                                        <i class="fas fa-exclamation-triangle me-1"></i>
                                        Belum Dikonfigurasi
                                    </span>
                                </div>
                                <p>Silakan masukkan nomor WhatsApp untuk mengaktifkan fitur kontak.</p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Panduan -->
                    <div class="card mt-4">
                        <div class="card-header bg-warning text-dark">
                            <h6 class="mb-0">
                                <i class="fas fa-question-circle me-2"></i>
                                Panduan
                            </h6>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled mb-0">
                                <li class="mb-2">
                                    <i class="fas fa-check text-success me-2"></i>
                                    Gunakan kode negara (62 untuk Indonesia)
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-check text-success me-2"></i>
                                    Jangan gunakan awalan 0
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-check text-success me-2"></i>
                                    Jangan gunakan tanda + atau spasi
                                </li>
                                <li>
                                    <i class="fas fa-check text-success me-2"></i>
                                    Test nomor setelah disimpan
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');

            sidebarToggle.addEventListener('click', function() {
                sidebar.classList.toggle('show');
                overlay.classList.toggle('show');
            });

            overlay.addEventListener('click', function() {
                sidebar.classList.remove('show');
                overlay.classList.remove('show');
            });

            window.addEventListener('resize', function() {
                if (window.innerWidth >= 768) {
                    sidebar.classList.remove('show');
                    overlay.classList.remove('show');
                }
            });

            // Format nomor WhatsApp input
            const nomorInput = document.getElementById('nomor_wa');
            nomorInput.addEventListener('input', function() {
                let value = this.value.replace(/\D/g, ''); // Remove non-digits
                if (value.startsWith('0')) {
                    value = '62' + value.substring(1); // Replace leading 0 with 62
                }
                this.value = value;
            });
        });
    </script>
</body>
</html>
