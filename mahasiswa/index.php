<?php
include '../koneksi.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mahasiswa</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Data Mahasiswa</h1>
        </header>
        
        <nav>
            <ul>
                <li><a href="../index.php">Beranda</a></li>
                <li><a href="index.php" class="active">Data Mahasiswa</a></li>
                <li><a href="../matakuliah/index.php">Data Mata Kuliah</a></li>
                <li><a href="../nilai/index.php">Data Nilai</a></li>
            </ul>
        </nav>
        
        <main>        
            <?php
            if (isset($_GET['pesan'])) {
                $pesan = $_GET['pesan'];
                $message = isset($_GET['message']) ? $_GET['message'] : '';
                
                if ($pesan == 'sukses') {
                    echo "<div class='alert alert-success'>$message</div>";
                } elseif ($pesan == 'error') {
                    echo "<div class='alert alert-error'>$message</div>";
                }
            }
            ?>
            <div class="action-bar">
                <h2>Daftar Mahasiswa</h2>
                <div class="action-bar-buttons">
                    <a href="tambah.php" class="btn btn-success">+ Tambah Mahasiswa</a>
                </div>
            </div>
            
            <table>
                <thead>
                    <tr>
                        <th>NIM</th>
                        <th>Nama</th>
                        <th>Program Studi</th>
                        <th>Semester</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT * FROM mahasiswa ORDER BY nim";
                    $result = mysqli_query($koneksi, $query);
                    
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . $row['nim'] . "</td>";
                            echo "<td>" . $row['nama'] . "</td>";
                            echo "<td>" . $row['prodi'] . "</td>";
                            echo "<td>" . $row['semester'] . "</td>";
                            echo "<td class='action-cell'>";
                            echo "<div class='btn-group'>";
                            echo "<a href='edit.php?nim=" . $row['nim'] . "' class='btn btn-info'>✎ Edit</a>";
                            echo "<a href='hapus.php?nim=" . $row['nim'] . "' class='btn btn-danger' onclick='return confirm(\"Apakah Anda yakin ingin menghapus data ini?\")'>🗑 Hapus</a>";
                            echo "</div>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>Tidak ada data mahasiswa</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </main>
        <script>            
            document.addEventListener('DOMContentLoaded', function() {
                var alerts = document.querySelectorAll('.alert');
                alerts.forEach(function(alert) {
                    setTimeout(function() {
                        alert.style.transition = 'opacity 0.5s';
                        alert.style.opacity = '0';
                        setTimeout(function() {
                            alert.remove();
                        }, 500);
                    }, 5000);
                });
            });
        </script>
        <footer>
            <p>&copy; 2025 Aplikasi Pengelolaan Nilai Mahasiswa</p>
        </footer>
    </div>
</body>
</html>