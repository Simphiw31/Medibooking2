<?php
$error =NULL;

include_once 'assets/conn/dbconnect.php';
if(isset($_GET['patient_id']))
{
    $patient_id = $_GET['patient_id'];
    if(isset($_POST['reset'])){
 
        $password =$_POST['password'];
    $cpassword=$_POST['cpassword'];
        $resultSet = mysqli_query($con,"SELECT * FROM patient WHERE patient_id = '$patient_id' LIMIT 1");
    
    if($resultSet->num_rows == 1)
    {   
        if($password == $cpassword){
        $update = mysqli_query($con,"UPDATE patient SET password = '$password' WHERE patient_id = '$patient_id' LIMIT 1");
        if($update){
            ?>
            <script type="text/javascript">
            alert('Updated!');
            </script>
            <?php
            header('location: index.php');
            }
        }else{
        ?>
        <script type="text/javascript">
        alert('Could not Update! :Passwords are not the same');
        </script>
        <?php
        header('location: index.php');
    }}
}

}
?><!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Clinic Appointment Application</title>
        <!-- Bootstrap -->
        <link href="assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="assets/css/style.css" rel="stylesheet">
    </head>
    <body>
        <div class="container">
            <!-- start -->
            <div class="login-container">
                    <div id="output"></div>
                    <div class="form-box">
                        <form class="form" role="form" method="POST" accept-charset="UTF-8">
                            <input name="password" type="password" placeholder="Password" required>
                            <input name="cpassword" type="password" placeholder="Confirm Password" required>
                            <button class="btn btn-info btn-block login" type="submit" name="reset">Reset Password</button>
                        </form>
                    </div>
                </div>
            <!-- end -->
        </div>

        <script src="assets/js/jquery.js"></script>

        <!-- js start -->
        
        <!-- js end -->
    </body>
</html>