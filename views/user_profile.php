<?php
session_start();
include("php/config.php");

$id = $_SESSION['id'];
$query = mysqli_query($con, "SELECT * FROM users WHERE id=$id");
$result = mysqli_fetch_assoc($query);
$res_Uname = $result['username'];
$res_email = $result['email'];
$res_Age = $result['Age'];
$res_profile_pic = !empty($result['profile_pic']) ? htmlspecialchars($result['profile_pic']) : "uploads/default-avatar.png"; // صورة افتراضية

// ✅ التعامل مع رفع صورة الملف الشخصي
if (isset($_POST['upload_pic'])) {
    $target_dir = "css/";
    $target_file = $target_dir . basename($_FILES["profile_pic"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // ✅ التحقق من أن الملف صورة
    $check = getimagesize($_FILES["profile_pic"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "<script>Swal.fire('message error!', 'File is not an image.', 'error');</script>";
        $uploadOk = 0;
    }

    // ✅ السماح فقط بـ JPG و JPEG و PNG
    if (!in_array($imageFileType, ['jpg', 'jpeg', 'png'])) {
        echo "<script>Swal.fire('Only JPG, JPEG, and PNG files are allowed.', 'error');</script>";
        $uploadOk = 0;
    }

    // ✅ نقل الملف المرفوع وتحديث قاعدة البيانات
    if ($uploadOk && move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $target_file)) {
        mysqli_query($con, "UPDATE users SET profile_pic='$target_file' WHERE id=$id");
        $_SESSION['profile_pic'] = $target_file;
        echo "<script>Swal.fire( 'Profile picture updated successfully!'.', 'success').then(() => location.reload());</script>";
    } else {
        echo "<script>Swal.fire('There was an error uploading your file.', 'error');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="css/pro_Style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>
    <!-- ✅ شريط التنقل -->
    <nav class="navbar">
        <div class="logo">
            <a href="home.php">Logo</a>
        </div>
        <div class="nav-links">
            <a href="edit.php">Change Profile</a>
            <a href="php/logout.php"><button class="btn logout-btn">Log Out</button></a>
        </div>
    </nav>

    <!-- ✅ قسم الملف الشخصي -->
    <main class="profile-container">
        <section class="profile-card">
            <header class="profile-header">
                <h2>Welcome, <?php echo htmlspecialchars($res_Uname); ?></h2>
            </header>

            <div class="profile-content">
                <!-- ✅ صورة الملف الشخصي -->
                <div class="profile-picture">
                    <img src="<?php echo $res_profile_pic; ?>" alt="Profile Picture" class="profile-img">
                    <form action="" method="post" enctype="multipart/form-data">
                        <input type="file" name="profile_pic" required>
                        <button type="submit" name="upload_pic" class="btn upload-btn">Upload New Picture</button>
                    </form>
                </div>

                <!-- ✅ معلومات المستخدم -->
                <div class="user-info">
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($res_email); ?></p>
                    <p><strong>Age:</strong> <?php echo htmlspecialchars($res_Age); ?></p>
                </div>
            </div>

            <!-- ✅ أزرار الإجراءات -->
            <div class="profile-actions">
                <a href="edit.php"><button class="btn">Edit Profile</button></a>
                <a href="change_password.php"><button class="btn">Change Password</button></a>
                <a href="delete_account.php"><button class="btn delete-btn">Delete Account</button></a>
            </div>
        </section>
    </main>

    <style>
        .profile-picture {
            text-align: center;
            margin-bottom: 15px;
        }

        .profile-img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #007bff;
            background-color: #f1f1f1;
        }

        .upload-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 8px 16px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }

        .upload-btn:hover {
            background-color: #0056b3;
        }
    </style>

</body>

</html>