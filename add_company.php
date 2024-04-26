<?php
// Sisipkan koneksi ke database di sini
include 'koneksi.php';

// Fungsi untuk menambahkan data perusahaan baru
function tambahPerusahaan($namaPerusahaan, $alamat, $kontak)
{
    global $mysqli; // Gunakan koneksi database yang sudah tersedia

    // Persiapkan pernyataan SQL untuk memasukkan data ke tabel Perusahaan
    $sql = "INSERT INTO Perusahaan (NamaPerusahaan, Alamat, Kontak) VALUES (?, ?, ?)";

    // Persiapkan pernyataan SQL
    if ($stmt = $mysqli->prepare($sql)) {
        // Bind parameter ke pernyataan SQL sebagai string
        $stmt->bind_param("sss", $namaPerusahaan, $alamat, $kontak);

        // Lakukan eksekusi pernyataan
        if ($stmt->execute()) {
            return true; // Jika berhasil, kembalikan true
        } else {
            return false; // Jika gagal, kembalikan false
        }

        // Tutup pernyataan
        $stmt->close();
    }
}

// Pesan popup setelah berhasil input
function showPopup()
{
    echo "<script>alert('Data perusahaan berhasil ditambahkan');</script>";
}

// Contoh penggunaan: tambah data perusahaan baru
if (isset($_POST['submit'])) {
    $namaPerusahaan = $_POST['nama_perusahaan'];
    $alamat = $_POST['alamat'];
    $kontak = $_POST['kontak'];

    // Panggil fungsi untuk menambahkan perusahaan baru
    if (tambahPerusahaan($namaPerusahaan, $alamat, $kontak)) {
        // Jika berhasil, arahkan kembali ke halaman utama atau lakukan tindakan lain
        showPopup();
        echo "<script>window.location.href = 'index.php';</script>";
        exit;
    } else {
        // Jika gagal, tampilkan pesan kesalahan atau lakukan tindakan lain
        echo "Gagal menambahkan data perusahaan.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Perusahaan Baru</title>
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

        label {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Tambah Perusahaan Baru</h1>
        <form action="" method="post">
            <div class="form-group">
                <label for="nama_perusahaan">Nama Perusahaan</label>
                <input type="text" class="form-control" id="nama_perusahaan" name="nama_perusahaan" required>
            </div>
            <div class="form-group">
                <label for="alamat">Alamat</label>
                <input type="text" class="form-control" id="alamat" name="alamat" required>
            </div>
            <div class="form-group">
                <label for="kontak">Kontak</label>
                <input type="text" class="form-control" id="kontak" name="kontak" required>
            </div>
            <button type="submit" class="btn btn-primary" name="submit">Tambah Perusahaan</button>
            <a href="index.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
    <!-- Tautan Bootstrap JS (Opsional) -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>