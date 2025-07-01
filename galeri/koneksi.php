
<?php
// File koneksi database MySQL
$hostname = "localhost";
$username = "root";
$password = "";
$database = "db_qgaleri";

$conn = mysqli_connect($hostname, $username, $password, $database);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
