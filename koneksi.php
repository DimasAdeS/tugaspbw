<?php
$host = "localhost"; // Sesuaikan dengan nama host MySQL Anda
$user = "root"; // Sesuaikan dengan nama pengguna MySQL Anda
$password = ""; // Sesuaikan dengan kata sandi MySQL Anda
$database = "pt_spil_logistik"; // Sesuaikan dengan nama database MySQL Anda

// Buat koneksi
$mysqli = new mysqli($host, $user, $password, $database);

// Periksa koneksi
if ($mysqli->connect_error) {
    die("Koneksi ke database gagal: " . $mysqli->connect_error);
}
?>