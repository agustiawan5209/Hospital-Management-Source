<?php
// include koneksi ke database
session_start();
include('includes/connection.php');

$selected_department = $_POST['department'];
$date = $_POST['date'];
$role_id = $_SESSION['auth']['id'];
$apt_id = null;
// Add Doctor ID
if (isset($_POST['patient_id'])) {
    $role_id = $_POST['patient_id'];
}
if (isset($_POST['id'])) {
    $apt_id = $_POST['id'];
}
$code = "";
if ($date != "" && $selected_department != '') {
    // check appointment where patient_id and department
    $cekDataPengguna = mysqli_query($connection, "SELECT count(id) as jml FROM `tbl_appointment` WHERE patient_id ='" . $role_id . "' AND date = '" . $date . "' AND department LIKE '%" . $selected_department . "%' AND NOT id='$apt_id'");
    $cej = mysqli_fetch_row($cekDataPengguna);

    // if exists the message will be false;
    
    if ($cej[0] == 0) {
        $fetch_query = mysqli_query($connection, "select count(id) as jumlah from tbl_appointment where date = '" . $date . "' AND department LIKE '%" . $selected_department . "%'");
        $row = mysqli_fetch_row($fetch_query);
        if ($row[0] == 0 || $row[0] == '0') {
            $apt_id = 1;
        } else {
            $apt_id = $row[0] + 1;
        }
        $code = 'APT-' . $apt_id;
        if ($selected_department != '' && $date != '') {
            $department_code = str_split($selected_department);
            $code = 'APT-' . $department_code[0] . '-' . $apt_id;
        }
        echo json_encode([
            'msg' => true,
            'code' => $code,
        ]);
    } else {
        echo json_encode([
            'msg' => false,
            'code' => null,
        ]);
    }
}
