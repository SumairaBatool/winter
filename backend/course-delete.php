<?php
// Database connection parameters
require_once('../includes/config.php');

// Check if ID parameter is set
if(isset($_GET['id'])) {
    // Sanitize the ID input
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    // Check if there are any teachers referencing this course
    $checkTeacherSql = "SELECT COUNT(*) AS count FROM teacher WHERE course_id = $id";
    $result = $conn->query($checkTeacherSql);
    $row = $result->fetch_assoc();

    // If there are teachers referencing this course, show an error
    if ($row['count'] > 0) {
        echo "Cannot delete course. It is referenced by one or more teachers.";
    } else {
        // If no teachers are referencing the course, proceed with deletion
        $sql = "DELETE FROM corses WHERE id = $id";

        if ($conn->query($sql) === TRUE) {
            header("Location: courses.php");
        } else {
            echo "Error deleting course: " . $conn->error;
        }
    }
} else {
    echo "ID parameter is missing";
}

// Close connection
$conn->close();
?>
