<?php
session_start();
include_once '../assets/conn/dbconnect.php';
// include_once 'connection/server.php';
if(!isset($_SESSION['adminSession']))
{
header("Location: ../index.php");
}
$usersession = $_SESSION['adminSession'];
$res=mysqli_query($con,"SELECT * FROM admin WHERE adminEmail= '$usersession'");
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
        <title>Welcome Admin <?php echo $userRow['adminFirstName'];?> <?php echo $userRow['adminLastName'];?></title>
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
                    <a class="navbar-brand" href="doctordashboard.php">Welcome Admin <?php echo $userRow['adminFirstName'];?> <?php echo $userRow['adminLastName'];?></a>
                </div>
                <!-- Top Menu Items -->
                <ul class="nav navbar-right top-nav">
                    
                    
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $userRow['adminFirstName']; ?> <?php echo $userRow['adminLastName']; ?><b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="admindoctorprofile.php"><i class="fa fa-fw fa-user"></i> Profile</a>
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
                            <a href="admindashboard.php"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
                        </li>
                        <li>
                            <a href="adminpatientlist.php"><i class="fa fa-fw fa-edit"></i> Patient List</a>
                        </li>
                        <li>
                            <a href="admindoctorlist.php"><i class="fa fa-fw fa-edit"></i> doctor List</a>
                        </li>
                        <li>
                            <a href="adminreceptionistlist.php"><i class="fa fa-fw fa-edit"></i> Receptionist List</a>
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
                                &emsp; &emsp;
                                <div class="pull-right"id="piechart2"></div>

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
                                    <th><input type="text" class="form-control" placeholder="Patients" disabled></th>
                                    <th><input type="text" class="form-control" placeholder="Doctors" disabled></th>
                                    <th><input type="text" class="form-control" placeholder="Receptionists" disabled></th>
                                    <th><input type="text" class="form-control" placeholder="Total Appontments" disabled></th>
                                    <th><input type="text" class="form-control" placeholder="patient attended" disabled></th>
                                    <th><input type="text" class="form-control" placeholder="patient not attended/missed appointments" disabled></th>
                                </tr>
                            </thead>
                            
                            <?php 
                            $res=mysqli_query($con,"SELECT count(*) as total
                                                    from patient  ");                
                                                    
                                  if (!$res) {
                                    printf("Error: %s\n", mysqli_error($con));
                                    exit();
                                }
                            while ($appointment=mysqli_fetch_array($res)) {
                                
                                echo "<tbody>";
                                echo "<tr class=''>";
                                    echo "<td>" . $appointment['total'] . "</td>";
                                   $doc = $appointment['total'];
                                   
                            } 
                            $res=mysqli_query($con,"SELECT count(*) as total
                                                    from doctor");                
                                                    
                                  if (!$res) {
                                    printf("Error: %s\n", mysqli_error($con));
                                    exit();
                                }
                            while ($appointment=mysqli_fetch_array($res)) {
                                
                                
                                    echo "<td>" . $appointment['total'] . "</td>";
                                    $patie = $appointment['total'];
                                    
                                   
                            } $res=mysqli_query($con,"SELECT count(*) as total
                                                    from receptionist ");                
                                                    
                                  if (!$res) {
                                    printf("Error: %s\n", mysqli_error($con));
                                    exit();
                                }
                            while ($appointment=mysqli_fetch_array($res)) {
                                
                                
                                    echo "<td>" . $appointment['total'] . "</td>";
                                    $rece = $appointment['total'];
                            }$res=mysqli_query($con,"SELECT count(*) as total1,sum(a.appointment_status='Attended') as total2,sum(a.appointment_status!='Attended') as total  
                                                    from appointment a");             
                                                    
                                  if (!$res) {
                                    printf("Error: %s\n", mysqli_error($con));
                                    exit();
                                }
                            while ($appointment=mysqli_fetch_array($res)) {
                                
                                
                                // echo "<td>" . $appointment['total']. "</td>";
                                echo "<td>" . $appointment['total1']. "</td>";
                                echo "<td>" . $appointment['total2']. "</td>";
                                echo "<td>" . $appointment['total']. "</td>";
                                    $attended = $appointment['total2'];
                                    $notAttended = $appointment['total'];
                            } 
                            
                                echo "</tr>";
                           echo "</tbody>";
                       echo "</table>";
                       echo "<div class='panel panel-default'>";
                       echo "<div class='col-md-offset-3 pull-right'>";
                        echo "</div>";
                        echo "</div>";
                    
                       
                        ?>
                        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                        <script type="text/javascript">
                        // Load google charts
                        google.charts.load('current', {'packages':['corechart']});
                        google.charts.setOnLoadCallback(drawChart);

                        // Draw the chart and set the chart values
                        function drawChart() {
                        var data = google.visualization.arrayToDataTable([
                        ['Task', 'Total Number'],
                        ['Patients', <?php echo $patie ?>],
                        ['Doctors', <?php echo $doc ?>],
                        ['Receptionist', <?php echo $rece?>]
                        
                        
                        ]);

                        // Optional; add a title and set the width and height of the chart
                        var options = {  'title':'Average Users',  'width':505, 'height':300};

                        // Display the chart inside the <div> element with id="piechart"
                        var chart = new google.visualization.PieChart(document.getElementById('piechart'));
                        chart.draw(data, options);
                        }
                        </script>

                        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                        <script type="text/javascript">
                        // Load google charts
                        google.charts.load('current', {'packages':['corechart']});
                        google.charts.setOnLoadCallback(drawChart);

                        // Draw the chart and set the chart values
                        function drawChart() {
                        var data = google.visualization.arrayToDataTable([
                        ['Task', 'Total Number'],
                        ['Attended', <?php echo $attended ?>],
                        ['Not Attended', <?php echo $notAttended ?>],
                       
                        
                        
                        ]);

                        // Optional; add a title and set the width and height of the chart
                        var options = { 'title':'Appointment status ' ,'width':505, 'height':300};

                        // Display the chart inside the <div> element with id="piechart"
                        var chart = new google.visualization.PieChart(document.getElementById('piechart2'));
                        chart.draw(data, options);
                        }
                        </script>

                    </div>
                </div>
                    <!-- panel end1 -->
                    
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