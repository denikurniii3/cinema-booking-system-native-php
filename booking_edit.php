<?php 
include 'koneksi.php'; 
include 'header.php'; 
$id = $_GET['id'];
// Fetch booking details along with schedule details
$sql = "SELECT b.*, s.id_schedule, s.harga_tiket, m.judul, c.nama_bioskop, st.nama_studio
        FROM bookings b
        JOIN schedules s ON b.id_schedule = s.id_schedule
        JOIN movies m ON s.id_movie = m.id_movie
        JOIN studios st ON s.id_studio = st.id_studio
        JOIN cinemas c ON st.id_cinema = c.id_cinema
        WHERE b.id_booking = '$id'";
$data = mysqli_query($conn, $sql);
$b = mysqli_fetch_array($data);
?>

<div class="row g-4">
    <!-- Form Pemesanan (Left Column) -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-lg h-100">
            <div class="card-header bg-warning py-3 text-center">
                <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-pencil-square me-2"></i>Edit Pesanan Tiket</h5>
            </div>
            <div class="card-body p-4">
                <form action="booking_aksi.php?act=edit" method="post" id="formBooking">
                    <input type="hidden" name="id_booking" value="<?= $b['id_booking']; ?>">
                    <input type="hidden" name="id_schedule" value="<?= $b['id_schedule']; ?>">
                    
                    <div class="mb-4">
                        <label class="form-label text-secondary fw-semibold">Film & Lokasi</label>
                        <input type="text" class="form-control bg-dark border-0 text-light opacity-75" 
                               value="<?= htmlspecialchars($b['judul']); ?> - <?= htmlspecialchars($b['nama_bioskop']); ?>" readonly>
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-secondary fw-semibold">Nama Pemesan</label>
                        <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($b['nama_pemesan']); ?>" required>
                    </div>

                    <!-- Dynamic summary box -->
                    <div class="booking-summary-box" id="summaryBox">
                        <div class="mb-3">
                            <span class="text-secondary small d-block">Kursi yang Dipilih:</span>
                            <span class="fw-bold text-warning fs-5" id="displaySeats"><?= htmlspecialchars($b['no_kursi']); ?></span>
                            <input type="hidden" name="no_kursi" id="inputSeats" value="<?= htmlspecialchars($b['no_kursi']); ?>" required>
                        </div>
                        <div class="row">
                            <div class="col-6 mb-3">
                                <span class="text-secondary small d-block">Jumlah Tiket:</span>
                                <input type="number" name="jumlah" id="inputJumlah" class="form-control bg-dark border-0 p-1 text-center fw-bold fs-5 text-light" readonly value="<?= $b['jumlah_tiket']; ?>">
                            </div>
                            <div class="col-6 mb-3">
                                <span class="text-secondary small d-block">Harga per Tiket:</span>
                                <span class="fw-bold text-light fs-6" id="displayHarga">Rp <?= number_format($b['harga_tiket'], 0, ',', '.'); ?></span>
                            </div>
                        </div>
                        <hr class="my-2">
                        <div class="d-flex justify-content-between align-items-center mt-2">
                            <span class="fw-bold text-secondary">Total Bayar:</span>
                            <span class="fw-bold text-success fs-4" id="displayTotal">Rp <?= number_format($b['total_bayar'], 0, ',', '.'); ?></span>
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <a href="booking_tampil.php" class="btn btn-secondary w-50">Batal</a>
                        <button type="submit" class="btn btn-warning w-50 fw-bold text-dark">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Peta Kursi (Right Column) -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-lg h-100">
            <div class="card-header bg-dark text-white py-3 text-center border-bottom border-secondary border-opacity-10">
                <h5 class="mb-0 fw-bold"><i class="bi bi-grid-3x3-gap-fill text-danger me-2"></i>Peta Kursi Bioskop</h5>
            </div>
            <div class="card-body d-flex flex-column justify-content-center align-items-center p-4">
                <div id="seatMapWrapper" class="w-100">
                    <!-- Visual Layar Bioskop -->
                    <div class="screen"></div>
                    <div class="screen-label text-center">LAYAR BIOSKOP</div>

                    <!-- Grid Kursi -->
                    <div class="seat-grid" id="seatGrid"></div>

                    <!-- Legend Kursi -->
                    <div class="seat-legend">
                        <div class="legend-item">
                            <div class="seat"></div>
                            <span>Tersedia</span>
                        </div>
                        <div class="legend-item">
                            <div class="seat selected"></div>
                            <span>Pilihan Anda</span>
                        </div>
                        <div class="legend-item">
                            <div class="seat booked"></div>
                            <span>Sudah Dipesan</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
const bookingId = <?= $b['id_booking']; ?>;
const scheduleId = <?= $b['id_schedule']; ?>;
let ticketPrice = <?= $b['harga_tiket']; ?>;
// Inisialisasi kursi yang sudah dipilih saat ini
let selectedSeats = <?= json_encode(array_filter(array_map('trim', explode(',', $b['no_kursi'])))); ?>;

window.addEventListener('DOMContentLoaded', () => {
    // Ambil data detail jadwal via AJAX, kirimkan bookingId agar kursi milik sendiri tidak dikunci merah
    fetch(`get_schedule_details.php?id_schedule=${scheduleId}&current_booking_id=${bookingId}`)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                alert(data.error);
                return;
            }

            ticketPrice = data.harga_tiket;
            // Render peta kursi berdasarkan kapasitas & kursi terpesan
            renderSeatMap(data.kapasitas, data.booked_seats);
        })
        .catch(err => {
            console.error('Gagal mengambil data kursi:', err);
            alert('Terjadi kesalahan saat memuat peta kursi.');
        });
});

function renderSeatMap(capacity, bookedSeats) {
    const seatGrid = document.getElementById('seatGrid');
    seatGrid.innerHTML = '';
    
    const cols = 10;
    const rows = Math.ceil(capacity / cols);
    let seatCount = 0;
    
    const rowLabels = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L'];
    
    for (let r = 0; r < rows; r++) {
        const rowDiv = document.createElement('div');
        rowDiv.className = 'seat-row';
        
        // Row label (e.g. A, B, C...)
        const labelSpan = document.createElement('span');
        labelSpan.className = 'seat-row-label';
        labelSpan.innerText = rowLabels[r] || `R${r+1}`;
        rowDiv.appendChild(labelSpan);
        
        for (let c = 1; c <= cols; c++) {
            seatCount++;
            if (seatCount > capacity) break;
            
            const seatId = `${rowLabels[r] || 'Row' + (r+1)}${c}`;
            
            const seatDiv = document.createElement('div');
            seatDiv.className = 'seat';
            seatDiv.innerText = seatId;
            seatDiv.dataset.seatId = seatId;
            
            // Check if it's already booked by someone else
            if (bookedSeats.includes(seatId)) {
                seatDiv.classList.add('booked');
            } else {
                // If it is in the current selection, highlight in green
                if (selectedSeats.includes(seatId)) {
                    seatDiv.classList.add('selected');
                }
                
                seatDiv.addEventListener('click', function() {
                    toggleSeat(seatDiv, seatId);
                });
            }
            
            rowDiv.appendChild(seatDiv);
        }
        
        seatGrid.appendChild(rowDiv);
    }
}

function toggleSeat(seatElement, seatId) {
    if (seatElement.classList.contains('selected')) {
        seatElement.classList.remove('selected');
        selectedSeats = selectedSeats.filter(s => s !== seatId);
    } else {
        seatElement.classList.add('selected');
        selectedSeats.push(seatId);
    }
    updateSummary();
}

function updateSummary() {
    // Tampilkan daftar kursi terpilih
    const seatDisplay = selectedSeats.length > 0 ? selectedSeats.join(', ') : '-';
    document.getElementById('displaySeats').innerText = seatDisplay;
    document.getElementById('inputSeats').value = selectedSeats.join(',');
    
    // Tampilkan jumlah tiket
    document.getElementById('inputJumlah').value = selectedSeats.length;
    
    // Hitung total bayar
    const totalPay = selectedSeats.length * ticketPrice;
    document.getElementById('displayTotal').innerText = 'Rp ' + totalPay.toLocaleString('id-ID');
}

// Validasi sebelum kirim: minimal pilih 1 kursi
document.getElementById('formBooking').addEventListener('submit', function(e) {
    if (selectedSeats.length === 0) {
        e.preventDefault();
        alert('Silakan pilih minimal 1 kursi bioskop sebelum melanjutkan!');
    }
});
</script>

<?php include 'footer.php'; ?>