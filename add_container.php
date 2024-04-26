<?php
// Proses tambah kontainer
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sisipkan koneksi database di sini
    include 'koneksi.php';

    // Mendapatkan data dari formulir
    $nomor_kontainer = $_POST['nomor_kontainer'];
    $jenis_kontainer = $_POST['jenis_kontainer'];
    $ukuran = $_POST['ukuran'];
    $berat = $_POST['berat'];
    $kapasitas = $_POST['kapasitas'];

    // Validasi input
    if (empty($nomor_kontainer) || empty($jenis_kontainer) || empty($ukuran) || empty($berat) || empty($kapasitas)) {
        echo '<div class="alert alert-danger" role="alert">Mohon lengkapi semua bidang dengan benar.</div>';
    } else {
        // Memasukkan data ke dalam tabel Kontainer
        $sql = "INSERT INTO Kontainer (NomorKontainer, JenisKontainer, Ukuran, Berat, Kapasitas) VALUES (?, ?, ?, ?, ?)";
        if ($stmt = $mysqli->prepare($sql)) {
            // Bind variabel ke pernyataan persiapan sebagai parameter
            $stmt->bind_param("sssis", $nomor_kontainer, $jenis_kontainer, $ukuran, $berat, $kapasitas);

            // Mengeksekusi pernyataan
            if ($stmt->execute()) {
                echo '<div class="alert alert-success" role="alert">Kontainer berhasil ditambahkan!</div>';
                // Redirect ke index.php setelah berhasil menambahkan kontainer
                header("Location: index.php");
                exit();
            } else {
                echo '<div class="alert alert-danger" role="alert">Terjadi kesalahan saat menambahkan kontainer: ' . $stmt->error . '</div>';
            }

            // Menutup pernyataan
            $stmt->close();
        } else {
            echo '<div class="alert alert-danger" role="alert">Terjadi kesalahan saat menyiapkan pernyataan: ' . $mysqli->error . '</div>';
        }
    }

    // Menutup koneksi
    $mysqli->close();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Kontainer Baru</title>
    <!-- Tautan Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Gaya CSS kustom -->
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-top: 50px;
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Tambah Kontainer Baru</h1>
        <!-- Form untuk menambahkan kontainer -->
        <form action="add_container.php" method="POST">
            <div class="form-group">
                <label for="nomor_kontainer">Nomor Kontainer:</label>
                <input type="text" class="form-control" id="nomor_kontainer" name="nomor_kontainer" required>
            </div>
            <div class="form-group">
                <label for="jenis_kontainer">Jenis Kontainer:</label>
                <input type="text" class="form-control" id="jenis_kontainer" name="jenis_kontainer" required>
            </div>
            <div class="form-group">
                <label for="ukuran">Ukuran:</label>
                <input type="text" class="form-control" id="ukuran" name="ukuran" required>
            </div>
            <div class="form-group">
                <label for="berat">Berat (kg):</label>
                <input type="number" class="form-control" id="berat" name="berat" required>
            </div>
            <div class="form-group">
                <label for="kapasitas">Kapasitas:</label>
                <input type="number" class="form-control" id="kapasitas" name="kapasitas" required>
            </div>
            <button type="submit" class="btn btn-primary">Tambah Kontainer</button>
        </form>
        <!-- Tombol Kembali -->
        <a href="index.php" class="btn btn-secondary mt-3">Kembali</a>
    </div>
    <!-- Tautan Bootstrap JS (Opsional) -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>