<?php

include_once 'assets/conn/dbconnect.php';
//include ;
$q = $_GET['q'];
// echo $q;,
$res = mysqli_query($con,"SELECT schedule_date,schedule_startTime,schedule_endTime,schedule_status,a.doctor_id ,b.doctorLastName
                        FROM schedule a,doctor b
                        WHERE  schedule_date ='$q' 
                        AND a.doctor_id = b.doctor_id");// AND doctor_id='$docID'");



if (!$res) {
die("Error running $sql: " . mysqli_error());
}




?>
<!DOCTYPE html>
<html lang="en">
<head>
    
    
</head>
<body>
     <?php 

        if (mysqli_num_rows($res)==0) {

            echo "<div class='alert alert-danger' role='alert'>Doctor is not available at the moment. Please check for an available date and time.</div>";
                
            } else {
             echo "   <table class='table table-hover'>";
        echo " <thead>";
            echo " <tr>";
                echo "<th>Dr Name</th>";
                echo " <th>Date</th>";
               echo "  <th>Start</th>";
               echo "  <th>End</th>";
                echo " <th>Availability</th>";
            echo " </tr>";
       echo "  </thead>";
       echo "  <tbody>";

         while($row = mysqli_fetch_array($res)) { 

            ?>

            <tr>
                <?php

                if ($row['schedule_status']!='Available') {
                $avail="danger";
                } else {
                $avail="primary";
                
            }
                echo "<td>Dr " . $row['doctorLastName'] . "</td>";
                echo "<td>" . $row['schedule_date'] . "</td>";
                echo "<td>" . $row['schedule_startTime'] . "</td>";
                echo "<td>" . $row['schedule_endTime'] . "</td>";
                echo "<td> <span class='label label-".$avail."'>". $row['schedule_status'] ."</span></td>";
                ?>
            </tr>
        <?php
    }
}
    ?>
        </tbody>
    </body>
</html>