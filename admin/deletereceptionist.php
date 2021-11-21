<?php
include_once '../assets/conn/dbconnect.php';
// Get the variables.
$patient_id = $_POST['ic'];

$delete = mysqli_query($con,"DELETE FROM receptionist WHERE receptionist_id=$patient_id");



?>

