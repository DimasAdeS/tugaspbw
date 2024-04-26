<?php
// Sisipkan koneksi ke database di sini
include 'koneksi.php';

// Load TCPDF autoloader
require_once 'vendor/autoload.php';

// Fungsi untuk menghasilkan file PDF
function generatePDF($data)
{
    // Buat instance TCPDF
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // Atur informasi dokumen
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('PT SPIL Logistik');
    $pdf->SetTitle('Data Transaksi');
    $pdf->SetSubject('Data Transaksi PT SPIL Logistik');

    // Atur margin
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

    // Atur font
    $pdf->SetFont('dejavusans', '', 10);

    // Tambahkan halaman
    $pdf->AddPage();

    // Buat tabel
    $html = '<h2>Data Transaksi</h2>';
    $html .= '<table border="1" cellpadding="5" cellspacing="0">';
    $html .= '<tr><th>ID Transaksi</th><th>ID Barang</th><th>ID Kontainer</th><th>ID Pelabuhan Asal</th><th>ID Pelabuhan Tujuan</th><th>ID Perusahaan Pengirim</th><th>ID Perusahaan Penerima</th><th>Tanggal Pengiriman</th><th>Rencana Jadwal Pengiriman</th><th>Nomor Referensi</th><th>Instruksi Khusus</th></tr>';

    foreach ($data as $row) {
        $html .= '<tr>';
        $html .= '<td>' . $row['IDTransaksi'] . '</td>';
        $html .= '<td>' . $row['IDBarang'] . '</td>';
        $html .= '<td>' . $row['IDKontainer'] . '</td>';
        $html .= '<td>' . $row['IDPelabuhanAsal'] . '</td>';
        $html .= '<td>' . $row['IDPelabuhanTujuan'] . '</td>';
        $html .= '<td>' . $row['IDPerusahaanPengirim'] . '</td>';
        $html .= '<td>' . $row['IDPerusahaanPenerima'] . '</td>';
        $html .= '<td>' . $row['TanggalPengiriman'] . '</td>';
        $html .= '<td>' . $row['RencanaJadwalPengiriman'] . '</td>';
        $html .= '<td>' . $row['NomorReferensi'] . '</td>';
        $html .= '<td>' . $row['InstruksiKhusus'] . '</td>';
        $html .= '</tr>';
    }

    $html .= '</table>';

    // Tambahkan konten ke PDF
    $pdf->writeHTML($html, true, false, true, false, '');

    // Output PDF ke browser atau simpan ke file
    $pdf->Output('Data_Transaksi.pdf', 'D');
}


// Query untuk mendapatkan data transaksi
$sql = "SELECT * FROM Transaksi";
$result = $mysqli->query($sql);
$sql = "SELECT 
            IDBarang, 
            IDKontainer, 
            IDPelabuhanAsal, 
            IDPelabuhanTujuan, 
            IDPerusahaanPengirim, 
            IDPerusahaanPenerima, 
            TanggalPengiriman, 
            RencanaJadwalPengiriman, 
            NomorReferensi, 
            InstruksiKhusus 
        FROM Transaksi";

// Periksa apakah ada data yang ditemukan
if ($result) {
    // Masukkan data ke dalam array
    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    // Jika parameter "download" terdefinisi dan bernilai "pdf", buat file PDF
    if (isset($_GET['download']) && $_GET['download'] === 'pdf') {
        generatePDF($data);
        exit;
    }

    // Jika parameter "download" terdefinisi dan bernilai "excel", buat file Excel
    if (isset($_GET['download']) && $_GET['download'] === 'excel') {
        // Kode untuk membuat file Excel akan ditambahkan di sini
        // Anda dapat menggunakan PHPExcel atau fungsi bawaan PHP untuk menulis data ke file Excel
        exit;
    }

    // Tampilkan data dalam bentuk tabel HTML
    echo '<!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <title>Data Transaksi</title>
                <style>
                    table {
                        border-collapse: collapse;
                        width: 100%;
                    }
                    th, td {
                        border: 1px solid #dddddd;
                        text-align: left;
                        padding: 8px;
                    }
                    th {
                        background-color: #f2f2f2;
                    }
                </style>
            </head>
            <body>
                <h1>Data Transaksi</h1>
                <table>
                    <tr>
                        <th>ID Transaksi</th>
                        <th>ID Barang</th>
                        <th>ID Kontainer</th>
                        <th>ID Pelabuhan Asal</th>
                        <th>ID Pelabuhan Tujuan</th>
                        <th>ID Perusahaan Pengirim</th>
                        <th>ID Perusahaan Penerima</th>
                        <th>Tanggal Pengiriman</th>
                        <th>Rencana Jadwal Pengiriman</th>
                        <th>Nomor Referensi</th>
                        <th>Instruksi Khusus</th>
                    </tr>';

    foreach ($data as $row) {
        echo '<tr>';
        echo '<td>' . $row['IDTransaksi'] . '</td>';
        echo '<td>' . $row['IDBarang'] . '</td>';
        echo '<td>' . $row['IDKontainer'] . '</td>';
        echo '<td>' . $row['IDPelabuhanAsal'] . '</td>';
        echo '<td>' . $row['IDPelabuhanTujuan'] . '</td>';
        echo '<td>' . $row['IDPerusahaanPengirim'] . '</td>';
        echo '<td>' . $row['IDPerusahaanPenerima'] . '</td>';
        echo '<td>' . $row['TanggalPengiriman'] . '</td>';
        echo '<td>' . $row['RencanaJadwalPengiriman'] . '</td>';
        echo '<td>' . $row['NomorReferensi'] . '</td>';
        echo '<td>' . $row['InstruksiKhusus'] . '</td>';
        echo '</tr>';
    }

    echo '</table>';

    // Tambahkan tautan untuk mengunduh PDF dan Excel
    echo '<p><a href="?download=pdf">Unduh PDF</a> | <a href="?download=excel">Unduh Excel</a></p>';

    echo '</body>
        </html>';
} else {
    echo "Tidak ada data transaksi yang tersedia.";
}

// Menutup koneksi
$mysqli->close();
?>