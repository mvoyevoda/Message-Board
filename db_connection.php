<?php

$servername = "localhost"; 
$username = "voyevoda";
$password = "maxim2722";
$dbname = "voyevoda_";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>
