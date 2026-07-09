<?php
include 'koneksi.php';
$act = $_GET['act'];

if($act == 'tambah'){
    $nama   = $_POST['nama'];
    $alamat = $_POST['alamat'];
    mysqli_query($conn, "INSERT INTO cinemas (nama_bioskop, alamat) VALUES ('$nama', '$alamat')");
} elseif($act == 'edit'){
    $id_cinema = $_POST['id_cinema'];
    $nama      = $_POST['nama'];
    $alamat    = $_POST['alamat'];
    mysqli_query($conn, "UPDATE cinemas SET nama_bioskop='$nama', alamat='$alamat' WHERE id_cinema='$id_cinema'");
} elseif($act == 'hapus'){
    $id = $_GET['id'];
    mysqli_query($conn, "DELETE FROM cinemas WHERE id_cinema='$id'");
}

header("location:cinema_tampil.php");
?>