<?php

$fromYear = '2022-2023';
$fromSemester = 1;
$toYear = '2022-2023';
$toSemester = 1;

$fromYear = isset($_POST['fromYear']) ? $_POST['fromYear'] : '2022-2023';
$fromSemester = isset($_POST['fromSemester']) ? $_POST['fromSemester'] : 1;
$toYear = isset($_POST['toYear']) ? $_POST['toYear'] : '2022-2023';
$toSemester = isset($_POST['toSemester']) ? $_POST['toSemester'] : 1;

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
function fetchQueryResults($conn, $sql)
{
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
$sql2 = "SELECT deg_prog.name AS degprogName, SUM(college_degree.count) AS totalEnrollees
         FROM college_degree
         JOIN deg_prog ON college_degree.degprogID = deg_prog.degprogID
         WHERE college_degree.timeID IN (
            SELECT timeID
            FROM time_period
            WHERE CAST(SUBSTRING_INDEX(SchoolYear, '-', 1) AS UNSIGNED) BETWEEN CAST(SUBSTRING_INDEX('$fromYear', '-', 1) AS UNSIGNED) AND CAST(SUBSTRING_INDEX('$toYear', '-', 1) AS UNSIGNED)
            AND semester BETWEEN $fromSemester AND $toSemester
         )
         GROUP BY college_degree.degprogID";

$charts['enrolleesCourseChart'] = fetchQueryResults($conn, $sql2);

// Execute SQL query to get data for the total number of enrollees per year and per degree program
$sql3 = "SELECT 
            time_period.SchoolYear,
            time_period.semester,
            deg_prog.degprogID,
            deg_prog.name AS degreeProgram,
            SUM(college_degree.count) AS totalEnrollees
         FROM 
            college_degree
         JOIN 
            deg_prog ON college_degree.degprogID = deg_prog.degprogID
         JOIN 
            time_period ON college_degree.timeID = time_period.timeID
         WHERE 
            college_degree.degprogID IN ('BSCS', 'BSDS', 'BSAM')
            AND time_period.SchoolYear BETWEEN '$fromYear' AND '$toYear'
         GROUP BY 
            time_period.SchoolYear, 
            time_period.semester,
            deg_prog.degprogID,
            deg_prog.name";

$charts['enrolleesYearChart'] = fetchQueryResults($conn, $sql3);

// Execute SQL query to get data for the total no. of students per year level per degree program
$sql4 = "SELECT deg_prog.name AS degprogName, college_degree.yearLevel, SUM(college_degree.count) AS totalStudents
         FROM college_degree
         JOIN deg_prog ON college_degree.degprogID = deg_prog.degprogID
         WHERE college_degree.timeID IN (
            SELECT timeID
            FROM time_period
            WHERE CAST(SUBSTRING_INDEX(SchoolYear, '-', 1) AS UNSIGNED) BETWEEN CAST(SUBSTRING_INDEX('$fromYear', '-', 1) AS UNSIGNED) AND CAST(SUBSTRING_INDEX('$toYear', '-', 1) AS UNSIGNED)
            AND semester BETWEEN $fromSemester AND $toSemester
         )
         GROUP BY deg_prog.name, college_degree.yearLevel";

$charts['studentsPerYear'] = fetchQueryResults($conn, $sql4);

// Execute SQL query to get data for the total number of scholars per semester and degree program
$sql5 = "SELECT time_period.SchoolYear, time_period.semester, award_type.awardType, deg_prog.name AS degreeProgram, SUM(student_awards.count) AS totalScholars, (SELECT SUM(sa.count)
         FROM student_awards sa
         JOIN award_type at ON sa.awardTypeID = at.awardTypeID
         WHERE at.awardTypeID IN ('US', 'CS')) AS grandTotal
         FROM student_awards
         JOIN award_type ON student_awards.awardTypeID = award_type.awardTypeID
         JOIN college_degree ON student_awards.degID = college_degree.degID
         JOIN time_period ON college_degree.timeID = time_period.timeID
         JOIN deg_prog ON college_degree.degprogID = deg_prog.degprogID
         WHERE award_type.awardTypeID IN ('US', 'CS')
         AND CAST(SUBSTRING_INDEX(time_period.SchoolYear, '-', 1) AS UNSIGNED) BETWEEN CAST(SUBSTRING_INDEX('$fromYear', '-', 1) AS UNSIGNED) AND CAST(SUBSTRING_INDEX('$toYear', '-', 1) AS UNSIGNED)
         AND time_period.semester BETWEEN $fromSemester AND $toSemester
         AND deg_prog.degprogID IN ('BSDS', 'BSCS', 'BSAM')
         GROUP BY time_period.SchoolYear, time_period.semester, award_type.awardType, deg_prog.name";

$charts['scholarsChart'] = fetchQueryResults($conn, $sql5);



// Execute SQL query to get data for the ratio of university scholars between degree programs
$sql6 = "SELECT 
            deg_prog.name, 
            time_period.SchoolYear,
            time_period.semester,
            COALESCE(SUM(CASE WHEN award_type.awardType = 'University Scholar' THEN student_awards.count ELSE 0 END), 0) AS UniversityScholars,
            SUM(college_degree.count) AS totalStudents
         FROM 
            college_degree
         JOIN 
            deg_prog ON college_degree.degprogID = deg_prog.degprogID
         LEFT JOIN 
            student_awards ON college_degree.degID = student_awards.degID
         LEFT JOIN 
            award_type ON student_awards.awardTypeID = award_type.awardTypeID AND award_type.awardType = 'University Scholar'
         JOIN
            time_period ON college_degree.timeID = time_period.timeID
         WHERE 
            college_degree.timeID IN (
                SELECT timeID
                FROM time_period
                WHERE CAST(SUBSTRING_INDEX(SchoolYear, '-', 1) AS UNSIGNED) BETWEEN CAST(SUBSTRING_INDEX('$fromYear', '-', 1) AS UNSIGNED) AND CAST(SUBSTRING_INDEX('$toYear', '-', 1) AS UNSIGNED)
                AND semester BETWEEN $fromSemester AND $toSemester
         )
         GROUP BY 
            deg_prog.name
         ORDER BY 
            time_period.SchoolYear ASC, time_period.semester ASC,
            UniversityScholars DESC";

$charts['USperDegProg'] = fetchQueryResults($conn, $sql6);

// Execute SQL query to get data for the ratio of college scholars between degree programs
$sql7 = "SELECT 
            deg_prog.name, 
            time_period.SchoolYear,
            time_period.semester,
            COALESCE(SUM(CASE WHEN award_type.awardType = 'College Scholar' THEN student_awards.count ELSE 0 END), 0) AS CollegeScholars,
            SUM(college_degree.count) AS totalStudents
         FROM 
            college_degree
         JOIN 
            deg_prog ON college_degree.degprogID = deg_prog.degprogID
         LEFT JOIN 
            student_awards ON college_degree.degID = student_awards.degID
         LEFT JOIN 
            award_type ON student_awards.awardTypeID = award_type.awardTypeID AND award_type.awardType = 'College Scholar'
         JOIN
            time_period ON college_degree.timeID = time_period.timeID
         WHERE 
            college_degree.timeID IN (
                SELECT timeID
                FROM time_period
                WHERE CAST(SUBSTRING_INDEX(SchoolYear, '-', 1) AS UNSIGNED) BETWEEN CAST(SUBSTRING_INDEX('$fromYear', '-', 1) AS UNSIGNED) AND CAST(SUBSTRING_INDEX('$toYear', '-', 1) AS UNSIGNED)
                AND semester BETWEEN $fromSemester AND $toSemester
         )
         GROUP BY 
            deg_prog.name
         ORDER BY 
            time_period.SchoolYear ASC,
            time_period.semester ASC,
            CollegeScholars DESC";

$charts['CSperDegProg'] = fetchQueryResults($conn, $sql7);

// Execute SQL query to get data for the total number of students who receive Latin honors along with their degree programs
$sql8 = "SELECT time_period.SchoolYear, time_period.semester, award_type.awardType, deg_prog.name AS degreeProgram, SUM(student_awards.count) AS totalRecipients,(SELECT SUM(sa.count)
            FROM student_awards sa
            JOIN award_type at ON sa.awardTypeID = at.awardTypeID
            WHERE at.awardTypeID IN ('CL', 'MCL', 'SCL')) AS grandTotal
            FROM student_awards
            JOIN award_type ON student_awards.awardTypeID = award_type.awardTypeID
            JOIN college_degree ON student_awards.degID = college_degree.degID
            JOIN time_period ON college_degree.timeID = time_period.timeID
            JOIN deg_prog ON college_degree.degprogID = deg_prog.degprogID
            WHERE award_type.awardTypeID IN ('CL', 'MCL', 'SCL')
            AND CAST(SUBSTRING_INDEX(time_period.SchoolYear, '-', 1) AS UNSIGNED) BETWEEN CAST(SUBSTRING_INDEX('$fromYear', '-', 1) AS UNSIGNED) AND CAST(SUBSTRING_INDEX('$toYear', '-', 1) AS UNSIGNED)
            AND time_period.semester BETWEEN $fromSemester AND $toSemester
            AND deg_prog.degprogID IN ('BSDS', 'BSCS', 'BSAM')
            GROUP BY time_period.SchoolYear, time_period.semester, award_type.awardType, deg_prog.name";

$charts['PopulationLaudes'] = fetchQueryResults($conn, $sql8);


// Execute SQL query to get data for the total number of enrollees per degree program per semester
$sql9 = "SELECT dp.name as DegreeProgram, tp.SchoolYear, tp.semester, SUM(cd.count) as totalEnrollees
         FROM college_degree cd
         JOIN deg_prog dp ON cd.degprogID = dp.degprogID
         JOIN time_period tp ON cd.timeID = tp.timeID
         WHERE CAST(SUBSTRING_INDEX(tp.SchoolYear, '-', 1) AS UNSIGNED) BETWEEN CAST(SUBSTRING_INDEX('$fromYear', '-', 1) AS UNSIGNED) AND CAST(SUBSTRING_INDEX('$toYear', '-', 1) AS UNSIGNED)
         AND tp.semester BETWEEN $fromSemester AND $toSemester
         GROUP BY dp.name, tp.SchoolYear, tp.semester
         ORDER BY tp.SchoolYear, tp.semester, dp.name";

$charts['enrollmentChartData'] = fetchQueryResults($conn, $sql9);

$conn->close();

echo json_encode($charts);
