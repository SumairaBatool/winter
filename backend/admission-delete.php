<?php
// Database connection parameters
require_once('../includes/config.php');

// Check if ID parameter is set
if(isset($_GET['id'])) {
    // Sanitize the ID input
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    // SQL query to delete record with given ID
    $sql = "DELETE FROM admissions WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        header("Location: user-admissions.php");
    } else {
        echo "Error deleting record: " . $conn->error;
    }
} else {
    echo "ID parameter is missing";
}

// Close connection
$conn->close();
?>
