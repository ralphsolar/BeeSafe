<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");   
    exit();
}

$username = $_SESSION['username'];
$user_id = $_SESSION['user_id']; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>BeeSafe!</title>
  <!-- AdminLTE CSS via CDN -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
  <!-- Font Awesome for Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <!-- Chart.js via CDN -->                        
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <!-- Include Font Awesome icons -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

  <!-- jQuery via CDN -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- AdminLTE JS via CDN -->
  <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
  <!-- Moment.js for Date Formatting (optional but useful) -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
</head>
<style>

h5 {
    font-size: 1.5rem; 
    color: #333;
    margin-bottom: 15px; 
    text-align: center; 
    font-weight: bold; 
}
#alert-section {
    margin-bottom: 20px;
    padding: 20px;
    border: 2px solid #f5c6cb; 
    border-radius: 8px; 
    background-color: #f9f9f9; 
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2); 
}
.alert {
    display: flex; 
    align-items: center;
    padding: 20px;
    margin-bottom: 15px;
    border: 2px solid #d9534f; 
    background-color: #f8d7da;
    color: #721c24;
    border-radius: 10px;
    font-weight: bold;
    font-size: 1.1rem;
    text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.2); 
    animation: blink-red 1s infinite, shake 1s ease-in-out;
    box-shadow: 0 0 15px rgba(255, 99, 71, 0.8);
    transition: transform 0.3s ease-in-out;
}

.alert i {
    margin-right: 15px; 
    font-size: 1.5rem; 
    color: #d9534f; 
}

@keyframes blink-red {
    0%, 100% {
        background-color: #f8d7da;
    }
    50% {
        background-color: #f5c6cb;
    }
}
@keyframes shake {
    0% { transform: translateX(0); }
    25% { transform: translateX(-15px); }
    50% { transform: translateX(15px); }
    75% { transform: translateX(-15px); }
    100% { transform: translateX(0); }
}

.alert:hover {
    transform: scale(1.05); 
    box-shadow: 0 0 25px rgba(255, 99, 71, 1); 
}




  </style>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">BeeSafe!</a>
      </li>
    </ul>
    <ul class="navbar-nav ml-auto">
    </li>
<li class="nav-item">
    <a class="nav-link" href="#" role="button" id="userNameDisplay">
        <i class="fas fa-user"></i> 
        <span id="currentUserName">Username: <?php echo htmlspecialchars($username); ?></span> |
        <span id="currentUserId">User ID: <?php echo htmlspecialchars($user_id); ?></span>
    </a>
</li>
      <li class="nav-item">
        <a class="nav-link" href="#" role="button">
          <i class="fas fa-clock"></i> <span id="currentDateTime">Loading...</span>
        </a>
      </li>
<li class="nav-item">
    <a class="nav-link" href="logout.php" role="button">
        <i class="fas fa-sign-out-alt"></i> Logout
    </a>
</li>

    </ul>
  </nav>
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="#" class="brand-link">
      <img src="media/BEE-LOGO.png" alt="BeeSafe Logo" style="width: 50px; margin-right: 10px;">
      <span class="brand-text font-weight-light">Hive Dashboard</span>
    </a>
    <div class="sidebar">
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
          <li class="nav-item">
            <a href="dashboard.php" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="analytics.php" class="nav-link active">
            <i class="nav-icon fas fa-chart-line"></i>
            <p>
              Analytics
          </p>
          </a>
          </li>
        </ul>
      </nav>
    </div>
  </aside>

    <div class="content-wrapper">
        <section class="content-header">
        <h1><i class="fas fa-chart-line"></i>   Analytics History</h1>
        </section>

<div id="min-max-summary" class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-thermometer-half"></i> Temperature</h3>
                </div>
                <div class="card-body">
                    <p><strong>Min Temp:</strong> <span id="min-temp"></span> °C at <span id="min-temp-timestamp"></span></p>
                    <p><strong>Max Temp:</strong> <span id="max-temp"></span> °C at <span id="max-temp-timestamp"></span></p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-tint"></i> Humidity</h3>
                </div>
                <div class="card-body">
                    <p><strong>Min Humidity:</strong> <span id="min-humidity"></span>% at <span id="min-humidity-timestamp"></span></p>
                    <p><strong>Max Humidity:</strong> <span id="max-humidity"></span>% at <span id="max-humidity-timestamp"></span></p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-weight"></i> Weight</h3>
                </div>
                <div class="card-body">
                    <p><strong>Min Weight:</strong> <span id="min-weight"></span> kg at <span id="min-weight-timestamp"></span></p>
                    <p><strong>Max Weight:</strong> <span id="max-weight"></span> kg at <span id="max-weight-timestamp"></span></p>
                </div>
            </div>
        </div>
    </div>
</div>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                 
                        <div class="card">
                            <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-database"></i> Latest Sensor Data Overview</h3>
                            </div>
                            <div class="card-body">
                                <canvas id="sensor-overview-chart"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                    
                        <div class="card">
                            <div class="card-header">
                            <h3 class="card-title">
                            <i class="fas fa-thermometer-half"></i><i class="fas fa-tint"></i>
                                Temperature vs Humidity 
                            </h3>
                            </div>
                            <div class="card-body">
                                <canvas id="temp-humidity-chart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-history"></i>  Historical Sensor Data (Average)</h3>
                        <div class="form-group float-right">
                            <label for="timeRange">Select Time Range: </label>
                            <select id="timeRange" onchange="fetchHistoricalData()">
                                <option value="daily">Daily</option>
                                <option value="monthly">Monthly</option>
                                <option value="annual">Annual</option>
                            </select>
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="historical-line-chart"></canvas>
                    </div>
                </div>
                <div class="card mt-4">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-chart-bar"></i> Bar Graph Sensor Data (Average)</h3>
                    </div>
                    <div class="card-body">
                        <canvas id="historical-bar-chart"></canvas>
                    </div>
                </div>

                 

            </div>
        </section>
    </div>
</div>

<script>
$(document).ready(function () {
    $('[data-widget="pushmenu"]').PushMenu();
});

// script for date and time
function updateCurrentDateTime() {
    const now = new Date();
    const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' };
    document.getElementById('currentDateTime').textContent = now.toLocaleDateString('en-US', options);
}
setInterval(updateCurrentDateTime, 1000);
updateCurrentDateTime();

// script for date and time
function updateCurrentDateTime() {
    const now = new Date();
    const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' };
    document.getElementById('currentDateTime').textContent = now.toLocaleDateString('en-US', options);
}
setInterval(updateCurrentDateTime, 1000);
updateCurrentDateTime();

// script for line chart and bar chart
let lineChart, barChart;

function fetchHistoricalData() {
    const timeRange = document.getElementById('timeRange').value;

    fetch(`trendData/historicalData.php?range=${timeRange}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Failed to fetch data: ' + response.statusText);
            }
            return response.json();
        })
        .then(data => {
            if (!data || !data.temperature || !data.humidity || !data.weight) {
                throw new Error('Invalid data format received');
            }

            let labels = [];
            let temperatureData = [];
            let humidityData = [];
            let weightData = [];

            if (timeRange === 'daily') {
                // Create labels starting from the current day
                const daysOfWeek = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
                const currentDayIndex = new Date().getDay();
                labels = [...daysOfWeek.slice(currentDayIndex), ...daysOfWeek.slice(0, currentDayIndex)];
                
                // Map the data to the corresponding days
                temperatureData = new Array(7).fill(null);
                humidityData = new Array(7).fill(null);
                weightData = new Array(7).fill(null);

                data.labels.forEach((timestamp, index) => {
                    const dayIndex = new Date(timestamp).getDay();
                    const adjustedIndex = (dayIndex - currentDayIndex + 7) % 7; // Ensure labels wrap correctly
                    temperatureData[adjustedIndex] = data.temperature[index];
                    humidityData[adjustedIndex] = data.humidity[index];
                    weightData[adjustedIndex] = data.weight[index];
                });
            } else if (timeRange === 'monthly') {
                labels = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                temperatureData = new Array(12).fill(null);
                humidityData = new Array(12).fill(null);
                weightData = new Array(12).fill(null);

                data.labels.forEach((month) => {
                    const [year, monthNumber] = month.split('-');
                    const monthIndex = parseInt(monthNumber, 10) - 1;

                    temperatureData[monthIndex] = data.temperature[data.labels.indexOf(month)];
                    humidityData[monthIndex] = data.humidity[data.labels.indexOf(month)];
                    weightData[monthIndex] = data.weight[data.labels.indexOf(month)];
                });
            } else if (timeRange === 'annual') {
                const startYear = data.labels[0];
                const currentYear = new Date().getFullYear();
                labels = [];
                for (let year = startYear; year <= currentYear; year++) {
                    labels.push(year.toString());
                }
                temperatureData = data.temperature;
                humidityData = data.humidity;
                weightData = data.weight;
            }

            if (lineChart) {
                lineChart.destroy();
            }
            if (barChart) {
                barChart.destroy();
            }

            lineChart = new Chart(document.getElementById('historical-line-chart').getContext('2d'), {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [
                        { label: 'Temperature (°C)', data: temperatureData, borderColor: 'red', fill: false },
                        { label: 'Humidity (%)', data: humidityData, borderColor: 'blue', fill: false },
                        { label: 'Weight (kg)', data: weightData, borderColor: 'green', fill: false }
                    ]
                },
                options: {
                    responsive: true,
                    scales: {
                        x: { display: true, title: { display: true, text: 'Time' } },
                        y: { display: true, title: { display: true, text: 'Value' } }
                    }
                }
            });

            barChart = new Chart(document.getElementById('historical-bar-chart').getContext('2d'), {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [
                        { label: 'Temperature (°C)', data: temperatureData, backgroundColor: 'rgba(255, 99, 132, 0.5)', borderColor: 'red', borderWidth: 1 },
                        { label: 'Humidity (%)', data: humidityData, backgroundColor: 'rgba(54, 162, 235, 0.5)', borderColor: 'blue', borderWidth: 1 },
                        { label: 'Weight (kg)', data: weightData, backgroundColor: 'rgba(75, 192, 192, 0.5)', borderColor: 'green', borderWidth: 1 }
                    ]
                },
                options: {
                    responsive: true,
                    scales: {
                        x: { display: true, title: { display: true, text: 'Time' } },
                        y: { display: true, title: { display: true, text: 'Value' } }
                    }
                }
            });
        })
        .catch(error => {
            console.error('Error fetching historical data:', error);
            alert('An error occurred while fetching the data. Please try again later.');
        });
}

document.addEventListener('DOMContentLoaded', fetchHistoricalData);




// script for latest sensor readings , temp vs humid graphs and pie chart
function fetchSensorData() {
    fetch('getData/index.php')  
    .then(response => response.json())
    .then(data => {
        if (data && data.length > 0) {
            const labels = data.map(item => new Date(item.timestamp).toLocaleString());
            const temperatureData = data.map(item => item.temperature);
            const humidityData = data.map(item => item.humidity);
            const weightData = data.map(item => item.weight);

            new Chart(document.getElementById('sensor-overview-chart').getContext('2d'), {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [
                        { label: 'Temperature (°C)', data: temperatureData, borderColor: 'red', fill: false },
                        { label: 'Humidity (%)', data: humidityData, borderColor: 'blue', fill: false },
                        { label: 'Weight (kg)', data: weightData, borderColor: 'green', fill: false }
                    ]
                },
                options: {
                    responsive: true,
                    scales: {
                        x: { display: true, title: { display: true, text: 'Timestamp' } },
                        y: { display: true, title: { display: true, text: 'Sensor Value' } }
                    }
                }
            });

            new Chart(document.getElementById('temp-humidity-chart').getContext('2d'), {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [
                        { label: 'Temperature (°C)', data: temperatureData, backgroundColor: 'red' },
                        { label: 'Humidity (%)', data: humidityData, backgroundColor: 'blue' }
                    ]
                },
                options: {
                    responsive: true,
                    scales: {
                        x: { display: true, title: { display: true, text: 'Timestamp' } },
                        y: { display: true, title: { display: true, text: 'Sensor Value' } }
                    }
                }
            });

            

        } else {
            console.error('No data found or data format issue');
        }
    })
    .catch(error => {
        console.error('Error fetching data:', error);
        alert('Error fetching sensor data');
    });
}
document.addEventListener('DOMContentLoaded', fetchSensorData);


// script for minmax data visualizations
$(document).ready(function() {
    $.ajax({
        url: 'getMinMax/index.php', 
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            $('#min-temp').text(data.min_temp);
            $('#max-temp').text(data.max_temp);
            $('#min-temp-timestamp').text(data.min_temp_timestamp);
            $('#max-temp-timestamp').text(data.max_temp_timestamp);

            $('#min-humidity').text(data.min_humidity);
            $('#max-humidity').text(data.max_humidity);
            $('#min-humidity-timestamp').text(data.min_humidity_timestamp);
            $('#max-humidity-timestamp').text(data.max_humidity_timestamp);

            $('#min-weight').text(data.min_weight);
            $('#max-weight').text(data.max_weight);
            $('#min-weight-timestamp').text(data.min_weight_timestamp);
            $('#max-weight-timestamp').text(data.max_weight_timestamp);
        },
        error: function(xhr, status, error) {
            console.log("Error: " + error);
        }
    });
});


</script>




</body>
</html>
