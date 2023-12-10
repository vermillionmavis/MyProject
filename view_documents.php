<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the user is logged in
    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];

        // Assuming you have a MySQL database
        $db = new mysqli("localhost", "root", "root", "admin");

        if ($db->connect_error) {
            die("Connection failed: " . $db->connect_error);
        }

        // Escape user input for security
        $username = $db->real_escape_string($username);

        // Retrieve documents for the logged-in user
        $query = "SELECT document_name FROM user_documents WHERE username = '$username'";
        $result = $db->query($query);

        if ($result) {
            if ($result->num_rows > 0) {
                echo "<h2>Your Submitted Documents:</h2>";
                echo "<ul>";
                while ($row = $result->fetch_assoc()) {
                    echo "<li>" . $row['document_name'] . "</li>";
                }
                echo "</ul>";
            } else {
                echo "You haven't submitted any documents yet.";
            }
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
