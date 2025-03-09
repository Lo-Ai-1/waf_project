<?php
session_start();
include("php/config.php");

// Ensure the user is a SOC Analyst
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'soc_analyst') {
    header("Location: home.php");
    exit();
}

// Get SOC Analyst details from database
$id = $_SESSION['id'];
$query = mysqli_query($con, "SELECT * FROM soc_analysts WHERE user_id=$id");
$soc_data = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SOC Analyst Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #2c3e50;
            color: #ecf0f1;
            margin: 0;
            padding: 0;
        }

        .container {
            padding: 30px;
            max-width: 1200px;
            margin: auto;
        }

        h1 {
            color: #1abc9c;
            text-align: center;
            margin-bottom: 40px;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 20px;
        }

        .card {
            background-color: rgba(0, 0, 0, 0.8);
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
        }

        .card h2 {
            font-size: 22px;
            margin-bottom: 15px;
            color: #ecf0f1;
        }

        .alert {
            background-color: #e74c3c;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 10px;
        }

        .log {
            background-color: #34495e;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 10px;
        }

        .ip-info {
            font-weight: bold;
        }

        .btn {
            background-color: #1abc9c;
            color: #fff;
            border: none;
            padding: 12px 20px;
            cursor: pointer;
            border-radius: 6px;
            margin-top: 20px;
            display: block;
            text-align: center;
            text-decoration: none;
            font-size: 16px;
        }

        .btn:hover {
            background-color: #16a085;
        }

        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }

            h1 {
                font-size: 24px;
            }
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #2c3e50;
            color: #ecf0f1;
            margin: 0;
        }

        .container {
            max-width: 900px;
            width: 100%;
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 20px;
            text-align: center;
        }

        h1 {
            margin-bottom: 20px;
            font-size: 32px;
            color: #1abc9c;
        }

        .grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 20px;
        }

        .card {
            background-color: #34495e;
            border-radius: 8px;
            padding: 20px;
            text-align: left;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
        }

        .alert {
            background-color: #e74c3c;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 10px;
            color: white;
        }

        .log {
            background-color: #2c3e50;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 10px;
        }

        .btn {
            position: absolute;
            top: 20px;
            right: 20px;
            background-color: #1abc9c;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .btn:hover {
            background-color: #16a085;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="nav">
        <div class="logo">
            <p><a href="home.php">Logo</a></p>
        </div>
        <div class="right-links">
            <a href="edit.php">Change Profile</a>
            <a href="php/logout.php"><button class="btn">Log Out</button></a>
        </div>
    </div>

    <div class="container">
        <div class="dashboard-box">
            <h1>Welcome, SOC Analyst <?php echo htmlspecialchars($soc_data['name']); ?>!</h1>
            <p>Email: <?php echo htmlspecialchars($soc_data['email']); ?></p>
            <p>Role: <?php echo htmlspecialchars($_SESSION['role']); ?></p>
            <p>Department: <?php echo htmlspecialchars($soc_data['department']); ?></p>
            <p>Last Login: <?php echo htmlspecialchars($soc_data['last_login']); ?></p>
        </div>

        <div class="log-section">
            <h2>System Logs</h2>
            <table>
                <tr>
                    <th>User ID</th>
                    <th>Activity</th>
                    <th>IP Address</th>
                    <th>Time</th>
                </tr>
                <?php
                $logs_query = mysqli_query($con, "SELECT * FROM logs ORDER BY log_time DESC LIMIT 20");
                while ($log = mysqli_fetch_assoc($logs_query)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($log['user_id']) . "</td>";
                    echo "<td>" . htmlspecialchars($log['activity']) . "</td>";
                    echo "<td>" . htmlspecialchars($log['ip_address']) . "</td>";
                    echo "<td>" . $log['log_time'] . "</td>";
                    echo "</tr>";
                }
                ?>
            </table>
        </div>
    </div>
</body>

</html>