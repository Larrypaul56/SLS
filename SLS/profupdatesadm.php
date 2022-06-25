<?php
session_start();
require_once('session_checker.php');
require_once('db_connection.php');
if(isset($_POST['upload'])){
   $target="imagi/".basename($_FILES['image']['name']);
$image=$_FILES['image']['name'];
$sess=$_SESSION['login_em'];
$destination=$_FILES['image']['tmp_name'];
$temp=explode('.',$image);
$image_extension=strtolower(end($temp));
$extension=array('jpg','png','jpeg');
if(in_array($image_extension,$extension)===true){
    $image_upload_path='/imagi/'.$image;
    $sql="UPDATE users set picture='$image_upload_path' where email='$sess'";
$qr=mysqli_query($conn,$sql);
if(move_uploaded_file($destination,$target)){
    echo "picture Uploaded Successfully";
}else{
    echo "picture not Uploaded Successfully";
}
}
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>PROFILE UPDATE</title>
        <link rel="stylesheet" href="styles/regstyle.css">
        <script src="scripts/regscript.js"></script>
    </head>
    <body>
        <div class="header">  I WILL PUT AN IMAGE HERE</div>
        <div class="main">
            <div class="banner">change profile</div>
            <div class="form-container">
                    <form action="profupdatesadm.php" name="myForm" method="POST"  enctype="multipart/form-data">
                     <input type="file" name="image" id="image"><br>
                    <input type="submit" name="upload" value="Upload Image">                        
                    </form>
            </div>
        </div>
        <a class="backto" href="profileadmin.php">Back to Profile</a>
       
        <div class="footer">&copy; of Kwanza Technologies</div>
    </body>
</html>