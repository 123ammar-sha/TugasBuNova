<?php
include '../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nim = $_POST['nim'];
    $nama = $_POST['nama'];
    $prodi = $_POST['prodi'];
    $semester = $_POST['semester'];
    
    $query = "INSERT INTO mahasiswa (nim, nama, prodi, semester) VALUES ('$nim', '$nama', '$prodi', '$semester')";
    
    if (mysqli_query($koneksi, $query)) {
        header("Location: index.php");        
    } else {
        $error = "Error: " . mysqli_error($koneksi);
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Mahasiswa</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Tambah Mahasiswa</h1>
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
            <h2>Form Tambah Mahasiswa</h2>
            
            <?php
            if (isset($error)) {
                echo "<div style='color: red; margin-bottom: 15px;'>$error</div>";
            }
            ?>
            
            <form method="POST" action="">
                <div class="form-group">
                    <label for="nim">NIM</label>
                    <input type="text" id="nim" name="nim" required>
                </div>
                
                <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" id="nama" name="nama" required>
                </div>
                
                <div class="form-group">
                    <label for="prodi">Program Studi</label>
                    <input type="text" id="prodi" name="prodi">
                </div>
                
                <div class="form-group">
                    <label for="semester">Semester</label>
                    <input type="number" id="semester" name="semester" min="1" max="14">
                </div>
                
                <div class="form-group">
                    <button type="submit" class="btn btn-success">Simpan</button>
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