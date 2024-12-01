<?php
header('Content-Type: application/json');

$servername = "srv443.hstgr.io";
$username = "u475920781_bee_db";
$password = "bee.4321A";
$dbname = "u475920781_bee_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch the latest sensor readings
$sql = "SELECT sensor_id, hive_id, temperature, humidity, weight, timestamp FROM sensors ORDER BY timestamp DESC LIMIT 10";
$result = $conn->query($sql);

// Initialize an array to hold the data
$data = array();
$device_status = "OFF"; // Default device status

if ($result->num_rows > 0) {
    // Loop through the result set and collect sensor data
    while ($row = $result->fetch_assoc()) {
        // Add each row to the data array
        $data[] = $row;
    }

    // Get the timestamp of the most recent reading (first row in the data array)
    $latest_timestamp = strtotime($data[0]['timestamp']); // Convert timestamp to Unix time
    $current_time = time(); // Get the current Unix time

    // Device is ON if the latest data is within the last 10 minutes (600 seconds)
    if ($current_time - $latest_timestamp <= 600) {
        $device_status = "ON";
    } else {
        $device_status = "OFF";
    }
}

// Prepare the response data
$response = array(
    'status' => $device_status, // Include the device status
    'data' => $data // Include the sensor readings
);

// Output the response as JSON
echo json_encode($response);

// Close the database connection
$conn->close();
?>
