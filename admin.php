<?php
require 'config.php';

// Manual login
if (!isset($_SESSION['admin'])) {
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $pass = $_POST['password'];
    if ($email == 'godswilluzoma517@gmail.com' && $pass == 'smart446688') {
      $_SESSION['admin'] = true;
    } else {
      die("Invalid admin credentials.");
    }
  } else {
    echo '<form method="POST"><input name="email"><input name="password" type="password"><button>Login</button></form>';
    exit;
  }
}

$users = $conn->query("SELECT * FROM users");
$txs = $conn->query("SELECT * FROM transfers ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html><head><title>Admin Panel</title></head><body>
<h2>Users</h2>
<table border='1'><tr><th>Name</th><th>Email</th><th>Account</th><th>Balance</th></tr>
<?php while ($u = $users->fetch_assoc()): ?>
<tr><td><?= $u['fullname'] ?></td><td><?= $u['email'] ?></td><td><?= $u['account_number'] ?></td><td>$<?= $u['balance'] ?></td></tr>
<?php endwhile; ?></table>

<h2>Transfers</h2>
<table border='1'><tr><th>From</th><th>To</th><th>Amount</th><th>Date</th></tr>
<?php while ($t = $txs->fetch_assoc()): ?>
<tr><td><?= $t['sender_account'] ?></td><td><?= $t['receiver_account'] ?></td><td>$<?= $t['amount'] ?></td><td><?= $t['created_at'] ?></td></tr>
<?php endwhile; ?></table>
</body></html>
