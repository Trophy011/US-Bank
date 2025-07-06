<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $fullname = $_POST['fullname'];
  $email = $_POST['email'];
  $phone = $_POST['phone'];
  $username = $_POST['username'];
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
  $otp = $_POST['otp'];

  if ($otp !== '123456') {
    $error = "Invalid OTP. Please use 123456.";
  } else {
    $account_number = '10' . rand(100000000, 999999999);
    $stmt = $conn->prepare("INSERT INTO users (fullname, email, phone, username, password, account_number, balance) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $initial_balance = 0;
    $stmt->bind_param("ssssssi", $fullname, $email, $phone, $username, $password, $account_number, $initial_balance);

    if ($stmt->execute()) {
      $subject = "Welcome to United State Bank";
      $message = "Hi $fullname,\n\nWelcome to United State Bank.\nYour Account Number is $account_number.\n\nRegards,\nUSB Team";
      mail($email, $subject, $message);
      header("Location: login.php");
      exit;
    } else {
      $error = "Error: " . $stmt->error;
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Register - United State Bank</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />
  <style>
    .hero-bg {
      background: linear-gradient(120deg, #003087 0%, #0072ce 100%);
    }
  </style>

  <!-- Google Translate -->
  <script type="text/javascript">
    function googleTranslateElementInit() {
      new google.translate.TranslateElement({ pageLanguage: 'en' }, 'google_translate_element');
    }
  </script>
  <script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
  <div id="google_translate_element" style="display:none;"></div>
  <script>
    window.addEventListener('load', () => {
      const lang = navigator.language || navigator.userLanguage;
      if (lang && !lang.startsWith('en')) {
        const interval = setInterval(() => {
          const select = document.querySelector('select.goog-te-combo');
          if (select) {
            select.value = lang.substr(0, 2);
            select.dispatchEvent(new Event('change'));
            clearInterval(interval);
          }
        }, 500);
      }
    });
  </script>
</head>
<body class="bg-gray-50 text-gray-900">

  <div class="min-h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded shadow-md w-full max-w-md">
      <h2 class="text-2xl font-bold mb-4 text-center text-blue-800">Open a Bank Account</h2>
      <?php if (!empty($error)): ?>
        <p class="text-red-600 text-sm mb-4 text-center"><?= $error ?></p>
      <?php endif; ?>
      <form method="POST" class="space-y-4">
        <input type="text" name="fullname" placeholder="Full Name" required class="w-full px-4 py-2 border rounded">
        <input type="email" name="email" placeholder="Email Address" required class="w-full px-4 py-2 border rounded">
        <input type="text" name="phone" placeholder="Phone Number" required class="w-full px-4 py-2 border rounded">
        <input type="text" name="username" placeholder="Username" required class="w-full px-4 py-2 border rounded">
        <input type="password" name="password" placeholder="Password" required class="w-full px-4 py-2 border rounded">
        <input type="text" name="otp" placeholder="Enter OTP (123456)" required class="w-full px-4 py-2 border rounded">
        <button type="submit" class="w-full bg-blue-800 text-white px-4 py-2 rounded hover:bg-blue-900">Register</button>
      </form>
      <p class="text-sm mt-4 text-center">Already have an account? <a href="login.php" class="text-blue-700 hover:underline">Login</a></p>
    </div>
  </div>

</body>
</html>
