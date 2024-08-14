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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $filename = $_POST['filename'];

    $sql = "UPDATE files SET filename='$filename' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        header("Location: dashboard.php");
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    $sql = "SELECT * FROM files WHERE id=$id";
    $result = $conn->query($sql);
    $file = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update File</title>
</head>
<body>
    <form action="update.php?id=<?php echo $id; ?>" method="post">
        <label for="filename">Filename:</label>
        <input type="text" name="filename" value="<?php echo $file['filename']; ?>" required>
        <button type="submit">Update</button>
    </form>
</body>
</html>

<?php
$conn->close();
?>
