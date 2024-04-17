<?php
session_start();
if (empty($_SESSION['name'])) {
    header('location:login.php');
}
include('header.php');
?>
<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-sm-4 col-3">
                <h4 class="page-title">MEDICAL RECORDS</h4>
            </div>
        </div>
        <div class="table-responsive">

            <table class="datatable table table-stripped ">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Patient Name</th>
                        <th>Gender</th>
                        <th>Phone</th>
                        <th>Date Of Birthday</th>
                        <th>Date</th>
                        <th>Doctor</th>
                        <th>Complaints</th>
                        <th>Diagnoses</th>
                        <th>Medical Drugs</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($_GET['ids'])) {
                        $id = $_GET['ids'];
                        $delete_query = mysqli_query($connection, "delete from tbl_medical_records where id='$id'");
                    }
                    $id_patient = $_SESSION['auth']['id'];
                    $sql = "SELECT * FROM tbl_medical_records where patient_id='$id_patient'";
                    $result = mysqli_query($connection, $sql);
                    $no = 1;
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                            <tr>
                                <td><?= $no++    ?></td>
                                <td><?= $row['patient_name'] ?></td>
                                <td><?= $row['gender'] ?></td>
                                <td><?= $row['phone'] ?></td>
                                <td><?= $row['date'] ?></td>
                                <td><?= $row['dob'] ?></td>
                                <td><?= $row['doctor_name'] ?></td>
                                <td><?= $row['complaints'] ?></td>
                                <td><?= $row['diagnoses'] ?></td>
                                <td><?= $row['medical_drugs'] ?></td>
                            </tr>
                    <?php
                        }
                        echo "</table>";
                    } else {
                        echo "Tidak ada data!";
                    }
                    ?>
                </tbody>
            </table>
        </div>

    </div>

</div>


<?php
include('footer.php');
?>
<script language="JavaScript" type="text/javascript">
    function confirmDelete() {
        return confirm('Are you sure want to delete this Patient?');
    }
</script>