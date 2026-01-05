<?php
// Include the database connection
include('config.php');

// Start session to access temporary data
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['entered_otp'])) {
    // Get the entered OTP
    $entered_otp = htmlspecialchars($_POST['entered_otp']);

    // Retrieve the stored data from the session
    $donation_data = $_SESSION['donation_data'];

    if ($entered_otp == $donation_data['otp']) {
        // Extract details
        $name = $donation_data['name'];
        $email = $donation_data['email'];
        $amount = $donation_data['amount'];

        // Insert donation data into the database
        $sql = "INSERT INTO donation (name, email, amount) VALUES ('$name', '$email', '$amount')";

        if ($con->query($sql)) {
            echo "Thank you for your donation!";
            unset($_SESSION['donation_data']); // Clear session data
        } else {
            echo "Error saving donation data: " . $con->error;
        }
    } else {
        echo "Invalid OTP. Please try again.";
    }
}
?>
