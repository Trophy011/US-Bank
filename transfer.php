<?php
require 'config.php';

if (!isset($_SESSION['user'])) {
  header("Location: login.html");
  exit;
}

$from_account = $_SESSION['user']['account_number'];
$to_account = $_POST['to'];
$amount = (float) $_POST['amount'];

// Check if recipient exists
$check = $conn->prepare("SELECT * FROM users WHERE account_number=?");
$check->bind_param("s", $to_account);
$check->execute();
$receiver = $check->get_result()->fetch_assoc();

if (!$receiver) {
  echo "<!DOCTYPE html><html><head>
    <meta charset='UTF-8'>
    <title>Error</title>
    <script src='//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit'></script>
    <script>
      function googleTranslateElementInit() {
        new google.translate.TranslateElement({ pageLanguage: 'en' }, 'google_translate_element');
      }
      window.onload = () => {
        const lang = navigator.language || navigator.userLanguage;
        const interval = setInterval(() => {
          const select = document.querySelector('select.goog-te-combo');
          if (select) {
            select.value = lang.substr(0, 2);
            select.dispatchEvent(new Event('change'));
            clearInterval(interval);
          }
        }, 500);
      };
    </script>
  </head>
  <body><div id='google_translate_element'></div>
    <p>Recipient not found.</p>
  </body></html>";
  exit;
}

if ($_SESSION['user']['balance'] < $amount) {
  echo "<!DOCTYPE html><html><head>
    <meta charset='UTF-8'>
    <title>Error</title>
    <script src='//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit'></script>
    <script>
      function googleTranslateElementInit() {
        new google.translate.TranslateElement({ pageLanguage: 'en' }, 'google_translate_element');
      }
      window.onload = () => {
        const lang = navigator.language || navigator.userLanguage;
        const interval = setInterval(() => {
          const select = document.querySelector('select.goog-te-combo');
          if (select) {
            select.value = lang.substr(0, 2);
            select.dispatchEvent(new Event('change'));
            clearInterval(interval);
          }
        }, 500);
      };
    </script>
  </head>
  <body><div id='google_translate_element'></div>
    <p>Insufficient funds.</p>
  </body></html>";
  exit;
}

// Transfer logic
$conn->query("UPDATE users SET balance = balance - $amount WHERE account_number = '$from_account'");
$conn->query("UPDATE users SET balance = balance + $amount WHERE account_number = '$to_account'");
$conn->query("INSERT INTO transfers (sender_account, receiver_account, amount) VALUES ('$from_account', '$to_account', '$amount')");

// Update session
$_SESSION['user']['balance'] -= $amount;

// Email notification
$toEmail = $receiver['email'];
$subject = "Credit Alert";
$message = "You have received $$amount from account $from_account.\n\nUSB";
mail($toEmail, $subject, $message);

// Redirect to dashboard
header("Location: dashboard.php");
exit;
?>
