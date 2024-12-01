<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Get user ID from session
$user_id = $_SESSION['user_id'];

// Database connection
$conn = new mysqli("localhost", "u475920781_bee_db", "bee.4321A", "u475920781_bee_db");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch historical analytics data
$sql = "SELECT timestamp, temperature, humidity, weight, windspeed FROM sensor_data WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Analytics History</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
    <div class="content-wrapper">
        <section class="content-header">
            <h1>Analytics History</h1>
        </section>
        <section class="content">
            <div class="container-fluid">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Timestamp</th>
                            <th>Temperature (°C)</th>
                            <th>Humidity (%)</th>
                            <th>Weight (kg)</th>
                            <th>Wind Speed (km/h)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data as $row): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['timestamp']); ?></td>
                                <td><?php echo htmlspecialchars($row['temperature']); ?></td>
                                <td><?php echo htmlspecialchars($row['humidity']); ?></td>
                                <td><?php echo htmlspecialchars($row['weight']); ?></td>
                                <td><?php echo htmlspecialchars($row['windspeed']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</div>
</body>
</html>
