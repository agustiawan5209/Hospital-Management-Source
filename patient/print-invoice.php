<?php
session_start();
include_once('../includes/config.php');
if (empty($_SESSION['auth'])) {
    header('location: ../login.php');
}
$basePath = $_SERVER['DOCUMENT_ROOT'];
require_once $basePath . '/includes/connection.php';

$id = $_GET['id'];
$fetch_query = mysqli_query($connection, "SELECT ta.id,ta.appointment_id, ta.patient_name, ta.patient_id, ta.doctor_id, ta.doctor, ta.department, ta.status AS ta_status, tap.status AS payment_status, ta.date, ta.time, ta.message, tap.sub_total FROM tbl_appointment AS ta INNER JOIN tbl_appointment_price AS tap ON ta.appointment_id = tap.appointment_id  where ta.id='$id'");
$row = mysqli_fetch_assoc($fetch_query);
$appointment_id = $row['appointment_id'];

$tbl_price = mysqli_query($connection, "SELECT * FROM tbl_price where doctor_id = " . $row['doctor_id']);
$tbl_prices = mysqli_fetch_assoc($tbl_price);

$tbl_tr = mysqli_query($connection, "SELECT * FROM tbl_transaction where appointment_id ='$appointment_id' LIMIT 1 ");
$count_tbl_tr = mysqli_num_rows($tbl_tr);
$data_tbl_tr = mysqli_fetch_assoc($tbl_tr);

?>
<!DOCTYPE html>
<html>

<head>
    <title>Invoice Klinik Sehat</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        div > table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .invoice-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .invoice-details {
            margin-bottom: 20px;
        }

        .invoice-details table {
            width: 50%;
            float: left;
        }

        .invoice-details table tr td:first-child {
            width: 30%;
        }

        .invoice-details table tr td:last-child {
            width: 70%;
        }

        .invoice-items {
            width: 100%;
            margin-top: 10px;
        }

        .invoice-items table {
            width: 100%;
        }

        .invoice-totals {
            margin-top: 20px;
            text-align: right;
        }
    </style>
</head>

<body id='body'>
    <div class="invoice-header">
        <h2 href="/"><img src="/assets/img/logo-dark.png" width="100"></h2>
        <h2 href="/" class="logo text-dark"></i> KLINIK <strong>MB</strong> </a>
    </div>

    <div class="invoice-details">
        <table>
            <tr>
                <td>Appointment ID:</td>
                <td>
                    <?php echo $row['appointment_id'];  ?>
                </td>
            </tr>

            <tr>
                <td>Pasien:</td>
                <?php
                $fetch_query = mysqli_query($connection, "select * from tbl_appointment where id='$id'");
                $row = mysqli_fetch_array($fetch_query);
                $pat_name = explode(",", $row['patient_name']);
                $pat_name = $pat_name[0];
                ?>
                <td><?= $pat_name ?></td>
            </tr>
            <tr>
                <td>Tanggal:</td>
                <td><?= date('j F Y', strtotime($row['date'])) ?></td>
            </tr>
        </table>

        <table>
            <tr class="form-group">
                <td>Department</td>
                <td>
                    <?= $row['department'] ?>
                </td>
            </tr>
            <tr class="form-group">
                <td>Doctor</td>
                <td>
                    <?php echo $row['doctor'];  ?>
                </td>
            </tr>
        </table>
        <br>
    </div>
    <br>
    <div class="invoice-items">
        <table class="list-group list-group-horizontal">
            <tr>
                <td>Transaction Code </td>
                <td>: <?= $data_tbl_tr['tr_code'] ?></td>
            </tr>
            <tr>
                <td>sub-total transactions</td>
                <td>: <?= $data_tbl_tr['sub_total'] ?></td>
            </tr>
            <tr>
                <td>Transactions Date</td>
                <td>: <?= $data_tbl_tr['date'] ?></td>
            </tr>


            <tr>
                <td>Transactions status</td>
                <td class="custom-badge status-<?= $status ?>"> : <?= $data_tbl_tr['status'] ?></td>
            </tr>
        </table>

    </div>
    <table border="0" style="width: 100%;">
        <tr>
            <td style="border: 0; text-align: right;">
        <span>Bertanda tangan Klinik MB</span>


        </td>
        </tr>
    </table>

    <script>
        window.print()
    </script>
</body>

</html>