<?php
// Konfigurasi database
$host = "127.0.0.1:3307";
$user = "root";
$password = "123";
$database = "db_pendataan_nilai_mahasiswa";

// Membuat koneksi
$koneksi = new mysqli($host, $user, $password, $database);

// Cek koneksi
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}
// echo "Koneksi database berhasil!";
?>