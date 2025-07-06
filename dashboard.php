<?php
require 'config.php';
if (!isset($_SESSION['user'])) {
  header("Location: login.html");
  exit;
}

$user = $_SESSION['user'];
?>

<!DOCTYPE html>
<html>
<head>
  <title>Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-10">
  <h2 class="text-2xl mb-4">Welcome, <?= $user['fullname'] ?></h2>
  <p><strong>Account Number:</strong> <?= $user['account_number'] ?></p>
  <p><strong>Balance:</strong> $<?= number_format($user['balance'], 2) ?></p>

  <hr class="my-6">

  <form action="transfer.php" method="POST" class="bg-white p-4 rounded shadow max-w-md">
    <h3 class="text-xl mb-4">Internal Transfer</h3>
    <input type="text" name="to" placeholder="Recipient Account" required class="w-full mb-2 px-3 py-2 border rounded">
    <input type="number" name="amount" placeholder="Amount" required class="w-full mb-2 px-3 py-2 border rounded">
    <button class="bg-blue-800 text-white px-4 py-2 rounded" type="submit">Send</button>
  </form>
</body>
</html>
