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
if ($conn->connect_error) { 
    die("Connection failed: " . $conn->connect_error); 
}

// Get the username from the session
$user = $_SESSION['username'];

// Fetch user data from the database
$sql = "SELECT email, notifications_enabled, theme FROM users WHERE username = '$user'";
$result = $conn->query($sql);

// Check if the query was successful
if ($result === false) {
    die("Error executing query: " . $conn->error);
}

// Fetch user data
if ($result->num_rows > 0) {
    $userData = $result->fetch_assoc();
} else {
    die("User not found.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        h1 {
            margin-bottom: 20px;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }

        input[type="checkbox"] {
            margin-bottom: 20px;
        }

        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-bottom: 20px;
            font-size: 16px;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #2980b9;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #3498db;
        }

        @media (max-width: 480px) {
            form {
                padding: 15px;
            }

            button {
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <h1>Settings</h1>
    <form action="update_settings.php" method="post">
        <div>
            <label for="notifications">Email Notifications:</label>
            <input type="checkbox" name="notifications_enabled" id="notifications" <?php echo ($userData['notifications_enabled'] ? 'checked' : ''); ?>>
        </div>

        <div>
            <label for="theme">Theme:</label>
            <select name="theme" id="theme">
                <option value="light" <?php echo ($userData['theme'] === 'light' ? 'selected' : ''); ?>>Light</option>
                <option value="dark" <?php echo ($userData['theme'] === 'dark' ? 'selected' : ''); ?>>Dark</option>
            </select>
        </div>

        <button type="submit">Update Settings</button>
    </form>
</body>
</html>
