<?php
// getHistoricalData/index.php

$servername = "srv443.hstgr.io";
$username = "u475920781_bee_db";
$password = "bee.4321A";
$dbname = "u475920781_bee_db";

// Establish connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$range = $_GET['range'] ?? 'hourly'; // Default to hourly if not provided

// SQL query based on time range
if ($range == 'daily') {
    // Calculate average temperature, humidity, and weight for each day
    $sql = "SELECT 
                DATE(timestamp) AS date, 
                AVG(temperature) AS avg_temp, 
                AVG(humidity) AS avg_humidity, 
                AVG(weight) AS avg_weight
            FROM sensors
            WHERE timestamp >= CURDATE() - INTERVAL 7 DAY
            GROUP BY DATE(timestamp)
            ORDER BY DATE(timestamp) ASC";
} else {
    // Default to hourly averages
    $sql = "SELECT 
                DATE_FORMAT(timestamp, '%Y-%m-%d %H:00:00') AS hour, 
                AVG(temperature) AS avg_temp, 
                AVG(humidity) AS avg_humidity, 
                AVG(weight) AS avg_weight
            FROM sensors
            WHERE timestamp >= NOW() - INTERVAL 7 DAY
            GROUP BY DATE_FORMAT(timestamp, '%Y-%m-%d %H:00:00')
            ORDER BY hour ASC";
}

$result = $conn->query($sql);

$data = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

echo json_encode($data);
$conn->close();
?>
