<?php
session_start();
include_once '../assets/conn/dbconnect.php';




$session= $_SESSION['patientSession'];
if (isset($_GET['schedule_date']) && isset($_GET['appointment_ID'])) {
	$appdate =$_GET['schedule_date'];
	$appointment_ID = $_GET['appointment_ID'];
}
$res = mysqli_query($con,"SELECT a.*, b.*,c.* FROM schedule a INNER JOIN patient b
							JOIN doctor c
							ON c.doctor_id = a.doctor_id
WHERE a.schedule_date='$appdate' AND schedule_id='$appointment_ID' AND b.patient_id= '$session'");
$userRow=mysqli_fetch_array($res,MYSQLI_ASSOC);


	
//INSERT
if (isset($_POST['appointment'])) {
$patient_id = mysqli_real_escape_string($con,$userRow['patient_id']);
$schedule_id = mysqli_real_escape_string($con,$appointment_ID);
$symptom = mysqli_real_escape_string($con,$_POST['symptom']);
$docId = mysqli_real_escape_string($con,$_POST['doctor']);
$appdate =$_GET['schedule_date'];
$appType = "Consultation";
$avail = "notAvailalable";
$status = "Pending";

$query = "INSERT INTO appointment (  patient_id , schedule_id , appointment_symptoms , appointment_type,doctor_id ,appointment_status,appointment_diagnoses,appointment_clinicalNotes )
			VALUES ( '$patient_id', '$schedule_id', '$symptom', '$appType','$docID' ,'$status','','') ";

// update table appointment schedule
// $sql = "UPDATE schedule SET schedule_status = '$avail' WHERE schedule_id = $schedule_id" ;
// $scheduleres=mysqli_query($con,$sql);
// if ($scheduleres) {
// 	$btn= "disable";
// } 

$result = mysqli_query($con,$query);
if( $result )
{
	
?>
<script type="text/javascript">
alert('Appointment made successfully.');
</script>
<?php

header("Location: patientapplist.php?patient_id='$patient_id'");
}
else
{
	echo mysqli_error($con);
?>
<script type="text/javascript">
alert('Appointment booking fail. Please try again.');
</script>
<?php
header("Location: patient.php");
}
////



// passing true in constructor enables exceptions in PHPMailer

}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
		
		<title>Make Appoinment</title>
		<link href="assets/css/bootstrap.min.css" rel="stylesheet">
		<link href="assets/css/default/style.css" rel="stylesheet">
		<link href="assets/css/default/blocks.css" rcel="stylesheet">


		<link rel="stylesheet" href="https://formden.com/static/cdn/font-awesome/4.4.0/css/font-awesome.min.css" />

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
							<li><a href="patientapplist.php?patient_id=<?php echo $userRow['patient_id']; ?>">Appointment</a></li>
						</ul>
					</ul>
					
					<ul class="nav navbar-nav navbar-right">
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $userRow['patientFirstName']; ?> <?php echo $userRow['patientLastName']; ?><b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li>
									<a href="profile.php?patient_id=<?php echo $userRow['patient_id']; ?>"><i class="fa fa-fw fa-user"></i> Profile</a>
								</li>
								<li>
									<a href="patientapplist.php?patient_id=<?php echo $userRow['patient_id']; ?>"><i class="glyphicon glyphicon-file"></i> Appointment</a>
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
		<div class="container">
			<section style="padding-bottom: 50px; padding-top: 50px;">
				<div class="row">
					<!-- start -->
					<!-- USER PROFILE ROW STARTS
					<div class="row">
					<div class="col-md-3 col-sm-3">
							
							<div class="user-wrapper">
								<img src="assets/img/image.jpeg" class="img-responsive" />
								<div class="description">
									<h4><?php echo $userRow['patientFirstName']; ?> <?php echo $userRow['patientLastName']; ?></h4>
								
									
									<hr />
								</div>
							</div>
						</div> -->
						
						<div class="col-md-9 col-sm-9  user-wrapper">
							<div class="description">
								
								
								<div class="panel panel-default">
									<div class="panel-body">
										
										
										<form class="form" role="form" method="POST" accept-charset="UTF-8">
											<div class="panel panel-default">
												<div class="panel-heading">Patient Information</div>
												<div class="panel-body">
													
													Patient Name: <?php echo $userRow['patientFirstName'] ?> <?php echo $userRow['patientLastName'] ?><br>
													patient ID: <?php echo $userRow['patient_id'] ?><br>
													Contact Number: <?php echo $userRow['patientPhone'] ?><br>
													Address: <?php echo $userRow['patientStreetAddress'] ?>
												</div>
											</div>
											<div class="panel panel-default">
												<div class="panel-heading">Appointment Information</div>
												<div class="panel-body">
													Date: <?php echo $userRow['schedule_date'] ?><br>
													Time: <?php echo $userRow['schedule_startTime'] ?> - <?php echo $userRow['schedule_endTime'] ?><br>
												</div>
											</div>
											<div class="panel panel-default">
												<div class="panel-heading">Doctor Information</div>
												<div class="panel-body">
													Doctor: Dr <?php echo substr($userRow['doctorFirstName'],0,1) ." ". $userRow['doctorLastName']?><br>
													Profession: <?php echo $userRow['doctorSpecialty'] ?> <br>
													<?php $_POST['doctor'] = $userRow['doctor_id'];?>
												</div>
											</div>

											
											
											<div class="form-group">
												<label for="recipient-name" class="control-label">Symptom:</label>
												<input type="text" class="form-control" name="symptom" required>
											</div>
											<!-- <div class="form-group">
												<label for="message-text" class="control-label">Comment:</label>
												<textarea class="form-control" name="comment" required></textarea>
											</div> -->
											<div class="form-group">
												<input type="submit" name="appointment" id="submit" class="btn btn-primary" value="Make Appointment">
											</div>
										</form>
									</div>
								</div>
								
							</div>
							
						</div>
					</div>
					<!-- USER PROFILE ROW END-->
					<!-- end -->
					<script src="assets/js/jquery.js"></script>
			<script src="assets/js/bootstrap.min.js"></script>
				</body>
			</html>