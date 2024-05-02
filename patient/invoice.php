<?php
session_start();
if (empty($_SESSION['name'])) {
    header('location:login.php');
}
include('header.php');

$id = $_GET['id'];
$fetch_query = mysqli_query($connection, "SELECT ta.id,ta.appointment_id, ta.patient_name, ta.patient_id, ta.doctor_id, ta.doctor, ta.department, ta.status AS ta_status, tap.status AS payment_status, ta.date, ta.time, ta.message, tap.sub_total FROM tbl_appointment AS ta INNER JOIN tbl_appointment_price AS tap ON ta.id = tap.appointment_id  where ta.id='$id'");
$row = mysqli_fetch_assoc($fetch_query);
$appointment_id = $row['appointment_id'];

function getLastId($connection)
{
    $result = mysqli_query($connection, "SELECT MAX(id) AS last_id FROM tbl_transaction;"); // Replace mysqli_query with your driver's query function

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['last_id'];
    } else {
        // Handle error or no records found
        return null;
    }
}

if (isset($_POST["submit-payment"])) {
    // Mendapatkan tanggal dan waktu saat ini
    $date = date("Ymd");
    $time = date("His");

    // Menentukan format kode transaksi
    $format = "TRX-$date-$time-";

    // Menghasilkan nomor urut transaksi
    $last_id = getLastId($connection);
    $next_id = $last_id + 1;

    // Memformat nomor urut dengan leading zeros
    $padded_id = str_pad($next_id, 4, "0", STR_PAD_LEFT);

    // Menggabungkan format dan nomor urut untuk menghasilkan kode transaksi
    $kode_transaksi = $format . $padded_id;

    // data 
    $appointment_id = $row['appointment_id'];
    $date = $row['date'];
    $sub_total = $row['sub_total'];
    $json_data = [
        'appointment_id' => $row['appointment_id'],
        'patient_name' => $row['patient_name'],
        'doctor' => $row['doctor'],
        'department' => $row['department'],
        'date' => $row['date'],
        'message' => $row['message'],
    ];
    $json_data = json_encode($json_data);
    // Menyimpan transaksi ke database

    $sql = "UPDATE  tbl_appointment_price SET `status`='FINISH' WHERE appointment_id= '$appointment_id' ";
    $sql_tr = "INSERT INTO tbl_transaction set appointment_id='$appointment_id',date = '$date',tr_code='$kode_transaksi', status='PENDING', sub_total='$sub_total', data='$json_data' ";
    $rows = mysqli_query($connection, $sql);
    $query = mysqli_query($connection, $sql_tr);

    if ($query) {
        $msg = "Data Pembayaran Berhasil Di Buat";
    } else {
    }

    // Menampilkan kode transaksi
    echo "Kode Transaksi: $kode_transaksi";
}


?>
<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-sm-4 ">
                <h4 class="page-title">Show INVOICE</h4>
            </div>
            <div class="col-sm-8  text-right m-b-20">
                <a href="appointments.php" class="btn btn-primary btn-rounded float-right">Back</a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <form action="#" class="card " method="POST" enctype="multipart/form-data">
                    <div class="card-body">
                        <?php
                        if($row['payment_status'] == 'FINISH'){
                        ?>
                        <a href="print-invoice.php?id=<?= $id ?>">
                            <button type="button" class="btn btn-primary fa-address-book" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                Print Invoice
                            </button>
                        </a>
                        <?php }?>
                        <div class="row border-bottom">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Appointment ID <span class="text-danger">*</span></label>
                                    <p>
                                        <?php echo $row['appointment_id'];  ?>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Patient Name</label>
                                    <?php
                                    $fetch_query = mysqli_query($connection, "select * from tbl_appointment where id='$id'");
                                    $row = mysqli_fetch_array($fetch_query);
                                    $pat_name = explode(",", $row['patient_name']);
                                    $pat_name = $pat_name[0];
                                    ?>
                                    <p>
                                        <?php echo $pat_name; ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="row border-bottom">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Department</label>
                                    <p>
                                        <?= $row['department'] ?>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Doctor</label>
                                    <p>
                                        <?php echo $row['doctor'];  ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="row border-bottom">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Date</label>
                                    <p>
                                        <?php echo $row['date'];  ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="row border-bottom">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Time</label>
                                    <p>
                                        <?php echo $row['time'];  ?>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Message</label>
                                    <p>
                                        <?php echo $row['message'];  ?>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Modal -->
                        <!-- Button trigger modal -->

                        <?php
                        $tbl_price = mysqli_query($connection, "SELECT * FROM tbl_price where doctor_id = " . $row['doctor_id']);
                        $tbl_prices = mysqli_fetch_assoc($tbl_price);

                        $tbl_tr = mysqli_query($connection, "SELECT * FROM tbl_transaction where appointment_id ='$appointment_id' LIMIT 1 ");
                        $count_tbl_tr = mysqli_num_rows($tbl_tr);
                        $data_tbl_tr = mysqli_fetch_assoc($tbl_tr);
                        if ($count_tbl_tr < 1) {
                        ?>

                            <button type="button" class="btn btn-primary fa-address-book" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                Paid Appointment With Scan QR Code
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h3 class="modal-title fs-3" style="text-transform: capitalize;" id="exampleModalLabel">scan qr code to continue payment</h3>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <img style="width: 100%;" src="<?= BASE_URL . "/assets/uploads/" . $tbl_prices['file'] ?>" alt="QR CODE">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" name="submit-payment" class="btn btn-primary">confirm payment</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <?php } else {
                            $status = 'red';
                            if ($data_tbl_tr['status'] == 'PENDING') {
                                $status = 'red';
                            }
                            if ($data_tbl_tr['status'] == 'FINISH') {
                                $status = 'green';
                            }
                            if ($data_tbl_tr['status'] == 'FAILED') {
                                $status = 'yellow';
                            }
                        ?>
                            <ul class="list-group list-group-horizontal">
                                <li class="list-group-item">Transaction Code : <?= $data_tbl_tr['tr_code'] ?></li>
                                <li class="list-group-item">sub-total transactions: <?= $data_tbl_tr['sub_total'] ?></li>
                                <li class="list-group-item">Transactions Date: <?= $data_tbl_tr['date'] ?></li>


                                <li class="list-group-item">Transactions status:
                                    <span class="custom-badge status-<?= $status ?>"><?= $data_tbl_tr['status'] ?></span>
                                </li>
                            </ul>
                        <?php } ?>
                    </div>
                </form>

            </div>

        </div>
    </div>
</div>

<?php
include('footer.php');
?>
<script type="text/javascript">
    $(document).ready(function() {
        $('#department').change(function() {
            var selected_department = $(this).val();
            $.ajax({
                type: "POST",
                url: "fetch-doctor.php",
                data: {
                    department: selected_department
                },
                cache: false,
                success: function(response) {
                    $('#doctor').html(response);
                }
            });
        });
        $('#doctor').change(function() {
            var selected_doctor = $(this).val();
            $.ajax({
                type: "POST",
                url: "fetch-schedule.php",
                data: {
                    doctor: selected_doctor
                },
                cache: false,
                success: function(response) {
                    $('#available_days').html(response);
                }
            });
        });


    });

    <?php
    if (isset($msg)) {
        echo 'swal({
            icon: "success",
            title: "success",
            text: "' . $msg . '",
        });';
    }
    ?>
</script>