<?php
// Proses tambah barang/kargo
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sisipkan koneksi database di sini
    include 'koneksi.php';

    // Mendapatkan data dari formulir
    $jenis_barang = $_POST['jenis_barang'];
    $jumlah = $_POST['jumlah'];
    $berat = $_POST['berat'];
    $volume = $_POST['volume'];
    $deskripsi = $_POST['deskripsi'];

    // Validasi input
    if (empty($jenis_barang) || $jumlah <= 0 || $berat <= 0 || $volume <= 0) {
        echo '<div class="alert alert-danger" role="alert">Mohon lengkapi semua bidang dengan benar.</div>';
    } else {
        // Memasukkan data ke dalam tabel BarangKargo
        $sql = "INSERT INTO BarangKargo (JenisBarang, Jumlah, Berat, Volume, Deskripsi) VALUES (?, ?, ?, ?, ?)";
        if ($stmt = $mysqli->prepare($sql)) {
            // Bind variabel ke pernyataan persiapan sebagai parameter
            $stmt->bind_param("siiis", $jenis_barang, $jumlah, $berat, $volume, $deskripsi);

            // Mengeksekusi pernyataan
            if ($stmt->execute()) {
                // Tambahkan pesan ke dalam tabel pesan
                $pesan_barang = "Barang/kargo dengan jenis " . $jenis_barang . " berhasil ditambahkan.";
                tambahPesan($mysqli, $pesan_barang);

                // Tampilkan pesan sukses kepada pengguna atau lakukan tindakan lain yang sesuai
                echo '<div class="alert alert-success" role="alert">Barang/kargo berhasil ditambahkan!</div>';
            } else {
                echo '<div class="alert alert-danger" role="alert">Terjadi kesalahan saat menambahkan barang/kargo. Silakan coba lagi.</div>';
            }

            // Menutup pernyataan
            $stmt->close();
        } else {
            echo '<div class="alert alert-danger" role="alert">Terjadi kesalahan. Silakan coba lagi.</div>';
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
    <title>Tambah Barang/Kargo</title>
    <!-- Tautan Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <h1>Tambah Barang/Kargo yang Akan Dikirim</h1>
        <!-- Pesan akan muncul di bawah judul -->
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Sisipkan koneksi database di sini
            include 'koneksi.php';

            // Mendapatkan data dari formulir
            $jenis_barang = $_POST['jenis_barang'];
            $jumlah = $_POST['jumlah'];
            $berat = $_POST['berat'];
            $volume = $_POST['volume'];
            $deskripsi = $_POST['deskripsi'];

            // Validasi input
            if (empty($jenis_barang) || $jumlah <= 0 || $berat <= 0 || $volume <= 0) {
                echo '<div class="alert alert-danger" role="alert">Mohon lengkapi semua bidang dengan benar.</div>';
            } else {
                // Memasukkan data ke dalam tabel BarangKargo
                $sql = "INSERT INTO BarangKargo (JenisBarang, Jumlah, Berat, Volume, Deskripsi) VALUES (?, ?, ?, ?, ?)";
                if ($stmt = $mysqli->prepare($sql)) {
                    // Bind variabel ke pernyataan persiapan sebagai parameter
                    $stmt->bind_param("siiis", $jenis_barang, $jumlah, $berat, $volume, $deskripsi);

                    // Mengeksekusi pernyataan
                    if ($stmt->execute()) {
                        // Tambahkan pesan ke dalam tabel pesan
                        $pesan_barang = "Barang/kargo dengan jenis " . $jenis_barang . " berhasil ditambahkan.";
                        tambahPesan($mysqli, $pesan_barang);

                        // Tampilkan pesan sukses kepada pengguna atau lakukan tindakan lain yang sesuai
                        echo '<div class="alert alert-success" role="alert">Barang/kargo berhasil ditambahkan!</div>';
                    } else {
                        echo '<div class="alert alert-danger" role="alert">Terjadi kesalahan saat menambahkan barang/kargo. Silakan coba lagi.</div>';
                    }

                    // Menutup pernyataan
                    $stmt->close();
                } else {
                    echo '<div class="alert alert-danger" role="alert">Terjadi kesalahan. Silakan coba lagi.</div>';
                }
            }

            // Menutup koneksi
            $mysqli->close();
        }
        ?>

        <!-- Form untuk menambahkan barang/kargo -->
        <form action="add_item.php" method="POST">
            <div class="form-group">
                <label for="jenis_barang">Jenis Barang/Kargo:</label>
                <input type="text" class="form-control" id="jenis_barang" name="jenis_barang" required>
            </div>
            <div class="form-group">
                <label for="jumlah">Jumlah:</label>
                <input type="number" class="form-control" id="jumlah" name="jumlah" required>
            </div>
            <div class="form-group">
                <label for="berat">Berat (kg):</label>
                <input type="number" class="form-control" id="berat" name="berat" required>
            </div>
            <div class="form-group">
                <label for="volume">Volume (m<sup>3</sup>):</label>
                <input type="number" class="form-control" id="volume" name="volume" required>
            </div>
            <div class="form-group">
                <label for="deskripsi">Deskripsi:</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Tambah Barang/Kargo</button>
        </form>
    </div>
    <!-- Tautan Bootstrap JS (Opsional) -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>