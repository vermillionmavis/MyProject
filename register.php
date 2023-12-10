<?php
    session_start();
    // Establish database connection
    $db = new mysqli("localhost", "root", "root", "admin");

    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }

    // Retrieve the user data from the registration form
    $username = $_POST['username'];
    $password = $_POST['password'];

    $checkQuery = "SELECT id FROM users WHERE username = ?";
    $checkStatement = $db->prepare($checkQuery);
    $checkStatement->bind_param("s", $username);
    $checkStatement->execute();
    $checkResult = $checkStatement->get_result();

    if ($checkResult !== false && $checkResult->num_rows > 0) {
        // Username already exists
        echo "Error: Username already exists. Please choose a different username.";
    } else {
        // Create a unique id for the user
        $user_id = uniqid();

        // Hash the password for security
        $password = isset($_POST['password']) ? $_POST['password'] : '';
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert the data into the database
        $query = "INSERT INTO users (id, username, password) VALUES ('$user_id', '$username', '$hashed_password')";

        if ($db->query($query) === TRUE) {
            // Store the username in the session for use in other pages
            $_SESSION['username'] = $username;
            $db->close();

        // Display the success message and redirect using JavaScript
            echo '<script>
                alert("Registration successful! Redirecting to login page...");
                setTimeout(function(){
                window.location.href = "admin.html";
                }, 3000); // 3 seconds delay
            </script>';
            exit();
        } else {
            echo "Error: " . $query . "<br>" . $db->error;
        }
}
    $checkStatement->close();
    // Close the database connection
    $db->close();
?>