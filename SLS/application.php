<?php 
session_start();
require_once('session_checker.php');
if(isset($_POST['submit'])){
    require_once("db_connection.php");
    $ds=$_POST['dates'];
    $de=$_POST['datee'];
    $rsn=$_POST['reason'];
    $sess=$_SESSION['login_em'];
    $sql="INSERT INTO application(date_start,date_end,reason,user_id ) VALUES('$ds','$de','$rsn',(SELECT user_id FROM users where email='$sess'))";
    $qr=mysqli_query($conn,$sql);
    if(!$qr){
        echo "Unsuccessful Query";
        die();
    }
    else{
        header("location:profilestu.php");
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>APPLICATION FORM</title>
        <link rel="stylesheet" href="css/bootstrap.css">
        <link rel="stylesheet" href="styles/regstyle2.css">
        <script src="scripts/regscript.js"></script>
    </head>
    <body> 
        <div class="grid-container">
        <div class="back header"><img src="imagi/slsbanner2.png" alt="slsbanner" srcset=""></div>
        <div class="back main">
            <div class="banner">APPLICATION FORM</div>
            <div class="form-container">
                     <form action="application.php" name="myForm" method="post" onsubmit="return validate()" enctype="multipart/form-data">
                    <div class="mb-4">
                                <label for="ds" class="form-label">Date Start</label>
                                <input type="date" class="form-control" name="dates" id="ds">
                                <span class="error" id="dse"></span>
                            </div>
                       <div class="mb-4">
                                <label for="de" class="form-label">Date End</label>
                                <input type="date" class="form-control" name="datee" id="fn">
                                <span class="error" id="de"></span>
                            </div>        
                      <div class="mb-4">
                                <label for="em" class="form-label">Email address</label>
                                <textarea type="email" class="form-control" name="reason" id="rsn" cols="30" rows="10"></textarea>
                                <span class="error" id="eme"></span>
                            </div>    
                                <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                            <button type="reset" class="btn btn-primary" name="reset">Clear</button>
                    </form>
                    <p>Back to <a href="profilestu.php">Profile</a></p> 
            </div>
            
        </div>
        
        <div class="back footer">&copy; of Kwanza Technologies</div>
    </div>
       
        
       
        
    </body>
</html>