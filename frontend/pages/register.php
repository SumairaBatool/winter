<?php
// Database connection
require_once("../../includes/config.php");
include("../../includes/header.php");

$error = '';
$errorPassword = '';
$username = '';
$useremail = '';
$password = '';
$cpassword = '';
$role = ''; // Store selected role

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $username = trim($_POST['username']);
    $useremail = trim(strtolower($_POST['useremail']));
    $password = trim($_POST['password']);
    $cpassword = trim($_POST['cpassword']);
    $role = $_POST['role']; // Get selected role

    // Validate password match
    if ($password != $cpassword) {
        $errorPassword = 'Password and Confirm password do not match.';
    } else {
        // Check if email already exists
        $stmt = $conn->prepare("SELECT * FROM a_users WHERE useremail = ?");
        $stmt->bind_param("s", $useremail);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error = 'This email already exists.';
        } else {
            // Hash the password before storing it
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Assign role ID based on the selected role name (Admin, Teacher, Student)
            $stmt = $conn->prepare("SELECT id FROM role WHERE role_name = ? LIMIT 1");
            $stmt->bind_param("s", $role);
            $stmt->execute();
            $role_query = $stmt->get_result();

            if ($role_query->num_rows > 0) {
                $role_data = $role_query->fetch_assoc();
                $role_id = $role_data['id']; // Fetch the role ID from the role table
            } else {
                die("Invalid role selected.");
            }

            // Insert user into the a_users table with the correct role_id
            $stmt = $conn->prepare("INSERT INTO a_users (username, useremail, userpassword, role_id) 
                                    VALUES (?, ?, ?, ?)");
            $stmt->bind_param("sssi", $username, $useremail, $hashed_password, $role_id);

            if ($stmt->execute()) {
                // Get the last inserted user ID
                $userId = $conn->insert_id;

                // Insert into the role-specific table based on the selected role
                if ($role == 'Admin') {
                    $stmt = $conn->prepare("INSERT INTO admin (admin_id, admin_name, email, admin_password) 
                                            VALUES (?, ?, ?, ?)");
                    $stmt->bind_param("isss", $userId, $username, $useremail, $hashed_password);
                } elseif ($role == 'Teacher') {
                    $stmt = $conn->prepare("INSERT INTO teacher (tid, teacher_name, email, teacher_password) 
                                            VALUES (?, ?, ?, ?)");
                    $stmt->bind_param("isss", $userId, $username, $useremail, $hashed_password);
                } elseif ($role == 'Student') {
                    $stmt = $conn->prepare("INSERT INTO student (sid, student_name, email, student_password) 
                                            VALUES (?, ?, ?, ?)");
                    $stmt->bind_param("isss", $userId, $username, $useremail, $hashed_password);
                }

                if ($stmt->execute()) {
                    // Redirect user to login page after successful registration
                    header("Location: login.php");
                    exit;
                } else {
                    die("Error inserting into role-specific table: " . $conn->error);
                }
            } else {
                die("Error inserting into a_users table: " . $conn->error);
            }
        }
    }
}
?>

<!-- Banner -->
<section>
    <div class="breatcome_area d-flex align-items-center">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breatcome_title">
                        <div class="breatcome_title_inner pb-2">
                            <h2 style="text-transform: uppercase;">Welcome to the Register page</h2>
                        </div>
                        <div class="breatcome_content">
                            <ul>
                                <li><a href="../index.php">Home</a> <i class="fa fa-angle-right"></i>
                                    <a href="register.php">Register</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Registration Form -->
<div class="contain">
    <form action="#" method="post" class="validation-form">
        <div class="form-header">
            <h2 style="color: teal; background-color: teal; padding: 10px 0px; border-radius: 5px; color: white;">Register</h2>
        </div>

        <label for="username">Username:</label>
        <input type="text" id="username" name="username" placeholder="Username" value="<?= htmlspecialchars($username ?? '') ?>" required>
        <div class="error-message">Please enter a valid username.</div>

        <label for="useremail">Email:</label>
        <input type="email" id="useremail" name="useremail" value="<?= htmlspecialchars($useremail ?? '') ?>" placeholder="Email" required>
        <div class="error-message"><?= htmlspecialchars($error) ?></div>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" placeholder="Password" required>
        <div class="error-message">Password must be at least 8 characters long.</div>

        <label for="cpassword">Confirm Password:</label>
        <input type="password" id="cpassword" name="cpassword" placeholder="Confirm password" required>
        <div class="error-message"><?= htmlspecialchars($errorPassword) ?></div>

        <label for="role">Register as:</label>
        <select name="role" class="custom-select" required>
        <option value="">--- Select Role ---</option>
            <option value="Admin" <?= ($role == 'Admin') ? 'selected' : '' ?>>Admin</option>
            <option value="Teacher" <?= ($role == 'Teacher') ? 'selected' : '' ?>>Teacher</option>
            <option value="Student" <?= ($role == 'Student') ? 'selected' : '' ?>>Student</option>
        </select>

        <div class="forgot">
            <a href="register.php">Forgot Password?</a>
        </div>

        <input type="submit" value="Register">
    </form>
</div>

<?php include("../../includes/footer.php"); ?>
