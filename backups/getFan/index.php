
<?php
// fan_status.php - API endpoint to fetch the most recent fan status

// Database connection (adjust to your environment)
$mysqli = new mysqli("localhost", "u475920781_bee_db", "bee.4321A", "u475920781_bee_db");

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Query to fetch the most recent fan status
$sql = "SELECT * FROM fan_status ORDER BY date DESC, timestamp_on DESC LIMIT 1";
$result = $mysqli->query($sql);

$response = [];

if ($result->num_rows > 0) {
    // Fetch the most recent record
    $row = $result->fetch_assoc();
    $response = $row;
} else {
    $response = ['status' => 'no_data'];
}

echo json_encode($response);

// Close connection
$mysqli->close();
?>
