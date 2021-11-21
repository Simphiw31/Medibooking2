<?php
session_start();
include_once '../assets/conn/dbconnect.php';
if (isset($_GET['appointment_ID'])) {
$appointment_ID=$_GET['appointment_ID'];
}
$res=mysqli_query($con, "SELECT a.*, b.*,c.*,d.*,e.* FROM patient a
JOIN appointment b
On a.patient_id = b.patient_id
JOIN schedule c
On b.schedule_id=c.schedule_id
JOIN city d
ON d.cityZipCode = a.cityZipCode
JOIN province e
ON d.provinceZipCode= e.provinceZipCode
WHERE b.appointment_ID  =".$appointment_ID);

$userRow=mysqli_fetch_array($res,MYSQLI_ASSOC);
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>A simple, clean, and responsive HTML invoice template</title>
        
        <link rel="stylesheet" type="text/css" href="assets/css/invoice.css">
    </head>
    <body>
        <div class="invoice-box">
            <table cellpadding="0" cellspacing="0">
                <tr class="top">
                    <td colspan="2">
                        <table>
                            <tr>
                                <td class="title">
                                    <img src="assets/img/2.png" style="width:100%; max-width:300px;">
                                </td>
                                
                                <td>
                                    Invoice #: <?php echo $userRow['appointment_ID'];?><br>
                                    Created: <?php echo date("d-m-Y");?><br>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                
                <tr class="information">
                    <td colspan="2">
                        <table>
                            <tr>
                                <td>
                                    <?php echo $userRow['patientStreetAddress'];?><br>
                                    <?php echo $userRow['provinceName'];?>,<br>
                                    <?php echo $userRow['cityName'];?><br>
                                    <?php echo $userRow['cityZipCode'];?>
                                </td>
                                
                                <td><?php echo $userRow['patient_id'];?><br>
                                    <?php echo $userRow['patientFirstName'];?> <?php echo $userRow['patientLastName'];?><br>
                                    <?php echo $userRow['patientEmail'];?>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                
                
                
                <tr class="heading">
                    <td>
                        Appointment Details
                    </td>
                    
                    <td>
                        #
                    </td>
                </tr>
                
                <tr class="item">
                    <td>
                        Appointment ID
                    </td>
                    
                    <td>
                       <?php echo $userRow['appointment_ID'];?>
                    </td>
                </tr>
                
                <tr class="item">
                    <td>
                        Schedule ID
                    </td>
                    
                    <td>
                        <?php echo $userRow['schedule_id'];?>
                    </td>
                </tr>
          

                 <tr class="item">
                    <td>
                        Appointment Date
                    </td>
                    
                    <td>
                        <?php echo $userRow['schedule_date'];?>
                    </td>
                </tr>

                 <tr class="item">
                    <td>
                        Appointment Time
                    </td>
                    
                    <td>
                        <?php echo $userRow['schedule_startTime'];?> untill <?php echo $userRow['schedule_endTime'];?>
                    </td>
                </tr>

                <tr class="item">
                    <td>
                        Patient Symptom
                    </td>
                    
                    <td>
                        <?php echo $userRow['appointment_symptoms'];?> 
                    </td>
                </tr>

                <tr class="item">
                    <td>
                        Doctor diagnoses
                    </td>
                    
                    <td>
                        <?php echo $userRow['appointment_diagnoses'];?> 
                    </td>
                </tr>
                
                
                
            </table>
        </div>
        <div class="print">
        <button onclick="myFunction()">Print this page</button>
</div>
<script>
function myFunction() {
    window.print();
}
</script>
    </body>
</html>