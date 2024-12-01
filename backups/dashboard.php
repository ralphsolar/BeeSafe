<?php
session_start(); 
if (!isset($_SESSION['username'])) {
    header("Location: admin_login.php");   
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
.info-box-icon {
    width: 300px;  
    height: 100px; 
    display: flex;
    justify-content: center;
    align-items: center;
  }
  #fan-image {
    max-width: 70px;  
    max-height:70px; 
    object-fit: contain; 
  }
@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
#fan-image.on {
  animation: spin 1s linear infinite;
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
            <a href="#dashboard" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="analytics.php" class="nav-link">
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
    <div class="container-fluid d-flex align-items-center">
    <img src="media/bee_logo.png" alt="Logo" style="width: 100px; margin-right: 10px;">
    <h1>BeeSafe Hive Health Monitoring Dashboard</h1>
    </section>
    <h5> <i class="fas fa-bell"></i> Alerts & Notifications</h5>
    <div id="alert-section">
    <!-- Alerts will be dynamically inserted here -->
</div>

<div class="row">
  <div class="col-md-12 col-sm-12 col-12">
    <div class="info-box bg-info">
      <!-- Weather Icon Placeholder -->
      <span class="info-box-icon" id="weatherIcon">
        <i class="fas fa-cloud-sun"></i> 
      </span>

      <div class="info-box-content">
        <span class="info-box-text">Current Weather</span>
        <span class="info-box-number" id="weatherTemp">Loading...</span>
        <div class="progress">
          <div class="progress-bar" style="width: 100%"></div>
        </div>
        <span class="progress-description" id="weatherDesc">
          Weather description
        </span>
        <small id="weatherLocation"></small>
  </div>
</div>
<!-- Fan Status Box -->
<div class="info-box">
  <span class="info-box-icon bg-info">
    <img id="fan-image" src="media/fan_icon_img.png" alt="Fan Status" />
  </span>
  <div class="info-box-content">
    <span class="info-box-text">Fan Status in the Hive:</span>
    <span id="fan-timestamp" class="info-box-number">Loading...</span>
  </div>
</div>

<div class="card card-info mt-3">
  <div class="card-header">
    <h3 class="card-title"><i class="fas fa-hive"></i> Hive Information</h3>
  </div>
  <div class="card-body">
    <p><i class="fas fa-id-badge"></i> <strong>     Hive ID:</strong> 21</p>
    <p><i class="fas fa-cogs"></i> <strong>         Hive Name:</strong> NARTDI - DMMMSU NLUC Bacnotan</p>
    <p><i class="fas fa-map-marker-alt"></i> <strong>       Location:</strong> Sapilang, Bacnotan, La Union</p>
  </div>
</div>

    <section class="content">
      <div class="container-fluid">
         <h4>Latest Sensor Readings</h4>
        <div class="row">
          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
              <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-temperature-high"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Temperature</span>
                <span class="info-box-number" id="latestTemperature">
                  Loading...
                </span>
                <small id="temperatureTimestamp"></small>
              </div>
            </div>
          </div>
          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-water"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Humidity</span>
                <span class="info-box-number" id="latestHumidity">
                  Loading...
                </span>
                <small id="humidityTimestamp"></small>
              </div>
            </div>
          </div>
          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-weight-hanging"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Weight</span>
                <span class="info-box-number" id="latestWeight">
                  Loading...
                </span>
                <small id="weightTimestamp"></small>
              </div>
            </div>
          </div>
          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-wind"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Wind Speed</span>
                <span class="info-box-number" id="latestWindSpeed">
                  Loading...
                </span>
                <small id="windSpeedTimestamp"></small>
              </div>
            </div>
          </div>
        </div>
        
        <h4>Real-time Update of Sensors (Updates Every 10 Seconds)</h4>
<div class="row">
    <!-- Temperature Chart -->
    <div class="col-md-6">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Temperature Readings (°C)</h3>
            </div>
            <div class="card-body">
                <canvas id="temperatureChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Humidity Chart -->
    <div class="col-md-6">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Humidity Readings (%)</h3>
            </div>
            <div class="card-body">
                <canvas id="humidityChart"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Weight Chart -->
    <div class="col-md-6">
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title">Weight Readings (kg)</h3>
            </div>
            <div class="card-body">
                <canvas id="weightChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Wind Speed Chart (New) -->
    <div class="col-md-6">
        <div class="card card-success">
            <div class="card-header">
                <h3 class="card-title">Wind Speed Readings (m/s)</h3>
            </div>
            <div class="card-body">
            <canvas id="windChart"></canvas>
            </div>
        </div>
    </div>
</div>

          
        </div>    
      </div> 
    </section>
    <section class="content">
    <div class="container-fluid">
        <!-- Card for the historical data section -->
        <div class="card card-primary">
            <div class="card-header">
                <h4 class="card-title">Real-time Update of Sensors (Updates per Hour and Day in AVERAGE)</h4>
            </div>
            <div class="card-body">
                <!-- Form group for the dropdown menu -->
                <div class="form-group">
                    <label for="timeRange" class="font-weight-bold">Select Time Range:</label>
                    <select id="timeRange" class="form-control form-control-lg">
                        <option value="hourly">Per Hour</option>
                        <option value="daily">Per Day</option>
                    </select>
                </div>

                <!-- Section for displaying charts -->
                <div class="row">
                    <!-- Temperature Chart -->
                    <div class="col-md-12">
                        <div class="card card-info mb-4">
                            <div class="card-header">
                                <h5 class="card-title">Temperature (°C)</h5>
                            </div>
                            <div class="card-body">
                                <canvas id="historicalTempChart" style="width: 100%; height: 400px;"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- Humidity Chart -->
                    <div class="col-md-12">
                        <div class="card card-success mb-4">
                            <div class="card-header">
                                <h5 class="card-title">Humidity (%)</h5>
                            </div>
                            <div class="card-body">
                                <canvas id="historicalHumidityChart" style="width: 100%; height: 400px;"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- Weight Chart -->
                    <div class="col-md-12">
                        <div class="card card-warning mb-4">
                            <div class="card-header">
                                <h5 class="card-title">Weight (kg)</h5>
                            </div>
                            <div class="card-body">
                                <canvas id="historicalWeightChart" style="width: 100%; height: 400px;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>




  </div>

  <footer class="main-footer">
    <strong>&copy; 2024 <a href="#">BeeSafe</a>.</strong>
    All rights reserved.
  </footer>

</div>
<script>
  //script for windspeed api display current windspeed data
  async function fetchWindSpeed() {
    const apiKey = "84d8772aa18f5929db6a902f9ff858ad";
    const lat = 16.7340; 
    const lon = 120.3666; 
    const url = `https://api.openweathermap.org/data/2.5/weather?lat=${lat}&lon=${lon}&appid=${apiKey}&units=metric`;

    try {
      const response = await fetch(url);
      const data = await response.json();
      if (response.ok) {
        const windSpeed = data.wind.speed; 
        const timestamp = new Date(data.dt * 1000).toLocaleString();

        document.getElementById("latestWindSpeed").textContent = `${windSpeed} m/s`;
        document.getElementById("windSpeedTimestamp").textContent = `Last updated: ${timestamp}`;
      } else {
        document.getElementById("latestWindSpeed").textContent = "Error fetching data";
      }
    } catch (error) {
      console.error("Error fetching wind speed:", error);
      document.getElementById("latestWindSpeed").textContent = "Error";
    }
  }
  document.addEventListener("DOMContentLoaded", fetchWindSpeed);


  // script for getting sensors data thru api
   $(document).ready(function() {
    function fetchSensorData() {
      $.ajax({
        url: 'getData/index.php',
        method: 'GET',
        success: function(response) {
          let temperatureData = [];
          let humidityData = [];
          let weightData = [];
          let timestamps = [];

          response.forEach(entry => {
            timestamps.push(entry.timestamp);
            temperatureData.push(entry.temperature);
            humidityData.push(entry.humidity);
            weightData.push(entry.weight);
          });

          timestamps.reverse();
          temperatureData.reverse();
          humidityData.reverse();
          weightData.reverse();

          updateChart(temperatureChart, timestamps, temperatureData);
          updateChart(humidityChart, timestamps, humidityData);
          updateBarChart(weightChart, timestamps, weightData);

          $('#latestTemperature').text(temperatureData[0] + " °C");
          $('#temperatureTimestamp').text("Last updated: " + timestamps[0]);

          $('#latestHumidity').text(humidityData[0] + " %");
          $('#humidityTimestamp').text("Last updated: " + timestamps[0]);

          $('#latestWeight').text(weightData[0] + " kg");
          $('#weightTimestamp').text("Last updated: " + timestamps[0]);
        }
      });
    }

    const temperatureChart = new Chart(document.getElementById('temperatureChart').getContext('2d'), getLineChartConfigTemp('Temperature (°C)'));
    const humidityChart = new Chart(document.getElementById('humidityChart').getContext('2d'), getLineChartConfigHumid('Humidity (%)'));
    const weightChart = new Chart(document.getElementById('weightChart').getContext('2d'), getLineChartConfigWeight('Weight (kg)'));

    function getLineChartConfigTemp(label) {
      return {
        type: 'line',
        data: {
          labels: [], 
          datasets: [{
            label: label,
            data: [], 
            backgroundColor: 'rgba(0, 123, 255, 0.3)',
            borderColor: 'rgba(0, 123, 255, 1)',
            borderWidth: 1,
            fill: true
          }]
        },
        options: {
          responsive: true,
          scales: {
            x: { display: true },
            y: { beginAtZero: true }
          }
        }
      };
    }
    function getLineChartConfigHumid(label) {
      return {
        type: 'line',
        data: {
          labels: [], 
          datasets: [{
            label: label,
            data: [], 
            backgroundColor: 'rgba(0, 255, 255, 0.3)', 
            borderColor: 'rgba(0, 255, 255, 1)', 
            borderWidth: 1,
            fill: true
          }]
        },
        options: {
          responsive: true,
          scales: {
            x: { display: true },
            y: { beginAtZero: true }
          }
        }
      };
    }

    function getLineChartConfigWeight(label) {
      return {
        type: 'line',
        data: {
          labels: [],
          datasets: [{
            label: label,
            data: [], 
            backgroundColor: 'rgba(255, 165, 0, 0.5)', 
            borderColor: 'rgba(255, 140, 0, 1)', 
            borderWidth: 1
          }]
        },
        options: {
          responsive: true,
          scales: {
            x: { display: true },
            y: { beginAtZero: true }
          }
        }
      };
    }

    function updateChart(chart, labels, data) {
      chart.data.labels = labels;
      chart.data.datasets[0].data = data;
      chart.update();
    }

    function updateBarChart(chart, labels, data) {
      chart.data.labels = labels;
      chart.data.datasets[0].data = data;
      chart.update();
    }
    fetchSensorData();
    setInterval(fetchSensorData, 10000);
  });

// acript for weather thru openweather api
  $(document).ready(function() {
  const API_KEY = '84d8772aa18f5929db6a902f9ff858ad';  
  const LATITUDE = 16.7340;  
  const LONGITUDE = 120.3666;  

  const iconMapping = {
    'Clear': 'fas fa-sun',         
    'Clouds': 'fas fa-cloud',       
    'Rain': 'fas fa-cloud-showers-heavy', 
    'Snow': 'fas fa-snowflake',      
    'Drizzle': 'fas fa-cloud-rain', 
    'Thunderstorm': 'fas fa-bolt',   
    'Mist': 'fas fa-smog',        
    'Smoke': 'fas fa-smog',
    'Haze': 'fas fa-smog',
    'Dust': 'fas fa-smog',
    'Fog': 'fas fa-smog',
    'Sand': 'fas fa-smog',
    'Ash': 'fas fa-smog',
    'Squall': 'fas fa-wind',
    'Tornado': 'fas fa-wind'
  };

  // Function to fetch current weather data
  function fetchCurrentWeather() {
    const weatherAPI = `https://api.openweathermap.org/data/2.5/weather?lat=${LATITUDE}&lon=${LONGITUDE}&appid=${API_KEY}&units=metric`;

    $.get(weatherAPI, function(response) {
      const temp = response.main.temp;
      const description = response.weather[0].description;
      const location = response.name;
      const weatherMain = response.weather[0].main;  

      $('#weatherTemp').text(`${temp}°C`);
      $('#weatherDesc').text(description.charAt(0).toUpperCase() + description.slice(1));
      $('#weatherLocation').text(location);

      const iconClass = iconMapping[weatherMain] || 'fas fa-cloud-sun'; 
      $('#weatherIcon').html(`<i class="${iconClass}"></i>`);
    }).fail(function() {
      $('#weatherTemp').text('Failed to load weather');
    });
  }
  fetchCurrentWeather();
});

function updateDateTime() {
    const dateTimeElement = document.getElementById("currentDateTime");
    const now = new Date();
    const monthNames = [
      "January", "February", "March", "April", "May", "June",
      "July", "August", "September", "October", "November", "December"
    ];
    const day = now.getDate();
    const month = monthNames[now.getMonth()];
    const year = now.getFullYear();
    const formattedDate = `${month} ${day}, ${year}`;

    let hours = now.getHours();
    const minutes = String(now.getMinutes()).padStart(2, "0");
    const seconds = String(now.getSeconds()).padStart(2, "0");

    const ampm = hours >= 12 ? "PM" : "AM";
    hours = hours % 12; 
    hours = hours ? hours : 12; 
    const formattedTime = `${String(hours).padStart(2, "0")}:${minutes}:${seconds} ${ampm}`;
    dateTimeElement.textContent = `${formattedDate} | ${formattedTime}`;
  }
  setInterval(updateDateTime, 1000);
  updateDateTime();

// script for fan status 
function updateFanStatus() {
  fetch('getFan/index.php')
    .then(response => response.json())
    .then(data => {
      const fanImage = document.getElementById('fan-image');
      const fanTimestamp = document.getElementById('fan-timestamp');
      
      if (data.timestamp_off === null || new Date(data.timestamp_on) > new Date(data.timestamp_off)) {
        fanImage.classList.add('on');  
        fanTimestamp.textContent = `Fan is ON at ${data.timestamp_on}`;
      } else {
        fanImage.classList.remove('on');  
        fanTimestamp.textContent = `Fan is OFF at ${data.timestamp_off}`;
      }
    })
    .catch(error => {
      console.error('Error fetching fan status:', error);
      document.getElementById('fan-timestamp').textContent = "Error fetching fan status.";
    });
}
updateFanStatus();
setInterval(updateFanStatus, 1000);



// script for alert system and notifs
function fetchSensorReadings() {
    fetch('alerts/index.php')
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                const sensor = data.data;
                const { temperature, humidity, weight, timestamp } = sensor;

                let alerts = '';
                let alertTriggered = false;  
                if (temperature > 35) {
                    alerts += `<div class="alert"> <i class="fas fa-temperature-high"></i> Temperature in hive exceeded 35°C at ${timestamp}!</div>`;
                    alertTriggered = true;
                }
                if (humidity > 90) {
                    alerts += `<div class="alert"><i class="fas fa-tint"></i> Humidity in hive reaches above 90% at ${timestamp}!</div>`;
                    alertTriggered = true;
                }
                if (weight > 30) {
                    alerts += `<div class="alert"> <i class="fas fa-weight-hanging"></i> Weight of the hive exceeded 30 kg at ${timestamp}!</div>`;
                    alertTriggered = true;
                }
                if (alertTriggered) {
                    setTimeout(() => {
                        const audio = new Audio('alert.wav'); 
                        audio.play()
                            .then(() => console.log('Alert sound played successfully'))
                            .catch(error => console.error('Error playing alert sound:', error));
                    }, 500); 
                }
                document.getElementById('alert-section').innerHTML = alerts || '<div>No alerts at this time.</div>';

            } else {
                console.log(data.message);
            }
        })
        .catch(error => {
            console.error('Error fetching sensor readings:', error);
        });
}
setInterval(fetchSensorReadings, 5000); 


function generateAlert(message, timestamp, type) {
    const alertSection = document.getElementById('alert-section');

    const alertDiv = document.createElement('div');
    alertDiv.classList.add('alert');

    const icon = document.createElement('i');
    
    if (type === 'temperature') {
        icon.classList.add('fas', 'fa-temperature-high'); 
    } else if (type === 'humidity') {
        icon.classList.add('fas', 'fa-tint'); 
    } else if (type === 'weight') {
        icon.classList.add('fas', 'fa-weight'); 
    }
    alertDiv.appendChild(icon);
    alertDiv.innerHTML += `${message} <small>(${timestamp})</small>`;
    alertSection.appendChild(alertDiv);
}

//script for real time update (hour and day)
const historicalTempCtx = document.getElementById('historicalTempChart').getContext('2d');
const historicalHumidityCtx = document.getElementById('historicalHumidityChart').getContext('2d');
const historicalWeightCtx = document.getElementById('historicalWeightChart').getContext('2d');

let tempChart, humidityChart, weightChart;

function updateHistoricalCharts(timeRange) {
    fetch(`getHistoricalData/index.php?range=${timeRange}`)
        .then(response => response.json())
        .then(data => {
            const tempData = data.map(item => item.avg_temp);
            const humidityData = data.map(item => item.avg_humidity);
            const weightData = data.map(item => item.avg_weight);
            const labels = data.map(item => new Date(item.hour || item.date).toLocaleString());

            if (tempChart) tempChart.destroy();
            if (humidityChart) humidityChart.destroy();
            if (weightChart) weightChart.destroy();

            tempChart = renderChart(historicalTempCtx, `Temperature (${timeRange})`, labels, tempData, 'rgba(54, 162, 235, 1)');
            humidityChart = renderChart(historicalHumidityCtx, `Humidity (${timeRange})`, labels, humidityData, 'rgba(173, 216, 230, 1)');
            weightChart = renderChart(historicalWeightCtx, `Weight (${timeRange})`, labels, weightData, 'rgba(255, 159, 64, 1)');
        })
        .catch(error => console.error('Error fetching data:', error));
}

function renderChart(ctx, label, labels, data, borderColor) {
    return new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: label,
                data: data,
                fill: false,
                borderColor: borderColor,
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Time'
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: label
                    },
                    beginAtZero: true
                }
            }
        }
    });
}

document.getElementById('timeRange').addEventListener('change', function () {
    const timeRange = this.value;
    updateHistoricalCharts(timeRange);
});
updateHistoricalCharts('hourly');




// script for windchart
const windChartCtx = document.getElementById('windChart').getContext('2d');
if (!window.windChartData) {
    window.windChartData = {
        labels: [], 
        data: [] 
    };
}
 
function fetchWindData() {
  const API_KEY = '84d8772aa18f5929db6a902f9ff858ad';  
  const LATITUDE = 16.7340;  
  const LONGITUDE = 120.3666; 
    const url = `https://api.openweathermap.org/data/2.5/weather?lat=${LATITUDE}&lon=${LONGITUDE}&appid=${API_KEY}&units=metric`;

    fetch(url)
        .then(response => response.json())
        .then(data => {
            const windSpeed = data.wind.speed; 
            const timestamp = new Date().toLocaleTimeString(); 
            updateWindChart(timestamp, windSpeed); 
        })
        .catch(error => console.error('Error fetching wind data:', error));
}
function updateWindChart(timestamp, windSpeed) {
    window.windChartData.labels.push(timestamp);
    window.windChartData.data.push(windSpeed);

    if (window.windChartData.labels.length > 10) {
        window.windChartData.labels.shift(); 
        window.windChartData.data.shift();  
    }

    renderWindChart();
}

function renderWindChart() {
    if (window.windChart && window.windChart.destroy) {
        window.windChart.destroy(); 
    }
    window.windChart = new Chart(windChartCtx, {
        type: 'line', 
        data: {
            labels: window.windChartData.labels,
            datasets: [{
                label: 'Wind Speed (m/s)', 
                data: window.windChartData.data, 
                backgroundColor: 'rgba(75, 192, 192, 0.2)', 
                borderColor: 'rgba(75, 192, 192, 1)', 
                borderWidth: 1,
                fill: true
            }]
        },
        options: {
            responsive: true,
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Time' 
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'Wind Speed (m/s)'
                    },
                    beginAtZero: true 
                }
            }
        }
    });
}
setInterval(fetchWindData, 10000);
fetchWindData();



</script>

</body>
</html> 