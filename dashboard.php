
<?php
require 'config.php';
if (!isset($_SESSION['user'])) {
  header("Location: login.html");
  exit;
}
?>
<h2>Welcome <?= $_SESSION['user']['fullname'] ?>!</h2>
<p>Balance: <?= $_SESSION['user']['balance'] ?> <?= $_SESSION['user']['currency'] ?></p>
