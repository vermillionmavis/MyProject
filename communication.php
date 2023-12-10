<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the user is logged in
    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
        $message = $_POST['message'];

        // Assuming you have a MySQL database
        $db = new mysqli("localhost", "root", "root", "admin");

        if ($db->connect_error) {
            die("Connection failed: " . $db->connect_error);
        }

        // Escape user input for security
        $username = $db->real_escape_string($username);
        $message = $db->real_escape_string($message);

        // Insert communication and collaboration message into the database
        $query = "INSERT INTO communication_messages (username, message) VALUES ('$username', '$message')";

        if ($db->query($query) === TRUE) {
            echo "Message sent successfully!";
        } else {
            echo "Error: " . $query . "<br>" . $db->error;
        }

        // Close the database connection
        $db->close();
    } else {
        echo "User not logged in.";
    }
} else {
    // If the request is not a POST request, handle accordingly
    echo "Invalid request method";
}
?>
