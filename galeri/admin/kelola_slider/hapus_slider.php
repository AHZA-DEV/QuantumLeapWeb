<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../login.php");
    exit();
}

include '../../koneksi.php';

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    // Get slider data for file deletion
    $slider_query = mysqli_query($conn, "SELECT * FROM slider WHERE id='$id'");
    $slider_data = mysqli_fetch_array($slider_query);

    if ($slider_data) {
        // Delete file from server
        $file_path = "../../uploads/slider/" . $slider_data['gambar'];
        if (file_exists($file_path)) {
            unlink($file_path);
        }

        // Delete from database
        $delete_query = mysqli_query($conn, "DELETE FROM slider WHERE id='$id'");

        if ($delete_query) {
            header("Location: tambah_slider.php?pesan=hapus_berhasil");
        } else {
            header("Location: tambah_slider.php?pesan=hapus_gagal");
        }
    } else {
        header("Location: tambah_slider.php?pesan=data_tidak_ditemukan");
    }
} else {
    header("Location: tambah_slider.php");
}
exit();
?>