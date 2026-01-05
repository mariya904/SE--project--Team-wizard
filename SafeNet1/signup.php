<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="signup.css">
</head>
<body>
<div id="parent">
    <?php
    include("config.php");

    if (isset($_POST['registration'])) {
        $first_name = $_POST['fName'];
        $last_name = $_POST['lName'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Handle the photo upload
        $photo = null;
        if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
            $targetDir = "uploads/"; // Directory for uploads
            $fileName = basename($_FILES['photo']['name']);
            $targetFile = $targetDir . $fileName;
            $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

            if (!file_exists($targetDir)) {
                mkdir($targetDir, 0777, true);
            }

            // Validate allowed file types
            if (in_array($fileType, ['jpg', 'png', 'jpeg', 'gif'])) {
                if (move_uploaded_file($_FILES['photo']['tmp_name'], $targetFile)) {
                    $photo = $fileName; // Save file name to store in the database
                } else {
                    echo "Sorry, there was an error uploading your photo.";
                }
            } else {
                echo "Only JPG, JPEG, PNG, and GIF files are allowed.";
            }
        }

        // Verify unique email
        $verify_query = mysqli_query($con, "SELECT email FROM log_in WHERE email='$email'");
        if (mysqli_num_rows($verify_query) != 0) {
            echo "<div class='message'>
                 <p>This email is used, try another one please!</p>
                 </div> <br>";
            echo "<a href='javascript:self.history.back()'><button class='btn'>Go Back</button>";
        } else {
            // Insert into database with photo
            $query = "INSERT INTO log_in(f_name, l_name, email, password, photo) 
                      VALUES ('$first_name', '$last_name', '$email', '$password', '$photo')";
            if (mysqli_query($con, $query)) {
                echo "<div class='message'>
                          <p>Registration successfully!</p>
                      </div> <br>";
                echo "<a href='login.php'><button class='btn'>Login Now</button>";
            } else {
                echo "Error occurred: " . mysqli_error($con);
            }
        }
    } else {
    ?>
    <main>
        <div class="wrapper">
            <form action="" method="POST" enctype="multipart/form-data">
                <h1>Registration</h1>
                <div class="input-box">
                    <input type="text" name="fName" placeholder="First Name" autocomplete="off" required>
                </div>
                <div class="input-box">
                    <input type="text" name="lName" placeholder="Last Name" autocomplete="off" required>
                </div>
                <div class="input-box">
                    <input type="text" name="email" placeholder="Email" autocomplete="off" required>
                </div>
                <div class="input-box">
                    <input type="password" name="password" placeholder="Password" autocomplete="off" required>
                </div>
                <div class="input-box">
                    <label for="photo">Upload Profile Photo:</label>
                    <input type="file" name="photo" id="photo" accept="image/*" required>
                </div>
                <button type="submit" class="regbtn" name="registration">
                    <label>Register</label>
                </button>
            </form>
        </div>
    </main>
    <?php } ?>
</div>
</body>
</html>
