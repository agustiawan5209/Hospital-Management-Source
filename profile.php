tes
<?php 
session_start();
if(empty($_SESSION['name']))
{
    header('location:login.php');
}
include('header.php');
include('includes/connection.php');

?>
tes
<?php 
include('footer.php');
?>