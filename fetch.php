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

// Fetch data for yearLevel
$sql = "SELECT DISTINCT yearLevel FROM college_degree";
$result = $conn->query($sql);
$yrLevel = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $yrLevel[] = $row['yearLevel'];
    }
}

// Fetch data for degree programs, school year, and year level
$sql = "SELECT cd.yearLevel, cd.degprogID, tp.SchoolYear, tp.semester
        FROM college_degree cd
        JOIN time_period tp ON cd.timeID = tp.timeID";
$result = $conn->query($sql);

// Array to hold the degree programs data
$degree_programs = [];

// Check if there are any rows returned
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Format the value as 'yearLevel, degprogID, SchoolYear, semester'
        $value = "{$row['yearLevel']}, {$row['degprogID']}, {$row['SchoolYear']}, {$row['semester']}";
        // Create a display name
        $name = "{$row['yearLevel']} {$row['degprogID']} {$row['SchoolYear']} {$row['semester']}";
        // Save it in the array with the formatted string as the key and display name as the value
        $degree_programs[$value] = $name;
    }
}


// Fetch data for degree programs
$sql = "SELECT degprogID FROM deg_prog";
$result = $conn->query($sql);
$degree_prog = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $degree_prog[] = $row['degprogID'];
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
$sql = "SELECT title FROM rank_title";
$result = $conn->query($sql);
$ranks = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $ranks[] = $row['title'];
    }
}

// Fetch data for educational attainments
$sql = "SELECT attainment FROM educ_attainment";
$result = $conn->query($sql);
$educational_attainments = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $educational_attainments[] = $row['attainment'];
    }
}

// Fetch for existing academic year and semester
$sql = "SELECT SchoolYear, semester FROM time_period";
$result = $conn->query($sql);

$time_period_info = []; // Array to hold the time period data

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Format the value as 'SchoolYear, semester'
        $time_period_op = "{$row['SchoolYear']}, {$row['semester']}";
        // Save it in the array
        $time_period_info[] = $time_period_op;
    }
}

// Fetch existing degree programs
$sql = "SELECT degprogID FROM deg_prog";
$result = $conn->query($sql);

$deg_programs = []; // Array to hold the degree program IDs

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Simply save the degprogID in the array
        $deg_programs[] = $row['degprogID'];
    }
}

// Fetch data for existing achievements
$sql = "SELECT at.awardType, cd.yearLevel, cd.degprogID, tp.SchoolYear, tp.semester
        FROM student_awards sa
        JOIN award_type at ON sa.awardTypeID = at.awardTypeID
        JOIN college_degree cd ON sa.degID = cd.degID
        JOIN time_period tp ON cd.timeID = tp.timeID";
$result = $conn->query($sql);

// Array to hold the achievements data
$achievements = [];

// Check if there are any rows returned
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Format the value as 'awardType, yearLevel, degprogID, SchoolYear, semester'
        $achieve_op = "{$row['awardType']}, {$row['yearLevel']}, {$row['degprogID']}, {$row['SchoolYear']}, {$row['semester']}";
        // Save it in the array
        $achievements[] = $achieve_op;
    }
}


// Fetch data for existing degree program information
$sql = "SELECT cd.yearLevel, cd.degprogID, tp.SchoolYear, tp.semester
        FROM college_degree cd
        JOIN time_period tp ON cd.timeID = tp.timeID";
$result = $conn->query($sql);

$degree_exist = []; // Array to hold the detailed degree program data

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Format the value as 'yearLevel, degprogID, SchoolYear, semester'
        $degree_info = "{$row['yearLevel']}, {$row['degprogID']}, {$row['SchoolYear']}, {$row['semester']}";
        // Save it in the array
        $degree_exist[] = $degree_info;
    }
}

// Fetch existing events
$sql = "SELECT eventName FROM event";
$result = $conn->query($sql);

$event_name = []; // Array to hold the event names

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Simply save the eventName in the array
        $event_name[] = $row['eventName'];
    }
}

// Fetch existing publications
$sql = "SELECT title FROM publication";
$result = $conn->query($sql);

$pub_title = []; // Array to hold the publication titles

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Simply save the title in the array
        
        $pub_title[] = $row['title'];
    }
}
// Fetch the existing faculty information
$sql = "SELECT rt.title, ea.attainment, tp.SchoolYear, tp.semester
        FROM faculty f
        JOIN rank_title rt ON f.rankID = rt.rankID
        JOIN educ_attainment ea ON f.educAttainmentID = ea.educAttainmentID
        JOIN time_period tp ON f.timeID = tp.timeID";
$result = $conn->query($sql);

// Array to hold the faculty data
$faculty_info = [];

// Check if there are any rows returned
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Format the value as 'title, attainment, SchoolYear, semester'
        $faculty_op = "{$row['title']}, {$row['attainment']}, {$row['SchoolYear']}, {$row['semester']}";
        // Save it in the array
        $faculty_info[] = $faculty_op;
    }
}
// Close connection
$conn->close();
?>
