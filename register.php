<?php
require 'config.php';
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $fullname = trim($_POST['fullname']);
  $email = trim($_POST['email']);
  $phone = trim($_POST['phone']);
  $username = trim($_POST['username']);
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
  $otp = trim($_POST['otp']);

  // OTP check
  if (empty($otp) || $otp !== $_SESSION['otp']) {
    die("Invalid OTP. Please check your email and use the OTP sent.");
  }

  // Generate fake account number and default balance
  $account_number = '10' . rand(100000000, 999999999);
  $balance = 0;

  // Insert into users table
  $stmt = $conn->prepare("INSERT INTO users (fullname, email, phone, username, password, account_number, balance) VALUES (?, ?, ?, ?, ?, ?, ?)");
  $stmt->bind_param("ssssssd", $fullname, $email, $phone, $username, $password, $account_number, $balance);

  if ($stmt->execute()) {
    // Send welcome email
    $subject = "Welcome to United State Bank";
    $message = "Hi $fullname,\n\nWelcome to United State Bank.\nYour Account Number is: $account_number\n\nRegards,\nUSB Team";
    mail($email, $subject, $message);

    // Clear OTP session
    unset($_SESSION['otp']);

    // Redirect to login
    header("Location: login.html");
    exit;
  } else {
    echo "Error: " . $stmt->error;
  }
}
?>
