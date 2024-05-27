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

function redirectToFacultyPage() {
    header("Location: faculty.php");
    exit();
}

// Handle add academic year 
if (isset($_POST['add_acadYear'])) {
    $SchoolYear = $_POST['SchoolYear']; 
    $semester = $_POST['semester']; 

    $parts = explode("-", $SchoolYear);
    $endYear = substr($parts[1], -2); 
    $timeID = $endYear . '-' . $semester; 

    $sql = "INSERT INTO time_period (timeID, SchoolYear, semester) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $timeID, $SchoolYear, $semester);

    if ($stmt->execute()) {
        redirectToStudentsPage();
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

// Handle update academic year
if (isset($_POST['update_acadYear'])) {
    $timeID = $_POST['timeID'];
    $SchoolYear = $_POST['SchoolYear'];
    $semester = $_POST['semester'];

    $sql = "UPDATE time_period SET SchoolYear = ?, semester = ? WHERE timeID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sii", $SchoolYear, $semester, $timeID);

    if ($stmt->execute()) {
        redirectToStudentsPage();
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

// Handle delete academic year
if (isset($_POST['delete_acadYear'])) {
    $timeID = $_POST['timeID'];
    
    $sql = "DELETE FROM time_period WHERE timeID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $timeID);
    
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

// Handle add degree information
if (isset($_POST['add_degree_info'])) {
    $degID = $_POST['degID'];
    $timeID = $_POST['timeID'];
    $count = $_POST['count'];

    $sql = "INSERT INTO college_degree (degID, timeID, count) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $degID, $timeID, $count);
    
    if ($stmt->execute()) {
        redirectToStudentsPage();
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
} elseif (isset($_POST['update_degree_info'])) {
    $degID = $_POST['degID'];
    $timeID = $_POST['timeID'];
    $count = $_POST['count'];

    $sql = "UPDATE college_degree SET timeID=?, count=? WHERE degID=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $timeID, $count, $degID);
    
    if ($stmt->execute()) {
        redirectToStudentsPage();
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
} elseif (isset($_POST['delete_degree_info'])) {
    $degID = $_POST['degID'];

    $sql = "DELETE FROM college_degree WHERE degID=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $degID);
    
    if ($stmt->execute()) {
        redirectToStudentsPage();
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

// Handle add achievement
if (isset($_POST['add_achievement'])) {
    $awardTypeID = $_POST['awardTypeID'];
    $degID = $_POST['degID'];
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
} elseif (isset($_POST['update_achievement'])) {
    $achievement = $_POST['awardID'];
    $awardTypeID = $_POST['awardTypeID'];
    $degID = $_POST['degID'];
    $count = $_POST['count'];

    $sql = "UPDATE student_awards SET awardTypeID=?, degID=?, count=? WHERE awardID=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssis", $awardTypeID, $degID, $count, $awardID);
    
    if ($stmt->execute()) {
        redirectToStudentsPage();
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
} elseif (isset($_POST['delete_achievement'])) {
    $achievement = $_POST['awardID'];

    $sql = "DELETE FROM student_awards WHERE awardID=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $awardID);
    
    if ($stmt->execute()) {
        redirectToStudentsPage();
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

// Handle add event
if (isset($_POST['add_event'])) {
    $eventName = $_POST['eventName'];
    $timeID = $_POST['timeID'];
    $count = $_POST['count'];

    $sql = "INSERT INTO event (eventName, timeID, count) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $eventName, $timeID, $count);
    
    if ($stmt->execute()) {
        redirectToStudentsPage();
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
} elseif (isset($_POST['update_event'])) {
    $eventName = $_POST['eventName'];
    $timeID = $_POST['timeID'];
    $count = $_POST['count'];

    $sql = "UPDATE event SET timeID=?, count=? WHERE eventName=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $timeID, $count, $eventName);
    
    if ($stmt->execute()) {
        redirectToStudentsPage();
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
} elseif (isset($_POST['delete_event'])) {
    $eventName = $_POST['eventName'];

    $sql = "DELETE FROM event WHERE eventName=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $eventName);
    
    if ($stmt->execute()) {
        redirectToStudentsPage();
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

// Handle add publication
if (isset($_POST['add_publication'])) {
    $title = $_POST['title'];
    $timeID = $_POST['timeID'];
    $count = $_POST['count'];

    $sql = "INSERT INTO publication (title, timeID, count) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $title, $timeID, $count);
    
    if ($stmt->execute()) {
        redirectToFacultyPage();
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
} elseif (isset($_POST['update_publication'])) {
    $title = $_POST['title'];
    $timeID = $_POST['timeID'];
    $count = $_POST['count'];

    $sql = "UPDATE publication SET timeID=?, count=? WHERE title=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $timeID, $count, $title);
    
    if ($stmt->execute()) {
        redirectToFacultyPage();
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
} elseif (isset($_POST['delete_publication'])) {
    $title = $_POST['title'];

    $sql = "DELETE FROM publication WHERE title=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $title);
    
    if ($stmt->execute()) {
        redirectToFacultyPage();
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

// Handle add faculty by rank
if (isset($_POST['add_faculty_rank'])) {
    $rankID = $_POST['rankID'];
    $timeID = $_POST['timeID'];
    $count = $_POST['count'];

    $sql = "INSERT INTO faculty (rankID, timeID, count) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $rankID, $timeID, $count);
    
    if ($stmt->execute()) {
        redirectToFacultyPage();
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
} elseif (isset($_POST['update_faculty_rank'])) {
    $rankID = $_POST['rankID'];
    $timeID = $_POST['timeID'];
    $count = $_POST['count'];

    $sql = "UPDATE faculty SET timeID=?, count=? WHERE rankID=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isi", $timeID, $count, $rankID);
    
    if ($stmt->execute()) {
        redirectToFacultyPage();
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
} elseif (isset($_POST['delete_faculty_rank'])) {
    $rankID = $_POST['rankID'];

    $sql = "DELETE FROM faculty WHERE rankID=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $rankID);
    
    if ($stmt->execute()) {
        redirectToFacultyPage();
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

// Handle add faculty by educational attainment
if (isset($_POST['add_faculty_educattainment'])) {
    $educAttainmentID = $_POST['educAttainmentID'];
    $timeID = $_POST['timeID'];
    $count = $_POST['count'];

    $sql = "INSERT INTO faculty (educAttainmentID, timeID, count) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $educAttainmentID, $timeID, $count);
    
    if ($stmt->execute()) {
        redirectToFacultyPage();
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
} elseif (isset($_POST['update_faculty_educattainment'])) {
    $educAttainmentID = $_POST['educAttainmentID'];
    $timeID = $_POST['timeID'];
    $count = $_POST['count'];

    $sql = "UPDATE faculty SET timeID=?, count=? WHERE educAttainmentID=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isi", $timeID, $count, $educAttainmentID);
    
    if ($stmt->execute()) {
        redirectToFacultyPage();
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
} elseif (isset($_POST['delete_faculty_educattainment'])) {
    $educAttainmentID = $_POST['educAttainmentID'];

    $sql = "DELETE FROM faculty WHERE educAttainmentID=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $educAttainmentID);
    
    if ($stmt->execute()) {
        redirectToFacultyPage();
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}


// Close connection
$conn->close();
?>
