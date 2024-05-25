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

// Execute SQL query to retrieve the total number of publications per year
$sql3 = "SELECT 
         time_period.SchoolYear,
         SUM(publication.count) AS totalPublications
      FROM 
         publication
      JOIN 
         time_period ON publication.timeID = time_period.timeID
      GROUP BY 
         time_period.SchoolYear
      ORDER BY 
         time_period.SchoolYear";

$charts['numberOfPublications'] = fetchQueryResults($conn, $sql3);

// Execute SQL query to retrieve the total faculty involvment per publication
$sql4 = "SELECT 
         publication.title AS publicationTitle,
         time_period.SchoolYear,
         time_period.semester,
         SUM(faculty.count) AS totalFacultyParticipation
      FROM 
         publication
      JOIN 
         faculty ON publication.publicationID = faculty.publicationID
      JOIN 
         time_period ON publication.timeID = time_period.timeID";

$charts['researchInvolvement'] = fetchQueryResults($conn, $sql4);
         
// Execute SQL query retrieve the population of faculty by rank per year
$sql5 = "SELECT rt.title as Rank, tp.SchoolYear, COUNT(f.facultyID) as totalFaculty
         FROM faculty f
         JOIN rank_title rt ON f.rankID = rt.rankID
         JOIN time_period tp ON f.timeID = tp.timeID
         GROUP BY rt.title, tp.SchoolYear
         ORDER BY tp.SchoolYear, rt.title";

$charts['facultyNoYearlybyRank'] = fetchQueryResults($conn, $sql5);

// Execute SQL query to retrieve the population of faculty by educational attainment per year
$sql6 = "SELECT ea.attainment as EducationalAttainment, tp.SchoolYear, COUNT(f.facultyID) as totalFaculty
         FROM faculty f
         JOIN educ_attainment ea ON f.educAttainmentID = ea.educAttainmentID
         JOIN time_period tp ON f.timeID = tp.timeID
         GROUP BY ea.attainment, tp.SchoolYear
         ORDER BY tp.SchoolYear, ea.attainment";

$charts['facultyNoYearlybyEduc'] = fetchQueryResults($conn, $sql6);

// Execute SQL query to retrieve the total number of faculty per semester
$sql7 = "SELECT 
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

$charts['numberOfTotalFaculty'] = fetchQueryResults($conn, $sql7);

// Execute SQL query to get event data
$sql9 = "SELECT eventName, count FROM event";
$result9 = $conn->query($sql9);

if ($result9 === FALSE) {
    die("Query failed: " . $conn->error);
}

// Define the labels for the table headers
$labels = ["Event Name", "Participation Count"];

// Display the table headers
echo '<table class="table"><tr>';
foreach ($labels as $label) {
    echo '<th>' . htmlspecialchars($label, ENT_QUOTES, 'UTF-8') . '</th>';
}
echo '</tr>';

// Display the table rows
if ($result9->num_rows > 0) {
    while ($row = $result9->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($row["eventName"], ENT_QUOTES, 'UTF-8') . '</td>';
        echo '<td>' . htmlspecialchars($row["count"], ENT_QUOTES, 'UTF-8') . '</td>';
        echo '</tr>';
    }
} else {
    echo '<tr><td colspan="2">No events found</td></tr>';
}

echo '</table>';

header('Content-Type: application/json');
echo json_encode($charts);

$conn->close();
?>
