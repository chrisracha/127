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
    $sql = "SELECT timeID FROM time_period WHERE schoolYear = ? AND semester = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $schoolYear, $semester);
    $stmt->execute();
    $stmt->bind_result($timeID);
    $stmt->fetch();
    $stmt->close();
    return $timeID;
}

function generateNewEventID($eventName) {
    global $conn;
    
    // Extract the numeric part from the event name
    preg_match('/\d+/', $eventName, $matches);
    $numericPart = isset($matches[0]) ? intval($matches[0]) : ''; // Get the numeric part, if any

    // If numeric part exists, use it as the event ID, otherwise use the event name as is
    $newID = $numericPart ? 'E' . $numericPart : $eventName;

    // Check if the event ID already exists in the database
    $sql = "SELECT eventID FROM event WHERE eventID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $newID);
    $stmt->execute();
    $result = $stmt->get_result();

    // If the event ID already exists, increment the numeric part until a unique ID is found
    while ($result->num_rows > 0) {
        $numericPart++; // Increment numeric part
        $newID = 'E' . $numericPart; // Generate new event ID
        $stmt->bind_param("s", $newID);
        $stmt->execute();
        $result = $stmt->get_result();
    }

    return $newID;
}

// Function to generate new publication ID
function generateNewPublicationID($publicationNumber) {
    // Prefix 'PR' to the publication number
    $newID = 'PR' . $publicationNumber;
    return $newID;
}

// Handle add acad year and sem
if (isset($_POST['add_acad'])) {
    $newSchoolYear = $_POST['newSchoolYear'];
    $semester = $_POST['semester'];

    // Split the school year and create timeID from the last two digits of the end year and the semester.
    $parts = explode("-", $newSchoolYear);
    $endYear = substr($parts[1], -2); // Get last two digits of the ending year
    $timeID = $endYear . '-' . $semester; // Concatenate to form timeID

    // Check if the timeID already exists in the time_period table
    $checkSql = "SELECT 1 FROM time_period WHERE timeID = ?";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bind_param("s", $timeID);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    if ($checkResult->num_rows === 0) {
        // If timeID does not exist, proceed with insertion
        $sql = "INSERT INTO time_period (timeID, SchoolYear, semester) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $timeID, $newSchoolYear, $semester);

        if ($stmt->execute()) {
            redirectToStudentsPage();
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "The academic year and semester with ID '$timeID' already exist. Please try a different year or semester.";
    }

    $checkStmt->close();
}

// Delete operation
if (isset($_POST['delete_acad'])) {
    $oldSchoolYear = $_POST['oldSchoolYear'];

    $sql = "DELETE FROM time_period WHERE SchoolYear=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $oldSchoolYear);
    if ($stmt->execute()) {
        redirectToStudentsPage();
    } else {
        echo "Error: " . $stmt->error;
    }
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

// Handle update degree program
if (isset($_POST['update_degree'])) {
    $degprogID = $_POST['degprogID'];
    $name = $_POST['name'];

    $sql = "UPDATE deg_prog SET name = ? WHERE degprogID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $name, $degprogID);

    if ($stmt->execute()) {
        redirectToStudentsPage();
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

// Handle delete degree program
if (isset($_POST['delete_degree'])) {
    $degprogID = $_POST['degprogID'];

    $sql = "DELETE FROM deg_prog WHERE degprogID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $degprogID);

    if ($stmt->execute()) {
        redirectToStudentsPage();
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

// Handle add achievement
if (isset($_POST['add_achievement'])) {
    $awardTypeID = $_POST['awardType'];
    $degID = $_POST['degprogID'];
    $count = $_POST['count'];

    $sql = "INSERT INTO student_awards (awardTypeID, degID, count) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $awardTypeID, $degID, $count);
    if ($stmt->execute()) {
        redirectToStudentsPage();
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

// Handle update achievement
if (isset($_POST['update_achievement'])) {
    $awardTypeID = $_POST['awardType'];
    $degID = $_POST['degprogID'];
    $count = $_POST['count'];

    $sql = "UPDATE student_awards SET count = ? WHERE awardTypeID = ? AND degID = ?";
    $stmt = $conn = $conn->prepare($sql);
    $stmt->bind_param("iss", $count, $awardTypeID, $degID);
    if ($stmt->execute()) {
        redirectToStudentsPage(); 
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

// Handle delete achievement
if (isset($_POST['delete_achievement'])) {
    $awardTypeID = $_POST['awardType'];
    $degID = $_POST['degprogID'];

    $sql = "DELETE FROM student_awards WHERE awardTypeID = ? AND degID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $awardTypeID, $degID);
    if ($stmt->execute()) {
        redirectToStudentsPage(); 
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

// Handle add/update/delete event
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = isset($_POST['action']) ? $_POST['action'] : '';
    $eventName = isset($_POST['eventName']) ? $_POST['eventName'] : '';
    $schoolYear = isset($_POST['SchoolYear']) ? $_POST['SchoolYear'] : '';
    $semester = isset($_POST['semester']) ? $_POST['semester'] : '';
    $count = isset($_POST['count']) ? $_POST['count'] : 0;
    $eventID = isset($_POST['eventID']) ? $_POST['eventID'] : '';

    $timeID = fetchTimeID($schoolYear, $semester);

    if ($timeID) {
        echo "Fetched timeID: " . $timeID . "<br>";
    } else {
        die("Error: Invalid timeID for the provided school year and semester.");
    }

    $stmt = null;

    switch ($action) {
        case 'add_event':
            $eventID = generateNewEventID($eventName);
            $sql = "INSERT INTO event (eventID, eventName, timeID, count) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssi", $eventID, $eventName, $timeID, $count);
            break;

        case 'update_event':
            $checkSql = "SELECT eventID FROM event WHERE eventName = ? AND timeID = ?";
            $checkStmt = $conn->prepare($checkSql);
            $checkStmt->bind_param("si", $eventName, $timeID);
            $checkStmt->execute();
            $checkStmt->store_result();

            if ($checkStmt->num_rows > 0) {
                $sql = "UPDATE event SET count = ? WHERE eventName = ? AND timeID = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("isi", $count, $eventName, $timeID);
            } else {
                echo "Error: Event does not exist for the provided school year and semester.";
                exit();
            }
            $checkStmt->close();
            break;

        case 'delete_event':
            $checkSql = "SELECT eventID FROM event WHERE eventName = ? AND timeID = ?";
            $checkStmt = $conn->prepare($checkSql);
            $checkStmt->bind_param("si", $eventName, $timeID);
            $checkStmt->execute();
            $checkStmt->store_result();

            if ($checkStmt->num_rows > 0) {
                $sql = "DELETE FROM event WHERE eventName = ? AND timeID = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("si", $eventName, $timeID);
            } else {
                echo "Error: Event does not exist for the provided school year and semester.";
                exit();
            }
            $checkStmt->close();
            break;
    }

    if ($stmt && $stmt->execute()) {
        echo "Operation successful.";
    } else {
        echo "Error: " . ($stmt ? $stmt->error : 'Invalid operation');
    }

    if ($stmt) {
        $stmt->close();
    }
    $conn->close();
}

// Handle add/update/delete publication
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if action parameter is set
    if (isset($_POST['action'])) {
        $action = $_POST['action'];
        $title = isset($_POST['title']) ? $_POST['title'] : '';
        $timeID = isset($_POST['timeID']) ? $_POST['timeID'] : '';
        $count = isset($_POST['count']) ? $_POST['count'] : 0;

        // Create a new MySQLi connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Initialize statement variable
        $stmt = null;

        switch ($action) {
            case 'add_publication':
                // Generate publicationID based on title
                $publicationID = generateNewPublicationID($title);
                $sql = "INSERT INTO publication (publicationID, title, timeID, count) VALUES (?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                if (!$stmt) {
                    die("Error preparing statement: " . $conn->error);
                }
                $stmt->bind_param("sssi", $publicationID, $title, $timeID, $count);
                break;

            case 'update_publication':
                $sql = "UPDATE publication SET count = ? WHERE title = ? AND timeID = ?";
                $stmt = $conn->prepare($sql);
                if (!$stmt) {
                    die("Error preparing statement: " . $conn->error);
                }
                $stmt->bind_param("iss", $count, $title, $timeID);
                break;

            case 'delete_publication':
                $sql = "DELETE FROM publication WHERE title = ? AND timeID = ?";
                $stmt = $conn->prepare($sql);
                if (!$stmt) {
                    die("Error preparing statement: " . $conn->error);
                }
                $stmt->bind_param("ss", $title, $timeID);
                break;

            default:
                die("Error: Invalid action.");
        }

        if ($stmt && $stmt->execute()) {
            echo "Operation successful.";
            redirectToFacultyPage(); // Assuming successful operation, redirect to faculty page
        } else {
            echo "Error: " . ($stmt ? $stmt->error : 'Invalid operation');
        }

        // Close statement
        if ($stmt) {
            $stmt->close();
        }

        // Close connection
        $conn->close();
    } else {
        die("Error: Action parameter is missing.");
    }
}

?>
