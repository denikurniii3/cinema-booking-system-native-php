<?php 
include 'koneksi.php'; 
include 'header.php'; 
$id = $_GET['id'];
$data = mysqli_query($conn, "SELECT * FROM schedules WHERE id_schedule='$id'");
$s = mysqli_fetch_array($data);
?>

<div class="row justify-content-center mt-5">
    <div class="col-md-8">
        <div class="card border-0 shadow-lg">
            <div class="card-header bg-warning py-3 text-center border-bottom border-secondary border-opacity-10">
                <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-pencil-square me-2"></i>Edit Jadwal Tayang</h5>
            </div>
            <div class="card-body p-4">
                <form action="jadwal_aksi.php?act=edit" method="post">
                    <input type="hidden" name="id_schedule" value="<?= $s['id_schedule']; ?>">
                    
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="form-label text-secondary fw-semibold">Pilih Film</label>
                            <select name="id_movie" class="form-select" required>
                                <?php 
                                $m_list = mysqli_query($conn, "SELECT * FROM movies");
                                while($m = mysqli_fetch_array($m_list)){
                                    $sel = ($m['id_movie'] == $s['id_movie']) ? "selected" : "";
                                    echo "<option value='$m[id_movie]' $sel>".htmlspecialchars($m['judul'])."</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="form-label text-secondary fw-semibold">Pilih Lokasi Studio</label>
                            <select name="id_studio" class="form-select" required>
                                <?php 
                                $st_data = mysqli_query($conn, "SELECT st.*, c.nama_bioskop FROM studios st JOIN cinemas c ON st.id_cinema = c.id_cinema");
                                while($st = mysqli_fetch_array($st_data)){
                                    $sel = ($st['id_studio'] == $s['id_studio']) ? "selected" : "";
                                    echo "<option value='$st[id_studio]' $sel>".htmlspecialchars($st['nama_bioskop'])." - ".htmlspecialchars($st['nama_studio'])."</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <label class="form-label text-secondary fw-semibold">Tanggal Tayang</label>
                            <input type="date" name="tgl" class="form-control" value="<?= $s['tanggal_tayang']; ?>" required>
                        </div>
                        <div class="col-md-4 mb-4">
                            <label class="form-label text-secondary fw-semibold">Jam Tayang</label>
                            <input type="time" name="jam" class="form-control" value="<?= date('H:i', strtotime($s['jam_tayang'])); ?>" required>
                        </div>
                        <div class="col-md-4 mb-4">
                            <label class="form-label text-secondary fw-semibold">Harga Tiket (Rp)</label>
                            <input type="number" name="harga" class="form-control" value="<?= (int)$s['harga_tiket']; ?>" required>
                        </div>
                    </div>

                    <hr class="border-secondary border-opacity-10 my-4">
                    <div class="d-flex justify-content-between">
                        <a href="jadwal_tampil.php" class="btn btn-secondary px-4">Batal</a>
                        <button type="submit" class="btn btn-warning px-4 fw-bold">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>