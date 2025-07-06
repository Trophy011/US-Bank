<?php
require 'config.php';
ini_set('display_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $fullname = trim($_POST['fullname']);
  $email = trim($_POST['email']);
  $phone = trim($_POST['phone']);
  $username = trim($_POST['username']);
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
  $otp = trim($_POST['otp']);

  if (empty($otp) || $otp !== $_SESSION['otp']) {
    die("Invalid OTP. Please check your email and use the OTP sent.");
  }

  // Auto-generate account number
  $account_number = '10' . rand(100000000, 999999999);
  $balance = 0;

  $stmt = $conn->prepare("INSERT INTO users (fullname, email, phone, username, password, account_number, balance) VALUES (?, ?, ?, ?, ?, ?, ?)");
  $stmt->bind_param("ssssssd", $fullname, $email, $phone, $username, $password, $account_number, $balance);

  if ($stmt->execute()) {
    // Send welcome email
    $subject = "Welcome to United State Bank";
    $message = "Hi $fullname,\n\nWelcome to United State Bank. Your Account Number is: $account_number\n\nRegards,\nUSB Team";
    mail($email, $subject, $message);

    unset($_SESSION['otp']);
    header("Location: login.html");
    exit;
  } else {
    echo "Error: " . $stmt->error;
  }
}
?>
