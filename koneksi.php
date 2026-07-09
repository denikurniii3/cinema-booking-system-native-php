<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_bioskop";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Auto migration: Cek & tambahkan kolom no_kursi di tabel bookings jika belum ada
$cek_kolom = mysqli_query($conn, "SHOW COLUMNS FROM bookings LIKE 'no_kursi'");
if (mysqli_num_rows($cek_kolom) == 0) {
    mysqli_query($conn, "ALTER TABLE bookings ADD COLUMN no_kursi VARCHAR(255) NULL AFTER jumlah_tiket");
}
?>