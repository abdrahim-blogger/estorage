<?php
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

// Include the database connection
include 'db_connect.php';

// Get the current username from the session
$username = $_SESSION['username'];

// Get the form data
$email = isset($_POST['email']) ? $conn->real_escape_string($_POST['email']) : '';
$password = isset($_POST['password']) ? $conn->real_escape_string($_POST['password']) : '';

if (!empty($password)) {
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $sql = "UPDATE users SET email='$email', password='$hashedPassword' WHERE username='$username'";
} else {
    $sql = "UPDATE users SET email='$email' WHERE username='$username'";
}


// Execute the query
if ($conn->query($sql) === TRUE) {
    echo "Profile updated successfully!";
    header("Location: profile.php");
} else {
    echo "Error updating profile: " . $conn->error;
}

// Close the database connection
$conn->close();
?>
