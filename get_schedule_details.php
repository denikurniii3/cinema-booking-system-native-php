<?php
header('Content-Type: application/json');
include 'koneksi.php';

$id_schedule = isset($_GET['id_schedule']) ? intval($_GET['id_schedule']) : 0;
$current_booking_id = isset($_GET['current_booking_id']) ? intval($_GET['current_booking_id']) : 0;

if ($id_schedule <= 0) {
    echo json_encode(['error' => 'ID Jadwal tidak valid']);
    exit;
}

// 1. Ambil harga tiket & kapasitas studio
$q = "SELECT s.harga_tiket, st.kapasitas 
      FROM schedules s 
      JOIN studios st ON s.id_studio = st.id_studio 
      WHERE s.id_schedule = '$id_schedule'";
$res = mysqli_query($conn, $q);
$detail = mysqli_fetch_assoc($res);

if (!$detail) {
    echo json_encode(['error' => 'Jadwal tidak ditemukan']);
    exit;
}

// 2. Ambil semua kursi yang sudah dibooking untuk jadwal ini
// Kecuali booking milik pemesan sendiri jika sedang diedit
$q_booked = "SELECT no_kursi FROM bookings WHERE id_schedule = '$id_schedule'";
if ($current_booking_id > 0) {
    $q_booked .= " AND id_booking != '$current_booking_id'";
}
$res_booked = mysqli_query($conn, $q_booked);

$booked_seats = [];
while ($row = mysqli_fetch_assoc($res_booked)) {
    if (!empty($row['no_kursi'])) {
        $seats = explode(',', $row['no_kursi']);
        foreach ($seats as $seat) {
            $cleaned = trim($seat);
            if (!empty($cleaned)) {
                $booked_seats[] = $cleaned;
            }
        }
    }
}

// Kembalikan response JSON
echo json_encode([
    'harga_tiket' => (int)$detail['harga_tiket'],
    'kapasitas'   => (int)$detail['kapasitas'],
    'booked_seats'=> array_values(array_unique($booked_seats))
]);
?>
