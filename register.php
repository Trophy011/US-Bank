<?php
session_start();
require 'config.php';

// Show errors
ini_set('display_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $fullname = trim($_POST['fullname']);
  $email = trim($_POST['email']);
  $phone = trim($_POST['phone']);
  $username = trim($_POST['username']);
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
  $otp = trim($_POST['otp']);

  // Check OTP
  if (!isset($_SESSION['otp']) || $otp !== $_SESSION['otp']) {
    die("❌ Invalid OTP. Please check your email.");
  }

  // Generate account number and initial balance
  $account_number = '10' . rand(100000000, 999999999);
  $balance = 0;

  // Insert user
  $stmt = $conn->prepare("INSERT INTO users (fullname, email, phone, username, password, account_number, balance) VALUES (?, ?, ?, ?, ?, ?, ?)");
  $stmt->bind_param("ssssssd", $fullname, $email, $phone, $username, $password, $account_number, $balance);

  if ($stmt->execute()) {
    // Send welcome email
    $subject = "🎉 Welcome to United State Bank";
    $message = "Hello $fullname,\n\nWelcome to USB!\nYour Account Number: $account_number\n\nThank you!";
    mail($email, $subject, $message);

    unset($_SESSION['otp']);
    header("Location: login.php");
    exit;
  } else {
    die("❌ Error: " . $stmt->error);
  }
}
?>
