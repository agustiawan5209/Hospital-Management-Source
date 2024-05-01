<?php

session_start();
if (empty($_SESSION['name'])) {
    header('location:login.php');
}
include('header.php');
include('includes/connection.php');

$id = $_GET['ids'];
$fetch_query = mysqli_query($connection, "select * from tbl_transaction where id='$id'");
$row = mysqli_fetch_array($fetch_query);



if (isset($_POST['confirm-update'])) {
    // Data yang akan diubah
    // Query untuk update status pembayaran
    $sql = "UPDATE tbl_transaction SET status = 'FINISH' WHERE id = $id";

    mysqli_query($connection, $sql);
    $sql = "UPDATE tbl_appointment_price SET status = 'FINISH' WHERE appointment_id = '" . $row['appointment_id'] . "'";

    if (mysqli_query($connection, $sql) === TRUE) {
        $msg = "Record updated successfully";
?>
        <script>
            window.location.href = 'transaction.php'
        </script>
<?php
    } else {
        $msg = "Error updating record";
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
                <form action="#" class="card " method="POST" enctype="multipart/form-data">
                    <div class="card-body">
                        <div class="row border-bottom">
                            <div class="col-md-6">
                                <div class="form-group">

                                    <button type="button" class="btn btn-primary fa-address-book" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                        Confirm Transaction
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h3 class="modal-title fs-3" style="text-transform: capitalize;" id="exampleModalLabel">Confirm Transaction</h3>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Are You Sure for confirmation payment Appointment Finish?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" name="confirm-update" class="btn btn-primary">confirm payment</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row border-bottom">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Transaction Code</label>

                                    <p>
                                        <?= $row['tr_code'] ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="row border-bottom">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Appointment-ID</label>
                                    <p>
                                        <?= $row['appointment_id'] ?>
                                    </p>
                                </div>
                            </div>
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
                                    <label>Status</label>
                                    <p>
                                        <?php
                                        $status = 'red';
                                        if ($row['status'] == 'PENDING') {
                                            $status = 'red';
                                        }
                                        if ($row['status'] == 'FINISH') {
                                            $status = 'green';
                                        }
                                        if ($row['status'] == 'FAILED') {
                                            $status = 'yellow';
                                        }
                                        echo "<span class='custom-badge status-" . $status . "'> " . $row['status'] . " </span>" ?>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Sub Total</label>
                                    <p>
                                        <?php echo $row['sub_total'];  ?>
                                    </p>
                                </div>
                            </div>
                        </div>


                        <?php
                        $data = json_decode($row['data'], true);
                        ?>
                        <div class="row border-bottom">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label style="text-transform: uppercase; font-weight: 700;">Detail Appointment</label>
                                </div>
                            </div>
                        </div>
                        <div class="row border-bottom">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Appointment ID <span class="text-danger">*</span></label>
                                    <p>
                                        <?php echo $data['appointment_id'];  ?>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Patient Name</label>
                                    <p>
                                        <?php echo $data['patient_name']; ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="row border-bottom">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Department</label>
                                    <p>
                                        <?= $data['department'] ?>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Doctor</label>
                                    <p>
                                        <?php echo $data['doctor'];  ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="row border-bottom">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Date</label>
                                    <p>
                                        <?php echo $data['date'];  ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="row border-bottom">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Message</label>
                                    <p>
                                        <?php echo $data['message'];  ?>
                                    </p>
                                </div>
                            </div>
                        </div>
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