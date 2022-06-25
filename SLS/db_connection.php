<?php
$dbhost="localhost";
$username="root";
$password="";
$dbname="21050513056";
// Create Connection
$conn = mysqli_connect($dbhost, $username,$password,$dbname);
if(!$conn){
echo"connection Failed";
die();
}; ?>
