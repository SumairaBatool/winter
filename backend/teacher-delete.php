<?php
// Database connection parameters
require_once('../includes/config.php');
// Check if ID parameter is set
if (isset($_GET['id'])) {
    // Sanitize the ID input
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    // Check if the teacher is associated with any course
    $checkCourseSql = "SELECT COUNT(*) AS count FROM corses WHERE id = $id";
    $result = $conn->query($checkCourseSql);
    $row = $result->fetch_assoc();

    // If the teacher is associated with any courses, show an error
    if ($row['count'] > 0) {
        echo "Cannot delete teacher. They are associated with one or more courses.";
    } else {
        // If no courses are associated, proceed with teacher deletion
        $sql = "DELETE FROM teacher WHERE tid = $id";

        if ($conn->query($sql) === TRUE) {
            header("Location: teachers.php");
        } else {
            echo "Error deleting teacher: " . $conn->error;
        }
    }
} else {
    echo "ID parameter is missing";
}

// Close connection
$conn->close();
?>
