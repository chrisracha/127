<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

function getDatabaseConnection($servername, $username, $password, $dbname) {
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}

function getYearsData($conn) {
    $sql = "SELECT DISTINCT SchoolYear FROM time_period";
    $result = $conn->query($sql);
    if ($result === FALSE) {
        die("Query failed: " . $conn->error);
    } else if ($result->num_rows === 0) {
        die("No data found");
    }
    $years = [];
    while ($row = $result->fetch_assoc()) {
        $years[] = $row;
    }
    return $years;
}

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dmpcs_dashboard";

$conn = getDatabaseConnection($servername, $username, $password, $dbname);
$years = getYearsData($conn);
$conn->close();

$data = [
    'years' => $years
];
