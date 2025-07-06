<?php
require 'config.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin' || $_SESSION['user']['email'] !== 'godswilluzoma517@gmail.com') {
  die("Access denied.");
}
?>
