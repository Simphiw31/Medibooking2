<!-- <?php
include_once '../assets/conn/dbconnect.php';


$patient = $_GET['patient_id'];

$result = mysqli_query($con,"SELECT a.*, b.*,c.*
                            FROM patient a
                            JOIN appointment b
                            On a.patient_id = b.patient_id
                            JOIN schedule c
                            On b.schedule_id=c.schedule_id
                            WHERE a.patient_id=$patient");
$sim = mysqli_fetch_array($result,MYSQLI_ASSOC);

$patientEmail =$sim['patientEmail'];
$patientLastName=$sim['patientLastName'];
$patientFirstName=$sim['patientFirstName'];
$scheduleDate =$sim['schedule_date'];

header("Location: patientapplist.php");
?> -->
