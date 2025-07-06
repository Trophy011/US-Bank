<?php
require 'config.php';

if (!isset($_SESSION['user'])) {
  header("Location: login.html");
  exit;
}

$from_account = $_SESSION['user']['account_number'];
$to_account = $_POST['to'];
$amount = (float) $_POST['amount'];

// Check if recipient exists
$check = $conn->prepare("SELECT * FROM users WHERE account_number=?");
$check->bind_param("s", $to_account);
$check->execute();
$receiver = $check->get_result()->fetch_assoc();

if (!$receiver) {
  die("Recipient not found.");
}

if ($_SESSION['user']['balance'] < $amount) {
  die("Insufficient funds.");
}

// Deduct from sender
$conn->query("UPDATE users SET balance = balance - $amount WHERE account_number = '$from_account'");
// Add to receiver
$conn->query("UPDATE users SET balance = balance + $amount WHERE account_number = '$to_account'");
// Log transfer
$conn->query("INSERT INTO transfers (sender_account, receiver_account, amount) VALUES ('$from_account', '$to_account', '$amount')");

// Update session
$_SESSION['user']['balance'] -= $amount;

header("Location: dashboard.php");
?>
