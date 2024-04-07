<?php
session_start();

include('header.php');

?>
<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-sm-4 col-3">
                <h4 class="page-title">Appointments </h4>
            </div>
        </div>
        <div class="table-responsive">
            <table class="datatable table table-stripped ">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Appointment-ID</th>
                        <th>Patient Name</th>
                        <th>Doctor Name/Department</th>
                        <!-- <th>Available Days</th> -->
                        <th>Appointment Date</th>
                        <th>Payment Status</th>
                        <th>Sub Total</th>
                        <th>Check Invoice</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no=1;
                    if (isset($_GET['ids'])) {
                        $id = $_GET['ids'];
                        $delete_query = mysqli_query($connection, "delete from tbl_appointment where id='$id'");
                    }
                    $fetch_query = mysqli_query($connection, "SELECT ta.id, ta.appointment_id, ta.patient_name, ta.patient_id, ta.doctor_id, ta.doctor,ta.date, ta.department, ta.status AS ta_status, tap.status AS payment_status, tap.sub_total FROM tbl_appointment AS ta INNER JOIN tbl_appointment_price AS tap ON ta.appointment_id = tap.appointment_id WHERE ta.patient_id=". $_SESSION['auth']['id']);
                    while ($row = mysqli_fetch_array($fetch_query)) {


                    ?>
                        <tr>
                            <td><?= $no++?></td>
                            <td><?php echo $row['appointment_id']; ?></td>
                            <td><?php echo $row['patient_name']; ?></td>
                            <td><?php echo $row['doctor'] . '/' . $row['department'];; ?></td>
                            <td><?php echo $row['date']; ?></td>
                           
                            <td>
                            <span class="custom-badge status-red"><?= $row['payment_status'] ?></span>
                            </td>
                            <td class="nowrap">
                            <span class="custom-badge"><?= $row['sub_total'] ?></span>
                            </td>
                            <td class="text-right">
                                <div class="dropdown dropdown-action">
                                    <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="invoice.php?id=<?php echo $row['id']; ?>"><i class="fa fa-eye m-r-5"></i> show</a>
                                        <!-- <a class="dropdown-item" href="appointments.php?ids=<?php echo $row['id']; ?>" onclick="return confirmDelete()"><i class="fa fa-trash-o m-r-5"></i> Delete</a> -->
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
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
        return confirm('Are you sure want to delete this Appointments?');
    }
</script>