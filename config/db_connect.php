<?php
$servername = "localhost";
$dbusername = "u475920781_bee_db";
$dbpassword = "bee.4321A";
$dbname = "u475920781_bee_db";

// Create connection
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
