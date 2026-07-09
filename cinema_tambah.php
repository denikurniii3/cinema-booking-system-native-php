<?php include 'header.php'; ?>

<div class="row justify-content-center mt-5">
    <div class="col-md-6">
        <div class="card border-0 shadow-lg">
            <div class="card-header bg-dark text-white py-3 text-center border-bottom border-secondary border-opacity-10">
                <h5 class="mb-0 fw-bold"><i class="bi bi-geo-alt-fill text-danger me-2"></i>Tambah Bioskop Baru</h5>
            </div>
            <div class="card-body p-4">
                <form action="cinema_aksi.php?act=tambah" method="post">
                    <div class="mb-4">
                        <label class="form-label text-secondary fw-semibold">Nama Bioskop</label>
                        <input type="text" name="nama" class="form-control" placeholder="Contoh: Cineplex XXI Square" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label text-secondary fw-semibold">Alamat Lokasi</label>
                        <textarea name="alamat" class="form-control" rows="3" placeholder="Masukkan alamat lengkap bioskop..." required></textarea>
                    </div>
                    <hr class="border-secondary border-opacity-10 my-4">
                    <div class="d-flex justify-content-between">
                        <a href="cinema_tampil.php" class="btn btn-secondary px-4">
                            <i class="bi bi-arrow-left me-1"></i>Kembali
                        </a>
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-check-circle me-1"></i>Simpan Bioskop
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>