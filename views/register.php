<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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
            background-color: #34495e;
            color: #ecf0f1;
            font-size: 16px;
        }

        .field input:focus {
            outline: none;
            border-color: #1abc9c;
        }

        /* Button styling for submit and action buttons */
        .btn {
            background-color: #1abc9c;
            color: #fff;
            border: none;
            padding: 5px 20px;
            cursor: pointer;
            border-radius: 6px;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #16a085;
        }

        /* Styling for error and success messages */
        /* General styling for the message container */
        .message {
            margin-top: 20px;
            font-size: 18px;
            padding: 10px;
            border-radius: 6px;
            text-align: center;
        }

        /* Success message style */
        .message.success {
            color: #2ecc71;
            /* Green text */
            border: 2px solid #2ecc71;
            /* Green border */
            background-color: rgba(46, 204, 113, 0.1);
            /* Light green background */
        }

        /* Error message style */
        .message.error {
            color: #e74c3c;
            /* Red text */
            border: 2px solid #e74c3c;
            /* Red border */
            background-color: rgba(231, 76, 60, 0.1);
            /* Light red background */
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
    <div class="container">
        <div class="form-box box">
            <?php
            include("php/config.php");

            if (isset($_POST['submit'])) {
                $username = $_POST['username'];
                $email = $_POST['email'];
                $Age = $_POST['Age'];
                $password = $_POST['password'];

                // Verifying a unique email
                $verify_query = mysqli_query($con, "SELECT email FROM users WHERE email='$email'");
                if (mysqli_num_rows($verify_query) != 0) {
                    // Display error message
                    echo "<div class='message error'>
                <p>This email is already used. Please try another one!</p>
              </div>";
                    echo "<a href='javascript:self.history.back()'><button class='btn'>Go Back</button></a>";
                } else {
                    // Insert user into database
                    mysqli_query($con, "INSERT INTO users (username, email, Age, Password) VALUES('$username','$email','$Age','$password')")
                        or die("Error Occurred");

                    // Display success message
                    echo "<div class='message success'>
                <p>Registration successful! Please login now.</p>
              </div>";
                    echo "<a href='index.php'><button class='btn'>Login Now</button></a>";
                }
            } else {
                ?>
                <header>Sign Up</header>
                <form action="" method="post">
                    <div class="field input">
                        <label for="username">Username</label>
                        <input type="text" name="username" id="username" autocomplete="off" required>
                    </div>

                    <div class="field input">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" autocomplete="off" required>
                    </div>

                    <div class="field input">
                        <label for="Age">Age</label>
                        <input type="number" name="Age" id="Age" autocomplete="off" required>
                    </div>

                    <div class="field input">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" required>
                    </div>

                    <div class="field">
                        <input type="submit" name="submit" class="btn" value="Register">
                    </div>

                    <div class="link">
                        Already a Member? <a href="index.php">Sign In</a>
                    </div>
                </form>
            <?php } ?>
        </div>
    </div>
</body>

</html>