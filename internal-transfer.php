
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

if (!$receiver) die("Recipient not found.");
if ($_SESSION['user']['balance'] < $amount) die("Insufficient funds.");

$conn->query("UPDATE users SET balance = balance - $amount WHERE account_number = '$from_account'");
$conn->query("UPDATE users SET balance = balance + $amount WHERE account_number = '$to_account'");
$_SESSION['user']['balance'] -= $amount;
mail($receiver['email'], "Credit Alert", "You received $$amount from $from_account");
header("Location: dashboard.php");
?>
