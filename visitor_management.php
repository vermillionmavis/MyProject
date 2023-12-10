<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the user is logged in
    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
        $visitorName = $_POST['visitorName'];
        $reasonToVisit = $_POST['reasonToVisit'];
        $visitorComments = $_POST['visitorComments'];

        // Assuming you have a MySQL database
        $db = new mysqli("localhost", "root", "root", "admin");

        if ($db->connect_error) {
            die("Connection failed: " . $db->connect_error);
        }

        // Escape user input for security
        $username = $db->real_escape_string($username);
        $visitorName = $db->real_escape_string($visitorName);
        $reasonToVisit = $db->real_escape_string($reasonToVisit);
        $visitorComments = $db->real_escape_string($visitorComments);

        // Insert visitor management data into the database
        $query = "INSERT INTO visitor_management (username, visitor_name, reason_to_visit, visitor_comments) VALUES ('$username', '$visitorName', '$reasonToVisit', '$visitorComments')";

        if ($db->query($query) === TRUE) {
            echo "Visitor management data submitted successfully!";
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
