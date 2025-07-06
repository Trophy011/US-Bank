<?php
require 'config.php';

if (!isset($_SESSION['user'])) {
  header("Location: login.html");
  exit;
}

$from_account = $_SESSION['user']['account_number'];
$to_account = $_POST['to'];
$amount = (float) $_POST['amount'];

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

$conn->query("UPDATE users SET balance = balance - $amount WHERE account_number = '$from_account'");
$conn->query("UPDATE users SET balance = balance + $amount WHERE account_number = '$to_account'");
$conn->query("INSERT INTO transfers (sender_account, receiver_account, amount) VALUES ('$from_account', '$to_account', '$amount')");

$_SESSION['user']['balance'] -= $amount;

// Email notification to receiver
$toEmail = $receiver['email'];
$subject = "Credit Alert";
$message = "You have received $$amount from account $from_account.\n\nUSB";
mail($toEmail, $subject, $message);

header("Location: dashboard.php");
?>
