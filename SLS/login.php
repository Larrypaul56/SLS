<?php
if(isset($_POST['submit'])){
    require_once('db_connection.php');
    function test_input($data){
        $data= trim($data);
        $data=stripslashes($data);
        $data=htmlspecialchars($data);
        $data=htmlentities($data);
        return $data;
    }
    $em= test_input($_POST['email']);
    $pass= test_input($_POST['password']);
    $sql="SELECT * FROM users where email='$em'";
    $qr=mysqli_query($conn,$sql);
    if(!$qr){
        echo "Failed Query";
        die();
    }
        $rw=mysqli_fetch_array($qr);
        $passd= $rw['password'];
        if(password_verify($pass,$passd)){
            session_start();
            if($rw['roles']=="student"&&$rw['verified']==1){
                $_SESSION['login_em']=$em;
                $_SESSION['role']='student';
                header("location:profilestu.php");
            }
            else if($rw['roles']=='admin'&&$rw['verified']==1){
                         $_SESSION['login_em']=$em;
                         $_SESSION['role']='admin';
                         header("location:profileadmin.php");
                   }
                   else{
                       echo "undefined Role or UNVERIFIED ACCOUNT";
                   }
                }
        else{
            echo "Faield to Verify Password";
        }
  }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>LOGIN</title>        
        <link rel="stylesheet" href="css/bootstrap.css">
        <link rel="stylesheet" href="styles/regstyle.css">
        <script src="scripts/logscript.js"></script>
    </head>
    <body>
        <div class="grid-container">
             <div class="back header"> <img src="imagi/slsbanner2.png" alt="slsbanner" srcset="">
            </div>
            <div class="back main">
            <div class="banner">LOGIN</div>            
                    <form action="login.php" name="myForm" method="post" onsubmit="return validate()">
                            <div class="mb-4 ">
                                <label for="em" class="form-label">Email address</label>
                                <input type="email" class="form-control" name="email" id="em" aria-describedby="emailHelp">
                                <span class="error" id="eme"></span>
                                <!-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> -->
                            </div>
                            <div class="mb-4">
                                <label for="pass" class="form-label">Password</label>
                                <input type="password" class="form-control" name="password" id="pass">
                                <span class="error" id="passe"></span>
                            </div>
                           
                            <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                            <button type="reset" class="btn btn-primary" name="reset">Clear</button>
                    </form>            
            <div class="note"><p>If you dont have an account <a href="register.php">Register</a>here</p>   
            <p> Forgot Password Reset <a href="email_send_reset.php">here</a></p>
            </div>            
            </div>
            <div class="back footer">&copy; of Kwanza Technologies</div>
    </div>      
        <script src="js/bootstrap.bundle.js"></script>
    </body>
</html>