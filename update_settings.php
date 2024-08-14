<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "file_manage";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) { 
    die("Connection failed: " . $conn->connect_error); 
}

$user = $_SESSION['username'];
$notificationsEnabled = isset($_POST['notifications_enabled']) ? 1 : 0; // 1 for enabled, 0 for disabled
$theme = $_POST['theme']; // You might want to validate this input

$sql = "UPDATE users SET notifications_enabled='$notificationsEnabled', theme='$theme' WHERE username='$user'";
if ($conn->query($sql) === TRUE) {
    echo "Settings updated successfully.";
    header("Location: dashboard.php");
} else {
    echo "Error updating settings: " . $conn->error;
}

$conn->close();
?>
