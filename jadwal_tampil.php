<?php include 'koneksi.php'; include 'header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold m-0"><i class="bi bi-calendar-event text-danger me-2"></i> Jadwal Tayang Film</h3>
    <a href="jadwal_tambah.php" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i> Tambah Jadwal Baru
    </a>
</div>

<div class="card border-0 shadow-lg">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th width="80">No</th>
                        <th>Film</th>
                        <th>Bioskop & Studio</th>
                        <th>Tanggal & Jam</th>
                        <th>Harga Tiket</th>
                        <th width="200" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $sql = "SELECT s.*, m.judul, st.nama_studio, c.nama_bioskop 
                            FROM schedules s
                            JOIN movies m ON s.id_movie = m.id_movie
                            JOIN studios st ON s.id_studio = st.id_studio
                            JOIN cinemas c ON st.id_cinema = c.id_cinema
                            ORDER BY s.tanggal_tayang DESC, s.jam_tayang ASC";
                    
                    $data = mysqli_query($conn, $sql);
                    if(mysqli_num_rows($data) == 0){
                        echo "<tr><td colspan='6' class='text-center py-5 text-secondary'>Belum ada jadwal tayang yang diatur.</td></tr>";
                    }
                    while($d = mysqli_fetch_array($data)){
                    ?>
                    <tr>
                        <td class="fw-bold text-secondary"><?= $no++; ?></td>
                        <td class="fw-bold text-light fs-5">
                            <i class="bi bi-film text-danger me-2"></i><?= htmlspecialchars($d['judul']); ?>
                        </td>
                        <td>
                            <span class="d-block fw-bold text-light"><?= htmlspecialchars($d['nama_bioskop']); ?></span>
                            <small class="text-secondary"><i class="bi bi-door-closed me-1"></i><?= htmlspecialchars($d['nama_studio']); ?></small>
                        </td>
                        <td>
                            <span class="badge bg-info text-dark mb-1">
                                <i class="bi bi-calendar3 me-1"></i><?= date('d M Y', strtotime($d['tanggal_tayang'])); ?>
                            </span><br>
                            <span class="badge bg-secondary">
                                <i class="bi bi-clock me-1"></i><?= date('H:i', strtotime($d['jam_tayang'])); ?> WIB
                            </span>
                        </td>
                        <td class="fw-bold text-success">
                            Rp <?= number_format($d['harga_tiket'], 0, ',', '.'); ?>
                        </td>
                        <td class="text-center">
                            <div class="d-inline-flex gap-2">
                                <a href="jadwal_edit.php?id=<?= $d['id_schedule']; ?>" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil-square me-1"></i>Edit
                                </a>
                                <a href="jadwal_aksi.php?act=hapus&id=<?= $d['id_schedule']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus jadwal ini?')">
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