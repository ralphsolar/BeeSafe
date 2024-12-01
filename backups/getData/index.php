<?php
header('Content-Type: application/json');

$servername = "srv443.hstgr.io";
$username = "u475920781_bee_db";
$password = "bee.4321A";
$dbname = "u475920781_bee_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT sensor_id, hive_id, temperature, humidity, weight, timestamp FROM sensors ORDER BY timestamp DESC LIMIT 10";
$result = $conn->query($sql);

$data = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

echo json_encode($data);
$conn->close();
?>
