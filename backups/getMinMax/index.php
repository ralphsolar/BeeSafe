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
$sql = "
SELECT 
    (SELECT temperature FROM sensors ORDER BY temperature ASC LIMIT 1) AS min_temperature,
    (SELECT temperature FROM sensors ORDER BY temperature DESC LIMIT 1) AS max_temperature,
    (SELECT timestamp FROM sensors ORDER BY temperature ASC LIMIT 1) AS min_temp_timestamp,
    (SELECT timestamp FROM sensors ORDER BY temperature DESC LIMIT 1) AS max_temp_timestamp,

    (SELECT humidity FROM sensors ORDER BY humidity ASC LIMIT 1) AS min_humidity,
    (SELECT humidity FROM sensors ORDER BY humidity DESC LIMIT 1) AS max_humidity,
    (SELECT timestamp FROM sensors ORDER BY humidity ASC LIMIT 1) AS min_humidity_timestamp,
    (SELECT timestamp FROM sensors ORDER BY humidity DESC LIMIT 1) AS max_humidity_timestamp,

    (SELECT weight FROM sensors ORDER BY weight ASC LIMIT 1) AS min_weight,
    (SELECT weight FROM sensors ORDER BY weight DESC LIMIT 1) AS max_weight,
    (SELECT timestamp FROM sensors ORDER BY weight ASC LIMIT 1) AS min_weight_timestamp,
    (SELECT timestamp FROM sensors ORDER BY weight DESC LIMIT 1) AS max_weight_timestamp
";

$result = $conn->query($sql);
$data = array();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $data = [
        'min_temp' => $row['min_temperature'],
        'max_temp' => $row['max_temperature'],
        'min_temp_timestamp' => $row['min_temp_timestamp'],
        'max_temp_timestamp' => $row['max_temp_timestamp'],
        
        'min_humidity' => $row['min_humidity'],
        'max_humidity' => $row['max_humidity'],
        'min_humidity_timestamp' => $row['min_humidity_timestamp'],
        'max_humidity_timestamp' => $row['max_humidity_timestamp'],
        
        'min_weight' => $row['min_weight'],
        'max_weight' => $row['max_weight'],
        'min_weight_timestamp' => $row['min_weight_timestamp'],
        'max_weight_timestamp' => $row['max_weight_timestamp']
    ];
}

$conn->close();

echo json_encode($data);
?>
