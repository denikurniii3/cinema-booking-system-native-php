<?php
include 'koneksi.php';
$act = $_GET['act'];

if($act == 'tambah'){
    mysqli_query($conn, "INSERT INTO studios VALUES (NULL, '$_POST[id_cinema]', '$_POST[nama_studio]', '$_POST[kapasitas]')");
} 
elseif($act == 'edit'){
    $id    = $_POST['id_studio'];
    $id_c  = $_POST['id_cinema'];
    $nama  = $_POST['nama_studio'];
    $kap   = $_POST['kapasitas'];
    
    mysqli_query($conn, "UPDATE studios SET id_cinema='$id_c', nama_studio='$nama', kapasitas='$kap' WHERE id_studio='$id'");
} 
elseif($act == 'hapus'){
    mysqli_query($conn, "DELETE FROM studios WHERE id_studio='$_GET[id]'");
}

header("location:studio_tampil.php");
?>