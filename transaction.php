<?php
session_start();
if (empty($_SESSION['name'])) {
    header('location:login.php');
}
include('header.php');
include('includes/connection.php');
?>
<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-sm-4 col-3">
                <h4 class="page-title">Transaction</h4>
            </div>
            <?php
            if ($_SESSION['role'] == 1) { ?>
                <div class="col-sm-8 col-9 text-right m-b-20">
                    <a href="add-appointment.php" class="btn btn-primary btn-rounded float-right"><i class="fa fa-plus"></i> Add Transaction</a>
                </div>
            <?php } ?>
        </div>
        <div class="table-responsive">
            <table class="datatable table table-stripped ">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Transaction Code</th>
                        <th>Appointment ID</th>
                        <th>Status</th>
                        <th>Sub Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($_GET['ids'])) {
                        $id = $_GET['ids'];
                        $delete_query = mysqli_query($connection, "delete from tbl_transaction where id='$id'");
                    }
                    $no = 1;
                    $fetch_query = mysqli_query($connection, "select * from tbl_transaction order by id desc");
                    while ($row = mysqli_fetch_array($fetch_query)) {
                    ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $row['tr_code'] ?></td>
                            <td><?= $row['appointment_id'] ?></td>
                            <td><?= $row['status'] ?></td>
                            <td><?= $row['sub_total'] ?></td>
                            <td class="text-right">
                                <div class="dropdown dropdown-action">
                                    <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="confirm-payment.php?ids=<?php echo $row['id']; ?>" onclick="return confirmDelete()"><i class="fa fa-eye m-r-5"></i> Show</a>
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