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

// Execute SQL query to retrieve the ratio of faculty by rank
$sql1 = "SELECT 
         rank_title.title AS facultyRank, 
         SUM(COALESCE(faculty.count, 0)) AS rankCount,
         ROUND((SUM(COALESCE(faculty.count, 0)) * 100.0 / COALESCE((SELECT SUM(COALESCE(count, 0)) FROM faculty), 1)), 2) AS Percentage
      FROM 
         faculty
      JOIN 
         rank_title ON faculty.rankID = rank_title.rankID
      GROUP BY 
         rank_title.title
      ORDER BY 
         Percentage DESC";

$charts['ratioByRank'] = fetchQueryResults($conn, $sql1);

// Execute SQL query to retrieve the ratio of faculty by educational attainment
$sql2 = "SELECT 
         educ_attainment.attainment AS educationalAttainment,
         SUM(COALESCE(faculty.count, 0)) AS facultyCount,
         ROUND((SUM(COALESCE(faculty.count, 0)) * 100.0 / COALESCE((SELECT SUM(COALESCE(count, 0)) FROM faculty), 1)), 2) AS Percentage
      FROM 
         faculty
      JOIN 
         educ_attainment ON faculty.educAttainmentID = educ_attainment.educAttainmentID
      GROUP BY 
         educ_attainment.attainment
      ORDER BY 
         Percentage DESC";

$charts['ratioByEduc'] = fetchQueryResults($conn, $sql2);

// Execute SQL query to retrieve the total number of faculty per semester
$sql3 = "SELECT 
         time_period.SchoolYear,
         time_period.semester,
         SUM(faculty.count) AS totalFaculty
      FROM 
         faculty
      JOIN 
         time_period ON faculty.timeID = time_period.timeID
      GROUP BY 
         time_period.SchoolYear, time_period.semester
      ORDER BY 
         time_period.SchoolYear, time_period.semester";

$charts['numberOfTotalFaculty'] = fetchQueryResults($conn, $sql3);

// Execute SQL query to retrieve the total number of publications per year
$sql4 = "SELECT 
         time_period.SchoolYear AS SchoolYear,
         SUM(publication.count) AS totalPublications
      FROM 
         publication
      JOIN 
         time_period ON publication.timeID = time_period.timeID
      GROUP BY 
         time_period.SchoolYear
      ORDER BY 
         time_period.SchoolYear";

$charts['numberOfPublications'] = fetchQueryResults($conn, $sql4);

// Execute SQL query to retrieve the total faculty involvement per publication
$sql5 = "SELECT 
         publication.title AS publicationTitle,
         SUM(faculty.count) AS totalFacultyParticipation
      FROM 
         publication
      JOIN 
         faculty ON publication.publicationID = faculty.publicationID
      GROUP BY 
         publication.title";

$charts['researchInvolvement'] = fetchQueryResults($conn, $sql5);


echo json_encode($charts);
$conn->close();
?>
