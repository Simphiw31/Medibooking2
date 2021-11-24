<?php
session_start();
include_once '../assets/conn/dbconnect.php';
// include_once 'connection/server.php';
if(!isset($_SESSION['receptionistSession']))
{
header("Location: ../index.php");
}
$usersession = $_SESSION['receptionistSession'];
$res=mysqli_query($con,"SELECT * FROM receptionist WHERE receptionistEmail= '$usersession'");
$userRow=mysqli_fetch_array($res,MYSQLI_ASSOC);
// insert

// Adding a schedule 
        if (isset($_POST['submit'])) {

            $date = mysqli_real_escape_string($con,$_POST['date']);
            $starttime     = strtotime(mysqli_real_escape_string($con,$_POST['starttime']));
            $endtime     = strtotime(mysqli_real_escape_string($con,$_POST['endtime']));
            $bookavail         = 'Available';
            $duration = mysqli_real_escape_string($con,$_POST['appointmentDuration']);
            $rec_id = $userRow['receptionist_id'];
            $doc_id = mysqli_real_escape_string($con,$_POST['doctor']);
        //INSERT
            $appType = mysqli_real_escape_string($con,$_POST['appointmentType']);
                if($appType=='daily'){
                    $time=$starttime;
                    for($i=$starttime;$i<$endtime;$i=$i+$duration*60){
                    $time = $time+$duration*60;    
                    $it=date("H:i",$i);
                    $times=date("H:i",$time);

                    $query = " INSERT INTO schedule (  schedule_date , schedule_startTime , schedule_endTime , schedule_status , receptionist_id , doctor_id)
                                VALUES ( '$date', '$it', '$times', '$bookavail' ,'$rec_id','$doc_id') ";
                    
                    
                    
                    $result = mysqli_query($con, $query);
                    // echo $result;
                }
            
                    if($result )
                    {
                        ?>
                        <script type="text/javascript">
                        alert('Schedule added successfully.');
                        
                        </script>
                        <?php
                        // exit();
                    }
                    else
                    {
                        ?>
                        <script type="text/javascript">
                        alert('Added fail. Please try again.');
                        </script>
                        <?php
                    }
                
                }else if($appType=='weekly'){
                    //Weekly Schedule Add also not working
                    //trying to add schedule not working date manipulation not working as we thought
                    $monday = date('Y-m-d',strtotime('monday this week') );
                    $friday = date('Y-m-d',strtotime('firday this week') );    
                    for($j=$monday;$j<=$friday;$j->modify('+1 day')){

                        $time=$starttime;
                        for($i=$starttime;$i<$endtime;$i=$i+$duration*60){
                        $time = $time+$duration*60;    
                        $it=date("H:i",$i);
                        $times=date("H:i",$time);
    
                        $query = " INSERT INTO schedule (  schedule_date , schedule_startTime , schedule_endTime , schedule_status , receptionist_id , doctor_id)
                                    VALUES ( '$date', '$it', '$times', '$bookavail' ,'$rec_id','$doc_id') ";
                        
                        
                        // $starttime = strtotime('+'.$duration,strtotime($starttime));
                        
                        $result = mysqli_query($con, $query);
                    
                    }
                
                
                        if($result )
                        {
                            ?>
                            <script type="text/javascript">
                            alert('Schedule added successfully.');
                            
                            </script>
                            <?php
                           
                        }
                        else
                        {
                            ?>
                            <script type="text/javascript">
                            alert('Added fail. Please try again.');
                            </script>
                            <?php
                        }
                }
            }else{
                //Monthly Schedule Add
                //trying to add schedule not working date manipulation not working as we thought
                $_POST['startdate'] = date("Y-m-d");
                $d = new DateTime($_POST['startdate']);
                $t = $d->getTimestamp();
                for($x = $d ;$x<=date("y-m-t");$x->modify('+1 day')){
                    $addDay=86400;
                    $nextDay = date('w',($t+$addDay));
                    if(!$nextDay==0 ||$nextDay==6){
                        $time=$starttime;
                    for($i=$starttime;$i<$endtime;$i=$i+$duration*60){
                    $time = $time+$duration*60;    
                    $it=date("H:i",$i);
                    $times=date("H:i",$time);
                    $xt = date('y-m-d',$x);
                    $query = " INSERT INTO schedule (  schedule_date , schedule_startTime , schedule_endTime , schedule_status , receptionist_id , doctor_id)
                                VALUES ( '$xt', '$it', '$times', '$bookavail' ,'$rec_id','$doc_id') ";
                    
                    
                   
                    
                    $result = mysqli_query($con, $query);
                  
                }
            
                    if($result )
                    {
                        ?>
                        <script type="text/javascript">
                        alert('Schedule added successfully.');
                        
                        </script>
                        <?php
                        // exit();
                    }
                    else
                    {
                        ?>
                        <script type="text/javascript">
                        alert('Added fail. Please try again.');
                        </script>
                        <?php
                    }
                    }

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
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Welcome Receptionist <?php echo $userRow['name'];?> <?php echo $userRow['surname'];?></title>
        <!-- Bootstrap Core CSS -->
        <link href="assets/css/material.css" rel="stylesheet">
        <!-- Custom CSS -->
        <link href="assets/css/sb-admin.css" rel="stylesheet">
        <link href="assets/css/time/bootstrap-clockpicker.css" rel="stylesheet">
        <link href="assets/css/style.css" rel="stylesheet">
        <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet">
        <!-- Special version of Bootstrap that only affects content wrapped in .bootstrap-iso -->
        <link rel="stylesheet" href="https://formden.com/static/cdn/bootstrap-iso.css" /> 

        <!--Font Awesome (added because you use icons in your prepend/append)-->
        <link rel="stylesheet" href="https://formden.com/static/cdn/font-awesome/4.4.0/css/font-awesome.min.css" />

        <!-- Inline CSS based on choices in "Settings" tab -->
        <style>.bootstrap-iso .formden_header h2, .bootstrap-iso .formden_header p, .bootstrap-iso form{font-family: Arial, Helvetica, sans-serif; color: black}.bootstrap-iso form button, .bootstrap-iso form button:hover{color: white !important;} .asteriskField{color: red;}</style>

        <!-- Custom Fonts -->
    </head>
    <body>
        <div id="wrapper">

            <!-- Navigation -->
            <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="dashboard.php">Welcome Receptionist <?php echo $userRow['receptionistFirstName'];?> <?php echo $userRow['receptionistLastName'];?></a>
                </div>
                <!-- Top Menu Items -->
                <ul class="nav navbar-right top-nav">
                    
                    
                <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $userRow['receptionistFirstName']; ?> <?php echo $userRow['receptionistLastName']; ?><b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="profile.php"><i class="fa fa-fw fa-user"></i> Profile</a>
                            </li>
                           
                            <li class="divider"></li>
                            <li>
                                <a href="logout.php?logout"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
                <div class="collapse navbar-collapse navbar-ex1-collapse">
                    <ul class="nav navbar-nav side-nav">
                        <li>
                            <a href="dashboard.php"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
                        </li>
                        <li class="active">
                            <a href="addschedule.php"><i class="fa fa-fw fa-table"></i> doctor Schedule</a>
                        </li>
                        <li>
                            <a href="patientlist.php"><i class="fa fa-fw fa-edit"></i> Patient List</a>
                        </li>
                    </ul>
                </div>
                <!-- /.navbar-collapse -->
            </nav>
            <!-- navigation end -->

            <div id="page-wrapper">
                <div class="container-fluid">
                    
                    <!-- Page Heading -->
                    <div class="row">
                        <div class="col-lg-12">
                            <h2 class="page-header">
                            doctor Schedule
                            </h2>
                            <ol class="breadcrumb">
                                <li class="active">
                                    <i class="fa fa-calendar"></i> Schedule
                                </li>
                            </ol>
                        </div>
                    </div>
                    <!-- Page Heading end-->
                                               <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Add Schedule</button>

                    <!-- panel start -->
                    <div class="panel panel-primary">

                   
                        <!-- panel end -->
                        </div>
                    </div>
                    <!-- panel start -->
                    <form action="<?php $_PHP_SELF ?>" method="post" >
				<div style="text-align:center">
				<!-- maintaining dropdown state -->
				<?php
    $quer = "SELECT * from doctor order by doctorLastName ";

    $result=mysqli_query($con,$quer);

					$scheduleStatus='';
					$sortby='';
                    $doctor='';
					if (isset($_POST))
						if (is_array($_POST))
							if (isset($_POST['scheduleStatus'])){
								$scheduleStatus = $_POST['scheduleStatus'];
								$sortby =$_POST['sort'];
                                $doctor =$_POST['doctor'];
							}if(isset($_POST['appdate'])){
								$appdat=date($_POST['appdate']);
								$appdat1=date($_POST['appdate1']);
							}else {
								$appdat = date('Y-m-d');
								$appdat1 = date('Y-m-t');

							}
				?>
                For &nbsp;&nbsp;&nbsp;
								<select name="doctor" >
									<option value="%">All Doctors</option>
									<?php
									while ($doctors=mysqli_fetch_array($result)) {
                                    ?><option value="<?php echo $doctors["doctor_id"]?>">Dr <?php echo substr($doctors["doctorFirstName"],0,1)." " .$doctors["doctorLastName"]?> </option>;<?php
									}
                                    echo"</select>";?>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			Show :
			<select name="scheduleStatus">
				
				<option value="%">All Schedules</option>
				<option value="Available" <?php if($scheduleStatus=='Available') echo ' selected="selected"'; ?>>All Available Schedules</option>
				<option value="notAvailable" <?php if($scheduleStatus=='notAvailable') echo ' selected="selected"'; ?>>All Unavailable Schedules</option>
			
			</select>
			Sort By: <select  name='sort'>
			<option disabled >Ascending</option>
                         <option value='schedule_status ASC' <?php if($sortby=='schedule_status ASC') echo ' selected="selected"'; ?>>Schedule Status  </option>
					   <option value='schedule_date ,schedule_startTime ASC' <?php if($sortby=='schedule_date ,schedule_startTime ASC') echo ' selected="selected"'; ?>>Schedule Date  &nbsp;&nbsp;&nbsp;&nbsp;</option>
					   <option disabled >----------</option>
					   <option disabled >Descending</option>
					   <option value='schedule_status DESC' <?php if($sortby=='schedule_status DESC') echo ' selected="selected"'; ?>>Schedule Status  </option>
					   
                       <option value='schedule_date,schedule_startTime DESC' <?php if($sortby=='schedule_date,schedule_startTime DESC') echo ' selected="selected"'; ?>>Schedule Date  &nbsp;&nbsp;&nbsp;&nbsp;</option>
                                
                                 </select>
			&nbsp;&nbsp;&nbsp;&nbsp;
			show from : <input type="date" id="date" name="appdate" value="<?php echo date("Y-m-d")?>"/>
			&nbsp;&nbsp;&nbsp;to &nbsp;&nbsp;&nbsp; <input type="date" id="date" name="appdate1" value="<?php echo date('Y-m-t')?>">
			&nbsp;&nbsp;&nbsp;<button class='btn btn-primary' type='submit' value='submit2' name='submit2'>Show Only</button>
		</div>
		</form><br>
                     <!-- panel start -->
                    <div class="panel panel-primary filterable">

                        <!-- panel heading starat -->
                        <div class="panel-heading">
                            <h3 class="panel-title">List of Schedules</h3>
                            <div class="pull-right">
                            <button class="btn btn-default btn-xs btn-filter"><span class="fa fa-filter"></span> Filter</button>
                        </div>
                        </div>
                        <!-- panel heading end -->

                        <div class="panel-body">
                        <!-- panel content start -->
                           <!-- Table -->
                        <table class="table table-hover table-bordered">
                            <thead>
                                <tr class="filters">
                                    <th><input type="text" class="form-control" placeholder="Doctor" disabled></th>
                                    <th><input type="text" class="form-control" placeholder="Schedule date" disabled></th>
                                    <th><input type="text" class="form-control" placeholder="Start time." disabled></th>
                                    <th><input type="text" class="form-control" placeholder="End time" disabled></th>
                                    <th><input type="text" class="form-control" placeholder="Schedule Status" disabled></th>
                                    <th><input type="text" class="form-control" placeholder="Delete" disabled></th>
                                </tr>
                            </thead>
                            
                            <?php 
                            if(!isset($_POST['submit2'])){
                            $result=mysqli_query($con,"SELECT * FROM schedule a,doctor b WHERE a.doctor_id = b.doctor_id");
                            }else{
                                $scheduleStatus = $_POST['scheduleStatus'];
                                $doctor = $_POST['doctor'];
	                            $date1 = $_POST['appdate1'];
                                $date = $_POST['appdate'];
                                $sortby = $_POST['sort'];
                                $result=mysqli_query($con,"SELECT * 
                                                        FROM schedule a,doctor b 
                                                        WHERE a.doctor_id = b.doctor_id
                                                        AND a.doctor_id LIKE '$doctor'
                                                        AND schedule_status LIKE '$scheduleStatus'
                                                        AND schedule_date BETWEEN '$date' AND '$date1'
                                                        ORDER BY '$sortby'");
                        }



                                  
                            while ($schedule=mysqli_fetch_array($result)) {
                                
                              
                                echo "<tbody>";
                                echo "<tr>";
                                    echo "<td> Dr " . $schedule['doctorLastName'] . "</td>";
                                    echo "<td>" . $schedule['schedule_date'] . "</td>";
                                    echo "<td>" . $schedule['schedule_startTime'] . "</td>";
                                    echo "<td>" . $schedule['schedule_endTime'] . "</td>";
                                    echo "<td>" . $schedule['schedule_status'] . "</td>";
                                    echo "<form method='POST'>";
                                    echo "<td class='text-center'><a href='#' id='".$schedule['schedule_id']."' class='delete'><span class='fa fa-trash' aria-hidden='true'></span></a>
                            </td>";
                               
                            } 
                                echo "</tr>";
                           echo "</tbody>";
                       echo "</table>";
                       echo "<div class='panel panel-default'>";
                       echo "<div class='col-md-offset-3 pull-right'>";
                    //    echo "<button class='btn btn-primary' type='submit2' value='Submit' name='submit'>Update</button>";
                        echo "</div>";
                        echo "</div>";
                        ?>
                        <!-- panel content end -->
                        <!-- panel end -->
                        </div>
                    </div>
                    <!-- panel start -->
                </div>
            </div>
        <!-- /#wrapper -->






        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>   
                                    </div>
                                    <div class="modal-body">
                                        <!-- form start -->
                                        <form name="addSchedule" class="form-horizontal" method="post">
                                        <h4>Enter Schedule Details.</h4>
                                        <td>
											<div style="text-align:center" class="radio" required>
												<label><input type="radio" name="appointmentType" value="daily">Daily Schedule</label>
												<label><input type="radio" name="appointmentType" value="weekly">Weekly  Schedule</label>
												<label><input type="radio" name="appointmentType" value="monthly"?>Monthly Schedule</label>
											</div>
											</td>
                                        <div class="row" style="text-align:center"> <label class="control-label col-sm-2 requiredField" for="date">
                                   Date
                                   <span class="asteriskField">
                                    *
                                   </span>
                                  </label>
                                            <div class="col-xs-6 col-md-9">
                                                <input min="<?php echo date('Y-m-d')?>" value="<?php echo date('Y-m-d')?>" class="form-control" id="date" name="date" type="text" required/>
                                            </div>
                                            <label class="control-label col-sm-2 requiredField" for="doctor">
                                   Doctor
                                   <span class="asteriskField">
                                    *
                                   </span>
                                  </label>
                                            <div class="col-xs-6 col-md-9">
                                            <select class="select form-control" id="doctor" name="doctor" required>
                                                <?php $docSql = "SELECT doctor_id,substr(doctorFirstName,1,1) doctorFirstName,doctorLastName ,doctorSpecialty FROM doctor";
                                                 $docRes = mysqli_query($con,$docSql);
                                                ?>  
                                                 <option  value="">Select Doctor</option>";<<?php
                                                    while($doctor=mysqli_fetch_array($docRes)){
                                                     echo "<option value=". $doctor['doctor_id']."> Dr " .$doctor['doctorFirstName']." ". $doctor['doctorLastName']." (".$doctor['doctorSpecialty']. ")</option>";
                                                    }
                                                    echo "</select>"

                                                   ?>
                                            </div>
                                        </div>
                                        <label class="control-label col-sm-2 requiredField" for="starttime">
                                            Start Time
                                            <span class="asteriskField">
                                            *
                                         </span>
                                        </label>
                                        <div class="col-sm-4">
                                            <div class="input-group clockpicker"  data-align="top" data-autoclose="true">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-clock-o">
                                                    </i>
                                                 </div>
                                                <input class="form-control" id="starttime" name="starttime" type="text" required/>
                                             </div>
                                        </div>
                                        <label class="control-label col-sm-2 requiredField" for="endtime">
                                            End Time
                                            <span class="asteriskField">
                                            *
                                         </span>
                                        </label>
                                        <div class="col-sm-4">
                                            <div class="input-group clockpicker"  data-align="top" data-autoclose="true">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-clock-o">
                                                    </i>
                                                 </div>
                                                <input class="form-control" id="endtime" name="endtime" type="text" required/>
                                             </div>
                                        </div>
                                       
                                      <div >      
                                 <label style="text-align:center">
                                  Duration:
                                   <span class="asteriskField">
                                     *
                                   </span>
                                  </label><tr><td><br>
															<div style="text-align:center" class="radio">
																<label><input type="radio" name="appointmentDuration" value="30">30 Minutes</label>
																<label><input type="radio" name="appointmentDuration" value="45">45 Minutes</label>
																<label><input type="radio" name="appointmentDuration" value="60">60 Minites</label>
                                                </div>
                            </tr></td>
														
                                        
                                       
                                    <br>
                                        <button class="btn btn-lg btn-primary btn-block signup-btn" type="submit" name="submit">Add Doctor Schedule</button>
                                         </form>
                                        <!-- form end -->
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                            <br /><br/>
                        </div>


















       
        <!-- jQuery -->
        <script src="../patient/assets/js/jquery.js"></script>
        
        <!-- Bootstrap Core JavaScript -->
        <script src="../patient/assets/js/bootstrap.min.js"></script>
        <script src="assets/js/bootstrap-clockpicker.js"></script>
        <!-- Latest compiled and minified JavaScript -->
         <!-- script for jquery datatable start-->
        <!-- Include Date Range Picker -->
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>

        <script>
            $(document).ready(function(){
                var date_input=$('input[name="date"]'); //our date input has the name "date"
                var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
                date_input.datepicker({
                    format: 'yyyy/mm/dd',
                    container: container,
                    todayHighlight: true,
                    autoclose: true,
                })
            })
        </script>
        <script type="text/javascript">
            $('.clockpicker').clockpicker();
        </script>
        <script type="text/javascript">
        $(function() {
            $(".delete").click(function(){
                var element = $(this);
                var id = element.attr("id");
                var info = 'id=' + id;
                if(confirm("Are you sure you want to update this?"))
                {
                    $.ajax({
                        type: "POST",
                        url: "deleteschedule.php",
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
<script type="text/javascript">
            /*
            Please consider that the JS part isn't production ready at all, I just code it to show the concept of merging filters and titles together !
            */
            $(document).ready(function(){
                $('.filterable .btn-filter').click(function(){
                    var $panel = $(this).parents('.filterable'),
                    $filters = $panel.find('.filters input'),
                    $tbody = $panel.find('.table tbody');
                    if ($filters.prop('disabled') == true) {
                        $filters.prop('disabled', false);
                        $filters.first().focus();
                    } else {
                        $filters.val('').prop('disabled', true);
                        $tbody.find('.no-result').remove();
                        $tbody.find('tr').show();
                    }
                });

                $('.filterable .filters input').keyup(function(e){
                    /* Ignore tab key */
                    var code = e.keyCode || e.which;
                    if (code == '9') return;
                    /* Useful DOM data and selectors */
                    var $input = $(this),
                    inputContent = $input.val().toLowerCase(),
                    $panel = $input.parents('.filterable'),
                    column = $panel.find('.filters th').index($input.parents('th')),
                    $table = $panel.find('.table'),
                    $rows = $table.find('tbody tr');
                    /* Dirtiest filter function ever ;) */
                    var $filteredRows = $rows.filter(function(){
                        var value = $(this).find('td').eq(column).text().toLowerCase();
                        return value.indexOf(inputContent) === -1;
                    });
                    /* Clean previous no-result if exist */
                    $table.find('tbody .no-result').remove();
                    /* Show all rows, hide filtered ones (never do that outside of a demo ! xD) */
                    $rows.show();
                    $filteredRows.hide();
                    /* Prepend no-result row if all rows are filtered */
                    if ($filteredRows.length === $rows.length) {
                        $table.find('tbody').prepend($('<tr class="no-result text-center"><td colspan="'+ $table.find('.filters th').length +'">No result found</td></tr>'));
                    }
                });
            });
        </script>

    </body>
</html>