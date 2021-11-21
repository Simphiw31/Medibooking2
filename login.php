<!-- login -->
<!-- check session -->
<?php
session_start();
// session_destroy();
if (isset($_SESSION['patientSession']) != "") {
header("Location: patient/patient.php");
}
if (isset($_POST['login']))
{
$patient_id = mysqli_real_escape_string($con,$_POST['email']);
$password  = md5(mysqli_real_escape_string($con,$_POST['password']));



$res = mysqli_query($con,"SELECT * FROM patient WHERE patientEmail = '$patient_id' LIMIT 1");
$row=mysqli_fetch_array($res,MYSQLI_ASSOC);
if(mysqli_num_rows($res)==1){
$date =$row['createdate'];

if ($row['patientPassword'] == $password)
{
$_SESSION['patientSession'] = $row['patient_id'];

header("Location: patient/patient.php");

}}else {
    $doctor_id = mysqli_real_escape_string($con,$_POST['email']);
    $password  = md5(mysqli_real_escape_string($con,$_POST['password']));
    
    $res = mysqli_query($con,"SELECT * FROM doctor WHERE doctorEmail = '$doctor_id' AND doctorPassord = '$password'");
    
    $row=mysqli_fetch_array($res,MYSQLI_ASSOC);
    if (mysqli_num_rows($res)==1)
    {
    $_SESSION['doctorSession'] = $row['doctor_id'];
    ?>
    <script type="text/javascript">
    alert('Login Success');
    </script>
    <?php
    header("Location: doctor/doctordashboard.php");
    } else {
        $email = $_POST['email'];
        $password = $_POST['password'];

        // To protect mysqli injection for Security purpose
        $email = stripslashes($email);
        $password = stripslashes($password);
        $email = mysqli_real_escape_string($con,$email);
        $password = md5(mysqli_real_escape_string($con,$password));

        // SQL query to fetch information of registerd users and finds user match.
				$sql = "select * from receptionist where receptionistEmail = '$email' and receptionistPassword = '$password'";
	       		$result = mysqli_query($con, $sql);
	            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	            $count = mysqli_num_rows($result);

        if ($count==1)
        {
            $_SESSION['receptionistSession'] = $email; // Initializing Session
            header("location: receptionist/dashboard.php"); // Redirecting To Other Page

        }
        else
        {
            $email = $_POST['email'];
            $password = $_POST['password'];
    
            // To protect mysqli injection for Security purpose
            $email = stripslashes($email);
            $password = stripslashes($password);
            $email = mysqli_real_escape_string($con,$email);
            $password = md5(mysqli_real_escape_string($con,$password));
    
            // SQL query to fetch information of registerd users and finds user match.
                  $sql = "select * from admin where adminEmail = '$email' and adminPassword = '$password'";
                  $result = mysqli_query($con, $sql);
                  $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                  $count = mysqli_num_rows($result);
    
            if ($count == 1)
            {
                $_SESSION['adminSession'] = $email; // Initializing Session
                header("location: admin/admindashboard.php"); // Redirecting To Other Page
    
            }
            else
            {?>
                <script type="text/javascript">
                    alert('Invalid Email or Password!');
                </script><?php
            }
           
    
            //    mysqli_close($con); // Closing Connection
        }}
}
        }

        
?>