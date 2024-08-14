<?php 
session_start();

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
if ($conn->connect_error) { 
    die("Connection failed: " . $conn->connect_error); 
} 

$sql = "SELECT * FROM files"; 
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>freestorage</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="container">
        <nav class="navbar">
            <h2>File Management</h2>
            <div class="nav-links">
                <a href="profile.php"><i class="fas fa-user"></i> Profile</a>
                <a href="settings.php"><i class="fas fa-cog"></i> Settings</a>
                <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
            <button onclick="toggleDarkMode()">Toggle Dark Mode</button>
        </nav>
        <main class="main-content">
            <div class="file-actions">
                <form action="upload.php" method="post" enctype="multipart/form-data">
                    <input type="file" name="fileToUpload" id="fileToUpload">
                    <button type="submit" name="submit">Upload</button>
                </form>
            </div>

            <div class="file-list">
                <h3>Your Files</h3>
                <ul>
                    <?php if ($result->num_rows > 0) : ?>
                    <?php while($row = $result->fetch_assoc()) : ?>
                    <li>
                        <span><?php echo htmlspecialchars($row['filename']); ?></span>
                        <?php
                                    // Assuming your files are stored in a folder named 'uploads'
                                    $filePath = 'uploads/' . $row['filename'];
                                    // Check if the file is an image
                                    $imageFileType = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
                                    if (in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
                                        echo '<img src="' . $filePath . '" alt="' . htmlspecialchars($row['filename']) . '" style="max-width: 100px; max-height: 100px; margin-left: 10px;">';
                                    }
                                ?>
                            <a href="download.php?id=<?php echo $row['id']; ?>">Download</a>
                            <a href="update.php?id=<?php echo $row['id']; ?>">Update</a>
                            <a href="delete.php?id=<?php echo $row['id']; ?>">Delete</a>
                    </li>
                    <?php endwhile; ?>
                    <?php else : ?>
                    <li>No files found.</li>
                    <?php endif; ?>
                </ul>
            </div>
        </main>
    </div>
    <script src="script.js"></script>
</body>

</html>
<?php $conn->close(); ?>