<?php
// Sisipkan koneksi ke database di sini
include 'koneksi.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PT SPIL Logistik - Halaman Utama</title>
    <!-- Tautan Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Gaya Kustom -->
    <style>
        /* Gaya tambahan */
        body {
            background-color: #f0f0f0;
            font-family: Arial, sans-serif;
            padding-top: 20px;
        }

        .container {
            padding: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.1);
            max-width: 100vw;
            height: 100vh;
            overflow: auto;
        }

        h1 {
            color: #333333;
            text-align: center;
            margin-bottom: 30px;
        }

        h2 {
            color: #333333;
            margin-top: 40px;
            margin-bottom: 20px;
        }

        .search-container {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-inline {
            justify-content: center;
        }

        .form-control {
            width: 70vw;
            max-width: 300px;
            border-radius: 20px;
        }

        .btn-primary {
            border-radius: 20px;
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .menu-links {
            margin-top: 30px;
            text-align: center;
        }

        .btn-success {
            border-radius: 20px;
            background-color: #28a745;
            border-color: #28a745;
            margin-bottom: 10px;
        }

        .btn-success:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }

        .transaction-list {
            margin-top: 40px;
        }

        .transaction-item {
            background-color: #ffffff;
            border: 1px solid #dee2e6;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        .table-container {
            margin-top: 40px;
            overflow-x: auto;
        }

        .table-container table {
            width: 100%;
            border-collapse: collapse;
            border-radius: 5px;
            overflow: hidden;
        }

        .table-container th,
        .table-container td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #dee2e6;
        }

        .table-container th {
            background-color: #007bff;
            color: #fff;
        }

        .table-container tbody tr:hover {
            background-color: #f8f9fa;
        }

        .scroll-table {
            max-height: 60vh;
            overflow-y: auto;
        }

        .statistics {
            margin-top: 40px;
            background-color: #007bff;
            color: #fff;
            padding: 20px;
            border-radius: 5px;
            text-align: center;
        }

        .welcome-message {
            margin-top: 40px;
            background-color: #28a745;
            color: #fff;
            padding: 20px;
            border-radius: 5px;
            text-align: center;
        }

        /* Gaya untuk tombol */
        .btn {
            border-radius: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Selamat Datang di PT SPIL Logistik</h1>

        <!-- Pencarian atau Filter Transaksi -->
        <div class="search-container">
            <form action="search.php" method="get" class="form-inline">
                <input type="text" class="form-control mr-2" placeholder="Cari transaksi..." name="query">
                <button type="submit" class="btn btn-primary">Cari</button>
            </form>
        </div>

        <!-- Link atau Tombol Menu -->
        <div class="menu-links">
            <a href="add_item.php" class="btn btn-success">Tambah Barang/Kargo Baru</a>
            <a href="add_container.php" class="btn btn-success">Tambah Kontainer Baru</a>
            <a href="add_pelabuhan.php" class="btn btn-success">Tambah Pelabuhan Baru</a>
            <a href="add_company.php" class="btn btn-success">Tambah Perusahaan Baru</a>
            <a href="new_transaction.php" class="btn btn-success">Tambah Transaksi Baru</a>
            <a href="transaction_list.php" class="btn btn-info">Lihat Semua Transaksi</a>
        </div>



        <!-- Daftar Transaksi Terbaru -->
        <h2 class="mt-5">Transaksi Terbaru</h2>
        <div class="scroll-table">
            <!-- Daftar Transaksi Terbaru -->
            <div class="transaction-list">
                <?php
                // Query untuk mendapatkan data transaksi terbaru
                $sql_transaksi = "SELECT t.*, b.JenisBarang, k.NomorKontainer, pa.NamaPelabuhan AS Asal, pt.NamaPelabuhan AS Tujuan, pp.NamaPerusahaan AS Pengirim, pn.NamaPerusahaan AS Penerima 
              FROM Transaksi t
              LEFT JOIN BarangKargo b ON t.IDBarang = b.IDBarang
              LEFT JOIN Kontainer k ON t.IDKontainer = k.IDKontainer
              LEFT JOIN Pelabuhan pa ON t.IDPelabuhanAsal = pa.IDPelabuhan
              LEFT JOIN Pelabuhan pt ON t.IDPelabuhanTujuan = pt.IDPelabuhan
              LEFT JOIN Perusahaan pp ON t.IDPerusahaanPengirim = pp.IDPerusahaan
              LEFT JOIN Perusahaan pn ON t.IDPerusahaanPenerima = pn.IDPerusahaan
              ORDER BY t.TanggalPengiriman DESC
              LIMIT 5"; // Ambil lima transaksi terbaru
                $result_transaksi = $mysqli->query($sql_transaksi);

                // Periksa apakah hasilnya tidak kosong
                if ($result_transaksi->num_rows > 0) {
                    // Tampilkan data transaksi dalam loop
                    $counter = 0;
                    while ($row = $result_transaksi->fetch_assoc()) {
                        if ($counter % 2 == 0) {
                            echo "<div class='row'>";
                        }
                        echo "<div class='col-md-6'>";
                        echo "<div class='transaction-item'>";
                        echo "<p><strong>Jenis Barang:</strong> " . $row["JenisBarang"] . "</p>";
                        echo "<p><strong>Kontainer:</strong> " . $row["NomorKontainer"] . "</p>";
                        echo "<p><strong>Pelabuhan Asal:</strong> " . $row["Asal"] . "</p>";
                        echo "<p><strong>Pelabuhan Tujuan:</strong> " . $row["Tujuan"] . "</p>";
                        echo "<p><strong>Perusahaan Pengirim:</strong> " . $row["Pengirim"] . "</p>";
                        echo "<p><strong>Perusahaan Penerima:</strong> " . $row["Penerima"] . "</p>";
                        echo "<p><strong>Tanggal Pengiriman:</strong> " . $row["TanggalPengiriman"] . "</p>";
                        echo "<p><strong>Rencana Jadwal Pengiriman:</strong> " . $row["RencanaJadwalPengiriman"] . "</p>";
                        echo "<p><strong>Nomor Referensi:</strong> " . $row["NomorReferensi"] . "</p>";
                        echo "<p><strong>Instruksi Khusus:</strong> " . $row["InstruksiKhusus"] . "</p>";
                        echo "</div>";
                        echo "</div>";
                        if ($counter % 2 != 0 || $counter == $result_transaksi->num_rows - 1) {
                            echo "</div>";
                        }
                        $counter++;
                    }
                } else {
                    echo "<p>Tidak ada transaksi yang tersedia.</p>";
                }
                ?>
            </div>
        </div>


        <!-- Tabel Daftar Barang/Kargo -->
        <div class="table-container">
            <h2>Daftar Barang/Kargo</h2>
            <div class="scroll-table">
                <?php
                // Query untuk mendapatkan semua data barang/kargo
                $sql_barang = "SELECT * FROM BarangKargo";
                $result_barang = $mysqli->query($sql_barang);

                // Periksa apakah hasilnya tidak kosong
                if ($result_barang->num_rows > 0) {
                    // Tampilkan data dalam tabel
                    echo "<div class='table-responsive'>";
                    echo "<table class='table'>";
                    echo "<thead><tr><th>ID Barang</th><th>Jenis Barang</th><th>Jumlah</th><th>Berat</th><th>Volume</th><th>Deskripsi</th></tr></thead>";
                    echo "<tbody>";
                    while ($row = $result_barang->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["IDBarang"] . "</td>";
                        echo "<td>" . $row["JenisBarang"] . "</td>";
                        echo "<td>" . $row["Jumlah"] . "</td>";
                        echo "<td>" . $row["Berat"] . "</td>";
                        echo "<td>" . $row["Volume"] . "</td>";
                        echo "<td>" . $row["Deskripsi"] . "</td>";
                        echo "</tr>";
                    }
                    echo "</tbody>";
                    echo "</table>";
                    echo "</div>";
                } else {
                    echo "<p>Tidak ada barang/kargo yang tersedia.</p>";
                }
                ?>
            </div>
        </div>

        <!-- Tabel Daftar Kontainer -->
        <div class="table-container">
            <h2>Daftar Kontainer</h2>
            <div class="scroll-table">
                <?php
                // Query untuk mendapatkan semua data kontainer
                $sql_kontainer = "SELECT * FROM Kontainer";
                $result_kontainer = $mysqli->query($sql_kontainer);

                // Periksa apakah hasilnya tidak kosong
                if ($result_kontainer->num_rows > 0) {
                    // Tampilkan data dalam tabel
                    echo "<div class='table-responsive'>";
                    echo "<table class='table'>";
                    echo "<thead><tr><th>ID Kontainer</th><th>Nomor Kontainer</th><th>Jenis Kontainer</th><th>Ukuran</th><th>Berat</th><th>Kapasitas</th></tr></thead>";
                    echo "<tbody>";
                    while ($row = $result_kontainer->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["IDKontainer"] . "</td>";
                        echo "<td>" . $row["NomorKontainer"] . "</td>";
                        echo "<td>" . $row["JenisKontainer"] . "</td>";
                        echo "<td>" . $row["Ukuran"] . "</td>";
                        echo "<td>" . $row["Berat"] . "</td>";
                        echo "<td>" . $row["Kapasitas"] . "</td>";
                        echo "</tr>";
                    }
                    echo "</tbody>";
                    echo "</table>";
                    echo "</div>";
                } else {
                    echo "<p>Tidak ada kontainer yang tersedia.</p>";
                }
                ?>
            </div>
        </div>

        <!-- Tabel Daftar Perusahaan -->
        <div class="table-container">
            <h2>Daftar Perusahaan</h2>
            <div class="scroll-table">
                <?php
                // Query untuk mendapatkan lima data perusahaan teratas
                $sql_perusahaan = "SELECT * FROM Perusahaan";
                $result_perusahaan = $mysqli->query($sql_perusahaan);

                // Periksa apakah hasilnya tidak kosong
                if ($result_perusahaan->num_rows > 0) {
                    // Tampilkan data dalam tabel
                    echo "<div class='table-responsive'>";
                    echo "<table class='table'>";
                    echo "<thead><tr><th>ID Perusahaan</th><th>Nama Perusahaan</th><th>Alamat</th><th>Kontak</th></tr></thead>";
                    echo "<tbody>";
                    while ($row = $result_perusahaan->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["IDPerusahaan"] . "</td>";
                        echo "<td>" . $row["NamaPerusahaan"] . "</td>";
                        echo "<td>" . $row["Alamat"] . "</td>";
                        echo "<td>" . $row["Kontak"] . "</td>";
                        echo "</tr>";
                    }
                    echo "</tbody>";
                    echo "</table>";
                    echo "</div>";
                } else {
                    echo "<p>Tidak ada perusahaan yang tersedia.</p>";
                }
                ?>
            </div>
        </div>

        <!-- Tabel Daftar Pelabuhan -->
        <div class="table-container">
            <h2>Daftar Pelabuhan</h2>
            <div class="scroll-table">
                <?php
                // Query untuk mendapatkan lima data pelabuhan teratas
                $sql_pelabuhan = "SELECT * FROM Pelabuhan LIMIT 5";
                $result_pelabuhan = $mysqli->query($sql_pelabuhan);

                // Periksa apakah hasilnya tidak kosong
                if ($result_pelabuhan->num_rows > 0) {
                    // Tampilkan data dalam tabel
                    echo "<div class='table-responsive'>";
                    echo "<table class='table'>";
                    echo "<thead><tr><th>ID Pelabuhan</th><th>Nama Pelabuhan</th><th>Lokasi</th></tr></thead>";
                    echo "<tbody>";
                    while ($row = $result_pelabuhan->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["IDPelabuhan"] . "</td>";
                        echo "<td>" . $row["NamaPelabuhan"] . "</td>";
                        echo "<td>" . $row["Lokasi"] . "</td>";
                        echo "</tr>";
                    }
                    echo "</tbody>";
                    echo "</table>";
                    echo "</div>";
                } else {
                    echo "<p>Tidak ada pelabuhan yang tersedia.</p>";
                }
                ?>
            </div>
        </div>



        <!-- Statistik atau Ringkasan Data -->
        <div class="statistics mt-4">
            <h2>Statistik Transaksi</h2>
            <canvas id="transactionChart" width="400" height="200"></canvas>
            <?php
            // Query untuk menghitung jumlah total transaksi
            $sql_total_transaksi = "SELECT COUNT(*) AS total_transaksi FROM Transaksi";
            $result_total_transaksi = $mysqli->query($sql_total_transaksi);

            // Periksa apakah query berhasil dieksekusi
            if ($result_total_transaksi) {
                $row_total_transaksi = $result_total_transaksi->fetch_assoc();
                $total_transaksi = $row_total_transaksi['total_transaksi'];
                echo "<p>Jumlah Total Transaksi: <strong>$total_transaksi</strong></p>";
            } else {
                echo "<p>Gagal mengambil statistik transaksi.</p>";
            }
            ?>
        </div>

        <!-- Pesan Sambutan atau Penjelasan -->
        <div class="welcome-message mt-4">
            <p>Selamat datang di PT SPIL Logistik. Sistem ini memudahkan Anda untuk mencatat dan mengelola transaksi
                logistik dengan efisien. Silakan gunakan menu di atas untuk memulai.</p>
        </div>
    </div>
    <!-- Tautan Bootstrap JS (Opsional) -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
    <script>
        // Ambil elemen canvas
        var ctx = document.getElementById('transactionChart').getContext('2d');

        // Data transaksi (misalnya, total transaksi)
        var totalTransaksi = <?php echo $total_transaksi; ?>;

        // Buat grafik
        var myChart = new Chart(ctx, {
            type: 'bar', // Jenis grafik (bar, line, pie, dll.)
            data: {
                labels: ['Total Transaksi'], // Label sumbu X
                datasets: [{
                    label: 'Jumlah Transaksi', // Label dataset
                    data: [totalTransaksi], // Data transaksi
                    backgroundColor: 'rgba(54, 162, 235, 0.2)', // Warna latar belakang bar
                    borderColor: 'rgba(54, 162, 235, 1)', // Warna garis batas bar
                    borderWidth: 1 // Ketebalan garis batas bar
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true // Mulai sumbu Y dari angka 0
                        }
                    }]
                }
            }
        });
    </script>
</body>

</html>