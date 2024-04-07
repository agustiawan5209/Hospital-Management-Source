<?php
session_start();
if (empty($_SESSION['name'])) {
    header('location:login.php');
}
include('header.php');
include('includes/connection.php');
$id = $_GET['id'];

$sql = "SELECT * FROM tbl_medical_records WHERE id='$id'";
$result = mysqli_query($connection, $sql);

$row = mysqli_fetch_assoc($result);

if (isset($_REQUEST['edit-patient'])) {

    $id = $_GET['id'];

    $id_patient = $_POST['patient_name'];
    $query = mysqli_query($connection, "SELECT id, concat(first_name, ' ', last_name) as patient_name FROM tbl_patient WHERE id='$id_patient'");
    $patient = mysqli_fetch_array($query);
    $patient_name = $patient['patient_name'];
    $patient_id = $patient['id'];

    $gender = $_POST['gender'];
    $phone = $_POST['phone'];
    $date = $_POST['date'];
    $dob = $_POST['dob'];
    $doctor_name = $_POST['doctor_name'];
    $complaints = $_POST['complaints'];
    $diagnoses = $_POST['diagnoses'];
    $medical_drugs = $_POST['medical_drugs'];

    $sql = "UPDATE tbl_medical_records SET patient_id='$patient_id',  patient_name='$patient_name', gender='$gender', phone='$phone', date='$date', dob='$dob' ,doctor_name='$doctor_name', complaints='$complaints', diagnoses='$diagnoses', medical_drugs='$medical_drugs' WHERE id=$id";

    if (mysqli_query($connection, $sql) === TRUE) {
        $msg = "Record updated successfully";
?>
        <script>
            window.location.href = 'medical-records.php'
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
                <h4 class="page-title">Edit Patient</h4>

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
                                    $query_patient = mysqli_query($connection, "SELECT id, concat(first_name, ' ', last_name) as patient_name FROM tbl_patient");
                                    while ($patient = mysqli_fetch_array($query_patient)) {
                                    ?>
                                        <option <?= $row['patient_id'] == $patient['id'] ? 'selected': '' ?>  value="<?= $patient['id'] ?>"><?= $patient['patient_name'] ?> . </option>
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
                                    <option <?= $row['gender'] == 'male' ? 'selected' : '' ?> value="male">Male</option>
                                    <option <?= $row['gender'] == 'female' ? 'selected' : '' ?> value="female">Female</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">

                                <label for="phone">Phone:</label>
                                <input class="form-control" type="tel" id="phone" name="phone" value="<?= $row['phone'] ?>"><br>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">

                                <label for="dob">Date Of Birdtday:</label>
                                <input class="form-control" type="date" id="dob" name="dob" value="<?= $row['dob'] ?>"><br>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="date">Date Medical Records:</label>
                                <input class="form-control" type="date" id="date" name="date" value="<?= $row['date'] ?>"><br>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">

                                <label for="doctor_name">Doctor Name:</label>
                                <input class="form-control" type="text" id="doctor_name" name="doctor_name" value="<?= $row['doctor_name'] ?>"><br>

                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">

                                <label for="complaints">Complaints:</label>
                                <textarea class="form-control" id="complaints" name="complaints"><?= $row['complaints'] ?></textarea><br>

                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="diagnoses">Diagnoses:</label>
                                <textarea class="form-control" id="diagnoses" name="diagnoses"><?= $row['diagnoses'] ?></textarea><br>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">

                                <label for="medical_drugs">Medical Drugs:</label>
                                <textarea class="form-control" id="medical_drugs" name="medical_drugs"><?= $row['medical_drugs'] ?></textarea><br>

                            </div>
                        </div>
                    </div>

                    <div class="m-t-20 text-center">

                        <button name="edit-patient" class="btn btn-primary submit-btn">Update Patient</button>
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