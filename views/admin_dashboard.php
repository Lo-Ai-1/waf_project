<?php
session_start();
include("php/config.php");

if (!isset($_SESSION['valid']) || $_SESSION['role'] != 'admin') {
    header("Location: index.php");  // Redirect to login if not an admin
    exit();
}

// Fetch all users for admin to manage
$query = mysqli_query($con, "SELECT id, username, email, Age FROM users");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="nav">
        <div class="logo">
            <p><a href="home.php">Logo</a></p>
        </div>
        <div class="right-links">
            <a href="home.php">Go Home</a>
            <a href="php/logout.php"><button class="btn">Log Out</button></a>
        </div>
    </div>

    <main>
        <h2>Manage Users</h2>
        <table>
            <tr>
                <th>Username</th>
                <th>Email</th>
                <th>Age</th>
                <th>Actions</th>
            </tr>
            
            <?php while ($row = mysqli_fetch_assoc($query)) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['username']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo $row['Age']; ?></td>
                    <td>
                        <a href="edit_user.php?id=<?php echo $row['id']; ?>">Edit</a> |
                        <a href="delete_user.php?id=<?php echo $row['id']; ?>">Delete</a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </main>
</body>

</html>