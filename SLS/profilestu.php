<?php
session_start();
require_once("session_checker.php");
if(isset($_SESSION['login_em'])&& $_SESSION['role']=='student') {
?>
<!DOCTYPE html>
<html>
<?php 
    // echo $_SESSION['login_em'];
    ?>
    <head>
        <title>PROFILE STUDENT</title>
        <link rel="stylesheet" href="styles/regprof.css">   
    </head>
    <body>
    <div class="grid-container">
    <div class="back header"> 
         <img src="imagi/slsbanner2.png" alt="slsbanner" srcset="">
        </div>
        <div class="back sidebar">
            <div class="sideitems"><a href="application.php" class="links">Apply For Leave</a></div>
            <div class="sideitems"><a href="profupdatestu.php" class="links">Profile Update</a> </div>
            <div class="sideitems"><a href="logout.php" class="links">Logout</a></div>
            </div>
        <div class="back main">           
            <?php            
            require_once('db_connection.php');
            $sess=$_SESSION['login_em'];
            $sql="SELECT * FROM users where email='$sess'";            
            $qr=mysqli_query($conn,$sql);            
            if(mysqli_num_rows($qr)==1){
                $row=mysqli_fetch_array($qr);
                $fn=$row['full_name'];
                $ad=$row['user_id'];
                $prof_pic=$row['picture'];
            }
            else{
                echo"Failed Query Request";
            }            
            echo "<img class='echo-image' src='./$prof_pic'>";           
            ?>
            <!-- <img src="imagi/'.  echo $prof_pic?>.'" alt="Profile Picture"> -->
            <div class='info'> Name: <?php echo $fn ?> </div>
            <div class='info'> Admission Number <?php echo $ad ?> </div>
            <!-- <button type="button" name="imgup" id="imgup" value="Upload Image" onclick="return imageupload()">Upload Image</button> -->
            <label for="st">Status of Applications:</label>
            <input type="text" name="status" id="st" value=" <?php
            require_once('db_connection.php');
            $sess=$_SESSION['login_em'];
            $sql="SELECT status FROM application join users on application.user_id=users.user_id where email='$sess' ";
            $qr=mysqli_query($conn,$sql);
            if(mysqli_num_rows($qr)==1){
                if(!$qr){
                    echo "Query Failed";
                    die();
            }else{
                $row=mysqli_fetch_array($qr);
                $message=$row['status'];
            }
            echo $message;
            }else{
                echo "Not Applied";
            }
            ?>">
        </div>
        <div class="footer">&copy; of Kwanza Technologies</div>
    </div> 
    </body>
</html>
<?php
}
else{
    echo"Thou arern Student";
    header("location:login.php");
}
?>