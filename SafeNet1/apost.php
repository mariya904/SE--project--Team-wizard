<?php
// Include the database connection
include('config.php');

// Query to fetch all posts from the 'post' table
$sql = "SELECT * FROM post";
$result = $con->query($sql);

// Check for deletion (if `delete_id` is set in URL)
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    
    // Query to delete the post from the database
    $delete_sql = "DELETE FROM post WHERE post_id = $delete_id";
    if ($con->query($delete_sql) === TRUE) {
        // If deletion is successful, redirect to the same page to refresh the posts
        header("Location: apost.php");
        exit();
    } else {
        echo "Error deleting record: " . $con->error;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Cards</title>
    <link rel="stylesheet" href="apost.css"> <!-- Add your CSS file here -->
</head>
<body>
<div id="parent">
<div id="bar">
            <img src="logo.png" class="logo">
            <h2 style="margin-top:1vh; margin-left:2vh ;font-size:6vh;  "> <a href="home.php" class="home-link">SafeNet</a></h2>
              <button class="btn1" onclick="location.href='svolunteer.php'">Volunteer</button>         
             <button class="btn" onclick="location.href='apost.php'">post</button>      
              <button class="btn" onclick="location.href='afoundation.php'">Foundation</button>        
              <button class="btn" onclick="location.href='adonation.html'">Donation</button>
              <button class="btn" onclick="location.href='acrisis.php'">Crisis Map</button>        
              <button class="btn" onclick="location.href='acreate_event.php'">Create Event</button>
              <button class="btn" onclick="location.href='anews.php'">Newsroom</button>
              <button class="btn2" onclick="location.href='home.html'">log out</button>                      
        </div>
        <h1 style="text-align:center; margin:2vh">Posted News</h1>
    <div class="container">
        <?php
        // Check if there are any posts
        if ($result->num_rows > 0) {
            // Output each post as a card
            while ($row = $result->fetch_assoc()) {
                ?>
                <div class="card">
                    <img src="uploads/<?php echo htmlspecialchars($row['photo']); ?>" alt="Post Image">
                    <h3><?php echo htmlspecialchars($row['description']); ?></h3>
                    <p>Post ID: <?php echo htmlspecialchars($row['post_id']); ?></p>

                    <!-- Delete Button -->
                    <a href="apost.php?delete_id=<?php echo $row['post_id']; ?>" class="delete-button" onclick="return confirm('Are you sure you want to delete this post?')">Delete</a>
                </div>
                <?php
            }
        } else {
            echo "<p>No posts available.</p>";
        }
        ?>
    </div>

    <div class="footer">
    <div class="photo">
                <img src="logo.png"  class="logo2">
            <h1 style="font-size: 3.5vh; margin-left:7vh">SafeNet</h1>
            </div>
            <div class="first-div">
                <p style="font-size:3.5vh; font-weight: bold">User :</p><br>
                <p class="small_text">Create an Account.</p><br>
                <p class="small_text"> Create an Event.</p><br>
                <p class="small_text">Be a volunteer.</p><br>
                <p class="small_text">Anyone can Donate.</p><br>

            </div>
            <div class="second_div">
                <p style="font-size:3.5vh; font-weight: bold">Founmdation :</p><br>
                <p class="small_text">Create an Account.</p><br>
                <p class="small_text"> Analyze Crisis map.</p><br>  
            </div>

            <div class="third_div">
                <p style="font-size:3.5vh; font-weight: bold">Contact us :</p><br>
                <p class="small_text">Need any support call to 01347832465723.</p><br>
                <p class="small_text">or email saifnet72@gmail.com.</p><br>
            </div>

            <div class="fourth_div">
                <p style="font-size:3.5vh; font-weight: bold">Follow us on :</p><br>
                <div class="conimg">
                    <img src="fb.png" class="imgf">
                    <img src="lnkdin.png" class="imgf">
                    <img src="youtub.png" class="imgf">
                    <img src="insta.jpg" class="imgf">
                </div>
            </div>
    </div>
    </div>

</body>
</html>
