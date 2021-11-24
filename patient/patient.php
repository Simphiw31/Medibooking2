//<?php
session_start();
include_once '../assets/conn/dbconnect.php';
if(!isset($_SESSION['patientSession']))
{
header("Location: ../index.php");
}

$usersession = $_SESSION['patientSession'];


$res=mysqli_query($con,"SELECT * FROM patient WHERE patient_id = '$usersession'");

if ($res===false) {
	echo mysql_error();
} 

$userRow=mysqli_fetch_array($res,MYSQLI_ASSOC);


if(isset($_POST['searchAppointment'])){
	$date =  mysqli_real_escape_string($con,$_POST['date']);
	$doctor =  mysqli_real_escape_string($con,$_POST['doctor']);

	$res=mysqli_query($con,"SELECT * FROM schedule ");//WHERE schedule_date = ".strtotime($date));//AND doctor_id = '$doctor'");
	 
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

}
?>



<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- Tags nd css-->
		<title>Patient Dashboard</title>
		<link href="assets/css/material.css" rel="stylesheet">
		<link href="assets/css/default/style.css" rel="stylesheet">
		<link href="assets/css/default/blocks.css" rel="stylesheet">
		<link href="assets/css/date/bootstrap-datepicker.css" rel="stylesheet">
		<link href="assets/css/date/bootstrap-datepicker3.css" rel="stylesheet">
		<link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css" />
		
	</head>
	<body>
		
		<!-- navigation -->
		<nav class="navbar navbar-default " role="navigation">
			<div class="container-fluid">
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="patient.php"><img alt="Brand" src="assets/img/2.png" height="40px"></a>
				</div>
				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav">
						<ul class="nav navbar-nav">
							<li><a href="patient.php">Home</a></li>
							<!-- <li><a href="profile.php?patient_id =<?php echo $userRow['patient_id']; ?>">Profile</a></li> -->
							<li><a href="patientapplist.php?patient_id =<?php echo $userRow['patient_id']; ?>">Appointment</a></li>
						</ul>
					</ul>
					
					<ul class="nav navbar-nav navbar-right">
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $userRow['patientFirstName']; ?> <?php echo $userRow['patientLastName']; ?><b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li>
									<a href="profile.php?patient_id =<?php echo $userRow['patient_id']; ?>"><i class="fa fa-fw fa-user"></i> Profile</a>
								</li>
								<li>
									<a href="patientapplist.php?patient_id =<?php echo $userRow['patient_id']; ?>"><i class="glyphicon glyphicon-file"></i> Appointment</a>
								</li>
								<li class="divider"></li>
								<li>
									<a href="patientlogout.php?logout"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
								</li>
							</ul>
						</li>
					</ul>
				</div>
			</div>
		</nav>
		<!-- navigation -->
		
		<!-- 1st section start -->
		<section style="background: url(assets/img/cover2.jpg) backgroud-size:cover" id="promo-1" class="content-block promo-1 min-height-600px bg-offwhite">
			<div class="container">
				<div class="row">
					<div class="col-xs-12 col-md-8">
						
						
						<?php if ($userRow['patientPhone']=="") {
						// <!-- / notification start -->
						
							echo "<div class='row'>";
							echo "<div class='col-lg-12'>";
								echo "<div class='alert alert-danger alert-dismissable'>";
									echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
									echo " <i class='fa fa-info-circle'></i>  <strong>Please complete your profile.</strong>" ;
								echo "  </div>";
							echo "</div>";
							// <!-- notification end -->
							
							} else {
							}
							?>
									<!-- <input type="submit" name="doctor" value="Select"> -->
								
   
							<!-- notification end -->
							<h2>Hi <?php echo $userRow['patientFirstName']; ?> <?php echo $userRow['patientLastName']; ?>, Please select an appointment date</h2>
							<?php
								$quer = "SELECT * from doctor order by doctorLastName ";

							$result=mysqli_query($con,$quer);
							
							// include __DIR__. "/../doctordrop.php";
							
							?><div class="input-group" style="margin-bottom:10px;">
								<div class="input-group-addon">
									
								</div>
								
								<form action="" method="POST" name="searchAppointment">
								show schedule slots for : <input method="post" type="date" id="date" name="appdate" min="<?php echo date("Y-m-d")?>" value="<?php echo date("Y-m-d")?>" onchange=showUser(this.value)/>
                            	&nbsp;&nbsp;&nbsp; For &nbsp;&nbsp;&nbsp;
								<select name="doctor" >
									<option value="%">All Doctors</option>
									<?php
									while ($doctors=mysqli_fetch_array($result)) {
                                    ?><option value="<?php echo $doctors["doctor_id"]?>">Dr <?php echo substr($doctors["doctorFirstName"],0,1)." " .$doctors["doctorLastName"]." (" .$doctors["doctorSpecialty"].")"?> </option>;<?php
									}
                                    echo"</select>";?>
									<button  type="submit2" name="submit2" class="btn btn-block btn-warning"><i class="fa fa-search" aria-hidden="true"></i>Search appointment date </button>
									</form>
								
							</div>
							
						</div><?php
						// echo "<div class='panel panel-primary'>";
// echo "<div class='panel-heading'>List of Appointment</div>";

if (isset($_POST['submit2'])){
	$date =$_POST['appdate'];
	$docID =$_POST['doctor'];
	$res = mysqli_query($con, "SELECT a.*, b.*
		FROM schedule a
		JOIN doctor b
		ON a.doctor_id =b.doctor_id
		WHERE schedule_date = '$date'
		AND a.doctor_id LIKE '$docID'
		AND a.schedule_status LIKE 'Available'");

echo "<div class='panel-body'>";
echo "<table class='table table-hover'>";
echo "<thead>";
echo "<tr>";
echo "<th>Doctor </th>";
echo "<th>Profession </th>";
echo "<th>Schedule Date </th>";
echo "<th>Schedule StartTime </th>";
echo "<th>Schedule Duration </th>";
echo "<th>Schedule Status </th>";
// echo "<th>Print </th>";
// echo "<th>Cancel Appointment</th>";
echo "</tr>";
echo "</thead>";


if (!$res) {
	die("Error running $sql: " . mysqli_error($con));
	}
	
	while ($userRow = mysqli_fetch_array($res)) {

		if ($userRow['schedule_status']!='Available') {
			$avail="danger";
			$btnstate="disabled";
			$btnclick="danger";
			} else {
			$avail="primary";
			$btnstate="";
			$btnclick="primary";
			}


			// $scheduleID=$userRow['schedule_id'];

	echo "<tbody>";
	echo "<tr>";
	echo "<td>Dr " . $userRow['doctorLastName'] . "</td>";
	echo "<td>" . $userRow['doctorSpecialty'] . "</td>";
	echo "<td>" . $userRow['schedule_date'] . "</td>";

	echo "<td>" . $userRow['schedule_startTime'] . "</td>";
	$duration = (strtotime($userRow['schedule_endTime']) -strtotime($userRow['schedule_startTime']))/60;
	echo "<td>" . $duration. " minutes </td>";
	echo "<td> <span class='label label-".$avail."'>". $userRow['schedule_status'] ."</span></td>";
	echo "<td><a href='appointment.php?&appointment_ID=" . $userRow['schedule_id']. "&schedule_date=".$date."' class='btn btn-".$btnclick." btn-xs' role='button' ".$btnstate.">Book Now</a></td>";
	// echo "<td class='text-center'><a href='deleteappointment.php?appointment_ID=".$userRow['appointment_ID']."' class='delete'><span class='fa fa-close' aria-hidden='true'></span></a></td>";
	}


}else{}?>
						<!-- date textbox end -->
						<!-- script start -->
						<!-- <script>

						function showUser(str,doc) {
						
						if (str == "") {
						document.getElementById("txtHint").innerHTML = "No data to be shown";
						return;
						} else if(doc=="") {
						if (window.XMLHttpRequest) {
						// code for IE7+, Firefox, Chrome, Opera, Safari
						xmlhttp = new XMLHttpRequest();
						} else {
						// code for IE6, IE5
						xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
						}
						xmlhttp.onreadystatechange = function() {
						if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
						document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
						}
						};
						xmlhttp.open("GET","getschedule.php?q="+str+"p="+doc,true);
						console.log(str,doc);
						xmlhttp.send();
						}else {
						if (window.XMLHttpRequest) {
						// code for IE7+, Firefox, Chrome, Opera, Safari
						xmlhttp = new XMLHttpRequest();
						} else {
						// code for IE6, IE5
						xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
						}
						xmlhttp.onreadystatechange = function() {
						if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
						document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
						}
						};
						xmlhttp.open("GET","getschedule.php?q="+str+"&p="+doc,true);
						console.log(str,doc);
						xmlhttp.send();
					}
						}
						</script>
						
						<!-- script start end -->
						 -->
						<!-- table appointment start -->
						<!-- <div class="container"> -->
						<div class="container">
							<div class="row">
								<div class="col-xs-12 col-md-8">
									<div id="txtHint"></div>
								</div>
							</div>
						</div>
						<!-- </div> -->
						<!-- table appointment end -->
					</div>
				</div>
				<!-- /.row -->
			</div>
		</section>
		
		<!-- forth section end -->
		
		
		
		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="assets/js/jquery.js"></script>
		<script src="assets/js/date/bootstrap-datepicker.js"></script>
		<script src="assets/js/moment.js"></script>
		<script src="assets/js/transition.js"></script>
		<script src="assets/js/collapse.js"></script>
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<script src="assets/js/bootstrap.min.js"></script>
		
		<!-- date start -->
		<script>
		$(document).ready(function(){
		var date_input=$('input[name="date"]'); //our date input has the name "date"
		var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
		date_input.datepicker({
		format: 'yyyy-mm-dd',
		container: container,
		todayHighlight: true,
		autoclose: true,
		})
		})
		</script>
		<!-- date end -->
		
		
	</body>
</html>