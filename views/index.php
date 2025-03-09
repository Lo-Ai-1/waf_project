<?php
session_start();
include("php/config.php");

if (isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);

    // Fetch user details from the database
    $query = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result = mysqli_query($con, $query) or die("Query error: " . mysqli_error($con));
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        // Store user information in the session
        $_SESSION['valid'] = $row['email'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['Age'] = $row['Age'];
        $_SESSION['id'] = $row['id'];
        $_SESSION['role'] = $row['role']; // Save the user's role (admin/user/soc_analyst)

        // Get IP Address
        $ip_address = $_SERVER['REMOTE_ADDR'];

        // Log successful login
        log_activity($row['id'], "User logged in", $ip_address);

        // Redirect based on the role
        if ($row['role'] === 'admin') {
            header("Location: home.php"); // Admin profile page
        } elseif ($row['role'] === 'soc_analyst') {
            header("Location: soc_analyst.php"); // SOC Analyst dashboard
        } else {
            header("Location: user_profile.php"); // Normal user profile page
        }
        exit();
    } else {
        // Show error if login fails
        echo "<div class='message'>
            <p>Invalid email or password!</p>
        </div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">

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

        /* Container to center content */
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* Form box styling */
        .box.form-box {
            background-color: rgba(0, 0, 0, 0.6);
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.8);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        /* Header of the login form */
        header {
            font-size: 24px;
            margin-bottom: 20px;
            color: #fff;
        }

        /* Input field styling */
        .field.input {
            margin-bottom: 20px;
        }

        .field.input label {
            font-size: 14px;
            margin-bottom: 5px;
            display: block;
            color: #fff;
        }

        .field.input input {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #34495E;
            background-color: #2C3E50;
            color: #fff;
        }

        .field input {
            width: 100%;
            padding: 5px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            background-color: #E74C3C;
            color: #fff;
            border: none;
        }

        .field input:hover {
            background-color: #C0392B;
        }

        /* Link for sign up */
        .link {
            margin-top: 10px;
            color: #34495E;

        }

        .link a {
            text-decoration: none;
            color: inherit;
        }

        .link a:hover {
            text-decoration: underline;
        }

        /* Message display after form submission */
        .message {
            background-color: #f39c12;
            color: white;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        /* Style for the "Sign Up" link */
        .sign-up-link a {
            text-decoration: none;
            color: skyblue;
            font-weight: bold;
            /* Make the link bold */
        }

        .sign-up-link a:hover {
            text-decoration: underline;
            color: #16A085;
            /* Change color on hover */
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="box form-box">
            <header>Login</header>
            <form action="" method="post">
                <div class="field input">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" autocomplete="off" required>
                </div>
                <div class="field input">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" autocomplete="off" required>
                </div>
                <div class="field">
                    <input type="submit" name="submit" class="btn" value="Login">
                </div>
                <div class="link">
                    Don't have an account? <span class="sign-up-link"><a href="register.php">Sign Up</a></span>
                </div>
            </form>
        </div>
    </div>
</body>

</html>