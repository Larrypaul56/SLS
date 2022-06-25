<?php

session_start();
if(isset($_GET['emailrec'])){
    $em=$_GET['emailrec'];
    $em2=base64_decode($em);
    $_SESSION['recover']=$em2;
}
if(isset($_POST['submit']) ){
    require_once('db_connection.php');
    function test_input($data){
       $data= trim($data);
        $data=stripslashes($data);
        $data=htmlspecialchars($data);
        $data=htmlentities($data);
        return $data;
    }
    $email=$_SESSION['recover'];
        $pass= test_input($_POST['password']);
        $hash=password_hash($pass,PASSWORD_DEFAULT);
        $sql="UPDATE users set password='$hash' where email='$email' ";
        $qr=mysqli_query($conn,$sql);
        if(!$qr){echo "Unsuccessful Insertion";
        }else{
            echo "<script> alert('Successful password Reset You can Now login with new password');</script>";
            echo("<script> window.location='login.php';</script>");
            die();
       }
  }
else{
  echo "Not submitted yet";
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>RESET PASSOWORD</title>
        <link rel="stylesheet" href="styles/regstyle.css">
        <script src="scripts/regscript.js"></script>
    </head>
    <body>
        <div class="header">  I WILL PUT AN IMAGE HERE</div>
        <div class="main">
            <div class="banner">Reset Password</div>
            <div class="form-container">
                    <form action="password_reset.php" name="myForm" method="POST"  enctype="multipart/form-data">
                        <label for="pass">Enter New Password:</label>
                     <input type="password" name="password" id="pass"><br>
                     <label for="cpass">Confirm New Password</label>
                     <input type="password" name="cpassword" id="cpass"><br>
                    <input type="submit" name="submit" value="reset Password">                        
                    </form>
            </div>
        </div>
        <a href="login.php">Back to Login</a>
       
        <div class="footer">&copy; of Kwanza Technologies</div>
    </body>
</html>