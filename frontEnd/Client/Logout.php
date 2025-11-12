<?php
    session_start();

    // 1. Destroy the session data
    $_SESSION = array(); // Clear all session variables
    session_destroy();  // Destroy the session itself

    // 2. Redirect the user to the login page after logging out
    header("Location: /OMS/frontEnd/Client/RegistrationPage/Login.php");
    exit;
?>