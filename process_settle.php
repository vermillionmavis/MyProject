<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the user is logged in
    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];

        // Global check for required fields and legal agreement
        if (empty($_POST['reservationDate']) || empty($_POST['selectedRoom']) || empty($_FILES["attachment"]["name"]) || empty($_POST['visitorName']) || empty($_POST['reasonToVisit']) || empty($_POST['visitorComments'])) {
            echo "Error: All fields are required, and you must agree to the Terms and Conditions.";
            return;
        }

        // Handle settlement process based on the module
        handleFacilitiesSettle($username);
        handleDocumentSettle($username);
        handleVisitorSettle($username);

    } else {
        echo "User not logged in.";
    }
} else {
    echo "Invalid request method.";
}

// Function to handle facilities settlement
function handleFacilitiesSettle($username) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $selectedRoom = $_POST['selectedRoom'];
        $reservationDate = $_POST['reservationDate'];

        // Check if the reservation date and selected room are provided
        if (!isset($selectedRoom)) {
            echo "Error: Reservation date and selected room are required.";
            return;
        }

        // Assuming you have a MySQL database
        $db = new mysqli("localhost", "root", "root", "admin");

        if ($db->connect_error) {
            die("Connection failed: " . $db->connect_error);
        }

        // Escape user input for security
        $username = $db->real_escape_string($username);
        $selectedRoom = $db->real_escape_string($selectedRoom);
        $reservationDate = $db->real_escape_string($reservationDate);

        // Insert reservation data into the database
        $query = "INSERT INTO facility_reservations (username, reservation_date, facility_name) VALUES ('$username', '$reservationDate', '$selectedRoom')";

        if ($db->query($query) === TRUE) {
            echo "\nFacility reservation successful!";
        } else {
            echo "Error: " . $query . "<br>" . $db->error;
        }

        // Close the database connection
        $db->close();
    } else {
        echo "Invalid request method for facilities settlement.";
    }
}

// Function to handle document settlement
function handleDocumentSettle($username) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Check if the user is logged in
        if (isset($_SESSION['username'])) {
            // Check if a file is uploaded
            if (!empty($_FILES["attachment"]["name"])) {
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
                            echo "\nDocument uploaded successfully!";
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
                echo "Error: No file uploaded.";
            }
        } else {
            echo "User not logged in.";
        }
    } else {
        // If the request is not a POST request, handle accordingly
        echo "Invalid request method";
    }
}

// Function to handle visitor settlement
function handleVisitorSettle($username) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $visitorName = $_POST['visitorName'];
        $reasonToVisit = $_POST['reasonToVisit'];
        $visitorComments = $_POST['visitorComments'];

        // Check if all required fields are provided
        if (empty($visitorName) || empty($reasonToVisit) || empty($visitorComments)) {
            echo "Error: All fields are required.";
            return;
        }

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
            echo "\nVisitor management data submitted successfully!";
        } else {
            echo "Error: " . $query . "<br>" . $db->error;
        }

        // Close the database connection
        $db->close();
    } else {
        echo "Invalid request method for visitor settlement.";
    }
}
?>
