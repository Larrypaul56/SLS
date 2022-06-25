<?php
session_start();
require_once("session_checker.php");
if(isset($_SESSION['login_em'])&& $_SESSION['role']=='admin') {
 ?>  
<!DOCTYPE html>
<html>
      <head>
        <title> DASHBOARD</title>
        <link rel="stylesheet" href="styles/regprofadmin.css">
    </head>
    <body>
        <div class="grid-container">
        <div class="back header">
            <img src="imagi/slsbanner2.png" alt="slsbanner" srcset="">
    </div>
    <div class="back sidebar">
        <div class="sideitems"><a href="applist.php" class="links">Review Applications</a></div>
        <div class="sideitems"> <a href="listofstudents.php" class="links">Registered students</a></div>
        <div class="sideitems"><a href="profupdatesadm.php" class="links">Profile Update</a> </div>
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
            // echo  "<div class='info'> Name: $fn </div>"  ;
            // echo  "<div class='info'> Admission Number: $ad </div>"  ;
            ?>
            <div class='info'> Name: <?php echo $fn ?> </div>
            <div class='info'> Admission Number <?php echo $ad ?> </div>
      </div>
        <div class="back footer">&copy; of Kwanza Technologies</div>
        </div>
    </body>
</html>
<?php
}
else{
    echo"Thou arern Admin";
    header("location:login.php");
}
?>