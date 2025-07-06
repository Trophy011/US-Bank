<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $_SESSION['temp_user'] = $_POST;
  $otp = rand(100000, 999999);
  $_SESSION['otp'] = $otp;

  $email = $_POST['email'];
  $subject = "Your OTP - United State Bank";
  $message = "Your One-Time Password (OTP) is: $otp";

  mail($email, $subject, $message);
  header("Location: verify_otp.html");
}
?>
