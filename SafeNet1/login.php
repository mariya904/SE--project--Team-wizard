<?php 
   session_start();
   include("config.php");

   // Handle session timeout
   if (isset($_SESSION['start_time'])) {
       if ((time() - $_SESSION['start_time']) > $_SESSION['timeout']) {
           session_unset();
           session_destroy();
           header("Location: login.php?message=Session expired, please log in again.");
           exit();
       } else {
           $_SESSION['start_time'] = time(); // Reset session time
       }
   }

   // Handle login form submission
   if (isset($_POST['login'])) {
       $email = mysqli_real_escape_string($con, $_POST['email']);
       $password = mysqli_real_escape_string($con, $_POST['password']);

       $result = mysqli_query($con, "SELECT * FROM log_in WHERE email='$email' AND password='$password'") or die("Select Error");
       $row = mysqli_fetch_assoc($result);

       if (is_array($row) && !empty($row)) {
           // Set session variables
           $_SESSION['valid'] = $row['email'];
           $_SESSION['first_name'] = $row['f_name'];
           $_SESSION['last_name'] = $row['l_name'];            
           $_SESSION['log_id'] = $row['log_id'];
           $_SESSION['start_time'] = time(); // Start session time
           $_SESSION['timeout'] = 30 * 60;  // 30 minutes timeout

           // Handle "Remember Me"
           if (isset($_POST['r-check'])) {
               setcookie("user_email", $row['email'], time() + (7 * 24 * 60 * 60), "/"); // 7 days
           }

           header("Location: home.php");
           exit();
       } else {
           $error_message = "Wrong Username or Password";
       }
   }

   // Display message if redirected after session expiry
   if (isset($_GET['message'])) {
       $error_message = $_GET['message'];
   }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div id="parent">
        <h3 class="header">Log in As A User</h3>

        <?php if (isset($error_message)) { ?>
            <div class="message">
                <p><?php echo $error_message; ?></p>
            </div>
        <?php } ?>

        <div class="wrapper">
            <form action="" method="POST">
                <h1>Login</h1>
                <div class="input-box">
                    <input type="text" name="email" placeholder="Enter the email" 
                           value="<?php echo isset($_COOKIE['user_email']) ? $_COOKIE['user_email'] : ''; ?>" 
                           required>
                </div>
    
                <div class="input-box">
                    <input type="password" name="password" placeholder="Password" required>
                </div>
    
                <div class="remember-forgot">
                    <label><input type="checkbox" name="r-check" <?php echo isset($_COOKIE['user_email']) ? 'checked' : ''; ?>> Remember me</label>
                </div>
    
                <button type="submit" name="login" class="logbtn">Login</button>
            </form>
        </div>
    </div>
</body>
</html>
