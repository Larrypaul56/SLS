<?php
if(isset($_POST['send'])){
    require_once('db_connection.php');
    function test_input($data){
        $data= trim($data);
        $data=stripslashes($data);
        $data=htmlspecialchars($data);
        $data=htmlentities($data);
        return $data;
    }
    $email= test_input($_POST['email']);
   
    $sql="SELECT * from users where email='$email'";
    $qr=mysqli_query($conn,$sql);

    if(mysqli_num_rows($qr)==1){
        $email2=base64_encode($email);
        echo "<script> alert('Check your Email for the link to reset passwords');</script>";
        require_once('email_password_reset.php');
        
		// echo("<script> window.location='passwordreset.php';</script>");
    }
}else{
    // echo "Failed to Extract Data";
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Email Send Reset Password</title>
        <link rel="stylesheet" href="styles/regstyle.css">
        <script src="scripts/regscript.js"></script>
    </head>
    <body>
        <div class="header"> <img src="imagi/slsbanner2.png" alt="slsbanner" srcset=""></div>
        <div class="main">
            <div class="banner">Enter Email</div>
            <div class="form-container">
                    <form action="email_send_reset.php" name="myForm" method="POST"  enctype="multipart/form-data">
                     <input type="email" name="email" id="em"><br>
                    <input type="submit" name="send" value="Send Email">                        
                    </form>
            </div>
        </div>
        <div class="footer">&copy; of Kwanza Technologies</div>
    </body>
</html>