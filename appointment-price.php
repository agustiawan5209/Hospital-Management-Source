<?php
session_start();
if (empty($_SESSION['auth'])) {
    header('location:login.php');
}
include('header.php');
include('includes/connection.php');
?>
<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-sm-4 col-3">
                <h4 class="page-title">Appointment Price</h4>
            </div>
            <?php
            if ($_SESSION['role'] == 1) { ?>
                <div class="col-sm-8 col-9 text-right m-b-20">
                    <a href="add-appointment-price.php" class="btn btn-primary btn-rounded float-right"><i class="fa fa-plus"></i> Add appointment-price</a>
                </div>
            <?php } ?>
        </div>
        <div class="table-responsive">
            <table class="datatable table table-stripped ">
                <thead>
                    <tr>
                        <th>Department</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>QR Code</th>
                        <th>Status</th>
                        <?php
                        if ($_SESSION['role'] == 1) { ?>
                            <th>Action</th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($_GET['ids'])) {
                        $id = $_GET['ids'];
                        $delete_query = mysqli_query($connection, "delete from tbl_price where id='$id'");
                    }
                    $fetch_query = mysqli_query($connection, "SELECT tp.id, concat(te.first_name, ' ' , te.last_name) as doctor_name, te.department_name, tp.sub_total, tp.status, tp.file FROM tbl_price as tp INNER JOIN tbl_employee as te ON tp.doctor_id = te.id");
                    while ($row = mysqli_fetch_array($fetch_query)) {
                    ?>
                        <tr>
                            <td><?php echo $row['department_name']; ?></td>
                            <td><?php echo $row['doctor_name']; ?></td>
                            <td><?php echo $row['sub_total']; ?></td>
                            <td>
                                <img src="<?= BASE_URL.'/assets/uploads/' . $row['file']; ?>" alt="file QR CODE" width="100">
                            </td>
                            <td>
                                <?php
                                if ($row['status'] == 'Active') {
                                    $cs = 'green';
                                } else {
                                    $cs = 'red';
                                }
                                ?>
                                <span class="custom-badge status-<?= $cs ?>"><?= $row['status'] ?></span>
                            </td>
                            <?php
                            if ($_SESSION['role'] == 1) { ?>
                                <td class="text-right">
                                    <div class="dropdown dropdown-action">
                                        <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="edit-doctor.php?id=<?php echo $row['id']; ?>"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                            <a class="dropdown-item" href="appointment-price.php?ids=<?php echo $row['id']; ?>" onclick="return confirmDelete()"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                        </div>
                                    </div>
                                </td>
                            <?php } ?>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

    </div>

</div>


<?php
include('footer.php'); ?>
<script language="JavaScript" type="text/javascript">
    function confirmDelete() {
        return confirm('Are you sure want to delete this Doctor?');
    }
</script>