<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="volunform.css">
</head>
<body>
    <div id="parent">
    <?php

  include("config.php");

  if(isset($_POST['submit'])){
   $full_name = $_POST['fName'];
   $email = $_POST['email'];
   $locations = $_POST['location'];
   $DOB = $_POST['DOB'];
   $experties = $_POST['experties'];
   $gender = $_POST['gender'];

  //verrify the unique email

  $verify_query = mysqli_query($con, "SELECT email FROM volunteer WHERE email='$email'");
  if(mysqli_num_rows($verify_query) !=0){
      echo "<div class='message'>
       <p>This email is used, try another one please!</p>
       </div> <br>";
       echo "<a href='javascript:self.history.back()'><button class='btn'>Go Back</button>";
  }
  else{

      mysqli_query($con,"INSERT INTO volunteer(full_name,email,locations,date_of_birth,exparties,gender) VALUES('$full_name','$email','$locations','$DOB','$experties','$gender')") or die("Erroe Occured");

      echo "<div class='message'>
                <p>Registration successfully!</p>
            </div> <br>";
      echo "<a href='volunteer.html'><button class='btn'>Back now</button>";        

   }
  
 } else{

 ?>
              <main>
                <div class="wrapper">
                <form  action="" method="POST">
                    <h1>Registration</h1>
                    <div class="input-box">
                        <input type="text" name="fName" placeholder="Full Name" required>
                    </div>
        
                    <div class="input-box">
                        <input type="text" name="email" placeholder="Email" required>
                    </div>
        
        
                    <div class="input-box">
                        <input type="text" name="location" placeholder="Location" required>
                    </div>
        
        
                    <div class="input-box">
                        <label>Date of birth</label><br>
                        <input type="date" name="DOB" placeholder="" required>
                    </div>
        
        
                    <div class="input-box">
                        <input type="text" name="experties" placeholder="Exparties" required>
                    </div>
               
                        <select class="input-box" name="gender">
                            <option value="gender"> Select gender</option>
                            <option value="Male"> Male </option>
                            <option value="Female"> Female</option>
                            <option value="Other"> Other</option>
        
                        </select>
                        <button type="submit" name="submit" class="regbtn"><label href="">Register</label></button>
                        </form>
                    </div> 
                    <?Php } ?>
        
        
        
                    <!--<div>
                        <label>Do you want take volanteer?</label><br>
                        <label>Yes</label>
                        <input type="checkbox" name="hire" value="Hire">
                        <label>No</label>
                        <input type="checkbox" name="NotHire" value="NotHire">
                    </div>
        
        
                    <div>
                        <textarea name="details" placeholder="Details about event"></textarea>
                    </div>-->
        
        
                   
                    </main>

             </div>
             </body>
             </html>