<?php
include_once 'assets/conn/dbconnect.php';




include "login.php";
?>




<!-- register -->
<!-- unable to add user to a database dont know whats wrong was working b4 -->
<?php
if (isset($_POST['signup'])) {

$patientFirstName = mysqli_real_escape_string($con,$_POST['patientFirstName']);
$patientLastName  = mysqli_real_escape_string($con,$_POST['patientLastName']);
$patientEmail     = mysqli_real_escape_string($con,$_POST['patientEmail']);
$patientEmail = trim($patientEmail);
$patient_id     = mysqli_real_escape_string($con,$_POST['patient_id']);
$password         = mysqli_real_escape_string($con,$_POST['password']);
$streetAddress         = mysqli_real_escape_string($con,$_POST['Address']);
$confirm_password = mysqli_real_escape_string($con,$_POST['confirm_password']);
$province            = mysqli_real_escape_string($con,$_POST['province']);
$cityName              = mysqli_real_escape_string($con,$_POST['cityName']);
$cityZipCode             = mysqli_real_escape_string($con,$_POST['cityZipCode']);

$gender = mysqli_real_escape_string($con,$_POST['gender']);
// verify that id number has 13 digits
if(strlen($patient_id) < 13 && $patient_id==0000000000000 && $patient_id==1111111111111 && $patient_id==2222222222222 ){
    ?>
    <script type="text/javascript">
    alert('Invalid ID number.Please check your id and try again');
    </script>
    <?php
} else if ($password  != $confirm_password ){
    ?>
<script type="text/javascript">
alert('password do not match. Please try again');
</script>
<?php
}
else if( $password  == $confirm_password )
{
        //INSERT
        if(!filter_var($patientEmail, FILTER_VALIDATE_EMAIL)) {
            ?>
            <script type="text/javascript">
            alert('Invalid Email. Please try again');
            </script>
            <?php

        }  else {

    $query1 = "INSERT INTO city(cityZipCode,cityName,provinceZip)
                VALUE ('$cityZipCode','$cityName','$province')";
    $resul = mysqli_query($con,$query1);
    if($resul){
    $query = " INSERT INTO patient (  patient_id, patientPassword, patientFirstName, patientLastName,  patientGender,   patientEmail ,patientStreetAddress,cityZipCode,provinceZipCode)
                            VALUES ( '$patient_id', '$password', '$patientFirstName', '$patientLastName',  '$gender', '$patientEmail','$cityZipCode','$province' ) ";
   $result = mysqli_query($con, $query);
    }else{$query = " INSERT INTO patient (  patient_id, patientPassword, patientFirstName, patientLastName,  patientGender,   patientEmail ,patientStreetAddress,cityZipCode,provinceZipCode)
        VALUES ( '$patient_id', '$password', '$patientFirstName', '$patientLastName',  '$gender', '$patientEmail','$cityZipCode','$province' ) ";
$result = mysqli_query($con, $query);}

        
   if($result )
   {
        
    ?>
    <script type="text/javascript">
        alert('Registration was successfully.');
    </script>
    <?php


   }
}
}
else
{
?>
<script type="text/javascript">
alert('User already registered. Please try again');
</script>
<?php
}

}
?>
<!-- reset Password -->
<?php
if (isset($_POST['resetPassword'])) {
$patient_id     = mysqli_real_escape_string($con,$_POST['patient_id']);



//UPDATE
$query = "SELECT * FROM patient WHERE patient_id = '$patient_id'";
 $results = mysqli_query($con, $query);
 $result=mysqli_fetch_array($results,MYSQLI_ASSOC);
//   echo $result;
$patientEmail = $result['patientEmail'];
$patientFirstName = $result['patientFirstName'];
$patientLastName = $result['patientLastName'];

 if( $result )
 {

     
 ?>
 <script type="text/javascript">
 alert('Upadate was successfully.');
 </script>
 
 <?php
 }
else
{
?>
<script type="text/javascript">
alert('wrong input');
</script>
<?php
}

}
?>
<!-- end -->
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>Clinic Appointment Application</title>
        <!-- Bootstrap -->
        <!-- <link href="assets/css/bootstrap.min.css" rel="stylesheet"> -->
        <script src="https://code.jquery.com/jquery-2.2.4.js" ></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <link href="assets/css/style.css" rel="stylesheet">
        <link href="assets/css/style1.css" rel="stylesheet">
        <link href="assets/css/blocks.css" rel="stylesheet">
        <link href="assets/css/date/bootstrap-datepicker.css" rel="stylesheet">
        <link href="assets/css/date/bootstrap-datepicker3.css" rel="stylesheet">
        <!-- Special version of Bootstrap that only affects content wrapped in .bootstrap-iso -->
        <!-- <link rel="stylesheet" href="https://formden.com/static/cdn/bootstrap-iso.css" />  -->

        <!--Font Awesome (added because you use icons in your prepend/append)-->
        <link rel="stylesheet" href="https://formden.com/static/cdn/font-awesome/4.4.0/css/font-awesome.min.css" />
        <link href="assets/css/material.css" rel="stylesheet">
    </head>
    <body>
        <!-- navigation -->
        <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="index.php"><img alt="Brand" src="assets/img/2.png" height="40px"></a>
                </div>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    
                    
                    <ul class="nav navbar-nav navbar-right">
                        

                        <li><a href="#" data-toggle="modal" data-target="#myModal">Sign Up</a></li>
                    
                        <li>
                            <p class="navbar-text">Already have an account?</p>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><b>Login</b> <span class="caret"></span></a>
                            <ul id="login-dp" class="dropdown-menu">
                                <li>
                                    <div class="row">
                                        <div class="col-md-12">
                                            
                                            <form class="form" role="form" method="POST" accept-charset="UTF-8" >
                                                <div class="form-group">
                                                    <label class="sr-only" for="email">Enter Email</label>
                                                    <input type="text" class="form-control" name="email" placeholder="Enter Email" required>
                                                </div>
                                                <div class="form-group">
                                                    <label class="sr-only" for="password">Password</label>
                                                    <input type="password" class="form-control" name="password" placeholder="Password" required>
                                                </div>
                                                <div class="form-group">
                                                    <button type="submit" name="login" id="login" class="btn btn-primary btn-block">Sign in</button>
                                                    <br>
                                                </div>
                                                </form>
                                        
                                        
                                                    </div>
                                    </div>
                                </li>
                                <li><a href="#" data-toggle="modal" data-target="#resetModal"> Forgot Password</a></li>
                            </ul>
                            
                        </li>
                    </ul>
                    
                </div>
            </div>
        </nav>
        <!-- navigation -->

        <!-- modal container start -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <!-- modal content -->
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h3 class="modal-title">Sign Up</h3>
                    </div>
                    <!-- modal body start -->
                    <div class="modal-body">
                        
                        <!-- form start -->
                        <div class="container" id="wrap">
                            <div class="row">
                                <div class="col-md-6">
                                    
                                    <form action="<?php $_PHP_SELF ?>" method="POST" accept-charset="utf-8" class="form" role="form">
                                        <h4>Personal Details.</h4>
                                        <div class="row">
                                            <div class="col-xs-6 col-md-6">
                                                <input type="text" name="patientFirstName" value="" class="form-control input-lg" placeholder="First Name" required />
                                            </div>
                                            <div class="col-xs-6 col-md-6">
                                                <input type="text" name="patientLastName" value="" class="form-control input-lg" placeholder="Last Name" required />
                                            </div>
                                        </div>
                                        
                                        <input type="text" name="patientEmail" value="" class="form-control input-lg" placeholder="Your Email"  required/>
                                        <input type="number" name="patient_id" value="" class="form-control input-lg" placeholder="Your id Number"  required/>
                                        
                                        
                                       
                                        <input type="text" name="Address" value="" class="form-control input-lg" placeholder="Street Address"  required/>

                                        <div class="row">
                                            
                                            <div class="col-xs-4 col-md-4">
                                                <select name="province" class = "form-control input-lg" required>
                                                    <option value="">Select Province</option>
                                                    <option value="4731">Eastern Cape</option>
                                                    <option value="9300">Free State</option>
                                                    <option value="0001">Gauteng</option>
                                                    <option value="4500">KwaZulu Natal</option>
                                                    <option value="0699">Limpopo</option>
                                                    <option value="1030">Mpumalanga</option>
                                                    <option value="0300">North West</option>
                                                    <option value="8100">Northern Cape</option>
                                                    <option value="6700">Western Cape</option>

                                                </select>
                                            </div>
                                            <div class="col-xs-4 col-md-4">
                                                <input name="cityName" class = "form-control input-lg" placeholder="City Name"required></input>  
                                            </div>
                                            <div class="col-xs-4 col-md-4">
                                            <input name="cityZipCode" class = "form-control input-lg" placeholder="City Zip Code"required></input>  
                                            </div>
                                        </div>
                                        <label>Gender : </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="gender" value="male" required/>Male
                                        </label>
                                        <label class="radio-inline" >
                                            <input type="radio" name="gender" value="female" required/>Female
                                        </label>
                                        <input type="password" name="password" value="" class="form-control input-lg" placeholder="Password"  required/>
                                        
                                        <input type="password" name="confirm_password" value="" class="form-control input-lg" placeholder="Confirm Password"  required/>

                                        <br />
                                        <span class="help-block">By clicking Create my account, you agree to our Terms and Conditions Policy, including our Cookies.</span>
                                        
                                        <button class="btn btn-lg btn-primary btn-block signup-btn" type="submit" name="signup" id="signup">Create my account</button>
                                    </form>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- modal end -->
        <!-- modal container end -->
        
        <!-- modal container start -->
        <div class="modal fade" id="resetModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <!-- modal content -->
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h3 class="modal-title">RESET PASSWORD</h3>
                    </div>
                    <!-- modal body start -->
                    <div class="modal-body">
                        
                        <!-- form start -->
                        <div class="container" id="wrap">
                            <div class="row">
                                <div class="col-md-6">
                                    
                                    <form action="<?php $_PHP_SELF ?>" method="POST" accept-charset="utf-8" class="form" role="form">
                                        <div class="row">

                                        </div>
                                        
                                        <input type="number" name="patient_id" value="" class="form-control input-lg" placeholder="Your ID Number"  required/>
                                        
                                        <button class="text-center btn btn-primary  signup-btn" type="submit" name="resetPassword" id="signup">Reset Password</button>
                                      </div>
                                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        </div>
                                    </form>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- modal end -->
        <!-- modal container end -->

        <!-- 1st section start -->
        <section id="promo-1" class="content-block promo-1 min-height-600px bg-offwhite">
            <div class="container">
                <div class="row">
                    <div class="col-md-5">
                        
                        <h3>Make an appointment today!</h3>
                        <li style="font-size:16px" class="dropdown">This is Doctor's Schedule. Please <a data-toggle="dropdown">
                        <span class="label label-danger" >Login</span></a> to make an appointment.
                            <ul id="login-dp" class="dropdown-menu">
                                <li>
                                    <div class="row">
                                        <div class="col-md-12">
                                            
                                            <form class="form" role="form" method="POST" accept-charset="UTF-8" >
                                                <div class="form-group">
                                                    <label class="sr-only" for="email">patient_id</label>
                                                    <input type="text" class="form-control" name="email" placeholder="Email Address" required>
                                                </div>
                                                <div class="form-group">
                                                    <label class="sr-only" for="password">Password</label>
                                                    <input type="password" class="form-control" name="password" placeholder="Password" required>
                                                </div>
                                                <div class="form-group">
                                                    <button type="submit" name="login" id="login" class="btn btn-primary btn-block">Sign in</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </li>
                                </ul>
                                </li>
                        <!-- date textbox -->
                       
                        <div class="input-group" style="margin-bottom:10px;">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar">
                                </i>
                            </div>
                           <!-- <?php include "doctordrop.php";?> -->
                            <input class="form-control" id="date" name="date" value="<?php echo date("Y-m-d")?>" onchange="showUser(this.value)"/>
                        </div>
                       
                        <!-- date textbox end -->

                        <!-- script start -->
                        <script>
                                // this fetches time from schedule table
                            function showUser(str) {
                                
                                if (str == "") {
                                    document.getElementById("txtHint").innerHTML = "";
                                    return;
                                } else { 
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
                                    xmlhttp.open("GET","getuser.php?q="+str,true);
                                    console.log(str);
                                    xmlhttp.send();
                                }
                            }
                        </script>
                        
                        <!-- script start end -->
                     
                        <!-- table appointment start -->
                        <div id="txtHint"><b> </b></div>
                        
                        <!-- table appointment end -->
                    </div>

                      
                </div>
                <!-- /.row -->
            </div>
        </section>
           </div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/date/bootstrap-datepicker.js"></script>
    <script src="assets/js/moment.js"></script>
    <script src="assets/js/transition.js"></script>
    <script src="assets/js/collapse.js"></script>
     <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="assets/js/bootstrap.min.js"></script>
    <script type="text/javascript">
    $('#myModal').on('shown.bs.modal', function () {
    $('#myInput').focus()
    })
    </script>
    <!-- date start -->
  
<script>
    $(document).ready(function(){
        var todayDate = new Date();
        var date_input=$('input[name="date"]'); //our date input has the name "date"
        var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
        date_input.datepicker({
            minDate: todayDate,
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