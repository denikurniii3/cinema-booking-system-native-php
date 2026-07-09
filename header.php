<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CineTick - Kelola Bioskop Profesional</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php
// Mendapatkan nama file saat ini untuk deteksi menu aktif
$current_page = basename($_SERVER['PHP_SELF']);
?>

<nav class="navbar navbar-expand-lg navbar-dark">
  <div class="container">
    <a class="navbar-brand" href="index.php">
        <i class="bi bi-ticket-detailed-fill text-danger me-2"></i>Cine<span>Tick</span>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link <?= (strpos($current_page, 'index') !== false) ? 'active' : '' ?>" href="index.php">
             <i class="bi bi-grid-fill me-1"></i> Dashboard
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= (strpos($current_page, 'movie') !== false) ? 'active' : '' ?>" href="movie_tampil.php">
             <i class="bi bi-film me-1"></i> Film
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= (strpos($current_page, 'cinema') !== false) ? 'active' : '' ?>" href="cinema_tampil.php">
             <i class="bi bi-geo-alt-fill me-1"></i> Bioskop
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= (strpos($current_page, 'studio') !== false) ? 'active' : '' ?>" href="studio_tampil.php">
             <i class="bi bi-display me-1"></i> Studio
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= (strpos($current_page, 'jadwal') !== false) ? 'active' : '' ?>" href="jadwal_tampil.php">
             <i class="bi bi-calendar-event me-1"></i> Jadwal
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= (strpos($current_page, 'booking') !== false) ? 'active' : '' ?>" href="booking_tampil.php">
             <i class="bi bi-ticket-perforated me-1"></i> Pemesanan
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="container pb-5">