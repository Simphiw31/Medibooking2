<?php
session_start();
include_once '../assets/conn/dbconnect.php';
// include_once 'connection/server.php';
if(!isset($_SESSION['doctorSession']))
{
header("Location: ../index.php");
}
$usersession = $_SESSION['doctorSession'];
$res=mysqli_query($con,"SELECT * FROM doctor WHERE doctor_id=".$usersession);
$userRow=mysqli_fetch_array($res,MYSQLI_ASSOC);



?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Welcome Dr <?php echo $userRow['doctorFirstName'];?> <?php echo $userRow['doctorLastName'];?></title>
        <!-- Bootstrap Core CSS -->
        <link href="assets/css/material.css" rel="stylesheet">
        <!-- Custom CSS -->
        <link href="assets/css/sb-admin.css" rel="stylesheet">
        <link href="assets/css/style.css" rel="stylesheet">
        <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet">
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
                    <a class="navbar-brand" href="doctordashboard.php">Welcome Dr <?php echo $userRow['doctorFirstName'];?> <?php echo $userRow['doctorLastName'];?></a>
                </div>
                <!-- Top Menu Items -->
                <ul class="nav navbar-right top-nav">
                    
                    
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $userRow['doctorFirstName']; ?> <?php echo $userRow['doctorLastName']; ?><b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="doctorprofile.php"><i class="fa fa-fw fa-user"></i> Profile</a>
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
                        <li class="active">
                            <a href="doctordashboard.php"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
                        </li>
                        <li>
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
                            Dashboard
                            </h2>
                           <ol class="breadcrumb">
                                <li class="active">
                                    <div class="pull-left"id="piechart"></div>
                                    
                                </li>
                            </ol>
                        </div>
                        
                    </div>
                    <!-- Page Heading end-->
<!-- panel start -->
<div class="panel panel-primary filterable">
                        <!-- Default panel contents -->
                       <div class="panel-heading">
                       
                        <h3 class="panel-title">Mini Report</h3>
                        <div class="pull-right">
                        </div>
                        </div>
                        <div class="panel-body">
                        <!-- Table -->
                        
                        <table class="table table-hover table-bordered">
                            <thead>
                                <tr class="filters">
                                
                                    <th><input type="text" class="form-control" placeholder="Appontments" disabled></th>
                                    <th><input type="text" class="form-control" placeholder="patient attended" disabled></th>
                                    <th><input type="text" class="form-control" placeholder="patient not attended/missed appointments" disabled></th>
                                </tr>
                            </thead>
                            
                            <?php 
                            $res=mysqli_query($con,"SELECT count(*) as total1,sum(a.appointment_status='Attended') as total2,sum(a.appointment_status!='Attended') as total  
                                                    from appointment a");
                                  if (!$res) {
                                    printf("Error: %s\n", mysqli_error($con));
                                    exit();
                                }
                            while ($appointment=mysqli_fetch_array($res)) {
                                
                                echo "<tbody>";
                                echo "<tr class=''>";
                                    echo "<td>" . $appointment['total1'] . "</td>";
                                    echo "<td><span class='' aria-hidden='true'></span>".' '."". $appointment['total2'] . "</td>";
                                    echo "<td><span class='' aria-hidden='true'></span>".' '."". $appointment['total'] . "</td>";
                                    $attende = $appointment['total2'] ;
                                    $notAttend = $appointment['total'];
                                    $tot = $appointment['total1'];
                                    
                            } 
                                echo "</tr>";
                           echo "</tbody>";
                       echo "</table>";
                    
                       
                        ?>
                        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                        <script type="text/javascript">
                        // Load google charts
                        google.charts.load('current', {'packages':['corechart']});
                        google.charts.setOnLoadCallback(drawChart);

                        // Draw the chart and set the chart values
                        function drawChart() {
                        var data = google.visualization.arrayToDataTable([
                        ['Task', ''],
                        ['Patient not attended', <?php echo $notAttend; ?>],
                        // ['Appointments in total',<?php echo $tot; ?>],
                        ['Attended Patients', <?php echo $attende; ?>]
                        
                        
                        ]);

                        // Optional; add a title and set the width and height of the chart
                        var options = {    'width':1050, 'height':300};

                        // Display the chart inside the <div> element with id="piechart"
                        var chart = new google.visualization.PieChart(document.getElementById('piechart'));
                        chart.draw(data, options);
                        }
                        </script>

                    </div>
                </div>
                <div style="text-align:center" >show appointments from : <input method="post" type="date" id="date" name="appdate" value="<?php echo date("Y-m-d")?>"/>
                            &nbsp;&nbsp;&nbsp;to &nbsp;&nbsp;&nbsp; <input method="post" type="date" id="date" name="appdate1" value="<?php echo date('Y-m-t')?>">
                        <br><br></div>
                    <!-- panel end1 -->
                    


                    <!-- panel start -->
                    <div class="panel panel-primary filterable">
                        <!-- Default panel contents -->
                       <div class="panel-heading">
                        <h3 class="panel-title">Appointment List</h3>
                        <div class="pull-right">
                            <button class="btn btn-default btn-xs btn-filter"><span class="fa fa-filter"></span> Filter</button>
                        </div>
                        </div>
                        <div class="panel-body">
                        <!-- Table -->
                        <table class="table table-hover table-bordered">
                            <thead>
                                <tr class="filters">
                                    <th><input type="text" class="form-control" placeholder="patient ID" disabled></th>
                                    <th><input type="text" class="form-control" placeholder="Name" disabled></th>
                                    <th><input type="text" class="form-control" placeholder="Date" disabled></th>
                                    <th><input type="text" class="form-control" placeholder="Start" disabled></th>
                                    <th><input type="text" class="form-control" placeholder="End" disabled></th>
                                   
                                    
                                    <th><input type="text" class="form-control" placeholder="Symptom" disabled></th>
                                    <th><input type="text" class="form-control" placeholder="Comment" disabled></th>
                                    <th><input type="text" class="form-control" placeholder="Status" disabled></th>
                                    <th><input type="text" class="form-control" placeholder="Complete" disabled></th>
                                    <th><input type="text" class="form-control" placeholder="Print" disabled></th>
                                </tr>
                            </thead>
                            
                            <?php 
                            $res=mysqli_query($con,"SELECT a.*, b.*,c.*
                                                    FROM patient a
                                                    JOIN appointment b
                                                    On a.patient_id = b.patient_id
                                                    JOIN schedule c
                                                    On b.schedule_id=c.schedule_id
                                                    ");//WHERE schedule_date BETWEEN ".$this->input->post('appdate').  CAN'T GET WITH DATES
                                                    //" AND " .$this->input->post('appdate1')."") ;

                                                    
                                  if (!$res) {
                                    printf("Error: %s\n", mysqli_error($con));
                                    exit();
                                }
                            while ($appointment=mysqli_fetch_array($res)) {
                                
                                if (strtolower($appointment['appointment_status'])=='pending') {
                                    $status="danger";
                                    $icon='minus-o';
                                    $checked='';

                                } else {
                                    $status="success";
                                    $icon='check-o';
                                    $checked = 'disabled';
                                }   

                                echo "<tbody>";
                                echo "<tr class='$status'>";
                                    echo "<td>" . $appointment['patient_id'] . "</td>";
                                    echo "<td>" . $appointment['patientLastName'] . "</td>";
                                    echo "<td>" . $appointment['schedule_date'] . "</td>";
                                    echo "<td>" . $appointment['schedule_startTime'] . "</td>";
                                    echo "<td>" . $appointment['schedule_endTime'] . "</td>";
                                    echo "<td>" . $appointment['appointment_symptoms'] . "</td>";
                                    echo "<td>" . $appointment['appointment_diagnoses'] . "</td>";
                                    echo "<td><span class='fa fa-calendar-".$icon."' aria-hidden='true'></span>".' '."". $appointment['appointment_status'] . "</td>";
                                    echo "<form method='POST'>";
                                    echo "<td class='text-center'><input type='checkbox' name='enable' id='enable' value='".$appointment['appointment_ID']."' onclick='chkit(".$appointment['appointment_ID'].",this.checked);' ".$checked."></td>";
                            echo "<td class='text-center'><a href='invoice.php?appointment_ID=".$appointment['appointment_ID']."' target='_blank'><span class='fa fa-print' aria-hidden='true'></span></a></td>";
                               
                            } 
                                echo "</tr>";
                                    echo "</tbody>"; 
                                echo "</table>";
                              
                            echo "<div style='text-align:center'>
                            <br>
                            <td >&nbsp;&nbsp;Sort By: <select style='text-align:center' name='sort'>
                                                  <option value='patient_id'>patient Id&nbsp;&nbsp;&nbsp;&nbsp;</option>
                                                  <option value='patientLastName'>Name</option>
                                
                                 </select>
                                 <!-- adding spaces in between the drop down -->
                                 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                         <!-- adding spaces in between the drop down -->
                                 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"  ;
                                         echo "Show by appointment Status : <select>
                                         <option value='%'>All Appointments&nbsp;&nbsp;&nbsp;&nbsp;</option>
                                         <option value='Pending'>Pending</option>
                                         <option value='Missed'>Missed</option>
                                         <option value='Canceled'>Canceled</option>
                        </select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"  ; 
                       echo "<div class='panel panel-default'>";
                       echo "<div class='col-md-offset-3 pull-right'>";
                       
                       echo "<button class='btn btn-primary' type='submit' value='Submit' name='submit'>Update</button>";
                        echo "</div>";
                        echo "</div>";
                        ?>
                    </div>
                </div>
                    <!-- panel end -->
 
<script type="text/javascript">
function chkit(uid, chk) {
   chk = (chk==true ? "1" : "0");
   var url = "checkdb.php?userid="+uid+"&chkYesNo="+chk;
   if(window.XMLHttpRequest) {
      req = new XMLHttpRequest();
   } else if(window.ActiveXObject) {
      req = new ActiveXObject("Microsoft.XMLHTTP");
   }
   // Use get instead of post.
   req.open("GET", url, true);
   req.send(null);
}
</script>


 
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- /#page-wrapper -->
        </div>
        <!-- /#wrapper -->


       
        <!-- jQuery -->
        <script src="../patient/assets/js/jquery.js"></script>
        <script type="text/javascript">
$(function() {
$(".delete").click(function(){
var element = $(this);
var appointment_ID = element.attr("id");
var info = 'id=' + appointment_ID;
if(confirm("Are you sure you want to delete this?"))
{
 $.ajax({
   type: "POST",
   url: "deleteappointment.php",
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
        <!-- Bootstrap Core JavaScript -->
        <script src="../patient/assets/js/bootstrap.min.js"></script>
        <!-- Latest compiled and minified JavaScript -->
         <!-- script for jquery datatable start-->
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
        <!-- script for jquery datatable end-->

    </body>
</html>