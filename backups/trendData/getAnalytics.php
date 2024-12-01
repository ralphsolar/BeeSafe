<?php
// Database credentials
$servername = "localhost";  // Your database server
$username = "u475920781_bee_db";         // Your database username
$password = "bee.4321A";             // Your database password
$dbname = "u475920781_bee_db"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to fetch analytics data based on time range
function fetchAnalyticsData($timeRange) {
    global $conn;

    // Define the query based on the time range
    if ($timeRange == 'daily') {
        $sql = "SELECT DATE(timestamp) AS date, AVG(temperature) AS avg_temp, AVG(humidity) AS avg_hum, AVG(weight) AS avg_weight 
                FROM sensors GROUP BY DATE(timestamp)";
    } elseif ($timeRange == 'monthly') {
        $sql = "SELECT MONTH(timestamp) AS month, AVG(temperature) AS avg_temp, AVG(humidity) AS avg_hum, AVG(weight) AS avg_weight 
                FROM sensors GROUP BY MONTH(timestamp)";
    } else { // 'annual'
        $sql = "SELECT YEAR(timestamp) AS year, AVG(temperature) AS avg_temp, AVG(humidity) AS avg_hum, AVG(weight) AS avg_weight 
                FROM sensors GROUP BY YEAR(timestamp)";
    }

    // Prepare statement
    if ($stmt = $conn->prepare($sql)) {
        $stmt->execute();
        $result = $stmt->get_result();

        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        $stmt->close();
        return $data;
    }
    return [];
}

// Get the time range from the query parameters
$timeRange = isset($_GET['range']) ? $_GET['range'] : 'daily';

// Fetch the analytics data
$analyticsData = fetchAnalyticsData($timeRange);

// Return the data as a JSON response
header('Content-Type: application/json');
echo json_encode($analyticsData);

// Close the connection
$conn->close();
?>
