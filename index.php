<?php
session_start();
$isAdmin = isset($_SESSION['user']) && $_SESSION['user']['email'] === 'godswilluzoma517@gmail.com';
?>
