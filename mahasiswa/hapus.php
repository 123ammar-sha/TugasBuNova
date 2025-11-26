<?php
include '../koneksi.php';

$nim = $_GET['nim'];

// Cek apakah mahasiswa memiliki data nilai
$check_query = "SELECT COUNT(*) as total FROM nilai WHERE nim = '$nim'";
$check_result = mysqli_query($koneksi, $check_query);
$check_row = mysqli_fetch_assoc($check_result);

if ($check_row['total'] > 0) {
    header("Location: index.php?pesan=error&message=Mahasiswa memiliki data nilai, tidak dapat dihapus");
    exit();
}

// Hapus data mahasiswa
$query = "DELETE FROM mahasiswa WHERE nim = '$nim'";

if (mysqli_query($koneksi, $query)) {
    header("Location: index.php?pesan=sukses&message=Data mahasiswa berhasil dihapus");
} else {
    header("Location: index.php?pesan=error&message=Terjadi kesalahan: " . urlencode(mysqli_error($koneksi)));
}

exit();
?>