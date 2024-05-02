<?php
session_start();
if (empty($_SESSION['name'])) {
    header('location:login.php');
}
include('header.php');
include('includes/connection.php');

if (isset($_REQUEST['add-medical'])) {

    $id_patient = $_POST['patient_name'];
    $query = mysqli_query($connection, "SELECT id, concat(first_name, ' ', last_name) as patient_name FROM tbl_patient WHERE id='$id_patient'");
    $patient = mysqli_fetch_array($query);
    $patient_name = $patient['patient_name'];
    $patient_id = $patient['id'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $phone = $_POST['phone'];
    $date = $_POST['date'];
    $doctor_name = $_POST['doctor_name'];
    $complaints = $_POST['complaints'];
    $diagnoses = $_POST['diagnoses'];
    $medical_drugs = $_POST['medical_drugs'];


    $sql = "INSERT INTO tbl_medical_records ( patient_id, patient_name, gender, phone, date, dob, doctor_name, complaints, diagnoses, medical_drugs)
VALUES ( '$patient_id','$patient_name', '$gender', '$phone', '$date', '$dob', '$doctor_name', '$complaints', '$diagnoses', '$medical_drugs')";

    if (mysqli_query($connection, $sql)) {
        $msg = "berhasil DI Tambah";
    } else {
        $msg = 'Gagal DItambah';
    }
}
?>
<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-sm-4 ">
                <h4 class="page-title">Add Medical Records</h4>

            </div>
            <div class="col-sm-8  text-right m-b-20">
                <a href="patients.php" class="btn btn-primary btn-rounded float-right">Back</a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <form method="post">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="appointment_id">Select Appointment:</label>
                                <select class="form-control" id="appointment_id" name="appointment_id" required>
                                    <option value="">------</option>
                                    <?php
                                    $fetch_query = mysqli_query($connection, "SELECT id, concat(appointment_id, '||', patient_name, '||',department) as detail FROM `tbl_appointment` where doctor_id = " . $_SESSION['auth']['id']);

                                    while ($row = mysqli_fetch_array($fetch_query)) {
                                    ?>
                                        <option value="<?= $row['id'] ?>"><?= $row['detail'] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="patient_name">Patient Name:</label>
                                <input type="text" class="form-control" id="patient_name" readonly name="patient_name" />

                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="gender">Gender:</label>
                                <input type="text" class="form-control" id="gender" name="gender" />
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">

                                <label for="phone">Phone:</label>
                                <input class="form-control" type="tel" id="phone" name="phone"><br>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">

                                <label for="dob">Date Of Birdtday:</label>
                                <div class="cal-icon">
                                    <input type="text" class="form-control datetimepicker" readonly id="dob" name="dob" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="date">Date Medical Records:</label>
                                <div class="cal-icon">
                                <input type="text" class="form-control datetimepicker" readonly id="date" name="date">

                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">

                                <label for="doctor_name">Doctor Name:</label>
                                <input class="form-control" type="text" id="doctor_name" readonly name="doctor_name" value="<?= $_SESSION['auth']['first_name'] ?>"><br>

                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">

                                <label for="complaints">Complaints:</label>
                                <textarea class="form-control" id="complaints" name="complaints"></textarea><br>

                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="diagnoses">Diagnoses:</label>
                                <textarea class="form-control" id="diagnoses" name="diagnoses"></textarea><br>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">

                                <label for="medical_drugs">Medical Drugs:</label>
                                <textarea class="form-control" id="medical_drugs" name="medical_drugs"></textarea><br>

                            </div>
                        </div>
                    </div>

                    <div class="m-t-20 text-center">

                        <button name="add-medical" class="btn btn-primary submit-btn">Create Medical Record</button>
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
        $('#appointment_id').change(function() {
            $.ajax({
                type: "POST",
                url: "/fetch-appointment.php",
                data: {
                    apt_id: $(this).val(),
                },
                success: function(response) {
                    const element = JSON.parse(response);
                    if (element.status) {
                        const data_appointment = element.data;
                        var patient = String(data_appointment.patient_name).split(',');
                        $("#patient_name").val(patient[0]);
                        $("#dob").val(patient[1]);
                        $('#date').val(data_appointment.date)
                        $('#doctor_name').val(data_appointment.doctor)
                        $.ajax({
                            type: "POST",
                            url: "/fetch-patient.php",
                            data: {
                                id: data_appointment.patient_id,
                            },
                            success: function(res) {
                                const elem = JSON.parse(res)
                                if (elem.status) {
                                    const data_patient = elem.data;
                                    $("#phone").val(data_patient.phone);
                                    $("#gender").val(data_patient.gender);
                                }else{
                                    swal({
                                        icon: 'error',
                                        title: 'patient data is lost',
                                        text: 'you can manually create patient data or cancel medical record'
                                    })
                                }

                            }
                        });
                    }
                }
            });
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