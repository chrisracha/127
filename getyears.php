<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dmpcs_dashboard";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Execute SQL query to get years data
$sql10 = "SELECT SchoolYear FROM time_period";
$result10 = $conn->query($sql10);

if ($resultq0 === FALSE) {
    die("Query failed: " . $conn->error);
}

$years = [];
while ($row = $result10->fetch_assoc()) {
    $years[] = $row;
}

// Closing database connection
$conn->close();

// Combining charts and years data into a single array
$yrdata = [
    'years' => $years
];