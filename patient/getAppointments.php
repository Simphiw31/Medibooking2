<?php
session_start();
include_once '../assets/conn/dbconnect.php';

   
$status = $_GET['q'];
$res = mysqli_query($con,"SELECT * FROM appointments WHERE appointment_status LIKE '$status' ");//AND doctor_id LIKE '$docID'");
if (!$res) {
die("Error running $sql: " . mysqli_error());
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <?php
        if (mysqli_num_rows($res)==0) {
        echo "<div class='alert alert-danger' role='alert'>Doctor is not available at the moment. Please check for an available date and time.</div>";
        
        } else {
        echo "   <table class='table table-hover'>";
            echo " <thead>";
                echo " <tr>";
                    echo " <th>App Id</th>";
                    echo " <th>Date</th>";
                    echo "  <th>Start Time</th>";
                    echo "  <th>End Time</th>";
                    echo " <th>Availability</th>";
                    echo "  <th>Book Now!</th>";
                echo " </tr>";
            echo "  </thead>";
            echo "  <tbody>";
                while($row = mysqli_fetch_array($res)) {
                ?>
                <tr>
                    <?php
                    if ($row['schedule_status']!='Available') {
                    $avail="danger";
                    $btnstate="disabled";
                    $btnclick="danger";
                    } else {
                    $avail="primary";
                    $btnstate="";
                    $btnclick="primary";
                    }

                   
                   
                    echo "<td>" . $row['schedule_id'] . "</td>";
                    echo "<td>" . $row['schedule_date'] . "</td>";
                    echo "<td>" . $row['schedule_startTime'] . "</td>";
                    echo "<td>" . $row['schedule_endTime'] . "</td>";
 

                    echo "<td> <span class='label label-".$avail."'>". $row['schedule_status'] ."</span></td>";
                    echo "<td><a href='appointment.php?&appointment_ID=" . $row['schedule_id'] . "&schedule_date=".$date."' class='btn btn-".$btnclick." btn-xs' role='button' ".$btnstate.">Book Now</a></td>";

                    ?>
                    
                    </script>
                    <!-- ?> -->
                </tr>
                
                <?php
                }
                }
                ?>
            </tbody>
            <!-- modal start -->
            
            
            
            
            
        </body>
    </html>