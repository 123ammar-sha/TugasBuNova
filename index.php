<?php
include 'koneksi.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Pengelolaan Nilai Mahasiswa</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Aplikasi Pengelolaan Nilai Mahasiswa</h1>
        </header>
        
        <nav>
            <ul>
                <li><a href="index.php">Beranda</a></li>
                <li><a href="mahasiswa/index.php">Data Mahasiswa</a></li>
                <li><a href="matakuliah/index.php">Data Mata Kuliah</a></li>
                <li><a href="nilai/index.php">Data Nilai</a></li>
            </ul>
        </nav>
        
        <main>
            <h2>Selamat Datang</h2>
            <p>Aplikasi ini digunakan untuk mengelola data mahasiswa, mata kuliah, dan nilai akademik.</p>
            
            <div class="dashboard-cards">
                <div class="card">
                    <h3>Total Mahasiswa</h3>
                    <?php
                    $query = "SELECT COUNT(*) as total FROM mahasiswa";
                    $result = mysqli_query($koneksi, $query);
                    $row = mysqli_fetch_assoc($result);
                    echo "<p>" . $row['total'] . " Mahasiswa</p>";
                    ?>
                </div>
                
                <div class="card">
                    <h3>Total Mata Kuliah</h3>
                    <?php
                    $query = "SELECT COUNT(*) as total FROM matakuliah";
                    $result = mysqli_query($koneksi, $query);
                    $row = mysqli_fetch_assoc($result);
                    echo "<p>" . $row['total'] . " Mata Kuliah</p>";
                    ?>
                </div>
                
                <div class="card">
                    <h3>Total Nilai</h3>
                    <?php
                    $query = "SELECT COUNT(*) as total FROM nilai";
                    $result = mysqli_query($koneksi, $query);
                    $row = mysqli_fetch_assoc($result);
                    echo "<p>" . $row['total'] . " Nilai</p>";
                    ?>
                </div>
            </div>
        </main>
        
        <footer>
            <p>&copy; 2025 Aplikasi Pengelolaan Nilai Mahasiswa</p>
        </footer>
    </div>
</body>
</html>