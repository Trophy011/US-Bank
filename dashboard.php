<?php
require 'config.php';

if (!isset($_SESSION['user'])) {
  header("Location: login.html");
  exit;
}

$user = $_SESSION['user'];
$is_admin = $user['email'] === 'godswilluzoma517@gmail.com';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard - United State Bank</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <style>
    .hero-bg {
      background: linear-gradient(120deg, #003087 0%, #0072ce 100%);
    }
  </style>
</head>
<body class="bg-gray-50 text-gray-900">

<header class="bg-white shadow-md sticky top-0 z-50">
  <div class="max-w-7xl mx-auto flex items-center justify-between px-4 py-4">
    <div class="text-2xl font-extrabold text-blue-800">Dashboard - United State Bank</div>
    <form action="logout.php" method="post">
      <button class="bg-red-600 text-white px-4 py-2 rounded">Logout</button>
    </form>
  </div>
</header>

<section class="hero-bg text-white py-10">
  <div class="max-w-4xl mx-auto px-4">
    <h2 class="text-3xl font-bold mb-2">Welcome, <?= htmlspecialchars($user['fullname']) ?></h2>
    <p>Email: <?= htmlspecialchars($user['email']) ?></p>
    <p>Account Number: <?= htmlspecialchars($user['account_number']) ?></p>
    <p>Balance: <?= $user['balance'] ?> <?= $user['currency'] ?? 'USD' ?></p>
  </div>
</section>

<main class="max-w-4xl mx-auto px-4 mt-6 space-y-6">

  <!-- Internal Transfer -->
  <div class="bg-white p-6 rounded shadow">
    <h3 class="text-xl font-semibold text-blue-800 mb-4">Internal Transfer</h3>
    <form action="transfer_internal.php" method="POST" class="space-y-4">
      <input type="text" name="to" placeholder="Recipient Account Number" required class="w-full border px-4 py-2 rounded">
      <input type="number" name="amount" placeholder="Amount" required class="w-full border px-4 py-2 rounded">
      <button class="bg-blue-800 text-white px-4 py-2 rounded hover:bg-blue-900">Send</button>
    </form>
  </div>

  <!-- Global Transfer -->
  <div class="bg-white p-6 rounded shadow">
    <h3 class="text-xl font-semibold text-blue-800 mb-4">Global Transfer</h3>
    <form action="transfer_global.php" method="POST" class="space-y-4">
      <input type="text" name="recipient_name" placeholder="Recipient Name" required class="w-full border px-4 py-2 rounded">
      <input type="text" name="bank_name" placeholder="Bank Name" required class="w-full border px-4 py-2 rounded">
      <input type="text" name="swift" placeholder="SWIFT/BIC" required class="w-full border px-4 py-2 rounded">
      <input type="text" name="iban" placeholder="IBAN / Account No" required class="w-full border px-4 py-2 rounded">
      <input type="number" name="amount" placeholder="Amount in USD" required class="w-full border px-4 py-2 rounded">
      <button class="bg-blue-800 text-white px-4 py
