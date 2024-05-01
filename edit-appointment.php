<?php
session_start();
if (empty($_SESSION['name'])) {
    header('location:login.php');
}
include('header.php');
include('includes/connection.php');

$id = $_GET['id'];
$fetch_query = mysqli_query($connection, "select * from tbl_appointment where id='$id'");
$row = mysqli_fetch_array($fetch_query);


$name = explode(",", $row['patient_name']);
$name = $name[0];

$age = explode(",", $row['patient_name']);
$age = $age[1] ?? null;

$date = str_replace('/', '-', $age);
$dob = date('Y/m/d', strtotime($date));

if (isset($_REQUEST['save-appointment'])) {
    $appointment_id = $_REQUEST['appointment_id'];
    $dob = $_REQUEST['dob'];
    $patient_name = $_REQUEST['patient_name'] . "," . $dob;
    $department = $_REQUEST['department'];
    $doctor = $_REQUEST['doctor'];
    $available_days = $_REQUEST['available_days'];
    $date = $_REQUEST['date'];
    $time = $_REQUEST['time'];
    $message = $_REQUEST['message'];
    $status = $_REQUEST['status'];


    try {
        $update_query = mysqli_query($connection, "update tbl_appointment set appointment_id='$appointment_id', patient_name='$patient_name', department='$department' , available_days='$available_days', doctor='$doctor',   date='$date',  time='$time', message='$message', status='$status' where id='$id'");
        if ($update_query > 0) {
            $msg = "Appointment updated successfully";
            $fetch_query = mysqli_query($connection, "select * from tbl_appointment where id='$id'");
            $row = mysqli_fetch_array($fetch_query);
        } else {
            $msg = "Error!";
        }
    } catch (\Exception $th) {
        $msg = $th->getMessage();
    }
}

?>
<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-sm-4 ">
                <h4 class="page-title">Edit Appointment</h4>
            </div>
            <div class="col-sm-8  text-right m-b-20">
                <a href="appointments.php" class="btn btn-primary btn-rounded float-right">Back</a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <form method="post">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Appointment ID <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" id="appointment_id" name="appointment_id" readonly value="<?= $row['appointment_id'] ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Patient Name</label>
                                <select class="select" id="patient_name" name="patient_name" required>
                                    <option value="">Select</option>
                                    <?php
                                    $fetch_query = mysqli_query($connection, "select id, concat(first_name,' ',last_name) as name, dob from tbl_patient");
                                    while ($patient = mysqli_fetch_array($fetch_query)) {
                                    ?>
                                        <option value="<?= $patient['id'] . ',' . $patient['name'] . ',' . $patient['dob']; ?>" <?= $row['patient_id'] == $patient['id'] ? 'selected' : ''; ?>><?= $patient['name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Date</label>
                                <div class="cal-icon">
                                    <input type="text" class="form-control datetimepicker" id="date_appointment" name="date" required value="<?= $row['date'] ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Time</label>
                                <div class="time-icon">
                                    <input type="text" class="form-control" id="datetimepicker3" name="time" required value="<?= $row['time'] ?>">
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Department</label>
                                <select class="select" name="department" id="department" required>
                                    <option value="">Select</option>
                                    <?php
                                    $fetch_query = mysqli_query($connection, "select department_name from tbl_department");
                                    while ($department = mysqli_fetch_array($fetch_query)) {
                                    ?>
                                        <option <?= $department['department_name'] == $row['department'] ? 'selected' : '' ?>><?php echo $department['department_name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Doctor</label>
                                <select class="select" name="doctor" id="doctor" required>
                                    <option value="<?= $row['doctor_id'] . ',' . $row['doctor'] ?>"><?= $row['doctor'] ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Available Days</label>
                                <select class="select" name="available_days" id="available_days" required>
                                    <option><?= $row['available_days'] ?></option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Message</label>
                                <textarea cols="30" rows="4" class="form-control" name="message" required><?= htmlspecialchars($row['message']) ?>
                                </textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="display-block">Appointment Status</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" id="product_active" value="1" <?= $row['status'] == 1 ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="product_active">
                                        Finish
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" id="product_inactive" value="0" <?= $row['status'] == 2 ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="product_inactive">
                                        Unfinished
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="m-t-20 text-center">
                        <button name="save-appointment" class="btn btn-primary submit-btn">Save Appointment</button>
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
        $("#patient_name").change(function() {
            getAppoinmentID();
        })

        function getAppoinmentID() {
            var selectedOption = $('#department').val();
            var inputValue = $('#date_appointment').val();
            var patient_name = $('#patient_name').val();
            if (patient_name !== '') {
                var patient_id = String(patient_name).split(',');
                $.ajax({
                    type: "POST",
                    url: "code-appointment.php",
                    data: {
                        department: selectedOption,
                        date: inputValue,
                        patient_id: patient_id[0],
                        // id: <?= $row['id'] ?>,
                    },
                    cache: false,
                    success: function(response) {
                        if (response !== '') {
                            const elem = JSON.parse(response);
                            if (elem.msg) {
                                $('#appointment_id').val(elem.code);
                            } else {
                                swal({
                                    title: 'Maaf',
                                    text: 'Appointment Sudah Tersedia',
                                    icon: 'error',
                                })
                                var ap = "<?= $row['appointment_id'] ?>";
                                $('#appointment_id').val(ap);
                            }
                        }
                    },
                    error: (err) => {
                        console.log(err)
                    }
                });
            }
        }
        $('#department').change(function() {
            var selected_department = $(this).val();
            $.ajax({
                type: "POST",
                url: "fetch-doctor.php",
                data: {
                    department: selected_department,
                },
                cache: false,
                success: function(response) {
                    $('#doctor').html(response);
                    getAppoinmentID();
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
        $('#date_appointment').on('dp.change', function(e) {
            getAppoinmentID()
        })
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