<?php
include_once '../assets/conn/dbconnect.php';
// Get the variables.
$appointment_ID = $_POST['id'];

$delete = mysqli_query($con,"DELETE FROM appointment WHERE appointment_ID=$appointment_ID");



?>

