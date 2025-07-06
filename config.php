
<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "us_bank";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
session_start();

// Auto-translator
$lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
putenv("LC_ALL=$lang");
setlocale(LC_ALL, $lang);
bindtextdomain("messages", "./locale");
textdomain("messages");
?>
