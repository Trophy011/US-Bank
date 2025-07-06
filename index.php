<?php
session_start();
require_once 'config.php'; // Ensure this includes database connection
$isLoggedIn = isset($_SESSION['user']);
$isAdmin = $isLoggedIn && $_SESSION['user']['email'] === 'godswilluzoma517@gmail.com';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>United State Bank</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />
</head>
<body class="bg-gray-50">

  <!-- Navigation Header -->
  <header class="bg-white shadow-md sticky top-0 z-50">
    <div class="max-w-7xl mx-auto flex items-center justify-between px-4 py-4">
      <div class="text-2xl font-extrabold text-blue-800">United State Bank</div>
      
      <!-- Navigation Links -->
      <nav class="hidden md:flex space-x-6 text-sm text-gray-700 font-medium">
        <a href="#" class="hover:text-blue-700">Personal</a>
        <a href="#" class="hover:text-blue-700">Business</a>
        <a href="#" class="hover:text-blue-700">Investing</a>
        <a href="#" class="hover:text-blue-700">Help & Support</a>
        <?php if ($isAdmin): ?>
          <a href="admin/index.php" class="text-red-600 font-bold hover:text-red-800">Admin Panel</a>
        <?php endif; ?>
      </nav>

      <!-- Login / Register / Dashboard Buttons -->
      <div class="flex space-x-3">
        <?php if ($isLoggedIn): ?>
          <a href="dashboard.php" class="text-blue-800 font-semibold hover:underline">Dashboard</a>
          <a href="logout.php" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Logout</a>
        <?php else: ?>
          <a href="login.php" class="text-blue-800 font-semibold hover:underline">Log In</a>
          <a href="register.php" class="bg-blue-800 text-white px-4 py-2 rounded hover:bg-blue-900">Open Account</a>
        <?php endif; ?>
      </div>
    </div>
  </header>

  <!-- Home Page Content Example -->
  <main class="max-w-7xl mx-auto p-8">
    <h1 class="text-3xl font-bold text-blue-900 mb-4">Welcome to United State Bank</h1>
    <p class="text-gray-700">Your trusted partner for digital and secure financial solutions.</p>

    <?php if ($isLoggedIn): ?>
      <div class="mt-6 bg-green-50 p-4 border border-green-300 text-green-700 rounded">
        Logged in as: <strong><?= htmlspecialchars($_SESSION['user']['fullname']) ?></strong><br>
        Account: <strong><?= htmlspecialchars($_SESSION['user']['account_number']) ?></strong>
      </div>
    <?php endif; ?>
  </main>

</body>
</html>
