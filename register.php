<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $fullname = $_POST['fullname'];
  $email = $_POST['email'];
  $phone = $_POST['phone'];
  $username = $_POST['username'];
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
  $otp = rand(100000, 999999);
  $account_number = '10' . rand(100000000, 999999999);

  // Log registration attempt
  $ip = $_SERVER['REMOTE_ADDR'];
  $agent = $_SERVER['HTTP_USER_AGENT'];
  $log = $conn->prepare("INSERT INTO registration_logs (email, ip_address, user_agent) VALUES (?, ?, ?)");
  $log->bind_param("sss", $email, $ip, $agent);
  $log->execute();

  // Notify admin
  $admin_email = "youradmin@example.com";
  $subject = "New Signup Detected - United State Bank";
  $message = "A new user signed up:\n\nFullname: $fullname\nEmail: $email\nUsername: $username\nIP: $ip\n\nUSB Portal";
  mail($admin_email, $subject, $message);

  // Store user data in session
  $_SESSION['otp'] = $otp;
  $_SESSION['register'] = compact('fullname', 'email', 'phone', 'username', 'password', 'account_number');

  // Send OTP to user
  $subject = "Your OTP Code - United State Bank";
  $message = "Hi $fullname,\n\nYour OTP code is: $otp\n\nUse this to complete your account registration.";
  mail($email, $subject, $message);

  header("Location: verify_otp.php");
  exit;
}
?>
