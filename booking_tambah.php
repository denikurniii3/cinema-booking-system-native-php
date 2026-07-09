<?php include 'koneksi.php'; include 'header.php'; ?>

<div class="row g-4">
    <!-- Form Pemesanan (Left Column) -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-lg h-100">
            <div class="card-header bg-success text-white py-3 text-center">
                <h5 class="mb-0 fw-bold"><i class="bi bi-ticket-perforated-fill me-2"></i>Beli Tiket Bioskop</h5>
            </div>
            <div class="card-body p-4">
                <form action="booking_aksi.php?act=tambah" method="post" id="formBooking">
                    <!-- Data Input -->
                    <div class="mb-4">
                        <label class="form-label text-secondary fw-semibold">Pilih Jadwal Tayang</label>
                        <select name="id_schedule" id="id_schedule" class="form-select" required>
                            <option value="">-- Pilih Film & Lokasi --</option>
                            <?php 
                            $s_sql = "SELECT s.id_schedule, m.judul, c.nama_bioskop, st.nama_studio, s.harga_tiket, s.tanggal_tayang, s.jam_tayang
                                      FROM schedules s 
                                      JOIN movies m ON s.id_movie = m.id_movie
                                      JOIN studios st ON s.id_studio = st.id_studio
                                      JOIN cinemas c ON st.id_cinema = c.id_cinema
                                      ORDER BY s.tanggal_tayang DESC, s.jam_tayang ASC";
                            $s_data = mysqli_query($conn, $s_sql);
                            while($s = mysqli_fetch_array($s_data)){
                                $date_fmt = date('d M Y', strtotime($s['tanggal_tayang']));
                                $time_fmt = date('H:i', strtotime($s['jam_tayang']));
                                echo "<option value='$s[id_schedule]'>$s[judul] - $s[nama_bioskop] ($s[nama_studio]) | $date_fmt $time_fmt</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-secondary fw-semibold">Nama Pemesan</label>
                        <input type="text" name="nama" class="form-control" placeholder="Masukkan nama lengkap" required>
                    </div>

                    <!-- Readonly / Dynamic Info fields -->
                    <div class="booking-summary-box d-none" id="summaryBox">
                        <div class="mb-3">
                            <span class="text-secondary small d-block">Kursi yang Dipilih:</span>
                            <span class="fw-bold text-warning fs-5" id="displaySeats">-</span>
                            <input type="hidden" name="no_kursi" id="inputSeats" required>
                        </div>
                        <div class="row">
                            <div class="col-6 mb-3">
                                <span class="text-secondary small d-block">Jumlah Tiket:</span>
                                <input type="number" name="jumlah" id="inputJumlah" class="form-control bg-dark border-0 p-1 text-center fw-bold fs-5 text-light" readonly value="0">
                            </div>
                            <div class="col-6 mb-3">
                                <span class="text-secondary small d-block">Harga per Tiket:</span>
                                <span class="fw-bold text-light fs-6" id="displayHarga">Rp 0</span>
                            </div>
                        </div>
                        <hr class="my-2">
                        <div class="d-flex justify-content-between align-items-center mt-2">
                            <span class="fw-bold text-secondary">Total Bayar:</span>
                            <span class="fw-bold text-success fs-4" id="displayTotal">Rp 0</span>
                        </div>
                    </div>

                    <div id="btnContainer" class="mt-4 d-none">
                        <button type="submit" class="btn btn-success btn-lg w-100 shadow fw-bold">
                            <i class="bi bi-check2-circle me-1"></i>KONFIRMASI PESANAN
                        </button>
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
            <div class="card-body d-flex flex-column justify-content-center align-items-center p-4 min-h-350">
                <!-- Fallback / Placeholder sebelum pilih jadwal -->
                <div id="seatMapPlaceholder" class="text-center text-secondary py-5">
                    <i class="bi bi-info-circle-fill display-4 text-secondary opacity-25 mb-3"></i>
                    <p class="m-0">Silakan pilih jadwal tayang terlebih dahulu untuk memuat ketersediaan kursi bioskop.</p>
                </div>

                <!-- Seat Map Container (hidden initially) -->
                <div id="seatMapWrapper" class="w-100 d-none">
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
let ticketPrice = 0;
let selectedSeats = [];

document.getElementById('id_schedule').addEventListener('change', function() {
    const scheduleId = this.value;
    const placeholder = document.getElementById('seatMapPlaceholder');
    const wrapper = document.getElementById('seatMapWrapper');
    const summary = document.getElementById('summaryBox');
    const btn = document.getElementById('btnContainer');

    if (!scheduleId) {
        placeholder.classList.remove('d-none');
        wrapper.classList.add('d-none');
        summary.classList.add('d-none');
        btn.classList.add('d-none');
        return;
    }

    // Ambil data detail jadwal via AJAX
    fetch(`get_schedule_details.php?id_schedule=${scheduleId}`)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                alert(data.error);
                return;
            }

            ticketPrice = data.harga_tiket;
            document.getElementById('displayHarga').innerText = 'Rp ' + ticketPrice.toLocaleString('id-ID');

            // Render peta kursi berdasarkan kapasitas & kursi terpesan
            renderSeatMap(data.kapasitas, data.booked_seats);

            placeholder.classList.add('d-none');
            wrapper.classList.remove('d-none');
            summary.classList.remove('d-none');
            btn.classList.remove('d-none');
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
            
            if (bookedSeats.includes(seatId)) {
                seatDiv.classList.add('booked');
            } else {
                seatDiv.addEventListener('click', function() {
                    toggleSeat(seatDiv, seatId);
                });
            }
            
            rowDiv.appendChild(seatDiv);
        }
        
        seatGrid.appendChild(rowDiv);
    }
    
    selectedSeats = [];
    updateSummary();
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