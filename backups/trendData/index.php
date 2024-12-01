<?php
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

// Determine the mode from the query parameter (default to trend)
$mode = isset($_GET['mode']) ? $_GET['mode'] : 'trend';

$sensor_data = [];

// Fetch data based on the selected mode
if ($mode === 'trend') {
    $query = "
        SELECT 
            DATE(timestamp) AS date, 
            WEEKDAY(timestamp) AS weekday,  
            AVG(temperature) AS avg_temp, 
            AVG(humidity) AS avg_humidity, 
            AVG(weight) AS avg_weight
        FROM sensors 
        GROUP BY date 
        ORDER BY timestamp DESC
    ";
    $result = $conn->query($query);

    $sensor_data = [
        'days' => ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
        'temperature' => array_fill(0, 7, null),
        'humidity' => array_fill(0, 7, null),
        'weight' => array_fill(0, 7, null),
    ];

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $weekday_index = $row['weekday'];
            $sensor_data['temperature'][$weekday_index] = $row['avg_temp'];
            $sensor_data['humidity'][$weekday_index] = $row['avg_humidity'];
            $sensor_data['weight'][$weekday_index] = $row['avg_weight'];
        }
    } else {
        echo json_encode(['error' => 'No data available']);
        exit;
    }
} elseif ($mode === 'daily') {
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
} elseif ($mode === 'monthly') {
    $query = "
        SELECT 
            DATE_FORMAT(timestamp, '%Y-%m') AS month, 
            AVG(temperature) AS avg_temp
        FROM sensors 
        WHERE timestamp >= DATE_SUB(CURDATE(), INTERVAL 1 YEAR)
        GROUP BY month
        ORDER BY month DESC
    ";
    $result = $conn->query($query);

    $sensor_data = [
        'labels' => [],
        'temperature' => []
    ];

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $sensor_data['labels'][] = $row['month'];
            $sensor_data['temperature'][] = $row['avg_temp'];
        }
    }
} elseif ($mode === 'yearly') {
    $query = "
        SELECT 
            YEAR(timestamp) AS year, 
            AVG(temperature) AS avg_temp
        FROM sensors 
        WHERE timestamp >= DATE_SUB(CURDATE(), INTERVAL 5 YEAR)
        GROUP BY year
        ORDER BY year DESC
    ";
    $result = $conn->query($query);

    $sensor_data = [
        'labels' => [],
        'temperature' => []
    ];

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $sensor_data['labels'][] = $row['year'];
            $sensor_data['temperature'][] = $row['avg_temp'];
        }
    }
} else {
    echo json_encode(['error' => 'Invalid mode specified']);
    exit;
}

// Return the data in JSON format
echo json_encode($sensor_data);

$conn->close();
?>
