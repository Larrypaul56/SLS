<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Registered Students</title>
    <!-- <link rel="stylesheet" href="styles/regapp.css"> -->
    <link rel="stylesheet" href="styles/liststu.css">
</head>
<body>
     <div class="grid-container">
         <div class="back header"> <img src="imagi/slsbanner2.png" alt="slsbanner" srcset=""><br>
         <p class="heading">LIST OF REGISTERED STUDENTS</p>
        </div>
         <div class="back main">
         <?php
session_start();
require_once('session_checker.php');
require_once('db_connection.php');
$sql="SELECT * FROM users where roles='student'";
$qr=mysqli_query($conn,$sql);
$n=1;
if (!$qr) {echo "Query not inserted";}
while ($rows=mysqli_fetch_array($qr)) {
   $name=$rows['full_name'];
   $adm_no=$rows['user_id'];
   $pp=$rows['picture'];
   $email=$rows['email'];
   echo "<div class='echo container'>";
   echo "<img class='echo image' src='./$pp'>";
    echo"<div class='echo namec'>$name</div>,";
    echo "<div class='echo admc'>$adm_no</div>,";
    echo "<div class='echo admc'>$email</div>";
    echo"</div>";
$n++;
}
?>
<p>Go back to <a href="profileadmin.php">Dashboard</a> </p></div>
         <!-- <div class="back footer">&copy; of Kwanza Technologies</div> -->
     </div>
</body>
</html>