<?php 
include 'koneksi.php'; 
include 'header.php'; 
$id = $_GET['id'];
$data = mysqli_query($conn, "SELECT * FROM cinemas WHERE id_cinema='$id'");
$d = mysqli_fetch_array($data);
?>

<div class="row justify-content-center mt-5">
    <div class="col-md-6">
        <div class="card border-0 shadow-lg">
            <div class="card-header bg-warning py-3 text-center border-bottom border-secondary border-opacity-10">
                <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-pencil-square me-2"></i>Edit Data Bioskop</h5>
            </div>
            <div class="card-body p-4">
                <form action="cinema_aksi.php?act=edit" method="post">
                    <!-- Hidden ID agar sistem tahu mana yang diupdate -->
                    <input type="hidden" name="id_cinema" value="<?= $d['id_cinema']; ?>">
                    
                    <div class="mb-4">
                        <label class="form-label text-secondary fw-semibold">Nama Bioskop</label>
                        <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($d['nama_bioskop']); ?>" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label text-secondary fw-semibold">Alamat Lokasi</label>
                        <textarea name="alamat" class="form-control" rows="3" required><?= htmlspecialchars($d['alamat']); ?></textarea>
                    </div>
                    <hr class="border-secondary border-opacity-10 my-4">
                    <div class="d-flex justify-content-between">
                        <a href="cinema_tampil.php" class="btn btn-secondary px-4">Batal</a>
                        <button type="submit" class="btn btn-warning px-4 fw-bold">Update Bioskop</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>