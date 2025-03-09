<?php
session_start();
include("php/config.php");

// Check if the user is an admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: home.php");
    exit();
}

// Check if a user ID is provided
if (!isset($_GET['id'])) {
    die("User ID not specified.");
}

$user_id = intval($_GET['id']); // Sanitize user ID

// Delete the user from the database
$delete_query = mysqli_query($con, "DELETE FROM users WHERE id = $user_id");

if ($delete_query) {
    echo "<div class='message'>User deleted successfully!</div>";
} else {
    echo "<div class='message'>Failed to delete user. Please try again.</div>";
}

// Redirect back to admin dashboard
header("Location: home.php");
exit();
?>