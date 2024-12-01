<?php
// API endpoint to fetch sensor data for a specific date
if (isset($_GET['date'])) {
    $selectedDate = $_GET['date']; // Get the selected date (e.g., '2024-11-13')
    
    // Connect to the database
    $conn = new mysqli("localhost", "u475920781_bee_db", "bee.4321A", "u475920781_bee_db");
    
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    // Prepare the query to fetch sensor data for the selected date
    $query = "SELECT timestamp, temperature, humidity, weight 
              FROM sensors 
              WHERE DATE(timestamp) = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $selectedDate);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Check if records are found
    if ($result->num_rows > 0) {
        $records = [];
        while ($row = $result->fetch_assoc()) {
            $records[] = $row;
        }
        echo json_encode(['records' => $records]);
    } else {
        echo json_encode(['records' => []]);
    }

    // Close the database connection
    $conn->close();
}
?>
