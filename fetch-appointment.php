<?php
// include koneksi ke database
include('includes/connection.php');

$apt_id = $_POST['apt_id'];

$query = "SELECT * FROM tbl_appointment WHERE  id = '$apt_id' ";
$result = mysqli_query($connection, $query);

if(mysqli_num_rows($result) > 0){
    echo json_encode([
        "status"=> true,
        'data'=> mysqli_fetch_assoc($result),
    ]);
}else{
    echo json_encode([
        "status"=> true,
        'data'=> [],
    ]);
}
?>
