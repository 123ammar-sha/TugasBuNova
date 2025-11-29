<?php
include '../koneksi.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Nilai Mahasiswa</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Data Nilai Mahasiswa</h1>
        </header>

        <nav>
            <ul>
                <li><a href="../index.php">Beranda</a></li>
                <li><a href="../mahasiswa/index.php">Data Mahasiswa</a></li>
                <li><a href="../matakuliah/index.php">Data Mata Kuliah</a></li>
                <li><a href="index.php" class="active">Data Nilai</a></li>
            </ul>
        </nav>

        <main>
            <div class="nilai-container">
                <div>
                    <h2>Daftar Nilai Mahasiswa</h2>
                    <p class="text-muted">Per Mata Kuliah</p>
                </div>
                <a href="tambah.php" class="btn btn-success">+ Tambah Nilai</a>
            </div>

            <?php
            // Query untuk mengambil semua mata kuliah
            $query_matkul = "SELECT DISTINCT mk.id_matkul, mk.nama_matkul
                            FROM matakuliah mk
                            LEFT JOIN nilai n ON mk.id_matkul = n.id_matkul
                            ORDER BY mk.nama_matkul";

            $result_matkul = mysqli_query($koneksi, $query_matkul);

            if (mysqli_num_rows($result_matkul) > 0) {
                while ($matkul = mysqli_fetch_assoc($result_matkul)) {
                    $id_matkul = $matkul['id_matkul'];
                    $nama_matkul = $matkul['nama_matkul'];

                    // Query untuk mengambil semua nilai per mata kuliah
                    $query_nilai = "SELECT n.*, m.nim, m.nama
                                   FROM nilai n
                                   JOIN mahasiswa m ON n.nim = m.nim
                                   WHERE n.id_matkul = $id_matkul
                                   ORDER BY m.nama";

                    $result_nilai = mysqli_query($koneksi, $query_nilai);
                    $jumlah_mahasiswa = mysqli_num_rows($result_nilai);

                    echo "<div class='matakuliah-section'>";
                    echo "<div class='matakuliah-header'>";
                    echo "<h3>" . htmlspecialchars($nama_matkul) . "</h3>";
                    echo "<span class='matakuliah-count'>" . $jumlah_mahasiswa . " Mahasiswa</span>";
                    echo "</div>";

                    if ($jumlah_mahasiswa > 0) {
                        echo "<div class='table-wrapper'>";
                        echo "<table class='nilai-table'>";
                        echo "<thead>";
                        echo "<tr>";
                        echo "<th>No</th>";
                        echo "<th>NIM</th>";
                        echo "<th>Nama Mahasiswa</th>";
                        echo "<th>Tugas</th>";
                        echo "<th>UTS</th>";
                        echo "<th>UAS</th>";
                        echo "<th>Nilai Akhir</th>";
                        echo "<th class='text-center'>Aksi</th>";
                        echo "</tr>";
                        echo "</thead>";
                        echo "<tbody>";

                        $no = 1;
                        while ($nilai = mysqli_fetch_assoc($result_nilai)) {
                            // Hitung nilai akhir: Tugas 40% + UTS 30% + UAS 30%
                            $nilai_akhir = ($nilai['nilai_tugas'] * 0.4) +
                                          ($nilai['nilai_uts'] * 0.3) +
                                          ($nilai['nilai_uas'] * 0.3);
                            $nilai_akhir = round($nilai_akhir, 2);

                            // Tentukan kelas CSS berdasarkan nilai
                            $class_nilai = '';
                            if ($nilai_akhir >= 80) {
                                $class_nilai = 'nilai-tinggi';
                            } elseif ($nilai_akhir >= 60) {
                                $class_nilai = 'nilai-sedang';
                            } else {
                                $class_nilai = 'nilai-rendah';
                            }

                            echo "<tr>";
                            echo "<td>" . $no . "</td>";
                            echo "<td>" . htmlspecialchars($nilai['nim']) . "</td>";
                            echo "<td>" . htmlspecialchars($nilai['nama']) . "</td>";
                            echo "<td>" . htmlspecialchars($nilai['nilai_tugas']) . "</td>";
                            echo "<td>" . htmlspecialchars($nilai['nilai_uts']) . "</td>";
                            echo "<td>" . htmlspecialchars($nilai['nilai_uas']) . "</td>";
                            echo "<td class='nilai-akhir " . $class_nilai . "'>" . $nilai_akhir . "</td>";
                            echo "<td class='action-cell'>";
                            echo "<div class='btn-group-small'>";
                            echo "<a href='edit.php?id=" . $nilai['id_nilai'] . "' class='btn btn-sm btn-info'>Edit</a>";
                            echo "<a href='hapus.php?id=" . $nilai['id_nilai'] . "' class='btn btn-sm btn-danger' onclick='return confirm(\"Apakah Anda yakin ingin menghapus nilai ini?\");'>Hapus</a>";
                            echo "</div>";
                            echo "</td>";
                            echo "</tr>";

                            $no++;
                        }

                        echo "</tbody>";
                        echo "</table>";
                        echo "</div>";
                    } else {
                        echo "<div class='no-data'>Belum ada nilai untuk mata kuliah ini</div>";
                    }

                    echo "</div>";
                }
            } else {
                echo "<div class='matakuliah-section'>";
                echo "<div class='no-data'>Belum ada mata kuliah. Silakan buat mata kuliah terlebih dahulu.</div>";
                echo "</div>";
            }
            ?>
        </main>

        <footer>
            <p>&copy; 2025 Aplikasi Pengelolaan Nilai Mahasiswa</p>
        </footer>
    </div>
</body>
</html>
