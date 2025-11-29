<?php
include '../koneksi.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mata Kuliah</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Data Mata Kuliah</h1>
        </header>
        
        <nav>
            <ul>
                <li><a href="../index.php">Beranda</a></li>
                <li><a href="../mahasiswa/index.php">Data Mahasiswa</a></li>
                <li><a href="index.php" class="active">Data Mata Kuliah</a></li>
                <li><a href="../nilai/index.php">Data Nilai</a></li>
            </ul>
        </nav>
        
        <main>
            <h2>Daftar Mata Kuliah</h2>
            
            <table>
                <thead>
                    <tr>
                        <th style="width: 10%;">ID</th>
                        <th style="width: 70%;">Nama Mata Kuliah</th>
                        <th style="width: 20%; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT * FROM matakuliah ORDER BY id_matkul";
                    $result = mysqli_query($koneksi, $query);
                    
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . $row['id_matkul'] . "</td>";
                            echo "<td>" . htmlspecialchars($row['nama_matkul']) . "</td>";
                            echo "<td class='action-cell'>";
                            echo "<div class='btn-group' style='justify-content: center;'>";
                            echo "<a href='#' class='btn btn-info' onclick='return false;'>✏️ Edit</a>";
                            echo "<a href='index.php?hapus=" . $row['id_matkul'] . "' class='btn btn-danger' onclick='return confirm(\"Apakah Anda yakin ingin menghapus mata kuliah ini?\")'>🗑 Hapus</a>";
                            echo "</div>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3' style='text-align: center; padding: 30px; color: #a0aec0;'><em>Belum ada mata kuliah. Buat yang baru di atas.</em></td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </main>
        
        <footer>
            <p>&copy; 2025 Aplikasi Pengelolaan Nilai Mahasiswa</p>
        </footer>
    </div>
</body>
</html>