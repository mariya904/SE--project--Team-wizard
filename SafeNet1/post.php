<?php
// Start session
session_start();
include("config.php");

// Check if the user is logged in
if (!isset($_SESSION['log_id'])) {
    // Provide options for login
    echo '<script>
        if (confirm("You are not logged in. Would you like to log in as a regular user? Click OK. If you want to log in as a foundation, click Cancel.")) {
            window.location.href = "login.php"; // Redirect to user login page
        } else {
            window.location.href = "flog.php"; // Redirect to foundation login page
        }
    </script>';
    exit;
}

// Get the logged-in user's ID
$log_id = $_SESSION['log_id'];

// Handle post creation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_post'])) {
    $description = $_POST['description'];
    $photo = $_FILES['photo']['name'];

    // Upload the post photo
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["photo"]["name"]);
    move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file);

    // Insert the post into the database
    $insert_query = "INSERT INTO post (description, photo, log_id) VALUES ('$description', '$photo', '$log_id')";
    if (mysqli_query($con, $insert_query)) {
        header("Location: post.php"); // Reload page to show the new post
        exit;
    } else {
        echo "Error: Could not create post.";
    }
}

// Fetch posts from the database
$query = "SELECT p.post_id, p.description, p.photo, l.f_name, l.l_name, l.photo AS user_photo 
          FROM post p 
          JOIN log_in l ON p.log_id = l.log_id
          ORDER BY p.post_id DESC";
$result = mysqli_query($con, $query);

// Check if the query was successful
if (!$result) {
    die("Error executing query: " . mysqli_error($con));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Portal</title>
    <link rel="stylesheet" href="post.css">
</head>
<body>

<div id="parent">
    <div id="bar">
        <img src="logo.png" class="logo">
        <h2 style="margin-top:1vh; margin-left:2vh ;font-size:6vh;"> <a href="home.php" class="home-link">SafeNet</a></h2>
        <!-- Your navigation buttons -->
        <button class="btn1" onclick="location.href='volunteer.html'">Volunteer</button>         
        <button class="btn" onclick="location.href='post.php'">Post</button>      
        <button class="btn" onclick="location.href='ufoundation.php'">Foundation</button>        
        <button class="btn" onclick="location.href='donation.html'">Donation</button>
        <button class="btn" onclick="location.href='crisis_map.php'">Crisis Map</button>        
        <button class="btncr" onclick="location.href='create_event.html'">Create Event</button>
        <button class="btn" onclick="location.href='unews.php'">Newsroom</button>
        <button class="btn2" onclick="location.href='home.html'">Log Out</button>
    </div>

    <div id="container">
        <!-- Post creation area on the left -->
        <div class="post-create-area">
            <h2>Create a Post</h2>
            <form action="post.php" method="POST" enctype="multipart/form-data">
                <textarea name="description" placeholder="Write your post..." required></textarea><br><br>
                <input type="file" name="photo" required><br><br>
                <button type="submit" name="submit_post">Post</button>
            </form>
        </div>

        <!-- Posts display area on the right (scrollable) -->
        <div id="posts">
            <h2>User Posts</h2>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <div class="post">
                    <div class="post-header">
                        <img src="uploads/<?php echo $row['user_photo']; ?>" alt="User Photo" class="user-photo">
                         <h3><?php echo $row['f_name'] . " " . $row['l_name']; ?></h3>
                    </div>
                    <p><strong>Post ID:</strong> <?php echo $row['post_id']; ?></p> <!-- Display Post ID -->
                    <p><?php echo $row['description']; ?></p>
                    <img src="uploads/<?php echo $row['photo']; ?>" alt="Post Photo" class="post-photo">
                </div>
            <?php } ?>
        </div>
    </div>
</div>

</body>
</html>
