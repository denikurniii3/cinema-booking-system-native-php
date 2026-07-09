<?php
include 'koneksi.php';
$act = $_GET['act'];

if($act == 'tambah' || $act == 'edit'){
    $id_sch   = $_POST['id_schedule'];
    $nama     = $_POST['nama'];
    $jumlah   = intval($_POST['jumlah']);
    $no_kursi = $_POST['no_kursi'];

    // LOGIKA: Ambil harga tiket dari tabel schedules berdasarkan ID yang dipilih
    $cek_harga = mysqli_query($conn, "SELECT harga_tiket FROM schedules WHERE id_schedule = '$id_sch'");
    $h = mysqli_fetch_array($cek_harga);
    
    // HITUNG TOTAL OTOMATIS
    $total = $h['harga_tiket'] * $jumlah;

    if($act == 'tambah'){
        mysqli_query($conn, "INSERT INTO bookings (id_schedule, nama_pemesan, jumlah_tiket, total_bayar, no_kursi) 
                            VALUES ('$id_sch', '$nama', '$jumlah', '$total', '$no_kursi')");
    } else {
        $id_b = $_POST['id_booking'];
        mysqli_query($conn, "UPDATE bookings SET 
                             nama_pemesan='$nama', 
                             jumlah_tiket='$jumlah', 
                             total_bayar='$total', 
                             no_kursi='$no_kursi' 
                             WHERE id_booking='$id_b'");
    }

} elseif($act == 'hapus'){
    $id = $_GET['id'];
    mysqli_query($conn, "DELETE FROM bookings WHERE id_booking='$id'");
}

header("location:booking_tampil.php");
?>