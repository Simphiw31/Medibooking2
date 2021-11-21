<?php
session_start();
include_once '../assets/conn/dbconnect.php';
if(!isset($_SESSION['adminSession']))
{
header("Location: ../index.php");
}
$usersession = $_SESSION['adminSession'];
$res=mysqli_query($con,"SELECT * FROM admin WHERE adminEmail= '$usersession'");
$userRow=mysqli_fetch_array($res,MYSQLI_ASSOC);


if (isset($_POST['submit'])) {
//variables
$Name = $_POST['name'];
$Surname = $_POST['surname'];
$Phone = $_POST['phone'];
$date = $_POST['date_of_birth'];


$res=mysqli_query($con,"UPDATE adminstrator SET name='$Name', surname='$Surname', phone='$Phone',date_of_birth='$date' WHERE email= '$usersession'");
// $userRow=mysqli_fetch_array($res);

header( 'Location: admindoctorprofile.php' ) ;

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
        <title>Welcome Admin <?php echo $userRow['adminFirstName'];?> <?php echo $userRow['adminLastName'];?></title>
        <!-- Bootstrap Core CSS -->
        <link href="assets/css/material.css" rel="stylesheet">
        <!-- Custom CSS -->
        <link href="assets/css/sb-admin.css" rel="stylesheet">
        <link href="assets/css/time/bootstrap-clockpicker.css" rel="stylesheet">
        <link href="assets/css/style.css" rel="stylesheet">
        <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet">
        <!-- Special version of Bootstrap that only affects content wrapped in .bootstrap-iso -->
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
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $userRow['adminFirstName']; ?> <?php echo $userRow['adminFirstName']; ?><b class="caret"></b></a>
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
                         <li>
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
                            Administrator Profile
                            </h2>

                        </div>
                    </div>
                    <!-- Page Heading end-->

                    <!-- panel start -->
                    <div class="panel panel-primary">

                        <!-- panel heading starat -->
                        <div class="panel-heading">
                            <h3 class="panel-title">Admin Details</h3>
                        </div>
                        <!-- panel heading end -->

                        <div class="panel-body">
                        <!-- panel content start -->
                          <div class="container">
            <section style="padding-bottom: 50px; padding-top: 50px;">
                <div class="row">
                    <!-- start -->
                    <!-- USER PROFILE ROW STARTS-->
                    <div class="row">
                        <div class="col-md-3 col-sm-3">
                            
                            <div class="user-wrapper">
                                <img src="assets/img/2.jpeg" class="img-responsive" />
                                <div class="description">
                                    <h4><?php echo $userRow['adminFirstName']; ?> <?php echo $userRow['adminLastName']; ?></h4>
                                    <h5> <strong> System Admin </strong></h5>
                                    
                                    <hr />
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Update Profile</button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-9 col-sm-9  user-wrapper">
                            <div class="description">
                                <h3> <?php echo $userRow['adminFirstName']; ?> <?php echo $userRow['adminLastName']; ?> </h3>
                                <hr />
                                
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        
                                        
                                        <table class="table table-user-information" align="center">
                                            <tbody>
                                                
                                                
                                                <tr>
                                                    <td>Admin ID</td>
                                                    <td><?php echo $userRow['admin_id']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Name</td>
                                                    <td><?php echo $userRow['adminFirstName']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Surname</td>
                                                    <td><?php echo $userRow['adminLastName']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Contact Number</td>
                                                    <td><?php echo $userRow['adminPhoneNumber']; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Email <Address></Address></td>
                                                    <td><?php echo $userRow['adminEmail']; ?>
                                                    </td>
                                                </tr>
                                               
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                
                            </div>
                            
                        </div>
                    </div>
                    <!-- USER PROFILE ROW END-->
                    <div class="col-md-4">
                        
                        <!-- Large modal -->
                        
                        <!-- Modal -->
                        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="myModalLabel">Update Profile</h4>
                                    </div>
                                    <div class="modal-body">
                                        <!-- form start -->
                                        <form action="<?php $_PHP_SELF ?>" method="post" >
                                            <table class="table table-user-information">
                                                <tbody>
                                                    <tr>
                                                        <td>Admin ID:</td>
                                                        <td><?php echo $userRow['admin_id']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Name:</td>
                                                        <td><input type="text" class="form-control" name="name" value="<?php echo $userRow['adminFirstName']; ?>"  /></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Surname</td>
                                                        <td><input type="text" class="form-control" name="surname" value="<?php echo $userRow['adminLastName']; ?>"  /></td>
                                                    </tr>
                                               
                                                    <tr>
                                                        <td>Phone number</td>
                                                        <td><input type="text" class="form-control" name="phone" value="<?php echo $userRow['adminPhoneNumber']; ?>"  /></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Email</td>
                                                        <td><input type="text" class="form-control" name="email" value="<?php echo $userRow['adminEmail']; ?>"  /></td>
                                                    </tr>
                                            
                                                    <tr>
                                                        <td>
                                                            <input type="submit" name="submit" class="btn btn-info" value="Update Info"></td>
                                                        </tr>
                                                    </tbody>
                                                    
                                                </table>
                                                
                                                
                                                
                                            </form>
                                            <!-- form end -->
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                            <br /><br/>
                        </div>
                        
                    </div>
                        <!-- panel content end -->
                        <!-- panel end -->
                        </div>
                    </div>
                    <!-- panel start -->

                </div>
            </div>
        <!-- /#wrapper -->


       
        <!-- jQuery -->
        <script src="../patient/assets/js/jquery.js"></script>
        
        <!-- Bootstrap Core JavaScript -->
        <script src="../patient/assets/js/bootstrap.min.js"></script>
        <script src="assets/js/bootstrap-clockpicker.js"></script>
        <!-- Latest compiled and minified JavaScript -->
         <!-- script for jquery datatable start-->
        <!-- Include Date Range Picker -->
    </body>
</html>