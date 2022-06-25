<?php
session_start();
require_once('db_connection.php');
$key = $_GET['key'];
$sql = "SELECT * FROM users WHERE vkey='$key'";
$qr = mysqli_query($conn, $sql);
$count = mysqli_num_rows($qr);
$row = mysqli_fetch_array($qr);
$em=$row['email'];
if($count == 1){
    $usql = "UPDATE users SET verified=1 WHERE vkey='$key'";
	$ures = mysqli_query($conn, $usql);
	if($ures){
		echo "<script> alert('Account has Been Activation  Login NOw');</script>";
		echo("<script> window.location='login.php';</script>");
		// header('location:login.php');
	}else{
		echo "failed to activate account";
	}
}else{
	echo "Key not found in database";
}
 
?>