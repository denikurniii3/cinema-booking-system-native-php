<?php include 'header.php'; ?>

<div class="row justify-content-center mt-5">
    <div class="col-md-6">
        <div class="card border-0 shadow-lg">
            <div class="card-header bg-dark text-white py-3 text-center border-bottom border-secondary border-opacity-10">
                <h5 class="mb-0 fw-bold"><i class="bi bi-film text-danger me-2"></i>Tambah Film Baru</h5>
            </div>
            <div class="card-body p-4">
                <form action="movie_aksi.php?act=tambah" method="post">
                    <div class="mb-4">
                        <label class="form-label text-secondary fw-semibold">Judul Film</label>
                        <input type="text" name="judul" class="form-control" placeholder="Contoh: Doctor Strange" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label text-secondary fw-semibold">Genre</label>
                        <input type="text" name="genre" class="form-control" placeholder="Contoh: Action, Fantasy, Sci-Fi" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="form-label text-secondary fw-semibold">Durasi (Menit)</label>
                            <input type="number" name="durasi" class="form-control" placeholder="Contoh: 120" required>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="form-label text-secondary fw-semibold">Rating Umur</label>
                            <select name="rating" class="form-select">
                                <option value="SU">Semua Umur (SU)</option>
                                <option value="R13+">Remaja (R13+)</option>
                                <option value="D17+">Dewasa (D17+)</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label text-secondary fw-semibold">Link Poster Film (URL Gambar)</label>
                        <input type="url" name="poster" class="form-control" placeholder="Contoh: https://image.tmdb.org/t/p/w500/xyz.jpg">
                        <div class="form-text text-secondary opacity-50">Masukkan URL gambar untuk menampilkan poster film di katalog. Kosongkan untuk menggunakan poster default.</div>
                    </div>
                    <hr class="border-secondary border-opacity-10 my-4">
                    <div class="d-flex justify-content-between">
                        <a href="movie_tampil.php" class="btn btn-secondary px-4">
                            <i class="bi bi-arrow-left me-1"></i>Kembali
                        </a>
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-check-circle me-1"></i>Simpan Film
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>