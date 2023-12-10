<?php
    session_start();
    // Establish database connection
    $db = new mysqli('localhost', 'root', 'root', 'admin');

    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }

    // Retrieve the user data from the login form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Select the user data from the database
    $query = "SELECT id, username, password FROM users WHERE username = '$username'";
    $result = $db->query($query);

    if ($result->num_rows > 0) {
        // Check if the password is correct
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            // Store the username in the session for use in other pages
            $_SESSION['username'] = $username;

            header("Location: main_page.php");
        exit();
        
        } else {
            echo "Invalid username or password.";
        }
    } else {
        echo "Invalid username or password.";
    }

    // Close the database connection
    $db->close();
?>