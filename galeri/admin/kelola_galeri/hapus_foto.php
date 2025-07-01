<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../login.php");
    exit();
}

include '../../koneksi.php';

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    // Get foto data for file deletion
    $foto_query = mysqli_query($conn, "SELECT * FROM galeri WHERE id='$id'");
    $foto_data = mysqli_fetch_array($foto_query);

    if ($foto_data) {
        // Delete file from server
        $file_path = "../../uploads/galeri/" . $foto_data['foto'];
        if (file_exists($file_path)) {
            unlink($file_path);
        }

        // Delete from database
        $delete_query = mysqli_query($conn, "DELETE FROM galeri WHERE id='$id'");

        if ($delete_query) {
            header("Location: tambah_foto.php?pesan=hapus_berhasil");
        } else {
            header("Location: tambah_foto.php?pesan=hapus_gagal");
        }
    } else {
        header("Location: tambah_foto.php?pesan=data_tidak_ditemukan");
    }
} else {
    header("Location: tambah_foto.php");
}
exit();
?>