<?php
// include koneksi ke database
include('includes/connection.php');

$id = $_POST['id'];

$query = "SELECT * FROM tbl_patient WHERE  id = '$id' ";
$result = mysqli_query($connection, $query);

if(mysqli_num_rows($result) > 0){
    echo json_encode([
        "status"=> true,
        'data'=> mysqli_fetch_assoc($result),
    ]);
}else{
    echo json_encode([
        "status"=> false,
        'data'=> [],
    ]);
}
?>
