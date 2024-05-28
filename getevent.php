<?php

$fromYear = '2022-2023';
$fromSemester = 1;
$toYear = '2022-2023';
$toSemester = 1;

$fromYear = isset($_POST['fromYear']) ? $_POST['fromYear'] : '2022-2023';
$fromSemester = isset($_POST['fromSemester']) ? $_POST['fromSemester'] : 1;
$toYear = isset($_POST['toYear']) ? $_POST['toYear'] : '2022-2023';
$toSemester = isset($_POST['toSemester']) ? $_POST['toSemester'] : 1;
 
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
$sql10 = "SELECT event.eventName, event.count 
          FROM event 
          INNER JOIN time_period ON event.timeId = time_period.timeId
          WHERE CAST(SUBSTRING_INDEX(time_period.SchoolYear, '-', 1) AS UNSIGNED) BETWEEN CAST(SUBSTRING_INDEX('$fromYear', '-', 1) AS UNSIGNED) AND CAST(SUBSTRING_INDEX('$toYear', '-', 1) AS UNSIGNED)
          AND time_period.semester BETWEEN $fromSemester AND $toSemester";
$result10 = $conn->query($sql10);

if ($result10 === FALSE) {
    die("Query failed: " . $conn->error);
}

$events = [];
while ($row = $result10->fetch_assoc()) {
    $events[] = $row;
}

// Closing database connection
$conn->close();

// Combining charts and events data into a single array
$data = [
    'events' => $events
];

echo json_encode($data);