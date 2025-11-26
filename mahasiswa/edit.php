<?php
include '../koneksi.php';

$nim = $_GET['nim'];
$query = "SELECT * FROM mahasiswa WHERE nim = '$nim'";
$result = mysqli_query($koneksi, $query);
$mahasiswa = mysqli_fetch_assoc($result);

if (!$mahasiswa) {
    header("Location: index.php?pesan=error&message=Data mahasiswa tidak ditemukan");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $prodi = $_POST['prodi'];
    $semester = $_POST['semester'];
    
    $query = "UPDATE mahasiswa SET nama = '$nama', prodi = '$prodi', semester = '$semester' WHERE nim = '$nim'";
    
    if (mysqli_query($koneksi, $query)) {
        header("Location: index.php?pesan=sukses&message=Data mahasiswa berhasil diupdate");
        exit();
    } else {
        header("Location: index.php?pesan=error&message=Terjadi kesalahan: " . urlencode(mysqli_error($koneksi)));
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Mahasiswa</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Edit Mahasiswa</h1>
        </header>
        
        <nav>
            <ul>
                <li><a href="../index.php">Beranda</a></li>
                <li><a href="index.php">Data Mahasiswa</a></li>
                <li><a href="../matakuliah/index.php">Data Mata Kuliah</a></li>
                <li><a href="../nilai/index.php">Data Nilai</a></li>
            </ul>
        </nav>
        
        <main>
            <h2>Form Edit Mahasiswa</h2>
            
            <?php
            if (isset($error)) {
                echo "<div style='color: red; margin-bottom: 15px;'>$error</div>";
            }
            ?>
            
            <form method="POST" action="">
                <div class="form-group">
                    <label for="nim">NIM</label>
                    <input type="text" id="nim" name="nim" value="<?php echo $mahasiswa['nim']; ?>" readonly style="background-color: #f0f0f0;">
                </div>
                
                <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" id="nama" name="nama" value="<?php echo $mahasiswa['nama']; ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="prodi">Program Studi</label>
                    <input type="text" id="prodi" name="prodi" value="<?php echo $mahasiswa['prodi']; ?>">
                </div>
                
                <div class="form-group">
                    <label for="semester">Semester</label>
                    <input type="number" id="semester" name="semester" value="<?php echo $mahasiswa['semester']; ?>" min="1" max="14">
                </div>
                
                <div class="form-group">
                    <button type="submit" class="btn btn-success">Update</button>
                    <a href="index.php" class="btn">Batal</a>
                </div>
            </form>
        </main>
        
        <footer>
            <p>&copy; 2025 Aplikasi Pengelolaan Nilai Mahasiswa</p>
        </footer>
    </div>
</body>
</html>