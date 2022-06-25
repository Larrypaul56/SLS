<?php

//   require'C:\xampp\composer\vendor\autoload.php';
     //Import PHPMailer classes into the global namespace
     //These must be at the top of your script, not inside a function
     
     
require_once('db_connection.php');

if(isset($_POST['submit'])){
    function test_input($data){       
        $data= trim($data);
        $data=stripslashes($data);
        $data=htmlspecialchars($data);
        $data=htmlentities($data);
        return $data;
    }
    $ad= test_input($_POST['admission']);
    $fn= test_input($_POST['fullname']);
    $em= test_input($_POST['email']);
    $pass= test_input($_POST['password']);
    $cpass= test_input($_POST['cpassword']);
    $hash=password_hash($pass,PASSWORD_DEFAULT);
    $vkey=md5(time().$ad);
    $select= "SELECT * FROM users where full_name='$fn' && password='$hash' ";
    $result=mysqli_query($conn,$select);
    if(mysqli_fetch_row($result)>0){
        $error[]="User Already Exists";
    }else{
        if($pass!=$cpass){
        $error[]="Passwords Dont Match";
            }else{
                $insert=" INSERT INTO users(user_id,full_name,email,password,vkey) VALUES('$ad','$fn','$em','$hash','$vkey')";
                $query1=mysqli_query($conn,$insert);
                $rows=mysqli_fetch_array($query1);
                if(!$query1){
                    echo "Unsuccessful Insertion";
                    die();
                }
                else{                    
                    require_once'email_account_activation.php';
                    $vkey=md5(time().$ad);
                    $em=$rows['email'];                    
                    echo("<script> alert('Need to Verify Account before Login check your Email')</script>");
                    echo("<script> window.location='login.php';</script>");
                    // header("location:login.php");
                }                
            }
    }
} 
?>
<!DOCTYPE html>
<html>
    <head>
        <title>REGISTER HERE</title>
        <link rel="stylesheet" href="css/bootstrap.css">
        <link rel="stylesheet" href="styles/regstyle1.css">
        <script src="scripts/regscript.js"></script>
    </head>
    <body>
      <div class="grid-container">
      <div class=" back header"><img src="imagi/slsbanner2.png" alt="slsbanner" srcset=""></div>
      <div class="back main">
            <div class="banner">REGISTER HERE</div>
            <div class="form-container">
                    <!-- <form action="register.php" name="myForm" method="POST"  onsubmit="return validate()" enctype="multipart/form-data">
                        <div class="form-inputs">
                           <?php if(isset($error)){
                               foreach($error as $error){
                                   echo "<span class='error_msg'>".$error."</span>";
                               }
                           } 
                           ?>
                            <input type="number" class="input" name="admission" id="ad" placeholder="Enter Admission Number"><br>
                            <span class="error" id="ade"></span>
                            <input type="text" class="input" name="fullname" id="fn" placeholder="Enter Full Name"><br>
                            <span class="error" id="fne"></span>
                            <input type="email" class="input" name="email" id="em" placeholder="Enter Email" ><br>
                            <span class="error" id="eme"></span>
                            <input type="password" class="input" name="password" id="pass" placeholder="Enter Password"><br>
                            <span class="error" id="passe"></span>
                            <input type="password" class="input" name="cpassword" id="cpass" placeholder="Confirm Password"><br>
                            <span class="error" id="cpasse"></span>
                        </div>
                        <div class="form-buttons">
                            <input type="submit" class="but" name="submit" value="Submit">
                            <input type="reset" class="but" name="reset" value="Clear">
                        </div>
                        
                    </form> -->

                    <form action="register.php" name="myForm" method="post" onsubmit="return validate()" enctype="multipart/form-data">
                    <div class="mb-4">
                                <label for="ad" class="form-label">Admission Number/ID</label>
                                <input type="number" class="form-control" name="admission" id="ad">
                                <span class="error" id="ade"></span>
                            </div>
                    
                    <div class="mb-4">
                                <label for="fn" class="form-label">Full Name</label>
                                <input type="text" class="form-control" name="fullname" id="fn">
                                <span class="error" id="fne"></span>
                            </div>                   
                    <div class="mb-4">
                                <label for="em" class="form-label">Email address</label>
                                <input type="email" class="form-control" name="email" id="em" >
                                <span class="error" id="eme"></span>
                            </div>    
                        <div class="mb-4">
                                <label for="pass" class="form-label">Enter Password</label>
                                <input type="password" class="form-control" name="password" id="pass" >
                                <span class="error" id="passe"></span>
                            </div>
                            <div class="mb-4">
                                <label for="cpass" class="form-label"> Confirm Password:</label>
                                <input type="password" class="form-control" name="cpassword" id="pass">
                                <span class="error" id="cpasse"></span>
                            </div>
                           
                            <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                            <button type="reset" class="btn btn-primary" name="reset">Clear</button>
                    </form>
            </div>
            <div class="note"> If you Already Have an account <a href="login.php">Login</a></div>
        </div>
        <div class="back footer">&copy; of Kwanza Technologies</div>
      </div>        
    </body>
</html>