<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start session only if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Database connection
require_once("../../includes/config.php");
include("../../includes/header.php");

$error = '';
$useremail = '';
$password = '';
$role = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize input
    $useremail = trim(strtolower($_POST['useremail']));
    $password = trim($_POST['password']);
    $role = trim($_POST['role']);

    // Map role names to role IDs
    $role_map = ["Admin" => 1, "Teacher" => 2, "Student" => 3];
    $role_int = $role_map[$role] ?? 0;

    // Check if fields are empty
    if (empty($useremail) || empty($password) || empty($role)) {
        die("<p style='color:red;'>⚠️ All fields are required.</p>");
    }

    // SQL to fetch user data from the database
    $sql = "SELECT * FROM a_users WHERE useremail = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("❌ Error preparing query: " . $conn->error);
    }

    // Bind parameters and execute query
    $stmt->bind_param("s", $useremail);
    $stmt->execute();
    $result = $stmt->get_result();

    // Error in query execution
    if ($result === false) {
        die("❌ Error executing query: " . $conn->error);
    }

    // Check if user exists
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $row['userpassword'])) {
            // Check role match
            if ($row['role_id'] == $role_int) {
                // Store session variables
                $_SESSION['role'] = $role;
                $_SESSION['role_id'] = $row['role_id'];
                $_SESSION['user'] = $row['username'];
                $_SESSION['uid'] = $row['id'];

                session_regenerate_id(true); // Secure session

                // Redirect to the backend dashboard
                header("Location: ../../backend/");
                exit;
            } else {
                die("<p style='color:red;'>⚠️ Role mismatch: Expected $role_int but found " . $row['role_id'] . ".</p>");
            }
        } else {
            die("<p style='color:red;'>❌ Incorrect password.</p>");
        }
    } else {
        die("<p style='color:red;'>❌ User not found.</p>");
    }
}
?>

<!-- Login Form -->
<div class="contain">
    <form action="#" method="post" class="validation-form">
        <h2 style="color: white; background-color: teal; padding: 10px;">Log In</h2>
        <div style="color:red; padding:20px 0;"><?= $error ?></div>

        <label for="email">Email:</label>
        <input type="email" name="useremail" value="<?= htmlspecialchars($useremail) ?>" required>

        <label for="password">Password:</label>
        <input type="password" name="password" required>

        <label for="role">Login as:</label>
        <select name="role" required>
            <option value="">--- Select Role ---</option>
            <option value="Admin" <?= $role == 'Admin' ? 'selected' : '' ?>>Admin</option>
            <option value="Teacher" <?= $role == 'Teacher' ? 'selected' : '' ?>>Teacher</option>
            <option value="Student" <?= $role == 'Student' ? 'selected' : '' ?>>Student</option>
        </select>

        <button type="submit" class="btn btn-success btn-block">Sign In</button>
    </form>
</div>

<?php include("../../includes/footer.php"); ?>
