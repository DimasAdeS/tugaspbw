<?php
include 'koneksi.php'; // Sisipkan file koneksi ke database

// Fungsi untuk menambahkan data pelabuhan baru
function tambahPelabuhan($namaPelabuhan, $lokasi)
{
    global $mysqli; // Gunakan koneksi database yang sudah tersedia

    // Persiapkan pernyataan SQL untuk memasukkan data ke tabel Pelabuhan
    $sql = "INSERT INTO Pelabuhan (NamaPelabuhan, Lokasi) VALUES (?, ?)";

    // Persiapkan pernyataan SQL
    if ($stmt = $mysqli->prepare($sql)) {
        // Bind parameter ke pernyataan SQL sebagai string
        $stmt->bind_param("ss", $namaPelabuhan, $lokasi);

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

// Variabel untuk menampung pesan notifikasi
$notification = '';

// Contoh penggunaan: tambah data pelabuhan baru
if (isset($_POST['submit'])) {
    $namaPelabuhan = $_POST['nama_pelabuhan'];
    $lokasi = $_POST['lokasi'];

    // Panggil fungsi untuk menambahkan pelabuhan baru
    if (tambahPelabuhan($namaPelabuhan, $lokasi)) {
        // Jika berhasil, atur pesan notifikasi
        $notification = 'Data pelabuhan berhasil ditambahkan!';
    } else {
        // Jika gagal, atur pesan kesalahan
        $notification = 'Gagal menambahkan data pelabuhan.';
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pelabuhan Baru</title>
    <!-- Tautan Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <h1 class="mt-5">Tambah Pelabuhan Baru</h1>
        <form action="" method="post">
            <div class="form-group">
                <label for="nama_pelabuhan">Nama Pelabuhan</label>
                <input type="text" class="form-control" id="nama_pelabuhan" name="nama_pelabuhan" required>
            </div>
            <div class="form-group">
                <label for="lokasi">Lokasi</label>
                <input type="text" class="form-control" id="lokasi" name="lokasi" required>
            </div>
            <button type="submit" class="btn btn-primary" name="submit">Tambah Pelabuhan</button>
            <a href="index.php" class="btn btn-secondary">Kembali</a>
        </form>

        <!-- Notifikasi -->
        <?php if (!empty($notification)): ?>
            <div class="alert alert-success mt-3" role="alert">
                <?php echo $notification; ?>
            </div>
        <?php endif; ?>
    </div>
    <!-- Tautan Bootstrap JS (Opsional) -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>