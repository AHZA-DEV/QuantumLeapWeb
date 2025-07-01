
<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../login.php");
    exit();
}
include '../../koneksi.php';

$message = '';
$error = '';

// Process form submission
if (isset($_POST['tambah'])) {
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $filename = $_FILES['gambar']['name'];
        $file_ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        
        if (in_array($file_ext, $allowed)) {
            $new_filename = time() . '_' . $filename;
            $upload_path = '../../uploads/slider/' . $new_filename;
            
            if (move_uploaded_file($_FILES['gambar']['tmp_name'], $upload_path)) {
                $query = "INSERT INTO slider (judul, deskripsi, gambar, status) VALUES ('$judul', '$deskripsi', '$new_filename', '$status')";
                if (mysqli_query($conn, $query)) {
                    $message = "Slider berhasil ditambahkan!";
                } else {
                    $error = "Error: " . mysqli_error($conn);
                }
            } else {
                $error = "Gagal mengupload gambar!";
            }
        } else {
            $error = "Format file tidak diizinkan! Gunakan JPG, JPEG, PNG, atau GIF.";
        }
    } else {
        $error = "Silakan pilih gambar!";
    }
}

// Process delete
if (isset($_GET['hapus'])) {
    $id = (int)$_GET['hapus'];
    $query = "SELECT gambar FROM slider WHERE id = $id";
    $result = mysqli_query($conn, $query);
    if ($slider = mysqli_fetch_assoc($result)) {
        $file_path = '../../uploads/slider/' . $slider['gambar'];
        if (file_exists($file_path)) {
            unlink($file_path);
        }
        $delete_query = "DELETE FROM slider WHERE id = $id";
        if (mysqli_query($conn, $delete_query)) {
            $message = "Slider berhasil dihapus!";
        } else {
            $error = "Gagal menghapus slider!";
        }
    }
}

// Get all sliders
$sliders = mysqli_query($conn, "SELECT * FROM slider ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Slider - QuantumLeap Gallery</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
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
        .navbar-brand {
            font-weight: bold;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
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
        .slider-image {
            width: 100px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
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
                <span class="navbar-brand mb-0 h1">Kelola Slider</span>
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

            <!-- Form Tambah Slider -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-plus me-2"></i>
                        Tambah Slider Baru
                    </h5>
                </div>
                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="judul" class="form-label">Judul</label>
                                <input type="text" class="form-control" id="judul" name="judul" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" id="status" name="status" required>
                                    <option value="aktif">Aktif</option>
                                    <option value="nonaktif">Non Aktif</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="gambar" class="form-label">Gambar Slider</label>
                            <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*" required>
                            <div class="form-text">Format yang diizinkan: JPG, JPEG, PNG, GIF</div>
                        </div>
                        <button type="submit" name="tambah" class="btn btn-gradient">
                            <i class="fas fa-save me-2"></i>
                            Tambah Slider
                        </button>
                    </form>
                </div>
            </div>

            <!-- Daftar Slider -->
            <div class="card">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-list me-2"></i>
                        Daftar Slider
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Gambar</th>
                                    <th>Judul</th>
                                    <th>Deskripsi</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $no = 1;
                                while ($slider = mysqli_fetch_assoc($sliders)): 
                                ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td>
                                        <img src="../../uploads/slider/<?php echo $slider['gambar']; ?>" 
                                             alt="<?php echo $slider['judul']; ?>" class="slider-image">
                                    </td>
                                    <td><?php echo $slider['judul']; ?></td>
                                    <td><?php echo substr($slider['deskripsi'], 0, 50) . '...'; ?></td>
                                    <td>
                                        <span class="badge <?php echo $slider['status'] == 'aktif' ? 'bg-success' : 'bg-secondary'; ?>">
                                            <?php echo ucfirst($slider['status']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="edit_slider.php?id=<?php echo $slider['id']; ?>" 
                                               class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="?hapus=<?php echo $slider['id']; ?>" 
                                               class="btn btn-sm btn-danger"
                                               onclick="return confirm('Yakin ingin menghapus slider ini?')">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
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
            const mainContent = document.getElementById('mainContent');
            const overlay = document.getElementById('overlay');

            sidebarToggle.addEventListener('click', function() {
                sidebar.classList.toggle('show');
                overlay.classList.toggle('show');
            });

            overlay.addEventListener('click', function() {
                sidebar.classList.remove('show');
                overlay.classList.remove('show');
            });

            // Auto close sidebar on window resize
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
