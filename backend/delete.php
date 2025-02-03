<?php
// Database connection parameters
require_once('../includes/config.php');

// Check if ID parameter is set
if (isset($_GET['id'])) {
    // Sanitize the ID input
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    // SQL query to fetch the user's role_id from the a_users table
    $sql_role = "SELECT role_id FROM a_users WHERE id = $id";
    $result_role = $conn->query($sql_role);

    if ($result_role->num_rows > 0) {
        $role_data = $result_role->fetch_assoc();
        $role_id = $role_data['role_id'];

        // Begin a transaction to ensure all deletions happen together
        $conn->begin_transaction();

        try {
            // Initialize the variable for the delete query
            $sql_delete_role = "";

            // Delete the user from the respective table based on role_id
            if ($role_id == 1) {  // Admin
                $sql_delete_role = "DELETE FROM admin WHERE admin_id = $id";
            } elseif ($role_id == 2) {  // Teacher
                $sql_delete_role = "DELETE FROM teacher WHERE tid = $id";
            } elseif ($role_id == 3) {  // Student
                $sql_delete_role = "DELETE FROM student WHERE sid = $id";
            } else {
                // If role_id is not valid, display an error
                echo "Error: Invalid user role.";
                exit();
            }

            // Check if the $sql_delete_role query is not empty before executing
            if ($sql_delete_role !== "") {
                // Execute the role-specific delete query
                $conn->query($sql_delete_role);

                // Now delete the user from the a_users table
                $sql_delete_user = "DELETE FROM a_users WHERE id = $id";
                $conn->query($sql_delete_user);

                // Commit transaction
                $conn->commit();

                // Redirect after successful deletion
                header("Location: users.php");
                exit();
            } else {
                // If no valid role found, display an error
                echo "Error: Invalid user role.";
            }

        } catch (Exception $e) {
            // Rollback transaction if something goes wrong
            $conn->rollback();
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "User not found";
    }
} else {
    echo "ID parameter is missing";
}

// Close connection
$conn->close();
?>





