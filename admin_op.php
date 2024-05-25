<?php
// Establish a connection to the database (replace placeholders with your actual database credentials)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dmpcs_dashboard";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handling Degree Program form
    if (isset($_POST['add_degree'])) {
        // Retrieve degree program code and name from the form
        $degree_code = $_POST['degreeCode'];
        $degree_name = $_POST['degreeName'];

        // Prepare SQL statement to insert the degree program
        $sql = "INSERT INTO deg_prog (degprogID, name) VALUES (?, ?)";

        // Prepare and bind parameters
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $degree_code, $degree_name);

        // Execute the statement
        if ($stmt->execute()) {
            // Redirect to the main dashboard
            header("Location: students.php");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        // Close statement
        $stmt->close();
    } elseif (isset($_POST['delete_degree'])) {
        // Retrieve degree program code from the form
        $degree_code = $_POST['degreeCode'];

        // Prepare SQL statement to delete the degree program
        $sql = "DELETE FROM deg_prog WHERE degprogID = ?";

        // Prepare and bind parameters
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $degree_code);

        // Execute the statement
        if ($stmt->execute()) {
            // Redirect to the main dashboard
            header("Location: students.php");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        // Close statement
        $stmt->close();
    }

    // Handling Research/Publications form
    if (isset($_POST['add_publication'])) {
        // Retrieve data from the form
        $researchName = $_POST['researchName'];
        $year = $_POST['year'];
        $semester = $_POST['semester'];
        $participants = $_POST['participants'];

        // Generate the time_id based on year and semester
        $time_id = $year . " " . $semester;

        // Prepare SQL statement to insert the publication
        $sql = "INSERT INTO publication (title, time_id, count) VALUES (?, ?, ?)";

        // Prepare and bind parameters
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $researchName, $time_id, $participants);

        // Execute the statement
        if ($stmt->execute()) {
            // Redirect to the main dashboard
            header("Location: faculty.html");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        // Close statement
        $stmt->close();
    } elseif (isset($_POST['update_publication'])) {
        // Retrieve data from the form
        $publicationID = $_POST['publicationID'];
        $researchName = $_POST['researchName'];
        $year = $_POST['year'];
        $semester = $_POST['semester'];
        $participants = $_POST['participants'];

        // Generate the time_id based on year and semester
        $time_id = $year . " " . $semester;

        // Prepare SQL statement to update the publication
        $sql = "UPDATE publication SET title = ?, time_id = ?, count = ? WHERE publicationID = ?";

        /// Execute the statement
        if ($stmt->execute()) {
            // Redirect to the main dashboard
            header("Location: faculty.html");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        // Close statement
        $stmt->close();
    }
}

$conn->close();
?>
