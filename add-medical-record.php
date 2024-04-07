<?php
session_start();
if (empty($_SESSION['name'])) {
    header('location:login.php');
}
include('header.php');
include('includes/connection.php');

if (isset($_REQUEST['add-patient'])) {

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
                <h4 class="page-title">Add Patient</h4>

            </div>
            <div class="col-sm-8  text-right m-b-20">
                <a href="patients.php" class="btn btn-primary btn-rounded float-right">Back</a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <form method="post">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="patient_name">Patient Name:</label>
                                <select class="form-control" id="patient_name" name="patient_name" required>
                                    <option value="">------</option>
                                    <?php
                                    $query = mysqli_query($connection, "SELECT id, concat(first_name, ' ', last_name) as patient_name FROM tbl_patient");
                                    while ($row = mysqli_fetch_array($query)) {
                                    ?>
                                        <option value="<?= $row['id'] ?>"><?= $row['patient_name'] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="gender">Gender:</label>
                                <select class="form-control" id="gender" name="gender">
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
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
                                <input class="form-control" type="date" id="dob" name="dob"><br>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="date">Date Medical Records:</label>
                                <input class="form-control" type="date" id="date" name="date"><br>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">

                                <label for="doctor_name">Doctor Name:</label>
                                <input class="form-control" type="text" id="doctor_name" name="doctor_name" value="<?= $_SESSION['auth']['first_name'] ?>"><br>

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

                        <button name="add-patient" class="btn btn-primary submit-btn">Create Patient</button>
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
    <?php
    if (isset($msg)) {
        echo 'swal("' . $msg . '");';
    }
    ?>
</script>