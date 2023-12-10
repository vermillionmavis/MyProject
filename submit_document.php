<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the user is logged in
    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];

        // Handle file upload
        $targetDir = "D:/System/uploads/";
        $fileName = basename($_FILES["attachment"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

        // Allow both image and PDF uploads
        $allowedTypes = array("jpg", "jpeg", "png", "gif", "pdf", "docx");

        if (in_array($fileType, $allowedTypes)) {
            // Move the uploaded file to the chosen directory
            if (move_uploaded_file($_FILES["attachment"]["tmp_name"], $targetFilePath)) {
                // Assuming you have a MySQL database
                $db = new mysqli("localhost", "root", "root", "admin");

                if ($db->connect_error) {
                    die("Connection failed: " . $db->connect_error);
                }

                // Escape user input for security
                $username = $db->real_escape_string($username);
                $fileName = $db->real_escape_string($fileName);
                $targetFilePath = $db->real_escape_string($targetFilePath);

                // Insert file information into the database
                $query = "INSERT INTO user_documents (username, document_name, file_path) VALUES ('$username', '$fileName', '$targetFilePath')";

                if ($db->query($query) === TRUE) {
                    echo "Document uploaded successfully!";
                } else {
                    echo "Error: " . $query . "<br>" . $db->error;
                }

                // Close the database connection
                $db->close();
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        } else {
            echo "Invalid file type. Only DOCX, JPG, JPEG, PNG, GIF, and PDF files are allowed.";
        }
    } else {
        echo "User not logged in.";
    }
} else {
    // If the request is not a POST request, handle accordingly
    echo "Invalid request method";
}
?>
