<?php
require_once("../includes/config.php");
checkRole(['Admin', 'Student']); // Both Admin and Student can access

// Check if ID parameter is set
if(isset($_GET['id'])) {
    // Sanitize the ID input or sql injecttion bdniyati
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    // SQL query to delete record with given ID
    $sql = "UPDATE `admissions` SET `adm_status`='canceled' WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        header("Location: user-admissions.php");
    } else {
        echo "Error updating record: " . $conn->error;
    }
} else {
    echo "ID parameter is missing";
}
// Close connection
$conn->close();
?>
