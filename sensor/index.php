<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");
date_default_timezone_set('Asia/Manila');

// Database credentials
$servername = "localhost";
$username = "u475920781_bee_db";
$password = "bee.4321A";
$dbname = "u475920781_bee_db";

// Retrieve data from the POST request
$hive_id = isset($_POST['hive_id']) ? $_POST['hive_id'] : null;
$temperature = isset($_POST['temperature']) ? $_POST['temperature'] : null;
$humidity = isset($_POST['humidity']) ? $_POST['humidity'] : null;
$weight = isset($_POST['weight']) ? $_POST['weight'] : null;

// Validate required fields
if (is_null($hive_id) || is_null($temperature) || is_null($humidity) || is_null($weight)) {
    echo "Error: Missing required fields.";
    exit;
}

// Get the current timestamp
$current_timestamp = date("Y-m-d H:i:s"); // Format: YYYY-MM-DD HH:MM:SS

try {
    // Create a new PDO instance
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if the hive_id exists in the hive table
    $stmt = $conn->prepare("SELECT COUNT(*) FROM hive WHERE hive_id = :hive_id");
    $stmt->execute(['hive_id' => $hive_id]);
    $hive_exists = $stmt->fetchColumn();

    if ($hive_exists) {
        // Prepare and execute the SQL statement to insert the data
        $stmt = $conn->prepare("INSERT INTO sensors (hive_id, temperature, humidity, weight, timestamp) 
                                VALUES (:hive_id, :temperature, :humidity, :weight, :timestamp)");
        $stmt->execute([
            'hive_id' => $hive_id,
            'temperature' => $temperature,
            'humidity' => $humidity,
            'weight' => $weight,
            'timestamp' => $current_timestamp
        ]);

        // Return a success message
        echo "New record created successfully";
    } else {
        // Return an error message if hive_id does not exist
        echo "Error: Hive ID does not exist.";
    }
} catch (PDOException $e) {
    // Log the error and return an error message
    error_log("Database Error: " . $e->getMessage(), 3, "/var/log/php_errors.log");
    echo "An error occurred: " . $e->getMessage();
}

// Close the database connection
$conn = null;
?>
