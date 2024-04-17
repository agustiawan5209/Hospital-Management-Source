<?php

session_start();

include('config.php');
include('connection.php');

// Login Session
if (isset($_REQUEST['login'])) {
    $username = mysqli_real_escape_string($connection, $_REQUEST['username']);
    $pwd = mysqli_real_escape_string($connection, $_REQUEST['pwd']);

    // Cek kredensial di tabel tbl_employee
    $fetch_query = mysqli_query($connection, "SELECT * FROM tbl_employee WHERE username = '$username' AND password = '$pwd'");
    $employee_res = mysqli_num_rows($fetch_query);
    if ($employee_res > 0) {
        $data = mysqli_fetch_array($fetch_query);
        $name = $data['first_name'] . ' ' . $data['last_name'];
        $role = $data['role'];
        $_SESSION['name'] = $name;
        $_SESSION['role'] = $role;
        $_SESSION['auth'] = $data;
        header('location: ' . BASE_URL . 'dashboard.php');
    } else {
        // Jika tidak ditemukan di tabel tbl_employee, cek di tabel tbl_patient
        $fetch_query_patient = mysqli_query($connection, "SELECT * FROM tbl_patient  WHERE username ='$username' AND password = '$pwd'");

        $patient_res = mysqli_num_rows($fetch_query_patient);
        if ($patient_res > 0) {
            $data_patient = mysqli_fetch_array($fetch_query_patient);
            $name_patient = $data_patient['first_name'] . ' ' . $data_patient['last_name'];
            $_SESSION['name'] = $name_patient;
            $_SESSION['auth'] = $data_patient;
            $_SESSION['role'] = 'patient';


            // if has a session with name data_schedule
            if (isset($_SESSION['data_schedule'])) {
                $fetch_query = mysqli_query($connection, "select max(id) as id from tbl_appointment");
                $row = mysqli_fetch_row($fetch_query);
                if ($row[0] == 0) {
                    $apt_id = 1;
                } else {
                    $apt_id = $row[0] + 1;
                }

                // Get data Doktor And Departemen By ID
                $department_app = mysqli_query($connection, "SELECT *  FROM tbl_employee WHERE id =" . $_SESSION['data_schedule']['department_doctor']);

                $data_department = mysqli_fetch_assoc($department_app);

                $doctor_name = $name_patient ;
                $department_name = $data_department['department_name'];
                $doctor_id = $data_department['id'];
                $department_name = $data_department['department_name'];

                $appointment_id = 'APT-' . $apt_id;
                $patient_name = $data_patient['first_name'] . ' ' . $data_patient['last_name'] . ',' . $_SESSION['data_schedule']['dob'];
                $doctor = $_SESSION['data_schedule']['doctor'];
                $date = $_SESSION['data_schedule']['date'];
                $time = $_SESSION['data_schedule']['time'];
                $message = $_SESSION['data_schedule']['message'];
                $status = 0;
                $patient_id = $_SESSION['auth']['id'];

                // insert data appointment from patient where user is not login before
                $insert_query = mysqli_query($connection, "insert into tbl_appointment set appointment_id='$appointment_id', patient_name='$patient_name',patient_id='$patient_id', department='$department_name', doctor='$doctor_name', doctor_id='$doctor_id', date='$date',  time='$time', message='$message', status='$status'");

                makeAppointmentPrice($appointment_id, $connection, $doctor_id);

                if ($insert_query > 0) {
                    $msg = "Appointment created successfully";
                    $_SESSION['message'] = 'AppointMent Berhasil Ditambah';
                    unset($_SESSION['data_schedule']);
                } else {
                    $msg = "Error!";
                }
            }

            header('location: ' . BASE_URL . 'patient/dashboard.php');
        } else {
            $_SESSION['message'] = 'username dan password salah';
            header('location: ' . BASE_URL . '/login.php');
        }
    }
}


// Appointment schedule
if (isset($_POST['submit-appointment'])) {

    $date = date('d/m/Y', strtotime($_POST['dob']));
    // Check if has a session with name is auth
    $_SESSION['data_schedule'] = [
        'name' => $_POST['name'],
        'number' => $_POST['number'],
        'department_doctor' => $_POST['department_doctor'],
        'date' => $_POST['date'],
        'time' => $_POST['time'],
        'message' => $_POST['message'],
        'dob' => $date,
    ];

    if (!isset($_SESSION['auth'])) {
        header("location: ../login.php");
        exit;
    } else {
        $fetch_query = mysqli_query($connection, "select max(id) as id from tbl_appointment");
        $row = mysqli_fetch_row($fetch_query);
        if ($row[0] == 0) {
            $apt_id = 1;
        } else {
            $apt_id = $row[0] + 1;
        }

        // Get data Doktor And Departemen By ID
        $department_app = mysqli_query($connection, "SELECT * FROM tbl_employee  WHERE id =" . $_POST['department_doctor']);

        $data_department = mysqli_fetch_assoc($department_app);
        $doctor_name = $data_department['first_name'] . ' ' . $data_department['last_name'];
        $department_name = $data_department['department_name'];
        $doctor_id = $data_department['id'];
        $department_name = $data_department['department_name'];

        $appointment_id = 'APT-' . $apt_id;
        $patient_name =  $_SESSION['auth']['first_name'] . ' ' . $_SESSION['auth']['last_name'] . ',' . $_REQUEST['dob'];
        $doctor = $_REQUEST['doctor'];
        $date = $_REQUEST['date'];
        $time = $_REQUEST['time'];
        $message = $_REQUEST['message'];
        $status = 0;
        $patient_id = $_SESSION['auth']['id'];

        // insert data appointment from patient where user is not login before
        $insert_query = mysqli_query($connection, "insert into tbl_appointment set appointment_id='$appointment_id', patient_name='$patient_name',patient_id='$patient_id', department='$department_name', doctor='$doctor_name', doctor_id='$doctor_id', date='$date',  time='$time', message='$message', status='$status'");
        makeAppointmentPrice($appointment_id, $connection, $doctor_id);


        if ($insert_query > 0) {
            $msg = "Appointment created successfully";
            $_SESSION['message'] = 'AppointMent Berhasil Ditambah';

            unset($_SESSION['data_schedule']);
        } else {
            $msg = "Error!";
        }
        header('location: ' . BASE_URL . 'patient/dashboard.php');
    }
}

function makeAppointmentPrice($appointment_id, $connection, $doctor_id)
{

    $query_price = mysqli_query($connection, 'select * from tbl_price where doctor_id= ' . $doctor_id);
    $doctor = mysqli_fetch_assoc($query_price);
    $sub_total = $doctor['sub_total'];
    // insert data appointment from patient where user is not login before
    $insert_query = mysqli_query($connection, "insert into tbl_appointment_price set appointment_id='$appointment_id', status= 'PENDING', sub_total='$sub_total'");
}
