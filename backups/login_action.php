<?php
session_start();

// Replace these values with your database credentials
$servername = "localhost";
$dbusername = "u475920781_bee_db";
$dbpassword = "bee.4321A";
$dbname = "u475920781_bee_db";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // Check the database for user
    $sql = "SELECT * FROM users WHERE username = '$user' AND password = '$pass'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $_SESSION['username'] = $user;
        header("Location: dashboard.php");
    } else {
        echo "Invalid credentials. <a href='login.php'>Try again</a>";
    }
}

$conn->close();
?>
