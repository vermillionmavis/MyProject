<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect to the login page if not logged in
    header("Location: login.php");
    exit();
}

// Retrieve the username from the session
$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Page</title>
    <link rel="stylesheet" href="mstyles.css">
</head>
<body>

    <div id="header">
        <div id="user-info">
            <div id="user-circle" onclick="toggleUserPane()"></div>
            <span id="username"></span>        
            <div id="user-pane">
                <a href="logout.php">Logout</a>
            </div>
        </div>
        <h1>Administrative Management System</h1>
    </div>

    <div id="container">
        <div id="sidebar">
            <h2>Modules</h2>
            <ul>
                <li><a href="#" onclick="showModule('facilities')">Facilities Reservation</a></li>
                <li><a href="#" onclick="showModule('legal')">Legal Management</a></li>
                <li><a href="#" onclick="showModule('document')">Document Management</a></li>
                <li><a href="#" onclick="showModule('visitor')">Visitor Management</a></li>
                <li><a href="#" onclick="showModule('communication')">Communication and Collaboration</a></li>
            </ul>
            <div>
                <button type="button" onclick="settle()" id="settle-button">Settle</button>
                <p id="agreement-message" style="color: red; font-weight: bold;">Please agree to the Terms and Conditions before settling.</p>
            </div>
        </div>

        <div id="welcome-page">
            <div id="welcome-background">
                <div class="background-images">
                    <img class="background-image" src="jpegs/background1.jpg" alt="Background 1">
                    <img class="background-image" src="jpegs/background2.jpg" alt="Background 2">
                    <img class="background-image" src="jpegs/background3.jpg" alt="Background 3">
                </div>
                <div id="welcome-content">
                    <!-- Your existing welcome content goes here -->
                    <h2>Hello, <?php echo $username; ?>!</h2>
                    <p>We're glad to have you on board. Explore the modules using the sidebar to manage various aspects of the system.</p>
                    <p>If you have any questions or need assistance, feel free to reach out to our support team.</p>
                    <!-- Add more content or features as needed -->
                </div>
            </div>
        </div>

        <div id="modules">
            <div id="facilities" class="module-options">
                <h2>Facilities Reservation</h2>
                <div id="facilityImages" class="facility-container">
                    <div class="room" onclick="selectRoom('Room 1')">
                        <h3>Standard Suite</h3>
                        <img src="jpegs/room1.jpg" alt="Room 1" class="facility-image" data-room="Room 1">
                    </div>
                    <div class="room" onclick="selectRoom('Room 2')">
                        <h3>Premium Suite</h3>
                        <img src="jpegs/room2.jpg" alt="Room 2" class="facility-image" data-room="Room 2">
                    </div>
                    <div class="room" onclick="selectRoom('Room 3')">
                        <h3>Luxurious Suite</h3>
                        <img src="jpegs/room3.jpg" alt="Room 3" class="facility-image" data-room="Room 3">
                    </div>
                </div>
                <form id="facilities-form">
                    <input type="hidden" id="selectedRoom" name="selectedRoom" required>
                    <input type="date" id="reservationDate" name="reservationDate" required><br>
                </form>
                <div class="module-background"></div>
            </div>

            <div id="legal" class="module-options">
                <h2>Legal Management</h2>
                <p>Please read and agree to our Terms and Conditions before proceeding.</p>

                <h2>Terms and Conditions</h2>

                    <p>These terms and conditions ("Agreement") are an agreement between Adminstrative Management System ("Company", "us", "we" or "our") and you ("User", "you" or "your"). This Agreement sets forth the general terms and conditions of your use of the Administrative Manamgent System website and any of its products or services (collectively, "Website" or "Services").</p>

                    <h3>1. Acceptance of terms</h3>
                    <p>By accessing this Website, you agree to be bound by these terms and conditions, all applicable laws and regulations, and agree that you are responsible for compliance with any applicable local laws. If you do not agree with any of these terms, you are prohibited from using or accessing this site. The materials contained in this Website are protected by applicable copyright and trademark law.</p>

                    <h3>2. Use license</h3>
                    <p>Permission is granted to temporarily download one copy of the materials (information or software) on Adminstrative Management System's Website for personal, non-commercial transitory viewing only. This is the grant of a license, not a transfer of title, and under this license, you may not:</p>
                    <ul>
                        <li>modify or copy the materials;</li>
                        <li>use the materials for any commercial purpose or for any public display;</li>
                        <li>attempt to decompile or reverse engineer any software contained on Adminstrative Management System's Website;</li>
                        <li>remove any copyright or other proprietary notations from the materials; or</li>
                        <li>transfer the materials to another person or "mirror" the materials on any other server.</li>
                    </ul>
                    <p>This license shall automatically terminate if you violate any of these restrictions and may be terminated by Adminstrative Management System at any time. Upon terminating your viewing of these materials or upon the termination of this license, you must destroy any downloaded materials in your possession whether in electronic or printed format.</p>
                <form action="legal_management.php" method="post">
                <input type="checkbox" id="legal-agreement" name="agreement" value="on" required> I have read and agree to the Terms and Conditions
                </form>
                <div class="module-background"></div>
            </div>

            <div id="document" class="module-options">
                <h2>Document Management</h2>
                    <p>UPLOAD ID: </p>
                <form id="document-form" method="post" enctype="multipart/form-data">
                    <input type="file" id="document-upload" name="attachment" accept="image/*"><br>
                </form>
                <form id="view-documents-form" action="view_documents.php" method="post">
                    <input type="submit" value="View My Documents">
                </form>
                <div class="module-background"></div>
            </div>

            <div id="visitor" class="module-options">
                <h2>Visitor Management</h2>
                <form id="visitor-form" action="visitor_management.php" method="post">
                    <label for="visitorName">Visitor Name:</label>
                    <input type="text" id="visitorName" name="visitorName" required><br>

                    <label for="reasonToVisit">Reason to Visit:</label>
                    <input type="text" id="reasonToVisit" name="reasonToVisit" required><br>

                    <label for="visitorComments">Visitor Comments:</label>
                    <textarea name="visitorComments" id="visitorComments" rows="4" cols="50" placeholder="Enter visitor comments"></textarea><br>
                </form>
                <div class="module-background"></div>
            </div>

            <div id="communication" class="module-options">
                <h2>Communication and Collaboration</h2>
                <p>Contact: 123-456-7890</p>
                <form id="communication-form" action="communication.php" method="post">
                    <textarea name="message" rows="4" cols="50" placeholder="Enter your message"></textarea><br>
                    <input type="submit" value="Send Message">
                </form>
                <div class="module-background"></div>
            </div>
        </div>
    </div>
    

    <script>
    document.addEventListener("DOMContentLoaded", function () {
        var username = "<?php echo htmlspecialchars($username); ?>";
        if (username !== "") {
            var firstLetter = username.charAt(0).toUpperCase();
            document.getElementById("user-circle").innerText = firstLetter;
            document.getElementById("username").innerText = username;
        }
    });

    function showModule(moduleId) {
        // Hide all modules
        var modulesToHide = document.querySelectorAll('.module-options');
        modulesToHide.forEach(function (module) {
            module.style.display = 'none';
        });

        // Show the selected module
        var selectedModule = document.getElementById(moduleId);
        if (selectedModule) {
            selectedModule.style.display = 'block';
        }
    }

    // Add an event listener to hide the welcome page on sidebar link click
    document.querySelectorAll('#sidebar a').forEach(function (link) {
        link.addEventListener('click', function () {
            document.getElementById("welcome-page").style.display = "none";
        });
    });

    function selectRoom(room) {
        // Remove the "selected" class from all images
        var images = document.querySelectorAll('.facility-image');
        images.forEach(function (image) {
            image.classList.remove('selected');
        });

        // Add the "selected" class to the clicked image
        var selectedImage = document.querySelector(`.facility-image[data-room="${room}"]`);
        if (selectedImage) {
            selectedImage.classList.add('selected');
        }

        // Set the selected room in the hidden input field
        document.getElementById('selectedRoom').value = room;
    }

    document.getElementById('settle-button').addEventListener('click', settle);

    function settle() {
        var formData = new FormData();

        // Append data from Facilities Reservation module
        formData.append('selectedRoom', document.getElementById('selectedRoom').value);
        formData.append('reservationDate', document.getElementById('reservationDate').value);

        // Append data from Document Management module
        formData.append('attachment', document.getElementById('document-upload').files[0]);

        // Append data from Visitor Management module
        formData.append('visitorName', document.getElementById('visitorName').value);
        formData.append('reasonToVisit', document.getElementById('reasonToVisit').value);
        formData.append('visitorComments', document.getElementById('visitorComments').value);

        // Additional data can be appended here if needed

        // Make an AJAX request to process_settle.php
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    alert(xhr.responseText);
                } else {
                    alert('Error occurred while processing the request.');
                }
            }
        };
        
        // Open the AJAX request and set the method and URL of your PHP script
        xhr.open('POST', 'process_settle.php', true);

        // Send the FormData object
        xhr.send(formData);
        }
        
        function toggleSettleButton() {
            var agreementCheckbox = document.getElementById("legal-agreement");
            var settleButton = document.getElementById("settle-button");

            // Enable the settle button if the agreement checkbox is checked
            settleButton.disabled = !agreementCheckbox.checked;
        }

        // Attach an event listener to the agreement checkbox to toggle the settle button
        document.getElementById("legal-agreement").addEventListener("change", toggleSettleButton);
        
        document.getElementById("legal-agreement").addEventListener("change", function () {
        toggleSettleButton();
        var agreementNote = document.getElementById("agreement-message");
        agreementNote.style.display = "none"; // Hide the note when the agreement is checked
    });

    function toggleUserPane() {
            var userPane = document.getElementById("user-pane");
            userPane.style.display = (userPane.style.display === "block") ? "none" : "block";
        }

        document.addEventListener("click", function (event) {
            var userPane = document.getElementById("user-pane");
            var usernameCircle = document.getElementById("user-circle");

            if (event.target !== usernameCircle && !usernameCircle.contains(event.target) && event.target !== userPane && !userPane.contains(event.target)) {
                userPane.style.display = "none";
            }
        });


        // Call the toggleSettleButton function initially to set the initial state
        toggleSettleButton();
</script>
</body>
</html>
