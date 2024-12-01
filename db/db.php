<?php
    $servername = "localhost";
    $username = "u475920781_bee_db";
    $password = "bee.4321A";
    $databasename = "u475920781_bee_db";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $databasename);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }