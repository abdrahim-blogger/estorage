<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

// Database connection
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "file_manage";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// File upload handling
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if a file is uploaded
    if (isset($_FILES['fileToUpload']) && $_FILES['fileToUpload']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['fileToUpload']['tmp_name'];
        $fileName = $_FILES['fileToUpload']['name'];
        $filePath = 'uploads/' . $fileName; // Make sure the 'uploads' folder exists and is writable

        // Move the file to the uploads directory
        if (move_uploaded_file($fileTmpPath, $filePath)) {
            // Insert file info into the database
            $sql = "INSERT INTO files (filename) VALUES ('$fileName')";
            if ($conn->query($sql) === TRUE) {
                echo "File uploaded successfully!";
                header("Location: dashboard.php");
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "There was an error moving the uploaded file.";
        }
    } else {
        echo "No file uploaded or there was an upload error.";
    }
}

// Close the database connection
$conn->close();
?>
