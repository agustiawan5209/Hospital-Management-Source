<!DOCTYPE html>
<html lang="en">
<?php
include_once('includes/config.php');
?>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <link rel="shortcut icon" type="image/x-icon" href="<?= BASE_URL ?>assets/img/favicon.ico">
    <title>Klinik MB</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>assets/css/font-awesome.min.css">

    <link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>assets/css/select2.min.css">
    <link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>assets/css/bootstrap-datetimepicker.min.css">
    <link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>assets/css/style.css">

</head>

<body>
    <div class="main-wrapper">
        <div class="header">
            <div class="header-left">
                <a href="dashboard.php" class="logo">
                    <img src="<?= BASE_URL ?>/assets/img/logo.png" width="35" height="35" alt=""> <span>Klinik MB</span>
                </a>
            </div>
            <a id="toggle_btn" href="javascript:void(0);"><i class="fa fa-bars"></i></a>
            <a id="mobile_btn" class="mobile_btn float-left" href="#sidebar"><i class="fa fa-bars"></i></a>
            <ul class="nav user-menu float-right">
                <li class="nav-item dropdown has-arrow">
                    <a href="#" class="dropdown-toggle nav-link user-link" data-toggle="dropdown">
                        <span class="user-img">
                            <img class="rounded-circle" src="assets/img/user.jpg" width="24" alt="Admin">
                            <span class="status online"></span>
                        </span>
                        <?php
                        if ($_SESSION['role'] == 1) { ?>
                            <span>Admin</span>
                        <?php } else { ?>
                            <span><?php echo $_SESSION['name']; ?></span>
                        <?php } ?>
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="profile.php">Profile</a>
                        <a class="dropdown-item" href="logout.php">Logout</a>
                    </div>
                </li>
            </ul>
            <div class="dropdown mobile-user-menu float-right">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                <div class="dropdown-menu dropdown-menu-right">

                    <a class="dropdown-item" href="logout.php">Logout</a>
                </div>
            </div>
        </div>
        <div class="sidebar" id="sidebar">
            <div class="sidebar-inner slimscroll">
                <nav id="sidebar-menu" class="sidebar-menu">
                    <?php

                    if ($_SESSION['role'] == 1) { ?>
                        <ul>

                            <li>
                                <a href="dashboard.php"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a>
                            </li>

                            <li>
                                <a href="doctors.php"><i class="fa fa-user-md"></i> <span>Doctors</span></a>
                            </li>

                            <li>
                                <a href="patients.php"><i class="fa fa-wheelchair"></i> <span>Patients</span></a>
                            </li>
                            <li>
                                <a href="appointments.php"><i class="fa fa-calendar"></i> <span>Appointments</span></a>
                            </li>
                            <li>
                                <a href="appointment-price.php"><i class="fa fa-address-card"></i> <span>Appointments price</span></a>
                            </li>
                            <li>
                                <a href="schedule.php"><i class="fa fa-calendar-check-o"></i> <span>Doctor Schedule</span></a>
                            </li>
                            <li>
                                <a href="departments.php"><i class="fa fa-hospital-o"></i> <span>Departments</span></a>
                            </li>
                            <li>
                                <a href="employees.php"><i class="fa fa-user"></i> <span>Employees</span></a>
                            </li>
                            <li>
                                <a href="transaction.php"><i class="fa fa-credit-card"></i> <span>transaction</span></a>
                            </li>

                        </ul>
                    <?php } else { ?>
                        <ul>

                            <li >
                                <a href="dashboard.php"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a>
                            </li>

                            <li>
                                <a href="doctors.php"><i class="fa fa-user-md"></i> <span>Doctors</span></a>
                            </li>
                            <li>
                                <a href="patients.php"><i class="fa fa-wheelchair"></i> <span>Patients</span></a>
                            </li>
                            <li>
                                <a href="appointments.php"><i class="fa fa-calendar"></i> <span>Appointments</span></a>
                            </li>
                            <li>
                                <a href="appointment-price.php"><i class="fa fa-address-card"></i> <span>Appointments price</span></a>
                            </li>
                            <li>
                                <a href="medical-records.php"><i class="fa fa-clipboard"></i> <span>Medical Records</span></a>
                            </li>

                        </ul>
                    <?php } ?>
                </nav>
            </div>
        </div>
    </div>