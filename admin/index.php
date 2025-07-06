<?php
require '../config.php';
if (!isset($_SESSION['user']) || $_SESSION['user']['email'] !== 'godswilluzoma517@gmail.com') {
  header("Location: ../login.html");
  exit;
}

$result = $conn->query("SELECT * FROM users ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Admin Panel - United State Bank</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />
</head>
<body class="bg-gray-100">
  <div class="max-w-6xl mx-auto py-8">
    <h1 class="text-3xl font-bold text-blue-900 mb-6">Admin Panel</h1>

    <table class="w-full bg-white shadow-md rounded">
      <thead class="bg-blue-900 text-white">
        <tr>
          <th class="p-3">Name</th>
          <th class="p-3">Email</th>
          <th class="p-3">Phone</th>
          <th class="p-3">Username</th>
          <th class="p-3">Account</th>
          <th class="p-3">Balance</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
          <tr class="border-t">
            <td class="p-3"><?= htmlspecialchars($row['fullname']) ?></td>
            <td class="p-3"><?= htmlspecialchars($row['email']) ?></td>
            <td class="p-3"><?= htmlspecialchars($row['phone']) ?></td>
            <td class="p-3"><?= htmlspecialchars($row['username']) ?></td>
            <td class="p-3"><?= $row['account_number'] ?></td>
            <td class="p-3">$<?= number_format($row['balance'], 2) ?></td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</body>
</html>
