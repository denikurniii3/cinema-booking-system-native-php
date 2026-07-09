<?php 
include 'koneksi.php'; 
include 'header.php'; 
$id = $_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM studios WHERE id_studio='$id'");
$s = mysqli_fetch_array($query);
?>

<div class="row justify-content-center mt-5">
    <div class="col-md-6">
        <div class="card border-0 shadow-lg">
            <div class="card-header bg-warning py-3 text-center border-bottom border-secondary border-opacity-10">
                <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-pencil-square me-2"></i>Edit Data Studio</h5>
            </div>
            <div class="card-body p-4">
                <form action="studio_aksi.php?act=edit" method="post">
                    <input type="hidden" name="id_studio" value="<?= $s['id_studio']; ?>">
                    
                    <div class="mb-4">
                        <label class="form-label text-secondary fw-semibold">Lokasi Bioskop</label>
                        <select name="id_cinema" class="form-select" required>
                            <?php
                            $c_list = mysqli_query($conn, "SELECT * FROM cinemas");
                            while($c = mysqli_fetch_array($c_list)){
                                $selected = ($c['id_cinema'] == $s['id_cinema']) ? "selected" : "";
                                echo "<option value='".$c['id_cinema']."' $selected>".htmlspecialchars($c['nama_bioskop'])."</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-secondary fw-semibold">Nama Studio</label>
                        <input type="text" name="nama_studio" class="form-control" value="<?= htmlspecialchars($s['nama_studio']); ?>" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-secondary fw-semibold">Kapasitas (Kursi)</label>
                        <input type="number" name="kapasitas" class="form-control" value="<?= $s['kapasitas']; ?>" required>
                    </div>

                    <hr class="border-secondary border-opacity-10 my-4">
                    <div class="d-flex justify-content-between">
                        <a href="studio_tampil.php" class="btn btn-secondary px-4">Batal</a>
                        <button type="submit" class="btn btn-warning px-4 fw-bold">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>