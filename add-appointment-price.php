<?php
session_start();
if (empty($_SESSION['name']) || $_SESSION['role'] != 1) {
    header('location:login.php');
}
include('header.php');
include('includes/connection.php');

$fetch_query = mysqli_query($connection, "select max(id) as id from tbl_appointment");
$row = mysqli_fetch_row($fetch_query);
if ($row[0] == 0) {
    $apt_id = 1;
} else {
    $apt_id = $row[0] + 1;
}
if (isset($_REQUEST['add-appointment'])) {

    $appointment_id = 'APT-' . $apt_id;
    $department_doctor = $_REQUEST['department_doctor'];
    $sub_total = $_REQUEST['sub_total'];
    $status = $_REQUEST['status'];

    $query_check_price_doctor = mysqli_query($connection, 'SELECT * FROM tbl_price WHERE doctor_id = ' . $department_doctor);
    $query_row = mysqli_num_rows($query_check_price_doctor);
    if ($query_row < 1) {


        // **1. Mendefinisikan variabel**

        $namaFile = $_FILES['file']['name'];
        $tmpName = $_FILES['file']['tmp_name'];
        $ukuranFile = $_FILES['file']['size'];
        $tipeFile = $_FILES['file']['type'];

        // **2. Validasi file**

        // Pastikan file tidak kosong
        if (empty($namaFile)) {
            $msg = "Silakan pilih file gambar.";
            exit;
        }

        // Pastikan ukuran file tidak melebihi batas
        if ($ukuranFile > 2097152) { // 2 MB
            $msg = "Ukuran file gambar melebihi batas (2 MB).";
            exit;
        }

        // Pastikan tipe file gambar yang diizinkan
        $tipeFileValid = array('image/jpeg', 'image/png', 'image/gif');
        if (!in_array($tipeFile, $tipeFileValid)) {
            $msg = "Tipe file gambar tidak diizinkan.";
            exit;
        }

        // **3. Menyimpan file gambar**

        // Tentukan lokasi penyimpanan file
        $direktoriUpload = dirname(__DIR__) . "/hms/assets/uploads/";

        $namaFile = md5($namaFile) . '.' . explode('/', $tipeFile)[1];
        // Pindahkan file yang diupload ke direktori penyimpanan
        if (move_uploaded_file($tmpName, $direktoriUpload . $namaFile)) {
            $msg = "File gambar berhasil disimpan.";
        } else {
            $msg = "Gagal menyimpan file gambar.";
        }

        $insert_query = mysqli_query($connection, "insert into tbl_price set doctor_id='$department_doctor', sub_total='$sub_total', file='$namaFile', status='$status'");

        if ($insert_query > 0) {
            $msg = "Appointment price created successfully";
        } else {
            $msg = "Error!";
        }
    }else{
        $msg = "Appointment Price has been Added";
    }
}
?>
<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-sm-4 ">
                <h4 class="page-title">Add Appointment - Price </h4>

            </div>
            <div class="col-sm-8  text-right m-b-20">
                <a href="appointments.php" class="btn btn-primary btn-rounded float-right">Back</a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <form method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Doctor - Department</label>
                        <select class="select" name="department_doctor" id="department_doctor" required>
                            <option value="">Select</option>
                            <?php
                            $fetch_query = mysqli_query($connection, "select * from tbl_employee where role = 2");
                            while ($row = mysqli_fetch_array($fetch_query)) {
                            ?>
                                <option value="<?= $row['id'] ?>"><?php echo $row['department_name'] . ' - ' . $row['first_name'] . ' ' . $row['last_name']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Sub Total</label>
                        <div class="-icon">
                            <input type="text" class="form-control" name="sub_total" required>
                        </div>
                    </div>
                    <div class="mb-3 form-group">
                        <label for="file">File</label>
                        <input class="form-control" type="file" name="file" required>

                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="display-block">Appointment Price Status</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" id="product_active" value="Active" checked>
                                    <label class="form-check-label" for="product_active">
                                        Active
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" id="product_inactive" value="InActive">
                                    <label class="form-check-label" for="product_inactive">
                                        Inactive
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="m-t-20 text-center">
                        <button name="add-appointment" class="btn btn-primary submit-btn">Create Appointment-Price</button>
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
        $('#department').change(function() {
            var selected_department = $(this).val();
            $.ajax({
                type: "POST",
                url: "fetch-doctor.php",
                data: {
                    department: selected_department
                },
                cache: false,
                success: function(response) {
                    $('#doctor').html(response);
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