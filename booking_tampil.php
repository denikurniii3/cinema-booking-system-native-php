<?php include 'koneksi.php'; include 'header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold m-0"><i class="bi bi-ticket-perforated text-danger me-2"></i> Riwayat Pemesanan Tiket</h3>
    <a href="booking_tambah.php" class="btn btn-success fw-bold">
        <i class="bi bi-plus-circle me-1"></i> Beli Tiket Baru
    </a>
</div>

<div class="card border-0 shadow-lg">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th width="60">No</th>
                        <th>Nama Pemesan</th>
                        <th>Film & Bioskop</th>
                        <th>Nomor Kursi</th>
                        <th>Tiket</th>
                        <th>Total Bayar</th>
                        <th>Waktu Transaksi</th>
                        <th width="180" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $sql = "SELECT b.*, m.judul, c.nama_bioskop, s.jam_tayang, s.tanggal_tayang 
                            FROM bookings b
                            JOIN schedules s ON b.id_schedule = s.id_schedule
                            JOIN movies m ON s.id_movie = m.id_movie
                            JOIN studios st ON s.id_studio = st.id_studio
                            JOIN cinemas c ON st.id_cinema = c.id_cinema
                            ORDER BY b.id_booking DESC";
                    
                    $data = mysqli_query($conn, $sql);
                    if(mysqli_num_rows($data) == 0){
                        echo "<tr><td colspan='8' class='text-center py-5 text-secondary'>Belum ada transaksi pemesanan tiket.</td></tr>";
                    }
                    while($d = mysqli_fetch_array($data)){
                        $date_fmt = date('d M Y', strtotime($d['tanggal_tayang']));
                        $time_fmt = date('H:i', strtotime($d['jam_tayang']));
                    ?>
                    <tr>
                        <td class="fw-bold text-secondary"><?= $no++; ?></td>
                        <td class="fw-bold text-light"><?= htmlspecialchars($d['nama_pemesan']); ?></td>
                        <td>
                            <strong class="text-danger d-block fs-6"><?= htmlspecialchars($d['judul']); ?></strong>
                            <small class="text-secondary"><?= htmlspecialchars($d['nama_bioskop']); ?> (<?= $date_fmt ?> <?= $time_fmt ?>)</small>
                        </td>
                        <td>
                            <span class="badge bg-info text-dark">
                                <i class="bi bi-grid-fill me-1"></i><?= htmlspecialchars($d['no_kursi'] ?: '-'); ?>
                            </span>
                        </td>
                        <td class="text-secondary fw-semibold"><?= htmlspecialchars($d['jumlah_tiket']); ?> Kursi</td>
                        <td class="text-success fw-bold">Rp <?= number_format($d['total_bayar'], 0, ',', '.'); ?></td>
                        <td class="text-secondary"><small><?= date('d M Y H:i', strtotime($d['tanggal_pesan'])); ?></small></td>
                        <td class="text-center">
                            <div class="d-inline-flex gap-2">
                                <a href="booking_edit.php?id=<?= $d['id_booking']; ?>" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil-square me-1"></i>Edit
                                </a>
                                <a href="booking_aksi.php?act=hapus&id=<?= $d['id_booking']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Batalkan pesanan tiket ini?')">
                                    <i class="bi bi-trash-fill me-1"></i>Batal
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