<?php
/*session_start();
session_destroy();
header("location: ../index.php");
*/


session_start();

// Unset all session variables
$_SESSION = [];

// Destroy the session
session_destroy();

// Clear any remaining session cookies
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
}

// Redirect to login page
header("location: ../index.php");
exit();
?>