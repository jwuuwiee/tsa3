<?php
session_start();

// Clear all session variables, then destroy the session itself
$_SESSION = [];
session_destroy();

header("Location: login.php");
exit;
?>