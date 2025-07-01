
<?php
// Proses pengiriman pesan WA
if ($_POST) {
    $nama = $_POST['nama'];
    $pesan = $_POST['pesan'];
    
    // Nomor WhatsApp tujuan (bisa diambil dari database)
    // $nomor_wa = "6281234567890"; // Ganti dengan nomor yang sesuai
    
    $text = "Nama: " . $nama . "\nPesan: " . $pesan;
    $url = "https://wa.me/" . $nomor_wa . "?text=" . urlencode($text);
    
    header("Location: " . $url);
    exit();
}
?>
