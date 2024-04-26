<?php
// Sisipkan koneksi ke database di sini
include 'koneksi.php';

// Fungsi untuk membersihkan data input
function clean_input($data)
{
    global $mysqli; // Tambahkan variabel global $mysqli

    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);

    // Kembalikan hasil pembersihan
    return $mysqli->real_escape_string($data);
}

// Jika tombol Tambah Transaksi diklik
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengambil data input dan membersihkannya
    $barang_id = clean_input($_POST["barang"]);
    $kontainer_id = clean_input($_POST["kontainer"]);
    $pelabuhan_asal_id = clean_input($_POST["pelabuhan_asal"]);
    $pelabuhan_tujuan_id = clean_input($_POST["pelabuhan_tujuan"]);
    $perusahaan_pengirim_id = clean_input($_POST["perusahaan_pengirim"]);
    $perusahaan_penerima_id = clean_input($_POST["perusahaan_penerima"]);
    $tanggal_pengiriman = clean_input($_POST["tanggal_pengiriman"]);
    $rencana_jadwal_pengiriman = clean_input($_POST["rencana_jadwal_pengiriman"]);
    $nomor_referensi = clean_input($_POST["nomor_referensi"]);
    $instruksi_khusus = clean_input($_POST["instruksi_khusus"]);

    // Query untuk menyimpan transaksi ke database
    $sql_insert_transaksi = "INSERT INTO Transaksi (IDBarang, IDKontainer, IDPelabuhanAsal, IDPelabuhanTujuan, IDPerusahaanPengirim, IDPerusahaanPenerima, TanggalPengiriman, RencanaJadwalPengiriman, NomorReferensi, InstruksiKhusus) 
    VALUES ('$barang_id', '$kontainer_id', '$pelabuhan_asal_id', '$pelabuhan_tujuan_id', '$perusahaan_pengirim_id', '$perusahaan_penerima_id', '$tanggal_pengiriman', '$rencana_jadwal_pengiriman', '$nomor_referensi', '$instruksi_khusus')";

    // Jalankan query untuk menyimpan transaksi
    if ($mysqli->query($sql_insert_transaksi) === TRUE) {
        // Jika transaksi berhasil ditambahkan, tampilkan pesan pop-up
        echo "<script>alert('Transaksi berhasil ditambahkan!');</script>";
        // Mengarahkan kembali ke index.php
        echo "<script>window.location.href = 'index.php';</script>";
    } else {
        // Jika terjadi kesalahan, tampilkan pesan error
        echo "Error: " . $sql_insert_transaksi . "<br>" . $mysqli->error;
    }

    // Tutup koneksi database
    $mysqli->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PT SPIL Logistik - Transaksi Baru</title>
    <!-- Tautan Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <h1 class="mt-5">Transaksi Baru</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" id="transactionForm">
            <div class="form-group">
                <label for="barang">Barang/Kargo:</label>
                <select class="form-control" id="barang" name="barang" required>
                    <!-- Pilihan barang/kargo -->
                    <?php
                    $sql_barang = "SELECT * FROM BarangKargo";
                    $result_barang = $mysqli->query($sql_barang);
                    if ($result_barang->num_rows > 0) {
                        while ($row = $result_barang->fetch_assoc()) {
                            echo "<option value='" . $row['IDBarang'] . "'>" . $row['JenisBarang'] . "</option>";
                        }
                    } else {
                        echo "<option value=''>Tidak ada barang/kargo yang tersedia</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="kontainer">Kontainer:</label>
                <select class="form-control" id="kontainer" name="kontainer" required>
                    <!-- Pilihan kontainer -->
                    <?php
                    $sql_kontainer = "SELECT * FROM Kontainer";
                    $result_kontainer = $mysqli->query($sql_kontainer);
                    if ($result_kontainer->num_rows > 0) {
                        while ($row = $result_kontainer->fetch_assoc()) {
                            echo "<option value='" . $row['IDKontainer'] . "'>" . $row['NomorKontainer'] . "</option>";
                        }
                    } else {
                        echo "<option value=''>Tidak ada kontainer yang tersedia</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="pelabuhan_asal">Pelabuhan Asal:</label>
                <select class="form-control" id="pelabuhan_asal" name="pelabuhan_asal" required>
                    <!-- Pilihan pelabuhan asal -->
                    <?php
                    $sql_pelabuhan_asal = "SELECT * FROM Pelabuhan";
                    $result_pelabuhan_asal = $mysqli->query($sql_pelabuhan_asal);
                    if ($result_pelabuhan_asal->num_rows > 0) {
                        while ($row = $result_pelabuhan_asal->fetch_assoc()) {
                            echo "<option value='" . $row['IDPelabuhan'] . "'>" . $row['NamaPelabuhan'] . "</option>";
                        }
                    } else {
                        echo "<option value=''>Tidak ada pelabuhan yang tersedia</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="pelabuhan_tujuan">Pelabuhan Tujuan:</label>
                <select class="form-control" id="pelabuhan_tujuan" name="pelabuhan_tujuan" required>
                    <!-- Pilihan pelabuhan tujuan -->
                    <?php
                    $sql_pelabuhan_tujuan = "SELECT * FROM Pelabuhan";
                    $result_pelabuhan_tujuan = $mysqli->query($sql_pelabuhan_tujuan);
                    if ($result_pelabuhan_tujuan->num_rows > 0) {
                        while ($row = $result_pelabuhan_tujuan->fetch_assoc()) {
                            echo "<option value='" . $row['IDPelabuhan'] . "'>" . $row['NamaPelabuhan'] . "</option>";
                        }
                    } else {
                        echo "<option value=''>Tidak ada pelabuhan yang tersedia</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="perusahaan_pengirim">Perusahaan Pengirim:</label>
                <select class="form-control" id="perusahaan_pengirim" name="perusahaan_pengirim" required>
                    <!-- Pilihan perusahaan pengirim -->
                    <?php
                    $sql_perusahaan_pengirim = "SELECT * FROM Perusahaan";
                    $result_perusahaan_pengirim = $mysqli->query($sql_perusahaan_pengirim);
                    if ($result_perusahaan_pengirim->num_rows > 0) {
                        while ($row = $result_perusahaan_pengirim->fetch_assoc()) {
                            echo "<option value='" . $row['IDPerusahaan'] . "'>" . $row['NamaPerusahaan'] . "</option>";
                        }
                    } else {
                        echo "<option value=''>Tidak ada perusahaan yang tersedia</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="perusahaan_penerima">Perusahaan Penerima:</label>
                <select class="form-control" id="perusahaan_penerima" name="perusahaan_penerima" required>
                    <!-- Pilihan perusahaan penerima -->
                    <?php
                    $sql_perusahaan_penerima = "SELECT * FROM Perusahaan";
                    $result_perusahaan_penerima = $mysqli->query($sql_perusahaan_penerima);
                    if ($result_perusahaan_penerima->num_rows > 0) {
                        while ($row = $result_perusahaan_penerima->fetch_assoc()) {
                            echo "<option value='" . $row['IDPerusahaan'] . "'>" . $row['NamaPerusahaan'] . "</option>";
                        }
                    } else {
                        echo "<option value=''>Tidak ada perusahaan yang tersedia</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="tanggal_pengiriman">Tanggal Pengiriman:</label>
                <input type="date" class="form-control" id="tanggal_pengiriman" name="tanggal_pengiriman" required>
            </div>
            <div class="form-group">
                <label for="rencana_jadwal_pengiriman">Rencana Jadwal Pengiriman:</label>
                <input type="date" class="form-control" id="rencana_jadwal_pengiriman" name="rencana_jadwal_pengiriman"
                    required>
            </div>
            <div class="form-group">
                <label for="nomor_referensi">Nomor Referensi:</label>
                <input type="text" class="form-control" id="nomor_referensi" name="nomor_referensi" required>
            </div>
            <div class="form-group">
                <label for="instruksi_khusus">Instruksi Khusus:</label>
                <textarea class="form-control" id="instruksi_khusus" name="instruksi_khusus" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Tambah Transaksi</button>
        </form>
    </div>

    <!-- Tautan Bootstrap JS (Opsional) -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>