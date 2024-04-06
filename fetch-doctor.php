<?php
// include koneksi ke database
include('includes/connection.php');

// Ambil nilai departemen yang dipilih dari permintaan AJAX
$selected_department = $_POST['department'];

// Query untuk mengambil daftar dokter yang sesuai dengan departemen yang dipilih
$query = "SELECT CONCAT(first_name, ' ', last_name) AS name FROM tbl_employee WHERE role = 2 AND department = '$selected_department' AND status = 1";
$result = mysqli_query($connection, $query);

// Buat dropdown dokter dengan hasil query
$options = '<option value="">Select</option>';
while ($row = mysqli_fetch_assoc($result)) {
    $options .= '<option value="' . $row['name'] . '">' . $row['name'] . '</option>';
}

// Keluarkan dropdown dokter sebagai respons AJAX
echo $options;
?>
