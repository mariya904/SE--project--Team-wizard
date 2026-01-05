<?php 
   session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div id="parent">
    <h3 class="header">Log in As A Admin</h3>
         <?php             
             include("config.php");
             if(isset($_POST['login'])){
               $email = mysqli_real_escape_string($con,$_POST['email']);
               $password = mysqli_real_escape_string($con,$_POST['password']);

               $result = mysqli_query($con,"SELECT * FROM admin WHERE email='$email' AND password='$password' ") or die("Select Error");
               $row = mysqli_fetch_assoc($result);

               if(is_array($row) && !empty($row)){
                   $_SESSION['valid'] = $row['email'];
                   $_SESSION['name'] = $row['name'];            
                   $_SESSION['admin_id'] = $row['admin_id'];
               }else{
                   echo "<div class='message'>
                     <p>Wrong Username or Password</p>
                      </div> <br>";
                  echo "<a href='alog.php'><button class='btn'>Go Back</button>";
        
               }
               if(isset($_SESSION['valid'])){
                   header("Location: home.php");
               }
             }else{

           
           ?>
        <div class="wrapper">
            <form class="" action="login.php" method="POST">
                <h1>Login</h1>
                <div class="input-box">
                    <input type="text" name="email" placeholder="Enter the email" required>
                </div>
    
                <div class="input-box">
                    <input type="password" name="password" placeholder="Password" required>
                </div>
    
                <div class="remember-forgot">
                    <label><input type="checkbox" name="r-check">Remember me</label>
                </div>
    
                <button type="submit" name="login" class="logbtn"><label ><a href="ahome.php">Login</a></label></button>
    
                
            </form>
        </div>
         <?php } ?>    

        </div>
</body>
</html>