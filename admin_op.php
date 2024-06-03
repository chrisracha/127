<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dmpcs_dashboard";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function redirectToStudentsPage() {
    header("Location: students.php");
    exit();
}

// Remove the redundant declaration of redirectToFacultyPage()

function fetchTimeID($schoolYear, $semester) {
    global $conn;
    $sql = "SELECT timeID FROM time_period WHERE SchoolYear = ? AND semester = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("ss", $schoolYear, $semester);
        $stmt->execute();
        $stmt->bind_result($timeID);
        if ($stmt->fetch()) {
            return $timeID;
        }
        $stmt->close();
    }
    return null;
}

// Add and delete academic year and semester
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add_acad'])) {
        $newSchoolYear = $_POST['newSchoolYear'];
        $semester = $_POST['semester'];

        // Extract the last two digits of the ending year
        $parts = explode('-', $newSchoolYear);
        $lastTwoDigits = substr($parts[1], -2);  // Get last two digits of the end year
        $timeID = $lastTwoDigits . '-' . $semester;  // Concatenate to form timeID

        // Check if the timeID already exists to avoid duplicates
        $checkSql = "SELECT * FROM time_period WHERE timeID = ?";
        $checkStmt = $conn->prepare($checkSql);
        $checkStmt->bind_param("s", $timeID);
        $checkStmt->execute();
        $checkResult = $checkStmt->get_result();
        if ($checkResult->num_rows > 0) {
            echo "This academic year and semester combination already exists.";
        } else {
            // Insert new academic year, semester, and generated timeID
            $sql = "INSERT INTO time_period (timeID, SchoolYear, semester) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            if ($stmt) {
                $stmt->bind_param("ssi", $timeID, $newSchoolYear, $semester);
                if ($stmt->execute()) {
                    echo "New academic year and semester added successfully with timeID: $timeID";
                } else {
                    echo "Error adding academic year: " . $stmt->error;
                }
                $stmt->close();
            }
        }
        $checkStmt->close();
    }
}

if (isset($_POST['delete_acad'])) {
    // Get the selected option
    $selected_option = $_POST['existingSY'];

    // Separate the SchoolYear and semester using explode
    list($schoolYear, $semester) = array_map('trim', explode(",", $selected_option));

    // Prepare the SQL statement for deletion
    $sql = "DELETE FROM time_period WHERE SchoolYear = ? AND semester = ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt === false) {
        echo "Error preparing statement: " . $conn->error;
        exit;
    }
    
    // Bind parameters to the prepared statement
    $stmt->bind_param("si", $schoolYear, $semester);

    // Execute the deletion query
    if ($stmt->execute()) {
        echo "Record deleted successfully.";
    } else {
        echo "Error deleting record: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}


// Handle add degree program
if (isset($_POST['add_degree'])) {
    $degprogID = $_POST['degprogID'];
    $name = $_POST['name'];

    $sql = "INSERT INTO deg_prog (degprogID, name) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $degprogID, $name);

    if ($stmt->execute()) {
        redirectToStudentsPage();
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

if (isset($_POST['delete_degree']) && isset($_POST['existingSY'])) {
    // Sanitize the input to prevent SQL Injection
    $degprogID = $conn->real_escape_string($_POST['existingSY']);
    
    // SQL to delete a degree program
    $deleteSql = "DELETE FROM deg_prog WHERE degprogID = '$degprogID'";
    
    if ($conn->query($deleteSql) === TRUE) {
        echo "Degree program deleted successfully.";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

// Add achievement function
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_achievement') {
    $awardType = $_POST['awardType'];
    $degprogID = $_POST['degprogID'];
    $count = $_POST['count'];

    // Debug: Check what is being received
    echo "Award Type received: " . htmlspecialchars($awardType) . "<br>";
    echo "Degree Program received: " . htmlspecialchars($degprogID) . "<br>";
    echo "Count received: " . htmlspecialchars($count) . "<br>";

    // Step 1: Select awardtypeID column in award_type table that matches the given awardType
    $stmt = $conn->prepare("SELECT awardtypeID FROM award_type WHERE awardType = ?");
    $stmt->bind_param("s", $awardType);
    $stmt->execute();
    $stmt->bind_result($awardtypeID);
    $stmt->fetch();
    $stmt->close();

    // Debug: Check fetched awardtypeID
    echo "Award Type ID: $awardtypeID<br>";

    // Step 2: Use PHP explode function to separate yearLevel, degprogID, SchoolYear, semester
    $parts = array_map('trim', explode(',', $degprogID));
    if (count($parts) !== 4) {
        die("Error: Degree Program format is incorrect.");
    }
    list($yearLevel, $degreeProgramID, $SchoolYear, $semester) = $parts;

    // Debug: Check separated values
    echo "Year Level: $yearLevel<br>";
    echo "Degree Program ID: $degreeProgramID<br>";
    echo "School Year: $SchoolYear<br>";
    echo "Semester: $semester<br>";

    // Step 3: Select timeID column in time_period table that matches the given SchoolYear and semester
    $stmt = $conn->prepare("SELECT timeID FROM time_period WHERE SchoolYear = ? AND semester = ?");
    $stmt->bind_param("ss", $SchoolYear, $semester);
    $stmt->execute();
    $stmt->bind_result($timeID);
    $stmt->fetch();
    $stmt->close();

    // Debug: Check fetched timeID
    echo "Time ID: $timeID<br>";

    // Step 4: Select degID column in college_degree table that matches the given yearLevel, degprogID, timeID
    $stmt = $conn->prepare("SELECT degID FROM college_degree WHERE yearLevel = ? AND degprogID = ? AND timeID = ?");
    $stmt->bind_param("sss", $yearLevel, $degreeProgramID, $timeID);
    $stmt->execute();
    $stmt->bind_result($degID);
    $stmt->fetch();
    $stmt->close();

    // Debug: Check fetched degID
    echo "Degree ID: $degID<br>";

    // Step 5: Add row to student_awards table with the awardtypeID, degID, count
    $stmt = $conn->prepare("INSERT INTO student_awards (awardtypeID, degID, count) VALUES (?, ?, ?)");
    $stmt->bind_param("iii", $awardtypeID, $degID, $count);
    if ($stmt->execute()) {
        echo "Achievement added successfully.";
    } else {
        echo "Error adding achievement: " . $stmt->error;
    }
    $stmt->close();
}

// Delete achievement function
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete_achievement') {
    $achievement = $_POST['existingAchievements'];

    // Debug: Check what achievement is being received
    echo "Achievement received: " . htmlspecialchars($achievement) . "<br>";

    // Step 1: Use PHP explode function to separate awardType, yearLevel, degprogID, SchoolYear, semester
    list($awardType, $yearLevel, $degprogID, $SchoolYear, $semester) = array_map('trim', explode(',', $achievement));

    // Debug: Check separated values
    echo "Award Type: $awardType<br>";
    echo "Year Level: $yearLevel<br>";
    echo "Degree Program ID: $degprogID<br>";
    echo "School Year: $SchoolYear<br>";
    echo "Semester: $semester<br>";

    // Step 2: Select awardtypeID column in award_type table that matches the given awardType
    $stmt = $conn->prepare("SELECT awardtypeID FROM award_type WHERE awardType = ?");
    $stmt->bind_param("s", $awardType);
    $stmt->execute();
    $stmt->bind_result($awardtypeID);
    $stmt->fetch();
    $stmt->close();

    // Step 3: Select timeID column in time_period table that matches the given SchoolYear and semester
    $stmt = $conn->prepare("SELECT timeID FROM time_period WHERE SchoolYear = ? AND semester = ?");
    $stmt->bind_param("ss", $SchoolYear, $semester);
    $stmt->execute();
    $stmt->bind_result($timeID);
    $stmt->fetch();
    $stmt->close();

    // Step 4: Select degID column in college_degree table that matches the given yearLevel, degprogID, timeID
    $stmt = $conn->prepare("SELECT degID FROM college_degree WHERE yearLevel = ? AND degprogID = ? AND timeID = ?");
    $stmt->bind_param("sss", $yearLevel, $degprogID, $timeID);
    $stmt->execute();
    $stmt->bind_result($degID);
    $stmt->fetch();
    $stmt->close();

    // Step 5: Delete row in student_awards table that matches the awardtypeID, degID
    $stmt = $conn->prepare("DELETE FROM student_awards WHERE awardtypeID = ? AND degID = ?");
    $stmt->bind_param("ii", $awardtypeID, $degID);
    if ($stmt->execute()) {
        echo "Achievement deleted successfully.";
    } else {
        echo "Error deleting achievement: " . $stmt->error;
    }
    $stmt->close();
}

// Add degree program information function
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_deginfo') {
    $yearLevel = $_POST['yearLevel'];
    $degprogID = $_POST['degprogID'];
    $SchoolYear = $_POST['SchoolYear'];
    $semester = $_POST['semester'];
    $count = $_POST['count'];

    // Debug: Check what is being received
    echo "Year Level received: " . htmlspecialchars($yearLevel) . "<br>";
    echo "Degree Program received: " . htmlspecialchars($degprogID) . "<br>";
    echo "School Year received: " . htmlspecialchars($SchoolYear) . "<br>";
    echo "Semester received: " . htmlspecialchars($semester) . "<br>";
    echo "Count received: " . htmlspecialchars($count) . "<br>";

    // Step 1: Select timeID column in time_period table that matches the given SchoolYear and semester
    $stmt = $conn->prepare("SELECT timeID FROM time_period WHERE SchoolYear = ? AND semester = ?");
    $stmt->bind_param("ss", $SchoolYear, $semester);
    $stmt->execute();
    $stmt->bind_result($timeID);
    $stmt->fetch();
    $stmt->close();

    // Debug: Check fetched timeID
    echo "Time ID: $timeID<br>";

    // Step 2: Create degID by concatenating yearLevel, degprogID, and timeID
    $degID = $yearLevel . $degprogID . $timeID;

    // Debug: Check concatenated degID
    echo "Degree ID: $degID<br>";

    // Step 3: Insert the new degree information into the college_degree table
    $stmt = $conn->prepare("INSERT INTO college_degree (degID, yearLevel, degprogID, timeID, count) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $degID, $yearLevel, $degprogID, $timeID, $count);
    if ($stmt->execute()) {
        echo "Degree program information added successfully.";
    } else {
        echo "Error adding degree program information: " . $stmt->error;
    }
    $stmt->close();
}

// Delete degree information function
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete_deginfo') {
    $degreeProgram = $_POST['existingDPI'];

    // Debug: Check what degree program information is being received
    echo "Degree Program received: " . htmlspecialchars($degreeProgram) . "<br>";

    // Step 1: Use PHP explode function to separate yearLevel, degprogID, SchoolYear, semester
    list($yearLevel, $degprogID, $SchoolYear, $semester) = array_map('trim', explode(',', $degreeProgram));

    // Debug: Check separated values
    echo "Year Level: $yearLevel<br>";
    echo "Degree Program ID: $degprogID<br>";
    echo "School Year: $SchoolYear<br>";
    echo "Semester: $semester<br>";

    // Step 2: Select timeID column in time_period table that matches the given SchoolYear and semester
    $stmt = $conn->prepare("SELECT timeID FROM time_period WHERE SchoolYear = ? AND semester = ?");
    $stmt->bind_param("ss", $SchoolYear, $semester);
    $stmt->execute();
    $stmt->bind_result($timeID);
    $stmt->fetch();
    $stmt->close();

    // Step 3: Delete row in college_degree table that matches the yearLevel, degprogID, timeID
    $stmt = $conn->prepare("DELETE FROM college_degree WHERE yearLevel = ? AND degprogID = ? AND timeID = ?");
    $stmt->bind_param("isi", $yearLevel, $degprogID, $timeID);
    if ($stmt->execute()) {
        echo "Degree program deleted successfully.";
    } else {
        echo "Error deleting degree program: " . $stmt->error;
    }
    $stmt->close();
}

// Add event function
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_achievement') {
    $eventName = $_POST['eventName'];
    $schoolYear = $_POST['SchoolYear'];
    $semester = $_POST['semester'];
    $count = $_POST['count'];

    // Find the corresponding timeID for the selected SchoolYear and Semester
    $stmt = $conn->prepare("SELECT timeID FROM time_period WHERE SchoolYear = ? AND semester = ?");
    $stmt->bind_param("ss", $schoolYear, $semester);
    $stmt->execute();
    $stmt->bind_result($timeID);
    $stmt->fetch();
    $stmt->close();

    if ($timeID) {
        // Insert the new event into the event table
        $stmt = $conn->prepare("INSERT INTO event (eventName, timeID, count) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $eventName, $timeID, $count);
        if ($stmt->execute()) {
            echo "Event added successfully.";
        } else {
            echo "Error adding event: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Invalid SchoolYear or Semester selected.";
    }
}

// Delete event function
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete_event') {
    // Retrieve the selected event name
    $eventName = $_POST['existingEvents'];

    // Prepare and execute the SQL statement to delete the event
    $stmt = $conn->prepare("DELETE FROM event WHERE eventName = ?");
    if ($stmt) {
        $stmt->bind_param("s", $eventName);
        $stmt->execute();
        
        if ($stmt->affected_rows > 0) {
            echo "Event deleted successfully.";
        } else {
            echo "No event found with the name '$eventName'.";
        }
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
}

// Add publication function
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_publication') {
    $title = $_POST['title'];
    $schoolYear = $_POST['SchoolYear'];
    $semester = $_POST['semester'];
    $count = $_POST['count'];

    // Find the corresponding timeID for the selected SchoolYear and Semester
    $stmt = $conn->prepare("SELECT timeID FROM time_period WHERE SchoolYear = ? AND semester = ?");
    if ($stmt) {
        $stmt->bind_param("ss", $schoolYear, $semester);
        $stmt->execute();
        $stmt->bind_result($timeID);
        $stmt->fetch();
        $stmt->close();
    }

    if ($timeID) {
        // Insert the new publication into the publication table
        $stmt = $conn->prepare("INSERT INTO publication (title, timeID, count) VALUES (?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param("ssi", $title, $timeID, $count);
            if ($stmt->execute()) {
                echo "Publication added successfully.";
            } else {
                echo "Error adding publication: " . $stmt->error;
            }
            $stmt->close();
        }
    } else {
        echo "Invalid SchoolYear or Semester selected.";
    }
}

// Delete publication function
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete_publication') {
    $title = $_POST['existingPub'];


    // Ensure $title is not an array
    if (is_array($title)) {
        $title = $title[0]; // If it's an array, get the first element
    }

    // Prepare and execute the SQL statement to delete the publication
    $stmt = $conn->prepare("DELETE FROM publication WHERE title = ?");
    if ($stmt) {
        $stmt->bind_param("s", $title);
        $stmt->execute();
        
        // Debug: Check if the statement executed
        if ($stmt->error) {
            echo "Error executing statement: " . $stmt->error;
        }

        if ($stmt->affected_rows > 0) {
            echo "Publication deleted successfully.";
        } else {
            echo "No publication found with the title '" . htmlspecialchars($title) . "'.";
        }
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
}

// Add faculty information function
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_faculty_info') {
    // Retrieve form data
    $rankTitle = $_POST['rankTitle']; // Assuming you now send title
    $educAttainmentDesc = $_POST['educAttainmentDesc']; // Assuming you now send description
    $SchoolYear = $_POST['SchoolYear'];
    $semester = $_POST['semester'];
    $count = $_POST['count'];

    // Debug: Check what is being received
    echo "Rank Title received: " . htmlspecialchars($rankTitle) . "<br>";
    echo "Educational Attainment Description received: " . htmlspecialchars($educAttainmentDesc) . "<br>";
    echo "School Year received: " . htmlspecialchars($SchoolYear) . "<br>";
    echo "Semester received: " . htmlspecialchars($semester) . "<br>";
    echo "Population count received: " . htmlspecialchars($count) . "<br>";

    // Step 1: Fetch rankID based on rank title
    $stmt = $conn->prepare("SELECT rankID FROM rank_title WHERE title = ?");
    $stmt->bind_param("s", $rankTitle);
    $stmt->execute();
    $stmt->bind_result($rankID);
    if (!$stmt->fetch()) {
        echo "No valid rankID found for the given title.";
        $stmt->close();
        $conn->close();
        return;
    }
    $stmt->close();

    // Step 2: Fetch educAttainmentID based on educational attainment description
    $stmt = $conn->prepare("SELECT educAttainmentID FROM educ_attainment WHERE attainment = ?");
    $stmt->bind_param("s", $educAttainmentDesc);
    $stmt->execute();
    $stmt->bind_result($educAttainmentID);
    if (!$stmt->fetch()) {
        echo "No valid educAttainmentID found for the given description.";
        $stmt->close();
        $conn->close();
        return;
    }
    $stmt->close();

    // Step 3: Select timeID column in time_period table that matches the given SchoolYear and semester
    $stmt = $conn->prepare("SELECT timeID FROM time_period WHERE SchoolYear = ? AND semester = ?");
    $stmt->bind_param("ss", $SchoolYear, $semester);
    $stmt->execute();
    $stmt->bind_result($timeID);
    if (!$stmt->fetch()) {
        echo "No valid timeID found for the given SchoolYear and semester.";
        $stmt->close();
        $conn->close();
        return;
    }
    $stmt->close();

    // Step 4: Insert the new faculty information into the faculty table
    $stmt = $conn->prepare("INSERT INTO faculty (rankID, educAttainmentID, timeID, count) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $rankID, $educAttainmentID, $timeID, $count);
    if ($stmt->execute()) {
        echo "Faculty information added successfully.";
    } else {
        echo "Error adding faculty information: " . $stmt->error;
    }
    $stmt->close();
}

// Delete faculty information function
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete_faculty_info') {
    $facultyInfo = $_POST['existingfacultyInfo'];

    // Debug: Check what faculty information is being received
    echo "Faculty Info received: " . htmlspecialchars($facultyInfo) . "<br>";

    // Step 1: Use PHP explode function to separate title, attainment, SchoolYear, semester
    list($title, $attainment, $SchoolYear, $semester) = array_map('trim', explode(',', $facultyInfo));

    // Debug: Check separated values
    echo "Title: $title<br>";
    echo "Attainment: $attainment<br>";
    echo "School Year: $SchoolYear<br>";
    echo "Semester: $semester<br>";

    // Step 2: Select rankID column in rank_title table that matches the given title
    $stmt = $conn->prepare("SELECT rankID FROM rank_title WHERE title = ?");
    $stmt->bind_param("s", $title);
    $stmt->execute();
    $stmt->bind_result($rankID);
    if ($stmt->fetch()) {
        // Echo the title and rankID for debugging
        echo "Title: $title<br>";
        echo "Rank ID: $rankID<br>";
    } else {
        echo "No valid rankID found for the given title: $title.";
        $stmt->close();
        $conn->close();
        return;
    }
    $stmt->close();

    // Step 3: Select educAttainmentID column in educ_attainment table that matches the given attainment
    $stmt = $conn->prepare("SELECT educAttainmentID FROM educ_attainment WHERE attainment = ?");
    $stmt->bind_param("s", $attainment);
    $stmt->execute();
    $stmt->bind_result($educAttainmentID);
    if ($stmt->fetch()) {
        // Echo the educAttainmentID for debugging
        echo "Educational Attainment ID: $educAttainmentID<br>";
    } else {
        echo "No valid educAttainmentID found for the given attainment: $attainment.";
        $stmt->close();
        $conn->close();
        return;
    }
    $stmt->close();

    // Step 4: Select timeID column in time_period table that matches the given SchoolYear and semester
    $stmt = $conn->prepare("SELECT timeID FROM time_period WHERE SchoolYear = ? AND semester = ?");
    $stmt->bind_param("ss", $SchoolYear, $semester);
    $stmt->execute();
    $stmt->bind_result($timeID);
    if ($stmt->fetch()) {
        // Echo the timeID for debugging
        echo "Time ID: $timeID<br>";
    } else {
        echo "No valid timeID found for the given SchoolYear: $SchoolYear and semester: $semester.";
        $stmt->close();
        $conn->close();
        return;
    }
    $stmt->close();

    // Step 5: Delete row in faculty table that matches the rankID, educAttainmentID, and timeID
    $stmt = $conn->prepare("DELETE FROM faculty WHERE rankID = ? AND educAttainmentID = ? AND timeID = ?");
    $stmt->bind_param("sss", $rankID, $educAttainmentID, $timeID);
    if ($stmt->execute()) {
        echo "Faculty information deleted successfully.";
    } else {
        echo "Error deleting faculty information: " . $stmt->error;
    }
    $stmt->close();
}

$conn->close();
?>



