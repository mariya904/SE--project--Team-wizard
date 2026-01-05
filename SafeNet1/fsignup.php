
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
                  
                   if(isset($_POST['registration'])){
                    $first_name = $_POST['fName'];
                    $last_name = $_POST['lName'];
                    $email = $_POST['email'];
                    $password = $_POST['password'];

                    //verrify the unique email

                    $verify_query = mysqli_query($con, "SELECT email FROM f_login WHERE email='$email'");
                    if(mysqli_num_rows($verify_query) !=0){
                        echo "<div class='message'>
                         <p>This email is used, try another one please!</p>
                         </div> <br>";
                         echo "<a href='javascript:self.history.back()'><button class='btn'>Go Back</button>";
                    }
                    else{

                        mysqli_query($con,"INSERT INTO f_login(f_name,l_name,email,Password) VALUES('$first_name','$last_name','$email','$password')") or die("Erroe Occured");
            
                        echo "<div class='message'>
                                  <p>Registration successfully!</p>
                              </div> <br>";
                        echo "<a href='flog.php'><button class='btn'>Login Now</button>";        
            
                     }
                    
                   } else{

                   ?>
              <main>
              <div  class="wrapper">
    
                
                <form action="" method="POST">
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

                   
               <!--     <div class="input-box">
                        <input type="password" name="confirm_password" placeholder="Confirm Password" required>	
                    </div> -->
        
                    
    
        
                    <button type="submit" class="regbtn" name="registration"><label href="login-page.html">Registration</label></button>
                
                </form>
            
            </div>
            <?Php } ?>
            </main>

              
              </div>
</body>
</html>