<?php
// include koneksi ke database
include('includes/connection.php');

// Ambil nama dokter yang dipilih dari permintaan AJAX
$selected_doctor = $_POST['doctor'];

// Query untuk mengambil jadwal dokter yang sesuai dengan nama dokter yang dipilih
$query = "SELECT available_days, start_time, end_time FROM tbl_schedule WHERE doctor_name = '$selected_doctor'";
$result = mysqli_query($connection, $query);

// Buat dropdown jadwal dokter dengan hasil query
$options = '<option value="">Select Available Days</option>';
while ($row = mysqli_fetch_assoc($result)) {
    $days = explode(", ", $row["available_days"]);
    foreach ($days as $day) {
        $options .= '<option value="' . $day . '(' . $row["start_time"] . '-' . $row["end_time"] . ')' . '">' . $day . ' (' . $row["start_time"] . '-' . $row["end_time"] . ')' . '</option>';
    }
}

// Keluarkan dropdown jadwal dokter sebagai respons AJAX
echo $options;
?>
