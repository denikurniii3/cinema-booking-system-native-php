<?php
include 'koneksi.php';
$act = $_GET['act'];

if($act == 'tambah'){
    $id_movie = $_POST['id_movie'];
    $id_studio = $_POST['id_studio'];
    $tgl       = $_POST['tgl'];
    $jam       = $_POST['jam'];
    $harga     = $_POST['harga'];

    mysqli_query($conn, "INSERT INTO schedules (id_movie, id_studio, tanggal_tayang, jam_tayang, harga_tiket) 
                        VALUES ('$id_movie', '$id_studio', '$tgl', '$jam', '$harga')");
} 
elseif($act == 'edit'){
    $id_schedule = $_POST['id_schedule'];
    $id_movie    = $_POST['id_movie'];
    $id_studio   = $_POST['id_studio'];
    $tgl         = $_POST['tgl'];
    $jam         = $_POST['jam'];
    $harga       = $_POST['harga'];

    mysqli_query($conn, "UPDATE schedules SET 
                        id_movie='$id_movie', 
                        id_studio='$id_studio', 
                        tanggal_tayang='$tgl', 
                        jam_tayang='$jam', 
                        harga_tiket='$harga' 
                        WHERE id_schedule='$id_schedule'");
} 
elseif($act == 'hapus'){
    $id = $_GET['id'];
    mysqli_query($conn, "DELETE FROM schedules WHERE id_schedule='$id'");
}

header("location:jadwal_tampil.php");
?>