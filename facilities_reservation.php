<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the user is logged in
    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
        $reservationDate = $_POST['reservationDate'];
        $facilityName = $_POST['facilityName'];

        // Assuming you have a MySQL database
        $db = new mysqli("localhost", "root", "root", "admin");

        if ($db->connect_error) {
            die("Connection failed: " . $db->connect_error);
        }

        // Escape user input for security
        $username = $db->real_escape_string($username);
        $reservationDate = $db->real_escape_string($reservationDate);
        $facilityName = $db->real_escape_string($facilityName);

        // Insert reservation data into the database
        $query = "INSERT INTO facility_reservations (username, reservation_date, facility_name) VALUES ('$username', '$reservationDate', '$facilityName')";

        if ($db->query($query) === TRUE) {
            echo "Facility reservation successful!";
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
