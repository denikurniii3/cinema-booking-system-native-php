<?php 
include 'koneksi.php';
include 'header.php'; 
$id = $_GET['id'];
$data = mysqli_query($conn, "SELECT * FROM movies WHERE id_movie='$id'");
$d = mysqli_fetch_array($data);
?>

<div class="row justify-content-center mt-5">
    <div class="col-md-6">
        <div class="card border-0 shadow-lg">
            <div class="card-header bg-warning py-3 text-center border-bottom border-secondary border-opacity-10">
                <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-pencil-square me-2"></i>Edit Data Film</h5>
            </div>
            <div class="card-body p-4">
                <form action="movie_aksi.php?act=edit" method="post">
                    <input type="hidden" name="id_movie" value="<?php echo $d['id_movie']; ?>">
                    <div class="mb-4">
                        <label class="form-label text-secondary fw-semibold">Judul Film</label>
                        <input type="text" name="judul" class="form-control" value="<?php echo htmlspecialchars($d['judul']); ?>" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label text-secondary fw-semibold">Genre</label>
                        <input type="text" name="genre" class="form-control" value="<?php echo htmlspecialchars($d['genre']); ?>" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="form-label text-secondary fw-semibold">Durasi (Menit)</label>
                            <input type="number" name="durasi" class="form-control" value="<?php echo $d['durasi']; ?>" required>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="form-label text-secondary fw-semibold">Rating Umur</label>
                            <select name="rating" class="form-select">
                                <option value="SU" <?php if($d['rating']=='SU') echo 'selected'; ?>>Semua Umur (SU)</option>
                                <option value="R13+" <?php if($d['rating']=='R13+') echo 'selected'; ?>>Remaja (R13+)</option>
                                <option value="D17+" <?php if($d['rating']=='D17+') echo 'selected'; ?>>Dewasa (D17+)</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label text-secondary fw-semibold">Link Poster Film (URL Gambar)</label>
                        <input type="url" name="poster" class="form-control" value="<?php echo htmlspecialchars($d['poster'] ?? ''); ?>" placeholder="Contoh: https://image.tmdb.org/t/p/w500/xyz.jpg">
                        <div class="form-text text-secondary opacity-50">Masukkan URL gambar untuk mengganti poster film.</div>
                    </div>
                    <hr class="border-secondary border-opacity-10 my-4">
                    <div class="d-flex justify-content-between">
                        <a href="movie_tampil.php" class="btn btn-secondary px-4">Batal</a>
                        <button type="submit" class="btn btn-warning px-4 fw-bold">Update Film</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>