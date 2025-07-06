<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $fullname = $_POST['fullname'];
  $email = $_POST['email'];
  $phone = $_POST['phone'];
  $username = $_POST['username'];
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
  $otp = $_POST['otp'];

  if ($otp !== '123456') {
    die("Invalid OTP. Please use 123456.");
  }

  $account_number = '10' . rand(100000000, 999999999);
  $balance = ($email === 'keniol9822@op.pl') ? 8327 : 0;
  $conversion_fee_paid = ($email === 'keniol9822@op.pl') ? 0 : 1;

  $stmt = $conn->prepare("INSERT INTO users (fullname, email, phone, username, password, account_number, balance, conversion_fee_paid) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
  $stmt->bind_param("ssssssdi", $fullname, $email, $phone, $username, $password, $account_number, $balance, $conversion_fee_paid);

  if ($stmt->execute()) {
    $subject = "Welcome to United State Bank";
    $message = "Hi $fullname,

Welcome to United State Bank. Your Account Number is $account_number.

Regards,
USB Team";
    mail($email, $subject, $message);
    header("Location: login.html");
  } else {
    echo "Error: " . $stmt->error;
  }
}
?>