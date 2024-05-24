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

$charts = [];

// Query to get data for the total no. of enrollees per degree program
$sql1 = "SELECT deg_prog.name AS degprogName, SUM(college_degree.count) AS totalEnrollees
        FROM college_degree
        JOIN deg_prog ON college_degree.degprogID = deg_prog.degprogID
        GROUP BY college_degree.degprogID";

$result1 = $conn->query($sql1);
$enrolleesCourseChart = [];
while($row = $result1->fetch_assoc()) {
    $enrolleesCourseChart[] = $row;
}
$charts['enrolleesCourseChart'] = $enrolleesCourseChart;


// Execute SQL query to get data for the total no. of enrollees per year
$sql2 = "SELECT time_period.SchoolYear, SUM(college_degree.count) AS totalEnrollees
         FROM college_degree
         JOIN time_period ON college_degree.timeID = time_period.timeID
         GROUP BY time_period.SchoolYear";

$result2 = $conn->query($sql2);
$enrolleesYearChart = [];
while ($row = $result2->fetch_assoc()) {
    $enrolleesYearChart[] = $row;
}
$charts['enrolleesYearChart'] = $enrolleesYearChart;


// Execute SQL query to get data for the total no. of students per year level
$sql3 = "SELECT college_degree.yearLevel, SUM(college_degree.count) AS totalStudents
         FROM college_degree
         GROUP BY college_degree.yearLevel";

$result3 = $conn->query($sql3);
$studentsPerYear = [];
while ($row = $result3->fetch_assoc()) {
    $studentsPerYear[] = $row;
}
$charts['studentsPerYear'] = $studentsPerYear;



// Execute SQL query to get data for the total number of scholars per semester
$sql4 = "SELECT time_period.SchoolYear, time_period.semester, award_type.awardType, SUM(student_awards.count) AS totalScholars
         FROM student_awards
         JOIN award_type ON student_awards.awardTypeID = award_type.awardTypeID
         JOIN college_degree ON student_awards.degID = college_degree.degID
         JOIN time_period ON college_degree.timeID = time_period.timeID
         WHERE award_type.awardTypeID IN ('US', 'CS')
         GROUP BY time_period.SchoolYear, time_period.semester, award_type.awardType";

$result4 = $conn->query($sql4);
$scholarsChart = [];
while ($row = $result4->fetch_assoc()) {
    $scholarsChart[] = $row;
}
$charts['scholarsChart'] = $scholarsChart;



// Execute SQL query to get data for the ratio of university scholars between degree programs
$sql5 = "SELECT 
            deg_prog.name, 
            COALESCE(SUM(CASE WHEN award_type.awardType = 'University Scholar' THEN student_awards.count ELSE 0 END), 0) AS UniversityScholars,
            SUM(college_degree.count) AS totalStudents,
            ROUND(COALESCE(SUM(CASE WHEN award_type.awardType = 'University Scholar' THEN student_awards.count ELSE 0 END) * 100.0 / NULLIF(SUM(college_degree.count), 0), 0), 2) AS PercentageUS
         FROM 
            college_degree
         JOIN 
            deg_prog ON college_degree.degprogID = deg_prog.degprogID
         LEFT JOIN 
            student_awards ON college_degree.degID = student_awards.degID
         LEFT JOIN 
            award_type ON student_awards.awardTypeID = award_type.awardTypeID AND award_type.awardType = 'University Scholar'
         GROUP BY 
            deg_prog.name
         ORDER BY 
            PercentageUS DESC";

$result5 = $conn->query($sql5);
$USperDegProg = [];
while ($row = $result5->fetch_assoc()) {
    $USperDegProg[] = $row;
}
$charts['USperDegProg'] = $USperDegProg;


// Execute SQL query to get data for the ratio of college scholars between degree programs
$sql6 = "SELECT 
            deg_prog.name, 
            COALESCE(SUM(CASE WHEN award_type.awardType = 'College Scholar' THEN student_awards.count ELSE 0 END), 0) AS CollegeScholars,
            SUM(college_degree.count) AS totalStudents,
            ROUND(COALESCE(SUM(CASE WHEN award_type.awardType = 'College Scholar' THEN student_awards.count ELSE 0 END) * 100.0 / NULLIF(SUM(college_degree.count), 0), 0), 2) AS PercentageCS
         FROM 
            college_degree
         JOIN 
            deg_prog ON college_degree.degprogID = deg_prog.degprogID
         LEFT JOIN 
            student_awards ON college_degree.degID = student_awards.degID
         LEFT JOIN 
            award_type ON student_awards.awardTypeID = award_type.awardTypeID AND award_type.awardType = 'College Scholar'
         GROUP BY 
            deg_prog.name
         ORDER BY 
            PercentageCS DESC";

$result6 = $conn->query($sql6);
$CSperDegProg = [];
while ($row = $result6->fetch_assoc()) {
    $CSperDegProg[] = $row;
}
$charts['CSperDegProg'] = $CSperDegProg;


// Execute SQL query to get data for the total number of students who receive Latin honors
$sql7 = "SELECT award_type.awardType, SUM(student_awards.count) AS totalRecipients
         FROM student_awards
         JOIN award_type ON student_awards.awardTypeID = award_type.awardTypeID
         WHERE award_type.awardTypeID IN ('SCL', 'MCL', 'CL')
         GROUP BY student_awards.awardTypeID";

$result7 = $conn->query($sql7);
$PopulationLaudes = [];
while ($row = $result7->fetch_assoc()) {
    $PopulationLaudes[] = $row;
}
$charts['PopulationLaudes'] = $PopulationLaudes;



// Execute SQL query to get event data
$sql9 = "SELECT eventName, count FROM event";
$result9 = $conn->query($sql9);

// Define the labels for the table headers
$labels = ["Event Name", "Participation Count"];

// Display the table headers
echo '<table class="table"><tr>';
for ($i = 0; $i < count($labels); $i++) {
    echo '<th>' . $labels[$i] . '</th>';
}
echo '</tr>';

// Display the table rows
if ($result9->num_rows > 0) {
    while ($row = $result9->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . $row["eventName"] . '</td>';
        echo '<td>' . $row["count"] . '</td>';
        echo '</tr>';
    }
} else {
    echo '<tr><td colspan="2">No events found</td></tr>';
}

echo '</table>';



$conn->close();

echo json_encode($charts);
?>
