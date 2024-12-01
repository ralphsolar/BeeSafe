<?php

header("Content-Type: application/json");

$host = "srv443.hstgr.io";
$username = "u475920781_bee_db";
$password = "bee.4321A";
$dbname = "u475920781_bee_db";

// Create a connection to the database
$conn = new mysqli($host, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    http_response_code(500); // Internal Server Error
    echo json_encode(["error" => "Failed to connect to database: " . $conn->connect_error]);
    exit();
}

// SQL query to fetch historical data
$sql = "SELECT temperature, humidity, weight, timestamp FROM sensor_data ORDER BY timestamp DESC"; // Adjust the LIMIT as needed
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $data = [];

    // Fetch data row by row
    while ($row = $result->fetch_assoc()) {
        $data[] = [
            "temperature" => (float) $row["temperature"],
            "humidity" => (float) $row["humidity"],
            "weight" => (float) $row["weight"],
            "timestamp" => $row["timestamp"]
        ];
    }

    // Return the data as JSON
    echo json_encode($data);
} else {
    http_response_code(404); // Not Found
    echo json_encode(["error" => "No data found"]);
}

// Close the database connection
$conn->close();
?>