<?php
session_start();
include("php/config.php");

// Check if the user is logged in
if (!isset($_SESSION['valid'])) {
    header("Location: index.php"); // Redirect to login if not logged in
    exit();
}

// Get user data from the database to ensure updates are reflected
$id = $_SESSION['id'];
$query = mysqli_query($con, "SELECT * FROM users WHERE id='$id'");
$userData = mysqli_fetch_assoc($query);

$username = $userData['username']; // Updated username
$email = $userData['email'];
$age = $userData['Age'];
$role = $userData['role'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="">
    <style>
        /* Basic styling for the entire body */
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #0f2027, #203a43, #2c5364);
            color: white;
            text-align: center;
            margin: 0;
            padding: 0;
        }

        /* Navigation bar styles */
        .nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
            background-color: #2C3E50;
            color: #fff;
        }

        /* Links in the navigation bar */
        .nav a {
            color: #fff;
            text-decoration: none;
            margin-left: 15px;
        }

        .nav a:hover {
            text-decoration: underline;
        }

        /* Button styling for logout */
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

        /* Main container styling */
        .container {
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
            text-align: center;
        }

        /* Table styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background-color: #34495E;
            color: #fff;
        }

        table th,
        table td {
            border: 1px solid #2C3E50;
            padding: 10px;
            text-align: left;
        }

        table th {
            background-color: #2C3E50;
            font-weight: bold;
        }

        table tr:nth-child(even) {
            background-color: #3E5773;
        }

        /* Header and paragraph styles */
        h1,
        h2 {
            font-weight: bold;
            margin-bottom: 15px;
        }

        p,
        ul {
            text-align: left;
            margin: 10px 0;
        }

        ul li {
            margin-bottom: 5px;
        }

        /* Admin actions styling */
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
    <!-- Navigation bar section -->
    <div class="nav">
        <div class="logo">
            <p><a href="home.php">Logo</a></p>
        </div>
        <div class="right-links">
            <a href="edit.php">Change Profile</a>
            <a href="php/logout.php"><button class="btn">Log Out</button></a>
        </div>
    </div>

    <main>
        <div class="container">
            <?php if ($role === 'admin') { ?>
                <!-- Section for admin-specific features -->


                <h2>System Logs</h2>
                <table>
                    <tr>
                        <th>User ID</th>
                        <th>Activity</th>
                        <th>IP Address</th>
                        <th>Time</th>
                    </tr>
                    <?php
                    $logs_query = mysqli_query($con, "SELECT logs.*, users.username FROM logs JOIN users ON logs.user_id = users.id ORDER BY log_time DESC");
                    while ($log = mysqli_fetch_assoc($logs_query)) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($log['username']) . "</td>";
                        echo "<td>" . htmlspecialchars($log['activity']) . "</td>";
                        echo "<td>" . htmlspecialchars($log['ip_address']) . "</td>";
                        echo "<td>" . $log['log_time'] . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </table>

                <h1>Welcome, Admin <?php echo htmlspecialchars($username); ?>!</h1>
                <p>Manage the users of the WAF system below:</p>
                <table>
                    <tr>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Age</th>
                        <th>Actions</th>
                    </tr>
                    <?php
                    // Fetch all users for admin management
                    $query = mysqli_query($con, "SELECT * FROM users");
                    while ($row = mysqli_fetch_assoc($query)) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['Age']) . "</td>";
                        echo "<td class='admin-actions'>
                                <a href='edit_user.php?id=" . $row['id'] . "'>Edit</a> | 
                                <a href='delete_user.php?id=" . $row['id'] . "'>Delete</a>
                              </td>";
                        echo "</tr>";
                    }
                    ?>
                </table>
            <?php } else { ?>
                <!-- Section for regular user profile -->
                <h1>Welcome, <?php echo htmlspecialchars($username); ?>!</h1>
                <p>Here is your profile information:</p>
                <ul>
                    <li><strong>Name:</strong> <?php echo htmlspecialchars($username); ?></li>
                    <li><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></li>
                    <li><strong>Age:</strong> <?php echo htmlspecialchars($age); ?></li>
                </ul>
                <p>If you believe you need additional permissions, please contact the admin.</p>
            <?php } ?>
        </div>
    </main>
</body>

</html>