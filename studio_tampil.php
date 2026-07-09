<?php include 'koneksi.php'; include 'header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold m-0"><i class="bi bi-display text-danger me-2"></i> Studio Bioskop</h3>
    <a href="studio_tambah.php" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i> Tambah Studio Baru
    </a>
</div>

<div class="card border-0 shadow-lg">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th width="80">No</th>
                        <th>Nama Studio</th>
                        <th>Lokasi Bioskop</th>
                        <th>Kapasitas Kursi</th>
                        <th width="200" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $sql = "SELECT studios.*, cinemas.nama_bioskop FROM studios 
                            JOIN cinemas ON studios.id_cinema = cinemas.id_cinema
                            ORDER BY studios.id_studio DESC";
                    $data = mysqli_query($conn, $sql);
                    if(mysqli_num_rows($data) == 0){
                        echo "<tr><td colspan='5' class='text-center py-5 text-secondary'>Belum ada studio yang ditambahkan.</td></tr>";
                    }
                    while($d = mysqli_fetch_array($data)){
                    ?>
                    <tr>
                        <td class="fw-bold text-secondary"><?= $no++; ?></td>
                        <td class="fw-bold text-light fs-5">
                            <i class="bi bi-door-closed text-danger me-2"></i><?= htmlspecialchars($d['nama_studio']); ?>
                        </td>
                        <td>
                            <span class="badge bg-info text-dark">
                                <i class="bi bi-geo-alt me-1"></i><?= htmlspecialchars($d['nama_bioskop']); ?>
                            </span>
                        </td>
                        <td class="text-secondary fw-semibold">
                            <i class="bi bi-grid-3x3-gap-fill text-muted me-2"></i><?= htmlspecialchars($d['kapasitas']); ?> Kursi
                        </td>
                        <td class="text-center">
                            <div class="d-inline-flex gap-2">
                                <a href="studio_edit.php?id=<?= $d['id_studio']; ?>" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil-square me-1"></i>Edit
                                </a>
                                <a href="studio_aksi.php?act=hapus&id=<?= $d['id_studio']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus studio ini?')">
                                    <i class="bi bi-trash-fill me-1"></i>Hapus
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>