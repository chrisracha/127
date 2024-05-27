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

// Fetch data for academic years
$sql = "SELECT SchoolYear FROM time_period";
$result = $conn->query($sql);
$academic_years = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $academic_years[] = $row['SchoolYear'];
    }
}

// Fetch data for semesters
$sql = "SELECT DISTINCT Semester FROM time_period";
$result = $conn->query($sql);
$semesters = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $semesters[] = $row['Semester'];
    }
}

// Fetch data for degree programs
$sql = "SELECT degprogID FROM deg_prog";
$result = $conn->query($sql);
$degree_programs = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $degree_programs[] = $row['degprogID'];
    }
}

// Fetch data for award types
$sql = "SELECT awardType FROM award_type";
$result = $conn->query($sql);
$awardtypes = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $awardtypes[] = $row['awardType'];
    }
}


// Fetch data for ranks
$sql = "SELECT rankID, title FROM rank_title";
$result = $conn->query($sql);
$ranks = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $rank_title[$row['rankID']] = $row['title'];
    }
}

// Fetch data for educational attainments
$sql = "SELECT educAttainmentID, attainment FROM educ_attainment";
$result = $conn->query($sql);
$educational_attainments = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $educ_attainment[$row['educAttainmentID']] = $row['attainment'];
    }
}

// Close connection
$conn->close();
?>