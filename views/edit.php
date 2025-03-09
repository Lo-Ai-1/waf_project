<?php
session_start();
include("php/config.php");// Ensure you're including your database connection

// Fetch user data from the database when the page is loaded
if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
    $query = mysqli_query($con, "SELECT * FROM users WHERE id=$id");
    $result = mysqli_fetch_assoc($query);

    // Set initial values for the form
    $res_Uname = $result['username'];
    $res_email = $result['email'];
    $res_Age = $result['Age'];
}
// Fetch user data from the database when the page is loaded
else {
    echo "No user session found.";// If session is not found
}

// Process form submission to update profile
if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $Age = $_POST['Age'];
    $id = $_SESSION['id'];

    // Update the user profile in the database
    $edit_query = mysqli_query($con, "UPDATE users SET username='$username', email='$email', Age='$Age' WHERE id=$id");

    if ($edit_query) {
        $_SESSION['username'] = $username;
        $_SESSION['valid'] = $email;
        $_SESSION['Age'] = $Age;

        // Get IP Address
        $ip_address = $_SERVER['REMOTE_ADDR'];

        // Log profile update
        log_activity($id, "Updated profile information", ip_address: $ip_address);

        echo "<div class='message'><p>Profile Updated!</p></div><br>";
        echo "<a href='home.php'><button class='btn'>Go Home</button></a>";//try user_profile.php
    } else {
        echo "Error: " . mysqli_error($con);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Profile</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* Body styling with a smoother background gradient */
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #0f2027, #203a43, #2c5364);
            color: white;
            text-align: center;
            margin: 0;
            padding: 0;
        }

        /* Container setup with flexbox centering */
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 0 20px;
        }

        /* Form box styling with added shadow and rounded corners */
        .form-box {
            background-color: rgba(0, 0, 0, 0.8);
            padding: 40px;
            border-radius: 12px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            text-align: center;
            animation: fadeIn 0.5s ease;
        }

        /* Header style for the form */
        header {
            font-size: 28px;
            font-weight: bold;
            color: #1abc9c;
            margin-bottom: 20px;
            text-transform: uppercase;
        }

        /* Form field setup */
        .field {
            margin-bottom: 20px;
        }

        .field input {
            width: 100%;
            padding: 5px;
            border-radius: 6px;
            border: 2px solid #34495e;
            background-color: #2c3e50;
            color: #ecf0f1;
            font-size: 16px;
        }

        .field input:focus {
            outline: none;
            border-color: #1abc9c;
        }

        /* Button styling for submit and action buttons */
        .btn {
            background-color: #2c3e50;
            color: #fff;
            border: none;
            padding: 6px 20px;
            cursor: pointer;
            border-radius: 6px;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #16a085;
        }

        /* Styling for error and success messages */
        .message {
            margin-top: 20px;
            font-size: 18px;
            color: #e74c3c;
            padding: 10px;
            border-radius: 6px;
            background-color: rgba(231, 76, 60, 0.1);
        }

        .message p {
            margin: 0;
        }

        .message a {
            color: #e74c3c;
            text-decoration: none;
            font-weight: bold;
        }

        /* Link style for Sign In or Sign Up */
        .link {
            margin-top: 20px;
            font-size: 16px;
        }

        .link a {
            color: #1abc9c;
            text-decoration: none;
        }

        .link a:hover {
            text-decoration: underline;
        }

        /* Animation for smooth fade-in effect */
        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }
    </style>
</head>

<body>
    <div class="nav">
        <div class="logo">
            <p><a href="home.php">Logo</a></p>
        </div>
        <div class="right-links">
            <a href="php/logout.php"><button class="btn">Log Out</button></a>
        </div>
    </div>

    <div class="container">
        <div class="form-box box">
            <header>Change Profile</header>
            <form action="" method="post">
                <div class="field input">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" value="<?php echo htmlspecialchars($res_Uname); ?>"
                        autocomplete="off" required>
                </div>
                <div class="field input">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($res_email); ?>"
                        autocomplete="off" required>
                </div>
                <div class="field input">
                    <label for="Age">Age</label>
                    <input type="number" name="Age" id="Age" value="<?php echo htmlspecialchars($res_Age); ?>"
                        autocomplete="off" required>
                </div>
                <div class="field">
                    <input type="submit" name="submit" class="btn" value="Update" required>
                </div>
            </form>
        </div>
    </div>
</body>

</html>