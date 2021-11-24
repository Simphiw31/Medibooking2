<?php
session_start();
include_once '../assets/conn/dbconnect.php';
$session=$_SESSION[ 'patientSession'];
if(!isset($_POST['filterApp'])){


$res=mysqli_query($con, "SELECT a.*, b.*,c.* FROM patient a
	JOIN appointment b
		On a.patient_id = b.patient_id
	JOIN schedule c
		On b.schedule_id=c.schedule_id
	WHERE b.patient_id ='$session'");
}else{
	$status = $_POST['appointmentStatus'];
	$appDate = date("y-m-d",strtotime($_POST['appdate']));
	$appDate1 = date("y-m-d",strtotime($_POST['appdate1']));
	$res=mysqli_query($con, "SELECT a.*, b.*,c.* FROM patient a
							JOIN appointment b
							On a.patient_id = b.patient_id
							JOIN schedule c
							On b.schedule_id=c.schedule_id
							WHERE b.patient_id ='$session'
							AND c.schedule_status LIKE '$status'
							AND b.schedule_date BETWEEN '$appDate' AND '$appDate1'");
}
	if ($res) {
		$res=mysqli_query($con,"SELECT * FROM patient WHERE patient_id= '$session'");
	}
	$userRow=mysqli_fetch_array($res);

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
		<title>Make Appoinment</title>
	<link href="assets/css/material.css" rel="stylesheet">
		
		<link href="assets/css/default/style.css" rel="stylesheet">
		<link href="assets/css/default/blocks.css" rcel="stylesheet">
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
							<li><a href="patientapplist.php">Appointment</a></li>
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
<!-- display appoinment start -->
<?php


echo "<div class='container'>";
echo "<div class='row'>";
echo "<div class='page-header'>";
echo "<h1>Your appointment list. </h1>";
echo "</div>";
		?>
		<form action="<?php $_PHP_SELF ?>" method="post" >
				<div style="text-align:center">
				<!-- maintaining dropdown state -->
				<?php
					$appStatus='';
					$sortby='';
					if (isset($_POST))
						if (is_array($_POST)){
							if (isset($_POST['appointmentStatus'])){
								$appStatus = $_POST['appointmentStatus'];
								$sortby =$_POST['sort'];
							}
							if(isset($_POST['appdate'])){
								$appdat=date($_POST['appdate']);
								$appdat1=date($_POST['appdate1']);
							}else {
								$appdat = date('Y-m-d');
								$appdat1 = date('Y-m-t');

							}
							
	
						}

					
				?>
			Show :
			<select name="appointmentStatus">
				
				<option value="%">All Appointments</option>
				<option value="Attended" <?php if($appStatus=='Attended') echo ' selected="selected"'; ?>>All Attended Appointments</option>
				<option value="Pending" <?php if($appStatus=='Pending') echo ' selected="selected"'; ?>>All Pending Appointments</option>
				<option value="Missed" <?php if($appStatus=='Missed') echo ' selected="selected"'; ?>>All Missed Appointments</option>
				<option value="Cancelled" <?php if($appStatus=='Cancelled') echo ' selected="selected"'; ?>>All Canceled Appointments</option>
				
			</select>
			Sort By: <select  name='sort'>
			<option disabled >Ascending</option>

                       <option value='appointment_status ASC' <?php if($sortby=='appointment_status ASC') echo ' selected="selected"'; ?>>Appointment Status   </option>
					   <option value='schedule_date ,schedule_startTime ASC' <?php if($sortby=='schedule_date ,schedule_startTime ASC') echo ' selected="selected"'; ?>>Appointment Date  &nbsp;&nbsp;&nbsp;&nbsp;</option>
					   <option disabled >----------</option>
					   <option disabled >Descending</option>
					   <option value='appointment_status DESC' <?php if($sortby=='appointment_status DESC') echo ' selected="selected"'; ?>>Appointment Status  </option>
					   
                       <option value='schedule_date,schedule_startTime DESC' <?php if($sortby=='schedule_date,schedule_startTime DESC') echo ' selected="selected"'; ?>>Appointment Date  &nbsp;&nbsp;&nbsp;&nbsp;</option>
                                
                                 </select>
			&nbsp;&nbsp;&nbsp;&nbsp;
			show appointments from : <input type="date" id="date" name="appdate" value="<?php echo $appdat?>"/>
			&nbsp;&nbsp;&nbsp;to &nbsp;&nbsp;&nbsp; <input type="date" id="date" name="appdate1" value="<?php echo $appdat1?>">
			&nbsp;&nbsp;&nbsp;<button class='btn btn-primary' type='submit' value='Submit' name='submit'>Show Only</button>
		</div>
		</form><br>
		
		<?php
echo "<div class='panel panel-primary'>";
echo "<div class='panel-heading'>List of Appointment</div>";
echo "<div class='panel-body'>";
echo "<table class='table table-hover'>";
echo "<thead>";
echo "<tr>";
echo "<th>Doctor </th>";
echo "<th>Appointment Type </th>";
echo "<th>Appointment Date </th>";
echo "<th>Appointment StartTime </th>";
echo "<th>Appointment Duration </th>";
echo "<th>Appointment Status </th>";
echo "<th>Print </th>";
echo "<th>Cancel Appointment</th>";
echo "</tr>";
echo "</thead>";
if (!isset($_POST['submit'])){
$res = mysqli_query($con, "SELECT a.*, b.*,c.*,d.*
		FROM patient a
		JOIN appointment b
		On a.patient_id = b.patient_id
		JOIN schedule c
		On b.schedule_id=c.schedule_id
		JOIN doctor d
		ON d.doctor_id =c.doctor_id
		WHERE b.patient_id ='$session'");
}else{
	$appStatus = $_POST['appointmentStatus'];
	$date1 = $_POST['appdate1'];
	$date = $_POST['appdate'];
	$sortby = $_POST['sort'];
	$res = mysqli_query($con, "SELECT a.*, b.*,c.*,d.*
		FROM patient a
		JOIN appointment b
		On a.patient_id = b.patient_id
		JOIN schedule c
		On b.schedule_id=c.schedule_id
		JOIN doctor d
		ON d.doctor_id =c.doctor_id
		WHERE b.patient_id ='$session'
		AND b.appointment_status LIKE '$appStatus'
		AND c.schedule_date BETWEEN '$date' AND '$date1'
		ORDER BY ".$sortby);
		
}



if (!$res) {
die("Error running $sql: " . mysqli_error($con));
}

while ($userRow = mysqli_fetch_array($res)) {
echo "<tbody>";
echo "<tr>";
echo "<td>Dr " . $userRow['doctorLastName'] . "</td>";
echo "<td>" . $userRow['appointment_type'] . "</td>";
echo "<td>" . $userRow['schedule_date'] . "</td>";
echo "<td>" . $userRow['schedule_startTime'] . "</td>";
$duration = (strtotime($userRow['schedule_endTime']) -strtotime($userRow['schedule_startTime']))/60;
echo "<td>" . $duration. " minutes </td>";
echo "<td>" . $userRow['appointment_status'] . "</td>";
echo "<td><a href='invoice.php?appointment_ID=".$userRow['appointment_ID']."' target='_blank'><span class='fa fa-print' aria-hidden='true'></span></a> </td>";
// echo "<td class='text-center'><a href='deleteappointment.php?appointment_ID=".$userRow['appointment_ID']."' class='delete'><span class='fa fa-close' aria-hidden='true'></span></a></td>";
echo "<td class='text-center'><a href='#' id='".$userRow['appointment_ID']."' class='delete'><span class='fa fa-close' aria-hidden='true'></span></a></td>";

}

echo "</tr>";
echo "</tbody>";
echo "</table>";

?>
	</div>
</div>
</div>
</div>

        <!-- jQuery -->
        <script src="../patient/assets/js/jquery.js"></script>
        <script type="text/javascript">
$(function() {
$(".delete").click(function(){
var element = $(this);
var ic = element.attr("id");
var info = 'ic=' + ic;
if(confirm("Are you sure you want to cancel this?"))
{
 $.ajax({
   type: "POST",
   url: "appDelete.php",
   data: info,
   success: function(){
 }
});
  $(this).parent().parent().fadeOut(300, function(){ $(this).remove();});
 }
return false;
});
});
</script>


<!-- display appoinment end  -->
<script src="assets/js/jquery.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
</body>
</html>