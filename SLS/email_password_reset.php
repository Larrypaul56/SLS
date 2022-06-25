<?php
require_once'db_connection.php';
//Import PHPMailer classes into the global namespace
require './mailer/PHPMailer.php';
require './mailer/SMTP.php';
require './mailer/Exception.php';
// echo $em;
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
// require 'vendor/autoload.php';

//Create an instance; passing `true` enables exceptions

$mail = new PHPMailer(true);

try {
  //-----------------Server settings--------------------

  //Enable verbose debug output
  // $mail->SMTPDebug = SMTP::DEBUG_SERVER;
  //Send using SMTP
  $mail->isSMTP();
  //Set the SMTP server to send through                                            
  // $mail->Host       = 'smtp.gmail.com';
  $mail->Host       = 'atchosting.ac.tz';
  //Enable SMTP authentication                    
  $mail->SMTPAuth   = true;
  //SMTP username   atcemailphp@gmail.com                           
  $mail->Username   = 'laurencekisanga@atchosting.ac.tz';
  //SMTP password                    
  $mail->Password   = 'WWafzFfwPFzt';
  //Enable implicit TLS encryption                             
  $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
  //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`         
  $mail->Port= 465;

  //---------------------Recipients-------------------------
  $mail->setFrom('laurencekisanga@atchosting.ac.tz', 'Student Leave System');
  $mail->addAddress($email);
  // $mail->addAddress('larrytherealest@gmail.com');
  // $mail->addAddress($email, 'Human resource');     
  //Add a recipient
  //  $mail->addAddress('nahlanawarmunga805@gmail.com');               //Name is optional
  // $mail->addReplyTo('info@example.com', 'Information');
  // $mail->addCC('nahlanawarmunga805@gmail.com');
  // $mail->addBCC('nahlanawarmunga805@gmail.com');

  //--------------------Attachments-----------------------------
  // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
  // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
  //Content
 
  $mail->isHTML(true);                                  //Set email format to HTML
  $mail->Subject = 'Password Reset';
  $mail->Body    = "  
    <div style='border: 1px solid; border-radius:25px; font-size:20px;
     background-color:green; padding:5px; color:white; text-align:center;'>
    STUDENT LEAVE MANAGEMENT SYSTEM.
    </div>
    <div style='text-align:center; margin-top:50px;'> 
     <h2>click the link to reset your password, once clicked you will be redirected to change passwords:</h2> <h1 style='color:red;'><u>http://atchosting.ac.tz/SLS/password_reset.php?emailrec=$email2</u></h1></div>
     ";
  $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

  //--------------------send-----------------------------
  $mail->send();
  // echo 'Message has been sent';
} catch (Exception $e) {
  echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
  // header("location:activation.php");
  // die();
}
