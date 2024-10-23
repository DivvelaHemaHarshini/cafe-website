<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if form data is submitted
if (isset($_POST['name'], $_POST['number'], $_POST['guests'])) {
    $name = $_POST['name'];
    $number = $_POST['number'];
    $guests = $_POST['guests'];

    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'coffee-db');

    // Check connection
    if ($conn->connect_error) {
        die('Connection Failed: ' . $conn->connect_error);
    } else {
        echo "Database connected successfully.<br>";
    }

    // Prepare insert statement with backticks for table name
    $stmt = $conn->prepare("INSERT INTO `coffee-form` (name, number, guests) VALUES (?, ?, ?)");

    // Check if the statement was prepared correctly
    if ($stmt === false) {
        die("Error in statement preparation: " . $conn->error);
    }

    // Bind parameters (assuming guests is an integer, change bind types as needed)
    $stmt->bind_param("sss", $name, $number, $guests);

    // Execute the statement and check for errors
    if ($stmt->execute()) {
        $message = 'Message successfully sent!';
    } else {
        $message = 'Error: ' . $stmt->error;
    }

    // Show the result message
    // echo "<script>alert('$message');</script>";

    echo "Message sent successfully";

    // Close the statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo "No form data received.";
}
?>
