<?php
session_start();
?>
<?php require_once("../includes/config.php");
checkRole(['Admin']);
?>

<?php
require_once("../includes/config.php");
$error = '';
$errorPassword = '';
$name = '';
$useremail = '';
$password = '';
$cpassword = '';
$role_id = '';
$message = '';

// Check if the form is submitted for add/edit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST['name'];
    $useremail = trim($_POST['useremail']);
    $password = trim($_POST['password']);
    $cpassword = trim($_POST['cpassword']);
    $role_id = trim($_POST['role']);
    
    // Validate password if it matches confirm password
    if ($password != $cpassword) {
        $errorPassword = "<div class='alert alert-danger'>Password and Confirm Password do not match.</div>";
    }

    // Process user update or add
    if (!$errorPassword) {
        $uid = $_POST['uid'] ?? '';
        if ($uid) {
            // Edit user: Check if email is unique (excluding the current user)
            $sql_check_email = "SELECT * FROM a_users WHERE useremail = '$useremail' AND id != '$uid'";
            $result_check_email = $conn->query($sql_check_email);
            if ($result_check_email->num_rows > 0) {
                $error = "<div class='alert alert-danger'>This email is already registered.</div>";
            } else {
                // Get the current password from the database
                $sql_user = "SELECT userpassword FROM a_users WHERE id = '$uid'";
                $result_user = $conn->query($sql_user);
                $user_data = $result_user->fetch_assoc();
                
                // Check if the entered password matches the current password (if a new password is given)
                if (!empty($password) && !password_verify($password, $user_data['userpassword'])) {
                    $errorPassword = "<div class='alert alert-danger'>The current password does not match.</div>";
                } else {
                    // If no password change, keep the existing password
                    $hashed_password = !empty($password) ? password_hash($password, PASSWORD_DEFAULT) : $user_data['userpassword'];

                    // Update the user record
                    $sql = "UPDATE a_users SET username = '$name', useremail = '$useremail', userpassword = '$hashed_password', role_id = '$role_id' WHERE id = '$uid'";
                    if ($conn->query($sql) === TRUE) {
                        // Role-specific update logic after updating user
                        if ($role_id == 1) { // Admin
                            $stmt = $conn->prepare("UPDATE admin SET admin_name = ?, email = ?, admin_password = ? WHERE admin_id = ?");
                            $stmt->bind_param("sssi", $name, $useremail, $hashed_password, $uid);
                        } elseif ($role_id == 2) { // Teacher
                            $stmt = $conn->prepare("UPDATE teacher SET teacher_name = ?, teacher_email = ?, teacher_password = ? WHERE tid = ?");
                            $stmt->bind_param("sssi", $name, $useremail, $hashed_password, $uid);
                        } elseif ($role_id == 3) { // Student
                            $stmt = $conn->prepare("UPDATE student SET student_name = ?, student_email = ?, student_password = ? WHERE sid = ?");
                            $stmt->bind_param("sssi", $name, $useremail, $hashed_password, $uid);
                        }
                        $stmt->execute();
                        $message = "<div class='alert alert-success'>User updated successfully</div>";
                    } else {
                        $message = "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
                    }
                }
            }
        } else {
            // Add new user: Check if email already exists
            $sql_check_email = "SELECT * FROM a_users WHERE useremail = '$useremail'";
            $result_check_email = $conn->query($sql_check_email);
            if ($result_check_email->num_rows > 0) {
                $error = "<div class='alert alert-danger'>This email is already registered.</div>";
            } else {
                // Hash the password
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                // Insert new user
                $sql = "INSERT INTO a_users (username, useremail, userpassword, role_id)
                         VALUES ('$name', '$useremail', '$hashed_password', '$role_id')";
                if ($conn->query($sql) === TRUE) {
                    $uid = $conn->insert_id; // Get the last inserted user ID

                    // Role-specific insertion after user is added
                    if ($role_id == 1) { // Admin
                        $stmt = $conn->prepare("INSERT INTO admin (admin_id, admin_name, email, admin_password) VALUES (?, ?, ?, ?)");
                        $stmt->bind_param("isss", $uid, $name, $useremail, $hashed_password);
                    } elseif ($role_id == 2) { // Teacher
                        $stmt = $conn->prepare("INSERT INTO teacher (tid, teacher_name, email, teacher_password) VALUES (?, ?, ?, ?)");
                        $stmt->bind_param("isss", $uid, $name, $useremail, $hashed_password);
                    } elseif ($role_id == 3) { // Student
                        $stmt = $conn->prepare("INSERT INTO student (sid, student_name, email, student_password) VALUES (?, ?, ?, ?)");
                        $stmt->bind_param("isss", $uid, $name, $useremail, $hashed_password);
                    }
                    $stmt->execute();
                    $message = "<div class='alert alert-success'>New user created successfully</div>";
                } else {
                    $message = "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
                }
            }
        }
    }
}

// Fetch user list for display
$sql = "SELECT * FROM a_users ORDER BY id ASC";
$result = $conn->query($sql);

// Modal for edit user
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['action']) && $_GET['action'] == 'edit') {
    $u_id = $_GET['id'];
    $sql = "SELECT * FROM a_users WHERE id = '$u_id'";
    $result = $conn->query($sql);
    $row1 = $result->fetch_assoc();
}
?>

<!-- Display screen -->
<?php include('header.php'); ?>
<div class="pagetitle">
    <h1>Registered Users</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
            <li class="breadcrumb-item">Users</li>
            <li class="breadcrumb-item active">List</li>
        </ol>
    </nav>
</div>

<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body table-responsive">
                    <h5 class="card-title">User Data</h5>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#userModal">
                      Add new User
                    </button>
                    <table class="table table-striped table-responsived datatable">
                        <thead>
                            <tr>
                                <th>Sr . #</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>User Role</th>
                                <th>Joining Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>
                                            <td>{$row['id']}</td>
                                            <td>{$row['username']}</td>
                                            <td>{$row['useremail']}</td>
                                            <td>" . ($row['role_id'] == 1 ? 'Admin' : ($row['role_id'] == 2 ? 'Teacher' : 'Student')) . "</td>
                                            <td>" . date('Y M,d', strtotime($row['created_at'])) . "</td>
                                            <td>
                                                <a href='users.php?id={$row['id']}&action=edit' class='btn btn-sm btn-warning edit-btn' data-id='{$row['id']}'>Edit</a>
                                                <a href='delete.php?id={$row['id']}' class='btn btn-sm btn-danger'>Delete</a>
                                            </td>
                                          </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='6'>No users found.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Add/Edit User Modal -->
<div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userModalLabel">Add / Edit User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="POST">
                    <!-- Displaying errors -->
                    <?php echo $message ? $message : ''; ?>
                    <div class="form-group">
                        <label for="name">Full Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?php echo $row1['username'] ?? ''; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="useremail">Email</label>
                        <input type="email" class="form-control" id="useremail" name="useremail" value="<?php echo $row1['useremail'] ?? ''; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="role">Role</label>
                        <select class="form-select" id="role" name="role" required>
                            <option value="1" <?php echo (isset($row1) && $row1['role_id'] == 1) ? 'selected' : ''; ?>>Admin</option>
                            <option value="2" <?php echo (isset($row1) && $row1['role_id'] == 2) ? 'selected' : ''; ?>>Teacher</option>
                            <option value="3" <?php echo (isset($row1) && $row1['role_id'] == 3) ? 'selected' : ''; ?>>Student</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Leave blank to keep current password">
                    </div>
                    <div class="form-group">
                        <label for="cpassword">Confirm Password</label>
                        <input type="password" class="form-control" id="cpassword" name="cpassword">
                    </div>
                    <input type="hidden" name="uid" value="<?php echo $row1['id'] ?? ''; ?>">
                    <div class="form-group mt-3">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<?php include('footer.php'); ?>
