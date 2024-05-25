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

// Execute SQL query to get event data
$sql9 = "SELECT eventName, count FROM event";
$result9 = $conn->query($sql9);

if ($result9 === FALSE) {
    die("Query failed: " . $conn->error);
}

$events = [];
while ($row = $result9->fetch_assoc()) {
    $events[] = $row;
}

// Closing database connection
$conn->close();

// Combining charts and events data into a single array
$data = [
    'events' => $events
];
?>
