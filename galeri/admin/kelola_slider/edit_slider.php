
<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../login.php");
    exit();
}
include '../../koneksi.php';

$message = '';
$error = '';

// Get slider ID
if (!isset($_GET['id'])) {
    header("Location: tambah_slider.php");
    exit();
}

$id = (int)$_GET['id'];
$slider_query = mysqli_query($conn, "SELECT * FROM slider WHERE id = $id");

if (mysqli_num_rows($slider_query) == 0) {
    header("Location: tambah_slider.php");
    exit();
}

$slider = mysqli_fetch_assoc($slider_query);

// Process form submission
if (isset($_POST['update'])) {
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    
    $update_query = "UPDATE slider SET judul='$judul', deskripsi='$deskripsi', status='$status'";
    
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $filename = $_FILES['gambar']['name'];
        $file_ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        
        if (in_array($file_ext, $allowed)) {
            $new_filename = time() . '_' . $filename;
            $upload_path = '../../uploads/slider/' . $new_filename;
            
            if (move_uploaded_file($_FILES['gambar']['tmp_name'], $upload_path)) {
                // Delete old image
                $old_image = '../../uploads/slider/' . $slider['gambar'];
                if (file_exists($old_image)) {
                    unlink($old_image);
                }
                $update_query .= ", gambar='$new_filename'";
            } else {
                $error = "Gagal mengupload gambar!";
            }
        } else {
            $error = "Format file tidak diizinkan! Gunakan JPG, JPEG, PNG, atau GIF.";
        }
    }
    
    $update_query .= " WHERE id = $id";
    
    if (!$error && mysqli_query($conn, $update_query)) {
        $message = "Slider berhasil diupdate!";
        // Refresh data
        $slider_query = mysqli_query($conn, "SELECT * FROM slider WHERE id = $id");
        $slider = mysqli_fetch_assoc($slider_query);
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
    <title>Edit Slider - QuantumLeap Gallery</title>
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
        .current-image {
            max-width: 300px;
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
                <a class="nav-link active" href="tambah_slider.php">
                    <i class="fas fa-images me-2"></i>
                    Kelola Slider
                </a>
                <a class="nav-link" href="../kelola_galeri/tambah_foto.php">
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
                <span class="navbar-brand mb-0 h1">Edit Slider</span>
                <div class="d-flex align-items-center">
                    <a href="tambah_slider.php" class="btn btn-outline-secondary me-2">
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

            <!-- Form Edit Slider -->
            <div class="card">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">
                        <i class="fas fa-edit me-2"></i>
                        Edit Slider: <?php echo $slider['judul']; ?>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <form method="POST" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="judul" class="form-label">Judul</label>
                                        <input type="text" class="form-control" id="judul" name="judul" 
                                               value="<?php echo $slider['judul']; ?>" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="status" class="form-label">Status</label>
                                        <select class="form-select" id="status" name="status" required>
                                            <option value="aktif" <?php echo $slider['status'] == 'aktif' ? 'selected' : ''; ?>>Aktif</option>
                                            <option value="nonaktif" <?php echo $slider['status'] == 'nonaktif' ? 'selected' : ''; ?>>Non Aktif</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="deskripsi" class="form-label">Deskripsi</label>
                                    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required><?php echo $slider['deskripsi']; ?></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="gambar" class="form-label">Gambar Slider Baru (Opsional)</label>
                                    <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*">
                                    <div class="form-text">Kosongkan jika tidak ingin mengubah gambar. Format: JPG, JPEG, PNG, GIF</div>
                                </div>
                                <button type="submit" name="update" class="btn btn-gradient">
                                    <i class="fas fa-save me-2"></i>
                                    Update Slider
                                </button>
                            </form>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center">
                                <h6>Gambar Saat Ini:</h6>
                                <img src="../../uploads/slider/<?php echo $slider['gambar']; ?>" 
                                     alt="<?php echo $slider['judul']; ?>" class="img-fluid current-image">
                                <div class="mt-2">
                                    <small class="text-muted">File: <?php echo $slider['gambar']; ?></small>
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
