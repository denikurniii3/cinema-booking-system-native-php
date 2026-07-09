<?php 
include 'koneksi.php'; 
include 'header.php'; 
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold m-0"><i class="bi bi-film text-danger me-2"></i> Daftar Film</h3>
    <a href="movie_tambah.php" class="btn btn-primary shadow-sm">
        <i class="bi bi-plus-circle me-1"></i> Tambah Film Baru
    </a>
</div>

<?php if(isset($_GET['pesan'])): ?>
    <div class="alert alert-success alert-dismissible fade show border-0 bg-success bg-opacity-10 text-success mb-4" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>
        <?php 
        if($_GET['pesan'] == 'berhasil_tambah') echo "Film baru berhasil ditambahkan!";
        elseif($_GET['pesan'] == 'berhasil_update') echo "Data film berhasil diperbarui!";
        elseif($_GET['pesan'] == 'berhasil_hapus') echo "Film berhasil dihapus!";
        ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="card border-0 shadow-lg">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th width="80">No</th>
                        <th width="100">Poster</th>
                        <th>Judul Film</th>
                        <th>Genre</th>
                        <th>Durasi (Menit)</th>
                        <th>Rating</th>
                        <th width="200" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $data = mysqli_query($conn, "SELECT * FROM movies ORDER BY id_movie DESC");
                    if(mysqli_num_rows($data) == 0){
                        echo "<tr><td colspan='7' class='text-center py-5 text-secondary'>Belum ada film yang didaftarkan.</td></tr>";
                    }
                    while($d = mysqli_fetch_array($data)){
                        $poster_url = !empty($d['poster']) ? $d['poster'] : 'https://placehold.co/100x150/18181f/fff?text=No+Poster';
                    ?>
                    <tr>
                        <td class="fw-bold text-secondary"><?= $no++; ?></td>
                        <td>
                            <img src="<?= htmlspecialchars($poster_url); ?>" alt="Poster" 
                                 class="rounded border border-secondary border-opacity-25" 
                                 style="width: 50px; height: 75px; object-fit: cover;"
                                 onerror="this.src='https://placehold.co/100x150/18181f/fff?text=No+Poster'">
                        </td>
                        <td class="fw-bold text-primary fs-5"><?= htmlspecialchars($d['judul']); ?></td>
                        <td class="text-light"><?= htmlspecialchars($d['genre']); ?></td>
                        <td class="text-secondary fw-semibold">
                            <i class="bi bi-clock text-muted me-2"></i><?= htmlspecialchars($d['durasi']); ?> Menit
                        </td>
                        <td>
                            <span class="badge bg-secondary"><?= htmlspecialchars($d['rating']); ?></span>
                        </td>
                        <td class="text-center">
                            <div class="d-inline-flex gap-2">
                                <a href="movie_edit.php?id=<?= $d['id_movie']; ?>" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil-square me-1"></i>Edit
                                </a>
                                <a href="movie_aksi.php?act=hapus&id=<?= $d['id_movie']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus film ini?')">
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