<?php
session_start();
if (empty($_SESSION['name'])) {
    header('location:login.php');
}
include('header.php');
include('includes/connection.php');

$id = $_GET['id'];
$fetch_query = mysqli_query($connection, "select * from tbl_schedule where id='$id'");
$row = mysqli_fetch_assoc($fetch_query);

// $query_row_schedule = "SELECT ts.id, te.first_name, te.last_name, concat(te.first_name, ' ', te.last_name) as doctor_name, ts.available_days, ts.start_time, ts.end_time, ts.message, ts.status, ts.created_at, te.department_name, ts.doctor_id FROM `tbl_schedule` as ts INNER JOIN tbl_employee as te ON ts.doctor_id = te.id  WHERE ts.id='$id'";
if (isset($_REQUEST['save-schedule'])) {
    $doctor_id = $_REQUEST['department'];
    $days = implode(", ", $_REQUEST['days']);
    $start_time = $_REQUEST['start_time'];
    $end_time = $_REQUEST['end_time'];
    $message = $_REQUEST['msg'];
    $status = $_REQUEST['status'];
    $sesi = $_REQUEST['sesi'];

    $update_query = mysqli_query($connection, "update tbl_schedule set  doctor_id='$doctor_id', available_days='$days', start_time='$start_time', end_time='$end_time', message='$message' , sesi='$sesi', status='$status' where id='$id'");
    if ($update_query > 0) {
        $msg = "Schedule updated successfully";
        // echo "<script>window.location.href = 'schedule.php'</script>";
    } else {
        $msg = "Error!";
    }
}

?>
<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-sm-4 ">
                <h4 class="page-title">Edit Schedule</h4>
            </div>
            <div class="col-sm-8  text-right m-b-20">
                <a href="schedule.php" class="btn btn-primary btn-rounded float-right">Back</a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <form method="post">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Doctor/Department Name</label>
                                <select class="select" name="department" required>
                                    <option value="">Select</option>
                                    <?php
                                    $fetch_query = mysqli_query($connection, "select id, concat(first_name,' ', last_name, '-', department_name) as doctor_department from tbl_employee where role=2");
                                    while ($emp_name = mysqli_fetch_array($fetch_query)) {
                                    ?>
                                        <option value="<?= $emp_name['id'] ?>" <?= $emp_name['id'] == $row['doctor_id'] ? 'selected' : '' ?>><?php echo $emp_name['doctor_department']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Available Days</label>
                                <select class="select" multiple name="days[]" required>
                                    <option value="">Select Days</option>
                                    <?php

                                    $days = explode(", ", $row["available_days"]);
                                    $fetch_query = mysqli_query($connection, "select * from tbl_week");
                                    while ($rows = mysqli_fetch_array($fetch_query)) {
                                        if (in_array($rows["name"], $days))
                                            $selected = "selected";
                                        else
                                            $selected = "";
                                    ?>
                                        <option value="<?= $rows["name"]; ?>" <?php echo $selected; ?>><?= $rows["name"]; ?>
                                        </option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Maximal Doctor Appointment per Day </label>
                                <div class="time-icon">
                                    <input type="number" class="form-control" name="sesi" value="<?= $row['sesi'] ?>" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Start Time</label>
                                <div class="time-icon">
                                    <input type="text" class="form-control" id="datetimepicker3" name="start_time" value="<?php echo $row['start_time'];  ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>End Time</label>
                                <div class="time-icon">
                                    <input type="text" class="form-control" id="datetimepicker4" name="end_time" value="<?php echo $row['end_time'];  ?>" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Message</label>
                        <textarea cols="30" rows="4" class="form-control" name="msg" required><?php echo $row['message'];  ?></textarea>
                    </div>
                    <div class="form-group">
                        <label class="display-block">Schedule Status</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="status" id="product_active" value="1" <?php if ($row['status'] == 1) {
                                                                                                                            echo 'checked';
                                                                                                                        } ?>>
                            <label class="form-check-label" for="product_active">
                                Active
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="status" id="product_inactive" value="0" <?php if ($row['status'] == 0) {
                                                                                                                            echo 'checked';
                                                                                                                        } ?>>
                            <label class="form-check-label" for="product_inactive">
                                Inactive
                            </label>
                        </div>
                    </div>
                    <div class="m-t-20 text-center">
                        <button class="btn btn-primary submit-btn" name="save-schedule">Save</button>
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
        echo 'swal({
            icon: "success",
            title: "success",
            text: "' . $msg . '",
        }).then(()=>{window.location.href="schedule.php"});';
    }
    ?>
</script>