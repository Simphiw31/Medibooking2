<?php
include_once '../assets/conn/dbconnect.php';
// Get the variables.
$doctor_id = $_POST['ic'];

$delete = mysqli_query($con,"DELETE FROM doctor WHERE doctor_id=$doctor_id");



?>

