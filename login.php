<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $username = $_POST['username'];
  $password = $_POST['password'];

  $stmt = $conn->prepare("SELECT * FROM users WHERE username=? OR email=?");
  $stmt->bind_param("ss", $username, $username);
  $stmt->execute();
  $result = $stmt->get_result();
  $user = $result->fetch_assoc();

  if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user'] = $user;
    header("Location: dashboard.php");
    exit;
  } else {
    $error = "Invalid credentials";
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Login - United State Bank</title>
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
            clearInterval(interval
