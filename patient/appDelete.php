
<?php
include_once '../assets/conn/dbconnect.php';
// Get the variables.
$appointment_ID = $_POST['id'];


$nesSq = mysqli_query($con,"SELECT schedule_id FROM appointment WHERE appointment_ID='$appointment_ID'");
$sim = mysqli_fetch_array($nesSq);

$schedule = $sim['schedule_id'] ;


$delete = mysqli_query($con,"UPDATE FROM appointment SET appointment_status = 'Canceled' WHERE appointment_ID='$appointment_ID'");

if(isset($delete)) {
    $sql = mysqli_query($con,"UPDATE schedule SET schedule_status = 'Available' WHERE schedule_id='$schedule'") ;
}
header('Location: patientapplist.php');
?>