
<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../login.php");
    exit();
}
include '../../koneksi.php';

$message = '';
$error = '';

// Get photo ID
if (!isset($_GET['id'])) {
    header("Location: tambah_foto.php");
    exit();
}

$id = (int)$_GET['id'];
$photo_query = mysqli_query($conn, "SELECT * FROM galeri WHERE id = $id");

if (mysqli_num_rows($photo_query) == 0) {
    header("Location: tambah_foto.php");
    exit();
}

$photo = mysqli_fetch_assoc($photo_query);

// Process form submission
if (isset($_POST['update'])) {
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    
    $update_query = "UPDATE galeri SET judul='$judul', deskripsi='$deskripsi'";
    
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $filename = $_FILES['foto']['name'];
        $file_ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        
        if (in_array($file_ext, $allowed)) {
            $new_filename = time() . '_' . $filename;
            $upload_path = '../../uploads/galeri/' . $new_filename;
            
            if (move_uploaded_file($_FILES['foto']['tmp_name'], $upload_path)) {
                // Delete old image
                $old_image = '../../uploads/galeri/' . $photo['foto'];
                if (file_exists($old_image)) {
                    unlink($old_image);
                }
                $update_query .= ", foto='$new_filename'";
            } else {
                $error = "Gagal mengupload foto!";
            }
        } else {
            $error = "Format file tidak diizinkan! Gunakan JPG, JPEG, PNG, atau GIF.";
        }
    }
    
    $update_query .= " WHERE id = $id";
    
    if (!$error && mysqli_query($conn, $update_query)) {
        $message = "Foto berhasil diupdate!";
        // Refresh data
        $photo_query = mysqli_query($conn, "SELECT * FROM galeri WHERE id = $id");
        $photo = mysqli_fetch_assoc($photo_query);
    } elseif (!$error) {
        $error = "Error: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Foto - QuantumLeap Gallery</title>
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
        .current-photo {
            max-width: 100%;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        @media (min-width: 768px) {
            .sidebar {
                position: relative;
                left: 0;
            }
            .main-content {
                margin-left: 250px;
            }
            .mobile-toggle {
                display: none;
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
                <a class="nav-link active" href="tambah_foto.php">
                    <i class="fas fa-photo-video me-2"></i>
                    Kelola Galeri
                </a>
                <a class="nav-link" href="../kelola_kontak/edit_kontak.php">
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
                <span class="navbar-brand mb-0 h1">Edit Foto</span>
                <div class="d-flex align-items-center">
                    <a href="tambah_foto.php" class="btn btn-outline-secondary me-2">
                        <i class="fas fa-arrow-left me-1"></i>
                        Kembali
                    </a>
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

            <!-- Form Edit Foto -->
            <div class="card">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">
                        <i class="fas fa-edit me-2"></i>
                        Edit Foto: <?php echo $photo['judul']; ?>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <form method="POST" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="judul" class="form-label">Judul Foto</label>
                                        <input type="text" class="form-control" id="judul" name="judul" 
                                               value="<?php echo $photo['judul']; ?>" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="kategori" class="form-label">Kategori</label>
                                        <select class="form-select" id="kategori" name="kategori" required>
                                            <option value="event" <?php echo $photo['kategori'] == 'event' ? 'selected' : ''; ?>>Event</option>
                                            <option value="portrait" <?php echo $photo['kategori'] == 'portrait' ? 'selected' : ''; ?>>Portrait</option>
                                            <option value="landscape" <?php echo $photo['kategori'] == 'landscape' ? 'selected' : ''; ?>>Landscape</option>
                                            <option value="wedding" <?php echo $photo['kategori'] == 'wedding' ? 'selected' : ''; ?>>Wedding</option>
                                            <option value="family" <?php echo $photo['kategori'] == 'family' ? 'selected' : ''; ?>>Family</option>
                                            <option value="corporate" <?php echo $photo['kategori'] == 'corporate' ? 'selected' : ''; ?>>Corporate</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="deskripsi" class="form-label">Deskripsi</label>
                                    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required><?php echo $photo['deskripsi']; ?></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="foto" class="form-label">Foto Baru (Opsional)</label>
                                    <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
                                    <div class="form-text">Kosongkan jika tidak ingin mengubah foto. Format: JPG, JPEG, PNG, GIF</div>
                                </div>
                                <button type="submit" name="update" class="btn btn-gradient">
                                    <i class="fas fa-save me-2"></i>
                                    Update Foto
                                </button>
                            </form>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center">
                                <h6>Foto Saat Ini:</h6>
                                <img src="../../uploads/galeri/<?php echo $photo['foto']; ?>" 
                                     alt="<?php echo $photo['judul']; ?>" class="img-fluid current-photo">
                                <div class="mt-3">
                                    <small class="text-muted d-block">File: <?php echo $photo['foto']; ?></small>
                                    <small class="text-muted d-block">Upload: <?php echo date('d/m/Y', strtotime($photo['created_at'])); ?></small>
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
        });
    </script>
</body>
</html>
