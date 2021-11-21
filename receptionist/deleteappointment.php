 <?php
include_once '../assets/conn/dbconnect.php';

// Get the variables.
$appointment_ID = $_POST['id'];
$nesSq = mysqli_query($con,"SELECT patient_id FROM appointment WHERE appointment_ID=$appointment_ID");
$sim = mysqli_fetch_array($nesSq);

$patient_id = trim($sim['patient_id']) ;

$delete = mysqli_query($con,"DELETE FROM appointment WHERE appointment_ID='$appointment_ID'");
if(isset($delete)) {
    header("Location: appEmail.php?patient_id='$patient_id'");
}




?> 

