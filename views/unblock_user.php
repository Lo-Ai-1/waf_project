<?php
session_start();
include("php/config.php");

// Ensure the user is an admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: home.php");
    exit();
}

// Get the user ID to unblock
if (!isset($_GET['id'])) {
    die("User ID not provided.");
}

$user_id = intval($_GET['id']);
$admin_id = $_SESSION['id']; // Admin's user ID from session
$ip_address = $_SERVER['REMOTE_ADDR']; // Admin's IP address

// Unblock the user
$unblock_query = mysqli_query($con, "UPDATE users SET status='active' WHERE id=$user_id");
if ($unblock_query) {
    // Log the action
    if (function_exists('log_activity')) {
        log_activity($admin_id, "Unblocked user with ID $user_id", $ip_address);
    } else {
        error_log("log_activity function is missing");
    }

    echo "<div class='message success'>User unblocked successfully!</div>";
} else {
    echo "<div class='message error'>Failed to unblock user.</div>";
}

// Redirect back to admin dashboard
header("Location: home.php");
exit();
?>