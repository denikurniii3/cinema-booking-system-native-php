<?php include 'koneksi.php'; include 'header.php'; ?>

<div class="row justify-content-center mt-5">
    <div class="col-md-6">
        <div class="card border-0 shadow-lg">
            <div class="card-header bg-dark text-white py-3 text-center border-bottom border-secondary border-opacity-10">
                <h5 class="mb-0 fw-bold"><i class="bi bi-display text-danger me-2"></i>Tambah Studio Baru</h5>
            </div>
            <div class="card-body p-4">
                <form action="studio_aksi.php?act=tambah" method="post">
                    <div class="mb-4">
                        <label class="form-label text-secondary fw-semibold">Lokasi Bioskop</label>
                        <select name="id_cinema" class="form-select" required>
                            <option value="">-- Pilih Bioskop --</option>
                            <?php
                            $c = mysqli_query($conn, "SELECT * FROM cinemas");
                            while($row = mysqli_fetch_array($c)){
                                echo "<option value='$row[id_cinema]'>".htmlspecialchars($row['nama_bioskop'])."</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="form-label text-secondary fw-semibold">Nama Studio</label>
                        <input type="text" name="nama_studio" class="form-control" placeholder="Contoh: Studio 1, IMAX, Premiere" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label text-secondary fw-semibold">Kapasitas (Kursi)</label>
                        <input type="number" name="kapasitas" class="form-control" placeholder="Contoh: 50, 80" min="10" max="120" required>
                        <div class="form-text text-secondary opacity-50">Kapasitas menentukan ketersediaan kursi di halaman booking.</div>
                    </div>
                    <hr class="border-secondary border-opacity-10 my-4">
                    <div class="d-flex justify-content-between">
                        <a href="studio_tampil.php" class="btn btn-secondary px-4">
                            <i class="bi bi-arrow-left me-1"></i>Kembali
                        </a>
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-check-circle me-1"></i>Simpan Studio
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>