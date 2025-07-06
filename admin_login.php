<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = $_POST['email'];
  $password = $_POST['password'];

  $stmt = $conn->prepare("SELECT * FROM users WHERE email=? AND role='admin'");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();
  $admin = $result->fetch_assoc();

  if ($admin && password_verify($password, $admin['password'])) {
    $_SESSION['user'] = $admin;
    header("Location: admin.php");
    exit;
  } else {
    $error = "Invalid admin credentials";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Login - United State Bank</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
  <form method="POST" class="bg-white p-8 rounded shadow-md w-full max-w-sm">
    <h2 class="text-xl font-bold mb-4 text-center">Admin Login</h2>
    <?php if (isset($error)): ?>
      <p class="text-red-600 mb-2 text-sm text-center"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <input type="email" name="email" placeholder="Admin Email" required class="w-full border px-3 py-2 mb-4 rounded" />
    <input type="password" name="password" placeholder="Password" required class="w-full border px-3 py-2 mb-4 rounded" />
    <button class="bg-blue-800 text-white w-full py-2 rounded hover:bg-blue-900">Login</button>
  </form>
</body>
</html>
