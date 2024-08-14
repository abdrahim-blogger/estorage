<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "file_manage";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_GET['id'];
$sql = "SELECT * FROM files WHERE id=$id";
$result = $conn->query($sql);
$file = $result->fetch_assoc();

$file_path = $file['filepath'];

if (unlink($file_path)) {
    $sql = "DELETE FROM files WHERE id=$id";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: dashboard.php");
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    echo "Error deleting file.";
}

$conn->close();
?>
