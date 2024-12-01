<?php 
// Database configuration
$servername = "localhost";
$username = "u475920781_bee_db";
$password = "bee.4321A";
$dbname = "u475920781_bee_db";

// Set the default time zone to your server's time zone
date_default_timezone_set('Asia/Manila'); // Adjust time zone as needed

// Connect to MySQL
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve POST data from the request
$hive_id = isset($_POST['hive_id']) ? intval($_POST['hive_id']) : null;
$ontemp = isset($_POST['ontemp']) ? floatval($_POST['ontemp']) : null;
$offtemp = isset($_POST['offtemp']) ? floatval($_POST['offtemp']) : null;
$date = date("Y-m-d");
$timestamp_on = date('Y-m-d H:i:s');
$timestamp_off = date('Y-m-d H:i:s');

// Ensure required fields are present
if ($hive_id === null || ($ontemp === null && $offtemp === null)) {
    http_response_code(400);
    echo "Error: Missing required parameters";
    exit();
}

if ($ontemp !== null && $offtemp === null) {
    // Fan turned on: insert a new row with ontemp and timestamp_on
    $stmt = $conn->prepare("INSERT INTO fan_status (hive_id, ontemp, timestamp_on, offtemp, timestamp_off, date) VALUES (?, ?, ?, NULL, NULL, ?)");
    $stmt->bind_param("idss", $hive_id, $ontemp, $timestamp_on, $date);
    
    if ($stmt->execute()) {
        echo "Fan turned on, data inserted successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }
} elseif ($offtemp !== null) {
    // Fan turned off: update the latest row for this hive_id where timestamp_off is NULL
    $stmt = $conn->prepare("UPDATE fan_status SET offtemp = ?, timestamp_off = ? WHERE hive_id = ? AND timestamp_off IS NULL ORDER BY timestamp_on DESC LIMIT 1");
    $stmt->bind_param("dsi", $offtemp, $timestamp_off, $hive_id);
    
    if ($stmt->execute()) {
        echo "Fan turned off, offtemp and timestamp_off updated successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }
}

// Close statement and connection
$stmt->close();
$conn->close();
?>
