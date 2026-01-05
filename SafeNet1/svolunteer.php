<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "safenet";

$conn = new mysqli("localhost","root", "","safenet");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    // Query to delete the volunteer record
    $delete_sql = "DELETE FROM volunteer WHERE v_id = $delete_id";
    if ($conn->query($delete_sql) === TRUE) {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}


// Fetch data from the 'volunteer' table
$sql = "SELECT v_id, full_name, email, locations, date_of_birth, exparties, gender FROM volunteer";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Volunteer Data</title>
    <link rel="stylesheet" href="volunteer.css">
    <style>
        /* CSS styles for the layout */
        .container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }
        .card {
            width: 30vh;
            height: auto;
            margin:3vh;
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 10px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #f9f9f9;
        }
        .card img {
            width: 100%;
            height: 30vh;
            object-fit: cover;
            border-radius: 10px;
        }
        .card h3, .card p {
            margin: 5px 0;
        }
        .delete-button {
            margin-top: 10px;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            background-color: #e74c3c;
            color: #fff;
            cursor: pointer;
        }
        .delete-button:hover {
            background-color: #c0392b;
        }
    </style>
</head>
<body>
    <div class="parent">
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
   <h1 class="txt">Volunteers Data</h1>
    <div class="container">
        <?php
        // Generate a div for each row of data
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="card">';
                echo '<p>Date of Birth: ' . htmlspecialchars($row['v_id']) . '</p>';
                echo '<h3>' . htmlspecialchars($row['full_name']) . '</h3>';
                echo '<p>Email: ' . htmlspecialchars($row['email']) . '</p>';
                echo '<p>Location: ' . htmlspecialchars($row['locations']) . '</p>';
                echo '<p>Date of Birth: ' . htmlspecialchars($row['date_of_birth']) . '</p>';
                echo '<p>Exparties: ' . htmlspecialchars($row['exparties']) . '</p>';
                echo '<p>Gender: ' . htmlspecialchars($row['gender']) . '</p>';
                

                 // Add Delete Button
        echo '<form method="GET" action="' . htmlspecialchars($_SERVER['PHP_SELF']) . '">';
        echo '<input type="hidden" name="delete_id" value="' . htmlspecialchars($row['v_id']) . '">';
        echo '<button class="delete-button" type="submit">Delete</button>';
        echo '</form>';

        echo '</div>';
            }
        } else {
            echo '<p>No data found.</p>';
        }
        $conn->close();
        ?>
    </div>

    <!--for the footer-->
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