<?php
require 'config.php';

// Ensure the user is logged in
if (!isset($_SESSION['user'])) {
  header("Location: login.html");
  exit;
}

// Get latest data from DB
$account_number = $_SESSION['user']['account_number'];
$stmt = $conn->prepare("SELECT * FROM users WHERE account_number = ?");
$stmt->bind_param("s", $account_number);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Update session
$_SESSION['user'] = $user;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>User Dashboard - United State Bank</title>
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
      <div class="text-2xl font-extrabold text-blue-800">United State Bank Dashboard</div>
      <div>
        <a href="logout.php" class="bg-red-600 text-white px-4 py-2 rounded">Logout</a>
      </div>
    </div>
  </header>

  <section class="hero-bg text-white py-10">
    <div class="max-w-4xl mx-auto px-4">
      <h2 class="text-3xl font-bold mb-4">Welcome, <?php echo htmlspecialchars($user['fullname']); ?></h2>
      <p class="mb-2">Email: <?php echo htmlspecialchars($user['email']); ?></p>
      <p class="mb-2">Phone: <?php echo htmlspecialchars($user['phone']); ?></p>
      <p class="mb-2">Account Number: <?php echo htmlspecialchars($user['account_number']); ?></p>
      <p class="mb-2">Balance: $<?php echo number_format($user['balance'], 2); ?></p>
      <p class="mb-2">Joined On: <?php echo date("F j, Y", strtotime($user['created_at'])); ?></p>
    </div>
  </section>

  <main class="max-w-4xl mx-auto px-4 mt-6">
    <div class="bg-white p-6 rounded shadow mb-6">
      <h3 class="text-xl font-semibold text-blue-800 mb-4">Actions</h3>
      <ul class="list-disc pl-6">
        <li><a href="transfer_form.html" class="text-blue-700 hover:underline">Make an Internal Transfer</a></li>
        <li><a href="global_transfer_form.html" class="text-blue-700 hover:underline">Make a Global Transfer</a></li>
        <li><a href="history.php" class="text-blue-700 hover:underline">View Transfer History</a></li>
      </ul>
    </div>
  </main>
</body>
</html>
