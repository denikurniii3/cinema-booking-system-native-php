<?php include 'koneksi.php'; include 'header.php'; ?>

<div class="row justify-content-center mt-5">
    <div class="col-md-8">
        <div class="card border-0 shadow-lg">
            <div class="card-header bg-dark text-white py-3 text-center border-bottom border-secondary border-opacity-10">
                <h5 class="mb-0 fw-bold"><i class="bi bi-calendar-plus-fill text-danger me-2"></i>Input Jadwal Tayang Baru</h5>
            </div>
            <div class="card-body p-4">
                <form action="jadwal_aksi.php?act=tambah" method="post">
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="form-label text-secondary fw-semibold">Pilih Film</label>
                            <select name="id_movie" class="form-select" required>
                                <option value="">-- Pilih Film --</option>
                                <?php 
                                $m_data = mysqli_query($conn, "SELECT * FROM movies");
                                while($m = mysqli_fetch_array($m_data)){ 
                                    echo "<option value='$m[id_movie]'>".htmlspecialchars($m['judul'])."</option>"; 
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="form-label text-secondary fw-semibold">Pilih Lokasi Studio</label>
                            <select name="id_studio" class="form-select" required>
                                <option value="">-- Pilih Studio --</option>
                                <?php 
                                $st_data = mysqli_query($conn, "SELECT st.*, c.nama_bioskop FROM studios st JOIN cinemas c ON st.id_cinema = c.id_cinema");
                                while($st = mysqli_fetch_array($st_data)){ 
                                    echo "<option value='$st[id_studio]'>".htmlspecialchars($st['nama_bioskop'])." - ".htmlspecialchars($st['nama_studio'])."</option>"; 
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <label class="form-label text-secondary fw-semibold">Tanggal Tayang</label>
                            <input type="date" name="tgl" class="form-control" required>
                        </div>
                        <div class="col-md-4 mb-4">
                            <label class="form-label text-secondary fw-semibold">Jam Tayang</label>
                            <input type="time" name="jam" class="form-control" required>
                        </div>
                        <div class="col-md-4 mb-4">
                            <label class="form-label text-secondary fw-semibold">Harga Tiket (Rp)</label>
                            <input type="number" name="harga" class="form-control" placeholder="Contoh: 45000" required>
                        </div>
                    </div>
                    <hr class="border-secondary border-opacity-10 my-4">
                    <div class="d-flex justify-content-between">
                        <a href="jadwal_tampil.php" class="btn btn-secondary px-4">
                            <i class="bi bi-arrow-left me-1"></i>Kembali
                        </a>
                        <button type="submit" class="btn btn-primary px-5">
                            <i class="bi bi-check-circle me-1"></i>Simpan Jadwal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>