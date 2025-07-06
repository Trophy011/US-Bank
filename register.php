<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $entered_otp = $_POST['otp'];
  if ($entered_otp != $_SESSION['otp']) {
    die("Incorrect OTP. Please try again.");
  }

  $data = $_SESSION['temp_user'];
  $fullname = $data['fullname'];
  $email = $data['email'];
  $phone = $data['phone'];
  $username = $data['username'];
  $password = password_hash($data['password'], PASSWORD_DEFAULT);

  $account_number = '10' . rand(100000000, 999999999);
  $balance = 0;
  $currency = 'USD';

  $stmt = $conn->prepare("INSERT INTO users (fullname, email, phone, username, password, account_number, balance, currency) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
  $stmt->bind_param("ssssssis", $fullname, $email, $phone, $username, $password, $account_number, $balance, $currency);

  if ($stmt->execute()) {
    mail($email, "Welcome to United State Bank", "Your account number is $account_number.");
    unset($_SESSION['otp'], $_SESSION['temp_user']);
    header("Location: login.html");
  } else {
    echo "Error: " . $stmt->error;
  }
}
?>
