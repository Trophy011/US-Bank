<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $fullname = $_POST['fullname'];
  $email = $_POST['email'];
  $phone = $_POST['phone'];
  $username = $_POST['username'];
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
  $otp = $_POST['otp']; // Simulated

  $account_number = '10' . rand(100000000, 999999999); // 10-digit

  $stmt = $conn->prepare("INSERT INTO users (fullname, email, phone, username, password, account_number) VALUES (?, ?, ?, ?, ?, ?)");
  $stmt->bind_param("ssssss", $fullname, $email, $phone, $username, $password, $account_number);

  if ($stmt->execute()) {
    header("Location: login.html");
  } else {
    echo "Error: " . $stmt->error;
  }
}
?>
