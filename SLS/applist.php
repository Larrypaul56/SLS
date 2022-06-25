<?php
session_start();
require_once("session_checker.php");
if(isset($_SESSION['login_em'])&& $_SESSION['role']=='admin') {
 ?>  
 <!DOCTYPE html>
<html>
    <head>
        <title>APLICANTS LIST</title>
        <link rel="stylesheet" href="styles/regapp.css">
        <!-- <link rel="stylesheet" href="styles/regprofadmin.css"> -->
        <script src="scripts/logscript.js"></script>
    </head>
    <body> <div class="grid-container">
    <div class="back header"> <img src="imagi/slsbanner2.png" alt="slsbanner" srcset=""></div>

    <div class=" back main">
            <div class="banner">LIST OF APPLICANTS</div>
            <div class="printlinks">
                <a class="links" href="printpdf.php">PrintPDF</a>
             <a  class="links" href="excel-sample.php">PrintEXCEL</a></div>
            <table>
                <tr>
                    <th>S/no</th>
                    <th>Admission number</th>
                    <th>Full Name</th>
                    <th>Date Start</th>
                    <th>Date End</th>
                    <th>Reason</th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th>Current Status</th>
                </tr>
                <?php
                  require_once('db_connection.php');
                  $sql="SELECT * FROM application join users on application.user_id=users.user_id";
                  $qr=mysqli_query($conn,$sql);
                  $n=1;
            while($rw=mysqli_fetch_array($qr)){
                $m=$rw['application_id'];
                $ad=$rw['user_id'];
                $fn=$rw['full_name'];
                $ds=$rw['date_start'];
                $de=$rw['date_end'];
                $rsn=$rw['reason'];
                $stat=$rw['status'];
                echo "<tr>";
                echo "<td> $n </td>";
                echo "<td> $ad</td>";
                echo "<td> $fn </td>";
                echo "<td> $ds </td>";
                echo "<td> $de</td>";
                echo "<td> $rsn </td>";
                echo "<td> <a class='links' href='stu_approve.php?l=$m'>Approve</a></td>";
                echo "<td> <a class='links' href='stu_decline.php?l=$m'>Decline</a></td>";
                echo "<td> <a class='links' href='stu_deleteapp.php?l=$m'>Remove</a></td>";
                echo "<td> $stat </td>";
                echo "</tr>";
                $n++;
            }
              ?>
            </table>
        </div>
        <p> Go Back to <a href="profileadmin.php">Dashboard</a></p>
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
