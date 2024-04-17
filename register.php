<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">
    <title>Registrasi - Klinik MB</title>
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <!--[if lt IE 9]>
		<script src="assets/js/html5shiv.min.js"></script>
		<script src="assets/js/respond.min.js"></script>
	<![endif]-->
</head>

<?php
session_start();
include('includes/connection.php');

if(isset($_POST['register'])) {
    $first_name = $_REQUEST['first_name'];
    $last_name = $_REQUEST['last_name'];
    $username = $_REQUEST['username'];
    $emailid = $_REQUEST['emailid'];
    $dob = date('d/m/Y', strtotime($_REQUEST['dob']));
    $gender = $_REQUEST['gender'];
    $address = $_REQUEST['address'];
    $phone = $_REQUEST['phone'];
    $pwd = $_REQUEST['pwd'];
    $confirm_pwd = $_REQUEST['confirm_pwd'];


    if ($pwd !== $confirm_pwd) {
        $msg = "Password dan konfirmasi password tidak cocok.";
    } else {
        $existingUserQuery = "SELECT * FROM tbl_patient WHERE username = '$username'";
        $existingUserResult = mysqli_query($connection, $existingUserQuery);
        if(mysqli_num_rows($existingUserResult) > 0) {
            $msg = "Username sudah digunakan, silakan coba dengan username lain.";
        } else {
            $insert_query = "insert into tbl_patient set first_name='$first_name', last_name='$last_name', username='$username', email='$emailid', password='$pwd', dob='$dob', gender='$gender', patient_type='OutPatient', address='$address', phone='$phone', role=4, status=0";
            if(mysqli_query($connection, $insert_query)) {
                $msg = "Registrasi berhasil";
                header("Location: login.php");
                exit();
            } else {
                $msg = "Terjadi kesalahan saat mendaftarkan akun";
            }
        }
    }
}
?>

<body>
    <div class="main-wrapper account-wrapper">
        <div class="account-page">
            <div class="account-center">
                <div class="account-box">
                    <form method="post" class="form-signin">
                        <div class="account-logo">
                        <a href="/"><img src="assets/img/logo-dark.png" alt=""></a>
                            <a href="/" class="logo text-dark"></i> KLINIK <strong>MB</strong> </a>
                        </div>
                        <div class="form-group">
                            <label>Nama Depan</label>
                            <input type="text" class="form-control" name="first_name" required>
                        </div>
                        <div class="form-group">
                            <label>Nama Belakang</label>
                            <input type="text" class="form-control" name="last_name" required>
                        </div>
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" class="form-control" name="username" required>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" name="emailid" required>
                        </div>
                        <div class="form-group">
                            <label>Tanggal Lahir</label>
                            <input type="date" class="form-control" name="dob" required>
                        </div>
                        <div class="form-group">
                            <label>Gender</label>
                            <select class="form-control" name="gender" required>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Alamat</label>
                            <textarea class="form-control" name="address" rows="3" required></textarea>
                        </div>
                        <div class="form-group">
                            <label>Nomor Telepon</label>
                            <input type="text" class="form-control" name="phone" required>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" class="form-control" name="pwd" required>
                        </div>
                        <div class="form-group">
                            <label>Ulangi Password</label>
                            <input type="password" class="form-control" name="confirm_pwd" required>
                        </div>
                        <?php if (!empty($msg)) { ?>
                            <p><?php echo $msg; ?></p>
                        <?php } ?>
                        <div class="form-group text-center">
                            <button type="submit" name="register" class="btn btn-primary account-btn">Registrasi</button>
                        </div>
                    </form>
                    <div class="text-center register-link">
                        Sudah punya akun? <a href="login.php">Login disini</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/js/jquery-3.2.1.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/app.js"></script>
</body>

</html>