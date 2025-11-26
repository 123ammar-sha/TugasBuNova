<?php
// Konfigurasi database
$host = "127.0.0.1:3307";
$user = "root";
$password = "123";
$database = "db_pendataan_nilai_mahasiswa";

// Membuat koneksi
$koneksi = new mysqli($host, $user, $password, $database);

// Cek koneksi
if (mysqli_connect_error()) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>