<?php
session_start();

include('header.php');

$fetch_query = mysqli_query($connection, "select max(id) as id from tbl_appointment");
$row = mysqli_fetch_row($fetch_query);
if ($row[0] == 0) {
    $apt_id = 1;
} else {
    $apt_id = $row[0] + 1;
}
if (isset($_REQUEST['add-appointment'])) {

    $appointment_id = $_REQUEST['appointment_id'];
    $patient_name = $_REQUEST['patient_name'] . ',' . $_REQUEST['dob'];
    $patient_id = $_REQUEST['patient_id'];

    $department = $_REQUEST['department'];
    $doctor = explode(',', $_REQUEST['doctor']);
    $available_days = $_REQUEST['available_days'];
    $date = $_REQUEST['date'];
    $time = $_REQUEST['time'];
    $message = $_REQUEST['message'];
    $status = 0;
    $app_price = makeAppointmentPrice($appointment_id, $connection, $doctor[0]);

    if ($app_price) {
        $insert_query = mysqli_query($connection, "insert into tbl_appointment set appointment_id='$appointment_id', patient_id='$patient_id',patient_name='$patient_name', department='$department', doctor='$doctor[1]',doctor_id='$doctor[0]',  date='$date',  time='$time', message='$message', status='$status'");

        if ($insert_query > 0) {
            $msg = "Appointment created successfully";
        } else {
            $msg = "Error!";
        }
    } else {
        $msg = "Cannot Add Appointment : Appoinment could not be held because the price had not been determined";
    }
}
function makeAppointmentPrice($appointment_id, $connection, $doctor_id)
{

    $query_price = mysqli_query($connection, 'select * from tbl_price where doctor_id= ' . $doctor_id);
    if (mysqli_num_rows($query_price) > 0) {
        $doctor = mysqli_fetch_assoc($query_price);
        $sub_total = $doctor['sub_total'];
        // insert data appointment from patient where user is not login before
        $insert_query = mysqli_query($connection, "insert into tbl_appointment_price set appointment_id='$appointment_id', status= 'PENDING', sub_total='$sub_total'");
        return true;
    } else {
        return false;
    }
}
?>
<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-sm-4 ">
                <h4 class="page-title">Add Appointment</h4>

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
                                <input class="form-control" type="text" id="appointment_id" name="appointment_id" readonly>
                                <small class="form-text text-muted">Insert Department And Date Schedule For value Appointment ID</small>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Patient Name</label>
                                <input type="text" class="form-control" name="patient_name" readonly value="<?= $_SESSION['auth']['first_name'] . ' ' . $_SESSION['auth']['last_name'] ?>" required>
                                <input type="hidden" class="form-control" name="patient_id" readonly value="<?= $_SESSION['auth']['id'] ?>" required>
                            </div>
                            <div class="form-group">
                                <label>dirth of birthday</label>
                                <div class="cal-icon">
                                    <input type="text" class="form-control datetimepicker" value="<?= $_SESSION['auth']['dob'] ?>" readonly name="dob" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Date</label>
                                <div class="cal-icon">
                                    <input type="text" class="form-control datetimepicker" id="date_appointment" name="date" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Time</label>
                                <div class="time-icon">
                                    <input type="text" class="form-control" id="datetimepicker3" name="time" required>
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
                                    while ($row = mysqli_fetch_array($fetch_query)) {
                                    ?>
                                        <option><?php echo $row['department_name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Doctor</label>
                                <select class="select" name="doctor" id="doctor" required>
                                    <option value="">Select</option>

                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Message</label>
                                <textarea cols="30" rows="4" class="form-control" name="message" required></textarea>
                            </div>
                        </div>
                    </div>


                    <div class="m-t-20 text-center">
                        <button name="add-appointment" class="btn btn-primary submit-btn">Create Appointment</button>
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
        function getAppoinmentID() {
            var selectedOption = $('#department').val();
            var inputValue = $('#date_appointment').val();
            $.ajax({
                type: "POST",
                url: "/code-appointment.php",
                data: {
                    department: selectedOption,
                    date: inputValue,
                },
                cache: false,
                success: function(response) {
                    console.log(response)
                   if(response !== ''){
                    const elem = JSON.parse(response);
                    if(elem.msg){
                        $('#appointment_id').val(elem.code);
                    }else{
                        $('#appointment_id').val(null);
                        swal('Maaf Data Appointment Sudah Tersedia')
                    }
                   }
                },
                error: (err) => {
                    console.log(err)
                }
            });
        }
        $('#department').change(function() {
            var selected_department = $(this).val();
            $.ajax({
                type: "POST",
                url: "/fetch-doctor.php",
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
                url: "/fetch-schedule.php",
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