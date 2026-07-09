<?php
include 'koneksi.php';

$act = $_GET['act'];

if($act == 'tambah'){
    $judul  = $_POST['judul'];
    $genre  = $_POST['genre'];
    $durasi = $_POST['durasi'];
    $rating = $_POST['rating'];
    $poster = $_POST['poster'];

    mysqli_query($conn, "INSERT INTO movies (judul, genre, durasi, rating, poster) VALUES ('$judul', '$genre', '$durasi', '$rating', '$poster')");
    header("location:movie_tampil.php?pesan=berhasil_tambah");

} elseif($act == 'edit'){
    $id     = $_POST['id_movie'];
    $judul  = $_POST['judul'];
    $genre  = $_POST['genre'];
    $durasi = $_POST['durasi'];
    $rating = $_POST['rating'];
    $poster = $_POST['poster'];

    mysqli_query($conn, "UPDATE movies SET judul='$judul', genre='$genre', durasi='$durasi', rating='$rating', poster='$poster' WHERE id_movie='$id'");
    header("location:movie_tampil.php?pesan=berhasil_update");

} elseif($act == 'hapus'){
    $id = $_GET['id'];
    mysqli_query($conn, "DELETE FROM movies WHERE id_movie='$id'");
    header("location:movie_tampil.php?pesan=berhasil_hapus");
}
?>