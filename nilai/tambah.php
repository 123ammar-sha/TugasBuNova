<?php
include '../koneksi.php';

// Jika form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nim = mysqli_real_escape_string($koneksi, $_POST['nim']);
    $id_matkul = (int)$_POST['id_matkul'];
    $nilai_tugas = (float)$_POST['nilai_tugas'];
    $nilai_uts = (float)$_POST['nilai_uts'];
    $nilai_uas = (float)$_POST['nilai_uas'];
    
    // Validasi input
    if (empty($nim) || empty($id_matkul) || $nilai_tugas == '' || $nilai_uts == '' || $nilai_uas == '') {
        $error = "✗ Semua field harus diisi!";
    } elseif ($nilai_tugas < 0 || $nilai_tugas > 100 || $nilai_uts < 0 || $nilai_uts > 100 || $nilai_uas < 0 || $nilai_uas > 100) {
        $error = "✗ Nilai harus antara 0-100!";
    } else {
        // Cek apakah mahasiswa ada
        $check_mhs = "SELECT nim FROM mahasiswa WHERE nim = '$nim'";
        $result_mhs = mysqli_query($koneksi, $check_mhs);
        
        if (mysqli_num_rows($result_mhs) == 0) {
            $error = "✗ Mahasiswa dengan NIM tersebut tidak ditemukan!";
        } else {
            // Cek apakah nilai sudah ada
            $check_nilai = "SELECT id_nilai FROM nilai WHERE nim = '$nim' AND id_matkul = $id_matkul";
            $result_nilai = mysqli_query($koneksi, $check_nilai);
            
            if (mysqli_num_rows($result_nilai) > 0) {
                $error = "✗ Nilai untuk mahasiswa dan mata kuliah ini sudah ada. Silakan gunakan edit jika ingin mengubah.";
            } else {
                // Insert nilai
                $query = "INSERT INTO nilai (nim, id_matkul, nilai_tugas, nilai_uts, nilai_uas) 
                         VALUES ('$nim', $id_matkul, $nilai_tugas, $nilai_uts, $nilai_uas)";
                
                if (mysqli_query($koneksi, $query)) {
                    $success = "✓ Nilai berhasil ditambahkan";
                } else {
                    $error = "✗ Error: " . mysqli_error($koneksi);
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Nilai</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .form-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 30px;
            max-width: 600px;
            margin: 20px auto;
        }

        .form-card h3 {
            color: #333;
            margin-bottom: 25px;
            font-size: 20px;
        }

        .form-card .form-group {
            margin-bottom: 20px;
        }

        .form-card label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: 500;
            font-size: 14px;
        }

        .form-card input,
        .form-card select {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            transition: border-color 0.3s;
        }

        .form-card input:focus,
        .form-card select:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 15px;
        }

        .form-row .form-group {
            margin-bottom: 0;
        }

        .button-group {
            display: flex;
            gap: 10px;
            margin-top: 30px;
        }

        .button-group .btn {
            flex: 1;
            padding: 12px 20px;
            font-size: 14px;
            font-weight: 500;
        }

        .btn-back {
            background: #95a5a6;
            color: white;
            text-decoration: none;
            padding: 12px 20px;
            border-radius: 8px;
            transition: background 0.3s;
            text-align: center;
            font-weight: 500;
        }

        .btn-back:hover {
            background: #7f8c8d;
        }

        @media (max-width: 768px) {
            .form-card {
                padding: 20px;
                margin: 15px 10px;
            }

            .form-row {
                grid-template-columns: 1fr;
            }
        }

        .input-hint {
            font-size: 12px;
            color: #999;
            margin-top: 4px;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>Tambah Nilai Mahasiswa</h1>
        </header>
        
        <nav>
            <ul>
                <li><a href="../index.php">Beranda</a></li>
                <li><a href="../mahasiswa/index.php">Data Mahasiswa</a></li>
                <li><a href="../matakuliah/index.php">Data Mata Kuliah</a></li>
                <li><a href="index.php">Data Nilai</a></li>
            </ul>
        </nav>
        
        <main>
            <div class="form-card">
                <h3>➕ Masukkan Nilai Baru</h3>
                
                <?php
                if (isset($success)) {
                    echo "<div class='alert alert-success'>" . htmlspecialchars($success) . "</div>";
                }
                if (isset($error)) {
                    echo "<div class='alert alert-error'>" . htmlspecialchars($error) . "</div>";
                }
                ?>
                
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="nim">NIM Mahasiswa <span style="color: #e74c3c;">*</span></label>
                        <select id="nim" name="nim" required>
                            <option value="">-- Pilih Mahasiswa --</option>
                            <?php
                            $query_mhs = "SELECT nim, nama FROM mahasiswa ORDER BY nama";
                            $result_mhs = mysqli_query($koneksi, $query_mhs);
                            while ($mhs = mysqli_fetch_assoc($result_mhs)) {
                                echo "<option value='" . htmlspecialchars($mhs['nim']) . "'>" . 
                                     htmlspecialchars($mhs['nama']) . " (" . htmlspecialchars($mhs['nim']) . ")</option>";
                            }
                            ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="id_matkul">Mata Kuliah <span style="color: #e74c3c;">*</span></label>
                        <select id="id_matkul" name="id_matkul" required>
                            <option value="">-- Pilih Mata Kuliah --</option>
                            <?php
                            $query_mk = "SELECT id_matkul, nama_matkul FROM matakuliah ORDER BY nama_matkul";
                            $result_mk = mysqli_query($koneksi, $query_mk);
                            while ($mk = mysqli_fetch_assoc($result_mk)) {
                                echo "<option value='" . $mk['id_matkul'] . "'>" . 
                                     htmlspecialchars($mk['nama_matkul']) . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>Nilai <span style="color: #e74c3c;">*</span></label>
                        <p class="input-hint">Masukkan nilai antara 0-100</p>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="nilai_tugas" style="margin-bottom: 5px; display: block;">Tugas</label>
                                <input type="number" id="nilai_tugas" name="nilai_tugas" min="0" max="100" step="0.1" placeholder="0-100" required>
                            </div>
                            <div class="form-group">
                                <label for="nilai_uts" style="margin-bottom: 5px; display: block;">UTS</label>
                                <input type="number" id="nilai_uts" name="nilai_uts" min="0" max="100" step="0.1" placeholder="0-100" required>
                            </div>
                            <div class="form-group">
                                <label for="nilai_uas" style="margin-bottom: 5px; display: block;">UAS</label>
                                <input type="number" id="nilai_uas" name="nilai_uas" min="0" max="100" step="0.1" placeholder="0-100" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="button-group">
                        <button type="submit" class="btn btn-success">✓ Simpan Nilai</button>
                        <a href="index.php" class="btn-back">← Batal</a>
                    </div>
                </form>
            </div>
        </main>
        
        <footer>
            <p>&copy; 2025 Aplikasi Pengelolaan Nilai Mahasiswa</p>
        </footer>
    </div>
</body>
</html>
