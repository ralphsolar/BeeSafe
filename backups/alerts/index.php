<?php
header('Content-Type: application/json');

// Database connection
$host = 'localhost';
$dbname = 'u475920781_bee_db';
$username = 'u475920781_bee_db';
$password = 'bee.4321A';

try {
    // Create a PDO instance (connect to the database)
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch the latest sensor readings (temperature, humidity, weight) from the sensor_readings table
    $stmt = $pdo->prepare("SELECT temperature, humidity, weight, timestamp 
                           FROM sensors
                           ORDER BY timestamp DESC 
                           LIMIT 1");
    $stmt->execute();
    
    // Fetch the result
    $sensorData = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if data exists
    if ($sensorData) {
        // Return the data as a JSON response
        echo json_encode([
            'status' => 'success',
            'data' => $sensorData
        ]);
    } else {
        // If no sensor data found
        echo json_encode([
            'status' => 'error',
            'message' => 'No sensor data found.'
        ]);
    }

} catch (PDOException $e) {
    // Handle any errors from the database
    echo json_encode([
        'status' => 'error',
        'message' => 'Database error: ' . $e->getMessage()
    ]);
} finally {
    // Close the connection by setting PDO to null
    $pdo = null;
}
?>
