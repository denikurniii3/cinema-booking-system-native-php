<?php include 'koneksi.php'; include 'header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold m-0"><i class="bi bi-geo-alt-fill text-danger me-2"></i> Lokasi Bioskop</h3>
    <a href="cinema_tambah.php" class="btn btn-primary shadow-sm">
        <i class="bi bi-plus-circle me-1"></i> Tambah Bioskop Baru
    </a>
</div>

<div class="card border-0 shadow-lg">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th width="80">No</th>
                        <th>Nama Bioskop</th>
                        <th>Alamat / Detail Lokasi</th>
                        <th width="200" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $data = mysqli_query($conn, "SELECT * FROM cinemas ORDER BY id_cinema DESC");
                    if(mysqli_num_rows($data) == 0){
                        echo "<tr><td colspan='4' class='text-center py-5 text-secondary'>Belum ada lokasi bioskop yang ditambahkan.</td></tr>";
                    }
                    while($d = mysqli_fetch_array($data)){
                    ?>
                    <tr>
                        <td class="fw-bold text-secondary"><?= $no++; ?></td>
                        <td class="fw-bold text-light fs-5">
                            <i class="bi bi-building text-danger me-2"></i><?= htmlspecialchars($d['nama_bioskop']); ?>
                        </td>
                        <td class="text-secondary"><?= nl2br(htmlspecialchars($d['alamat'] ?? '')); ?></td>
                        <td class="text-center">
                            <div class="d-inline-flex gap-2">
                                <a href="cinema_edit.php?id=<?= $d['id_cinema']; ?>" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil-square me-1"></i>Edit
                                </a>
                                <a href="cinema_aksi.php?act=hapus&id=<?= $d['id_cinema']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus bioskop ini beserta semua studionya?')">
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