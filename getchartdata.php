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

// Helper function to execute a query and fetch all results
function fetchQueryResults($conn, $sql) {
    $result = $conn->query($sql);
    if ($result === FALSE) {
        die("Query failed: " . $conn->error);
    }
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    return $data;
}

// Query to get data for the total no. of enrollees per degree program
$sql1 = "SELECT deg_prog.name AS degprogName, SUM(college_degree.count) AS totalEnrollees
         FROM college_degree
         JOIN deg_prog ON college_degree.degprogID = deg_prog.degprogID
         GROUP BY college_degree.degprogID";

$charts['enrolleesCourseChart'] = fetchQueryResults($conn, $sql1);

// Execute SQL query to get data for the total no. of enrollees per year
$sql2 = "SELECT time_period.SchoolYear, SUM(college_degree.count) AS totalEnrollees
         FROM college_degree
         JOIN time_period ON college_degree.timeID = time_period.timeID
         GROUP BY time_period.SchoolYear";

$charts['enrolleesYearChart'] = fetchQueryResults($conn, $sql2);

// Execute SQL query to get data for the total no. of students per year level per degree program
$sql3 = "SELECT deg_prog.name AS degprogName, college_degree.yearLevel, SUM(college_degree.count) AS totalStudents
         FROM college_degree
         JOIN deg_prog ON college_degree.degprogID = deg_prog.degprogID
         GROUP BY deg_prog.name, college_degree.yearLevel";

$charts['studentsPerYear'] = fetchQueryResults($conn, $sql3);

// Execute SQL query to get data for the total number of scholars per semester
$sql4 = "SELECT time_period.SchoolYear, time_period.semester, award_type.awardType, SUM(student_awards.count) AS totalScholars
         FROM student_awards
         JOIN award_type ON student_awards.awardTypeID = award_type.awardTypeID
         JOIN college_degree ON student_awards.degID = college_degree.degID
         JOIN time_period ON college_degree.timeID = time_period.timeID
         WHERE award_type.awardTypeID IN ('US', 'CS')
         GROUP BY time_period.SchoolYear, time_period.semester, award_type.awardType";

$charts['scholarsChart'] = fetchQueryResults($conn, $sql4);

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

$charts['USperDegProg'] = fetchQueryResults($conn, $sql5);

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

$charts['CSperDegProg'] = fetchQueryResults($conn, $sql6);

// Execute SQL query to get data for the total number of students who receive Latin honors
$sql7 = "SELECT time_period.SchoolYear, award_type.awardType, SUM(student_awards.count) AS totalRecipients
         FROM student_awards
         JOIN award_type ON student_awards.awardTypeID = award_type.awardTypeID
         JOIN college_degree ON student_awards.degID = college_degree.degID
         JOIN time_period ON college_degree.timeID = time_period.timeID
         WHERE award_type.awardTypeID IN ('SCL', 'MCL', 'CL')
         GROUP BY time_period.SchoolYear, award_type.awardType";

$charts['PopulationLaudes'] = fetchQueryResults($conn, $sql7);


// Execute SQL query to get data for the total number of enrollees per degree program per semester
$sql8 = "SELECT dp.name as DegreeProgram, tp.SchoolYear, tp.semester, SUM(cd.count) as totalEnrollees
         FROM college_degree cd
         JOIN deg_prog dp ON cd.degprogID = dp.degprogID
         JOIN time_period tp ON cd.timeID = tp.timeID
         GROUP BY dp.name, tp.SchoolYear, tp.semester
         ORDER BY tp.SchoolYear, tp.semester, dp.name";

$charts['enrollmentData'] = fetchQueryResults($conn, $sql8);

$conn->close();

echo json_encode($charts);
?>
