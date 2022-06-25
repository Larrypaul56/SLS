<?php
session_start();
require_once('session_checker.php');
if(isset($_GET['l'])){
    require_once('db_connection.php');
    $m=mysqli_real_escape_string($conn,stripslashes(htmlentities(trim(strip_tags($_GET['l'])))));
    $sql="DELETE FROM application WHERE application_id='$m'";
    $qr=mysqli_query($conn,$sql);
    if(!$qr){
        echo "Query Failed";
        
}else{
   header("location:applist.php");

}



   
}
?>