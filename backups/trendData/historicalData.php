<?php
// Start the session to check user authentication
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Database credentials
$servername = "localhost";
$dbusername = "u475920781_bee_db";
$dbpassword = "bee.4321A";
$dbname = "u475920781_bee_db";

// Set headers to handle JSON response
header("Content-Type: application/json");

// Create database connection
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['error' => 'Database connection failed: ' . $conn->connect_error]));
}

// Get the selected time range from query parameters
$range = isset($_GET['range']) ? $_GET['range'] : 'daily';

$sensor_data = [];

// Retrieve data based on the time range
if ($range === 'daily') {
    $query = "
        SELECT 
            DATE(timestamp) AS date, 
            AVG(temperature) AS avg_temp, 
            AVG(humidity) AS avg_humidity, 
            AVG(weight) AS avg_weight
        FROM sensors
        WHERE timestamp >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
        GROUP BY date
        ORDER BY date DESC
    ";
    $result = $conn->query($query);

    $sensor_data = [
        'labels' => [],
        'temperature' => [],
        'humidity' => [],
        'weight' => []
    ];

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $sensor_data['labels'][] = $row['date'];
            $sensor_data['temperature'][] = $row['avg_temp'];
            $sensor_data['humidity'][] = $row['avg_humidity'];
            $sensor_data['weight'][] = $row['avg_weight'];
        }
    }
} elseif ($range === 'monthly') {
    $query = "
        SELECT 
            DATE_FORMAT(timestamp, '%Y-%m') AS month, 
            AVG(temperature) AS avg_temp, 
            AVG(humidity) AS avg_humidity, 
            AVG(weight) AS avg_weight
        FROM sensors
        WHERE timestamp >= DATE_SUB(CURDATE(), INTERVAL 1 YEAR)
        GROUP BY month
        ORDER BY month DESC
    ";
    $result = $conn->query($query);

    $sensor_data = [
        'labels' => [],
        'temperature' => [],
        'humidity' => [],
        'weight' => []
    ];

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $sensor_data['labels'][] = $row['month'];
            $sensor_data['temperature'][] = $row['avg_temp'];
            $sensor_data['humidity'][] = $row['avg_humidity'];
            $sensor_data['weight'][] = $row['avg_weight'];
        }
    }
} elseif ($range === 'annual') {
    $query = "
        SELECT 
            YEAR(timestamp) AS year, 
            AVG(temperature) AS avg_temp, 
            AVG(humidity) AS avg_humidity, 
            AVG(weight) AS avg_weight
        FROM sensors
        WHERE timestamp >= DATE_SUB(CURDATE(), INTERVAL 5 YEAR)
        GROUP BY year
        ORDER BY year DESC
    ";
    $result = $conn->query($query);

    $sensor_data = [
        'labels' => [],
        'temperature' => [],
        'humidity' => [],
        'weight' => []
    ];

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $sensor_data['labels'][] = $row['year'];
            $sensor_data['temperature'][] = $row['avg_temp'];
            $sensor_data['humidity'][] = $row['avg_humidity'];
            $sensor_data['weight'][] = $row['avg_weight'];
        }
    }
} else {
    echo json_encode(['error' => 'Invalid time range specified']);
    exit;
}

// Return the data in JSON format
echo json_encode($sensor_data);

// Close the database connection
$conn->close();
?>
