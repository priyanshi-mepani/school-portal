<?php
session_start();

// Remove all session variables
session_unset();

// Destroy the session completely
session_destroy();

// Send them back to the login page
header("Location: login.html");
exit();
?>