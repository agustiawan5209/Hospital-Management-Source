<?php
// include koneksi ke database
include('includes/connection.php');

// Ambil nama dokter yang dipilih dari permintaan AJAX
$doctor_id = $_POST['doctor'];

// Query untuk mengambil jadwal dokter yang sesuai dengan nama dokter yang dipilih
$query = "SELECT available_days, start_time, end_time,sesi FROM tbl_schedule WHERE doctor_id = '$doctor_id'";
$result = mysqli_query($connection, $query);

$tbl_appointment_ = mysqli_query( $connection,"SELECT id,doctor_id FROM tbl_appointment WHERE doctor_id='$doctor_id'");
$appointment_count = mysqli_num_rows($tbl_appointment_);

// Buat dropdown jadwal dokter dengan hasil query
$msg = [
    'status'=> true,
    'options'=> '<option value="">Select Available Days</option>',
];
while ($row = mysqli_fetch_assoc($result)) {
    if(isset($row)){
        if($appointment_count < $row['sesi']){
            $days = explode(", ", $row["available_days"]);
            foreach ($days as $day) {
                $msg['options'] .= '<option value="' . $day . '(' . $row["start_time"] . '-' . $row["end_time"] . ')' . '">' . $day . ' (' . $row["start_time"] . '-' . $row["end_time"] . ')' . '</option>';
            }
            $msg['status'] = true;
        }else{
            $msg['status'] = false;
        }
    }
}

// Keluarkan dropdown jadwal dokter sebagai respons AJAX
echo json_encode($msg);
?>
