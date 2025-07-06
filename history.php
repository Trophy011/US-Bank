<?php
require 'config.php';

// Check if user is logged in
if (!isset($_SESSION['user'])) {
  header("Location: login.html");
  exit;
}

$user_account = $_SESSION['user']['account_number'];

// Fetch transfer history
$stmt = $conn->prepare("
  SELECT * FROM transfers 
  WHERE sender_account = ? OR receiver_account = ?
  ORDER BY created_at DESC
");
$stmt->bind_param("ss", $user_account, $user_account);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Transfer History - United State Bank</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 text-gray-900">
  <div class="max-w-6xl mx-auto px-4 py-8">
    <h2 class="text-3xl font-bold text-blue-800 mb-6">Transfer History</h2>
    <a href="dashboard.php" class="text-blue-700 hover:underline mb-4 inline-block">← Back to Dashboard</a>
    
    <div class="overflow-x-auto">
      <table class="w-full bg-white shadow rounded border border-gray-200 text-sm">
        <thead class="bg-gray-100 text-gray-700">
          <tr>
            <th class="px-4 py-2 text-left">Date</th>
            <th class="px-4 py-2 text-left">Direction</th>
            <th class="px-4 py-2 text-left">Account</th>
            <th class="px-4 py-2 text-left">Amount (USD)</th>
          </tr>
        </thead>
        <tbody class="text-gray-700">
          <?php while ($row = $result->fetch_assoc()): ?>
            <tr class="border-t">
              <td class="px-4 py-2"><?php echo date("F j, Y h:i A", strtotime($row['created_at'])); ?></td>
              <td class="px-4 py-2 font-semibold <?php echo $row['sender_account'] == $user_account ? 'text-red-600' : 'text-green-600'; ?>">
                <?php echo $row['sender_account'] == $user_account ? 'Sent' : 'Received'; ?>
              </td>
              <td class="px-4 py-2">
                <?php echo $row['sender_account'] == $user_account ? $row['receiver_account'] : $row['sender_account']; ?>
              </td>
              <td class="px-4 py-2">$<?php echo number_format($row['amount'], 2); ?></td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>
