<?php
session_start();
if (empty($_SESSION['name'])) {
    header('location:login.php');
}
include('header.php');

$id = $_GET['id'];
$fetch_query = mysqli_query($connection, "select * from tbl_appointment where id='$id'");
$row = mysqli_fetch_array($fetch_query);

if (isset($_REQUEST['save-appointment'])) {
    $appointment_id = $_REQUEST['appointment_id'];
    $patient_name = $_REQUEST['patient_name'];
    $department = $_REQUEST['department'];
    $doctor = $_REQUEST['doctor'];
    $available_days = $_REQUEST['available_days'];
    $date = $_REQUEST['date'];
    $time = $_REQUEST['time'];
    $message = $_REQUEST['message'];
    $status = $_REQUEST['status'];


    $update_query = mysqli_query($connection, "update tbl_appointment set appointment_id='$appointment_id', patient_name='$patient_name', department='$department', doctor='$doctor',  available_days='$available_days', date='$date',  time='$time', message='$message', status='$status' where id='$id'");
    if ($update_query > 0) {
        $msg = "Appointment updated successfully";
        $fetch_query = mysqli_query($connection, "select * from tbl_appointment where id='$id'");
        $row = mysqli_fetch_array($fetch_query);
    } else {
        $msg = "Error!";
    }
}

?>
<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-sm-4 ">
                <h4 class="page-title">Show Appointment</h4>
            </div>
            <div class="col-sm-8  text-right m-b-20">
                <a href="appointments.php" class="btn btn-primary btn-rounded float-right">Back</a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <div class="card ">
                    <div class="card-body">
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

                        <button type="button" class="btn btn-primary" onclick="tampilkanModalJenisPembayaran()" data-bs-toggle="modal" data-bs-target="#modalJenisPembayaran">
                            Pilih Jenis Pembayaran
                        </button>

                        <div class="modal fade" id="modalJenisPembayaran" tabindex="-1" aria-labelledby="modalJenisPembayaranLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalJenisPembayaranLabel">Jenis Pembayaran</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <ul class="list-group">
                                            <li class="list-group-item">
                                                <input type="radio" name="jenisPembayaran" value="tunai" checked> Tunai
                                            </li>
                                            <li class="list-group-item">
                                                <input type="radio" name="jenisPembayaran" value="transfer"> Transfer Bank
                                            </li>
                                            <li class="list-group-item">
                                                <input type="radio" name="jenisPembayaran" value="kartu_kredit"> Kartu Kredit
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" onclick="tutupModalJenisPembayaran()">Batal</button>
                                        <button type="button" class="btn btn-primary" onclick="simpanJenisPembayaran()">Simpan</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

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

        // Untuk menampilkan modal
        function tampilkanModalJenisPembayaran() {
            var modal = document.getElementById("modalJenisPembayaran");
            modal.style.display = "block";
        }

        // Untuk menutup modal
        function tutupModalJenisPembayaran() {
            var modal = document.getElementById("modalJenisPembayaran");
            modal.style.display = "none";
        }

        // Memanggil fungsi tampilkanModalJenisPembayaran() saat tombol ditekan
        document.getElementById("myBtn").addEventListener("click", tampilkanModalJenisPembayaran);

        // Memanggil fungsi tutupModalJenisPembayaran() saat tombol close ditekan
        document.getElementsByClassName("btn-close")[0].addEventListener("click", tutupModalJenisPembayaran);

        // Memanggil fungsi tutupModalJenisPembayaran() saat area luar modal ditekan
        window.addEventListener("click", function(event) {
            if (event.target == modal) {
                tutupModalJenisPembayaran();
            }
        });
    });

    <?php
    if (isset($msg)) {
        echo 'swal("' . $msg . '");';
    }
    ?>
</script>