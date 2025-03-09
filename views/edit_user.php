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

// Fetch user data
$query = mysqli_query($con, "SELECT * FROM users WHERE id = $user_id");
$user = mysqli_fetch_assoc($query);

if (!$user) {
    die("User not found.");
}

// Handle form submission
if (isset($_POST['submit'])) {
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $age = intval($_POST['age']);
    $role = mysqli_real_escape_string($con, $_POST['role']);

    // Update the user in the database
    $update_query = mysqli_query($con, "UPDATE users SET username='$username', email='$email', Age='$age', role='$role' WHERE id=$user_id");

    if ($update_query) {
        // Log the action
        $admin_id = $_SESSION['id'];
        $ip_address = $_SERVER['REMOTE_ADDR'];
        log_activity($admin_id, "Updated user ID $user_id profile", $ip_address);

        echo "<div class='message success'>User updated successfully!</div>";
    } else {
        echo "<div class='message error'>Failed to update user. Please try again.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* Add the styles from homepage */
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #0f2027, #203a43, #2c5364);
            color: white;
            text-align: center;
            margin: 0;
            padding: 0;
        }

        .nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
            background-color: #2C3E50;
            color: #fff;
        }

        .nav a {
            color: #fff;
            text-decoration: none;
            margin-left: 15px;
        }

        .nav a:hover {
            text-decoration: underline;
        }

        .btn {
            background-color: #E74C3C;
            color: #fff;
            border: none;
            padding: 8px 12px;
            cursor: pointer;
            border-radius: 5px;
        }

        .btn:hover {
            background-color: #C0392B;
        }

        .container {
            padding: 20px;
            max-width: 800px;
            margin: 0 auto;
            text-align: center;
        }

        h1 {
            font-weight: bold;
            margin-bottom: 15px;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
            margin-top: 20px;
        }

        label {
            font-weight: bold;
        }

        input,
        select {
            padding: 8px;
            font-size: 1rem;
            width: 100%;
            max-width: 400px;
            border-radius: 5px;
            border: 1px solid #BDC3C7;
        }

        .message {
            margin-top: 20px;
            padding: 10px;
            border-radius: 5px;
            font-weight: bold;
        }

        .success {
            background-color: #27AE60;
            color: #fff;
        }

        .error {
            background-color: #E74C3C;
            color: #fff;
        }

        .admin-actions a {
            color: #1ABC9C;
            text-decoration: none;
            margin-right: 10px;
        }

        .admin-actions a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="nav">
        <div class="logo">
            <p><a href="home.php">Logo</a></p>
        </div>
        <div class="right-links">
            <a href="home.php">Back to Home</a>
        </div>
    </div>

    <div class="container">
        <h1>Edit User</h1>

        <form action="" method="post">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" value="<?php echo htmlspecialchars($user['username']); ?>"
                required>

            <label for="email">Email:</label>
            <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($user['email']); ?>"
                required>

            <label for="age">Age:</label>
            <input type="number" name="age" id="age" value="<?php echo $user['Age']; ?>" required>

            <label for="role">Role:</label>
            <select name="role" id="role" required>
                <option value="user" <?php echo $user['role'] === 'user' ? 'selected' : ''; ?>>User</option>
                <option value="admin" <?php echo $user['role'] === 'admin' ? 'selected' : ''; ?>>Admin</option>
            </select>

            <button type="submit" name="submit" class="btn">Update User</button>
        </form>
    </div>
</body>

</html>