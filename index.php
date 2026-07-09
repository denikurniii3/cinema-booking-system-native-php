<?php 
include 'koneksi.php'; 
include 'header.php'; 

// Fetch stats data
$movies_count = mysqli_num_rows(mysqli_query($conn, "SELECT id_movie FROM movies"));
$cinemas_count = mysqli_num_rows(mysqli_query($conn, "SELECT id_cinema FROM cinemas"));
$studios_count = mysqli_num_rows(mysqli_query($conn, "SELECT id_studio FROM studios"));
$bookings_count = mysqli_num_rows(mysqli_query($conn, "SELECT id_booking FROM bookings"));
$tickets_sold_res = mysqli_fetch_array(mysqli_query($conn, "SELECT SUM(jumlah_tiket) as total FROM bookings"));
$tickets_sold = $tickets_sold_res['total'] ?? 0;
?>

<!-- Hero Banner -->
<div class="p-5 mb-5 rounded-4 text-center border border-secondary border-opacity-10 shadow-lg" 
     style="background: linear-gradient(135deg, rgba(20, 20, 28, 0.9) 0%, rgba(10, 10, 15, 0.95) 100%);">
    <div class="container-fluid py-3">
        <h1 class="display-4 fw-bold text-danger mb-3">Selamat Datang di Cine<span>Tick</span>!</h1>
        <p class="col-md-10 mx-auto fs-5 text-secondary">Sistem manajemen bioskop premium untuk mengelola film, studio, jadwal tayang, dan transaksi pemesanan tiket dengan visual peta kursi interaktif.</p>
        <a href="booking_tambah.php" class="btn btn-primary btn-lg px-5 py-3 mt-3 shadow-lg">
            <i class="bi bi-ticket-perforated-fill me-2"></i> Beli Tiket Sekarang
        </a>
    </div>
</div>

<!-- Stats Counter Rows -->
<div class="row g-4 mb-5 text-center">
    <div class="col-md-3">
        <div class="card border-0 p-3 h-100 bg-opacity-75">
            <div class="card-body">
                <div class="fs-1 text-danger mb-2"><i class="bi bi-film"></i></div>
                <h6 class="text-secondary text-uppercase mb-1">Total Film</h6>
                <h3 class="fw-bold m-0"><?= $movies_count; ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 p-3 h-100 bg-opacity-75">
            <div class="card-body">
                <div class="fs-1 text-warning mb-2"><i class="bi bi-geo-alt"></i></div>
                <h6 class="text-secondary text-uppercase mb-1">Total Bioskop</h6>
                <h3 class="fw-bold m-0"><?= $cinemas_count; ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 p-3 h-100 bg-opacity-75">
            <div class="card-body">
                <div class="fs-1 text-info mb-2"><i class="bi bi-display"></i></div>
                <h6 class="text-secondary text-uppercase mb-1">Total Studio</h6>
                <h3 class="fw-bold m-0"><?= $studios_count; ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 p-3 h-100 bg-opacity-75">
            <div class="card-body">
                <div class="fs-1 text-success mb-2"><i class="bi bi-ticket-detailed"></i></div>
                <h6 class="text-secondary text-uppercase mb-1">Tiket Terjual</h6>
                <h3 class="fw-bold m-0"><?= $tickets_sold; ?> Kursi</h3>
            </div>
        </div>
    </div>
</div>

<!-- Section: Now Showing Movie Catalog -->
<h3 class="mb-4"><i class="bi bi-fire text-danger me-2"></i> Sedang Tayang (Now Showing)</h3>
<div class="row g-4">
    <?php
    $movies_res = mysqli_query($conn, "SELECT * FROM movies ORDER BY id_movie DESC LIMIT 8");
    if(mysqli_num_rows($movies_res) == 0){
        echo "<div class='col-12 text-center py-5 text-secondary card'><p class='m-0'>Belum ada film yang didaftarkan.</p></div>";
    }
    while($m = mysqli_fetch_array($movies_res)){
        // Fallback jika tidak ada poster URL
        $poster_url = !empty($m['poster']) ? $m['poster'] : 'https://placehold.co/400x600/18181f/fff?text=' . urlencode($m['judul']);
    ?>
    <div class="col-sm-6 col-md-4 col-lg-3">
        <div class="card movie-card border-0 bg-opacity-75">
            <div class="movie-poster-container">
                <img src="<?= htmlspecialchars($poster_url); ?>" class="movie-poster" alt="<?= htmlspecialchars($m['judul']); ?>" onerror="this.src='https://placehold.co/400x600/18181f/fff?text=No+Poster'">
                <div class="movie-overlay">
                    <span class="badge bg-secondary mb-2"><?= $m['rating']; ?></span>
                    <h5 class="fw-bold text-white mb-1 text-truncate"><?= $m['judul']; ?></h5>
                    <p class="text-secondary small mb-3 text-truncate"><?= $m['genre']; ?></p>
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-secondary"><i class="bi bi-clock me-1"></i><?= $m['durasi']; ?> Min</small>
                        <a href="booking_tambah.php" class="btn btn-sm btn-primary">Beli Tiket</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
</div>

<?php include 'footer.php'; ?>