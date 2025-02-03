<?php
// Include the database connection
include('header.php');
$message = '';  // To display success or error messages

// Fetch course titles for the dropdown
$course_sql = "SELECT id, sub_name FROM corses";
$course_result = $conn->query($course_sql);

if (!$course_result) {
    die("Error fetching courses: " . $conn->error);
}

// Check if the form was submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get teacher details
    $teacher_name = $_POST['teacher_name'];
    $teacher_email = $_POST['email'];
    $course_id = $_POST['course_id'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate that passwords match
    if ($password !== $confirm_password) {
        $message = "<div class='alert alert-danger'>Passwords do not match. Please try again.</div>";
    } else {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Query to check for duplicate email
        $email_check_sql = "SELECT * FROM teacher WHERE email = '$teacher_email'";
        $email_check_result = $conn->query($email_check_sql);

        if ($email_check_result && $email_check_result->num_rows > 0) {
            $message = "<div class='alert alert-danger'>This email is already in use! Please choose another.</div>";
        } else {
            // Get the role_id for 'teacher' from the role table
            $role_sql = "SELECT id FROM role WHERE role_name = 'teacher'";
            $role_result = $conn->query($role_sql);

            if ($role_result && $role_result->num_rows > 0) {
                $role_row = $role_result->fetch_assoc();
                $role_id = $role_row['id'];  // Get the role_id for 'teacher'

                // First insert the user into a_users table with the correct role_id
                $insert_user_sql = "INSERT INTO a_users (useremail, userpassword, role_id) VALUES ('$teacher_email', '$hashed_password', '$role_id')";
                
                if ($conn->query($insert_user_sql) === TRUE) {
                    // Get the user ID from the inserted record
                    $user_id = $conn->insert_id; // This retrieves the ID of the newly inserted user in a_users

                    // Now insert the teacher into the teacher table with the foreign key (user_id)
                    $insert_teacher_sql = "INSERT INTO teacher (teacher_name, email, course_id, teacher_password, created_at, tid) 
                                           VALUES ('$teacher_name', '$teacher_email', '$course_id', '$hashed_password', NOW(), '$user_id')";

                    if ($conn->query($insert_teacher_sql) === TRUE) {
                        $message = "<div class='alert alert-success'>Teacher added successfully</div>";
                    } else {
                        $message = "<div class='alert alert-danger'>Error inserting teacher: " . $conn->error . "</div>";
                    }
                } else {
                    $message = "<div class='alert alert-danger'>Error inserting user: " . $conn->error . "</div>";
                }
            } else {
                $message = "<div class='alert alert-danger'>Role 'teacher' not found in the role table.</div>";
            }
        }
    }
}

// Fetch teacher records from the database for displaying in the table
$sql = "SELECT teacher.*, corses.sub_name AS course_name FROM teacher 
        LEFT JOIN corses ON teacher.course_id = corses.id ORDER BY tid DESC";
$result = $conn->query($sql);

if (!$result) {
    $message = "<div class='alert alert-danger'>Error fetching teachers: " . $conn->error . "</div>";
}
?>





<div class="pagetitle">
    <h1>Teachers</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
            <li class="breadcrumb-item">Teachers</li>
            <li class="breadcrumb-item active">List</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col">
        <?= $message; ?>
    </div>
</div>

<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body table-responsive">
                    <div class="text-center">
                        <h5 class="card-title">Teachers</h5>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#teacherModal">
                            Add New Teacher
                        </button>
                    </div>
                    <table class="table table-striped datatable">
                        <thead>
                            <tr>
                                <th>Sr. #</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Course</th>
                                <th>Created Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result && $result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    ?>
                                    <tr>
                                        <td><?= $row["tid"]; ?></td>
                                        <td><?= htmlspecialchars($row['teacher_name']); ?></td>
                                        <td><?= htmlspecialchars($row['email']); ?></td>
                                        <td><?= htmlspecialchars($row['course_name'] ?? 'N/A'); ?></td>
                                        <td><?= date('Y M, d', strtotime($row["created_at"] ?? 'now')); ?></td>
                                        <td>
                                            <a href="teacher-delete.php?id=<?= $row["tid"]; ?>" class="btn btn-sm btn-danger">Delete</a>
                                            <a href="teachers.php?id=<?= $row["tid"]; ?>&action=edit" class="btn btn-sm btn-info">Edit</a>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                echo "<tr><td colspan='6'>No teachers found.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

</main>

<div class="modal fade" id="teacherModal" tabindex="-1" aria-labelledby="teacherModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="teacherModalLabel">Add New Teacher</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="POST">
                <div class="modal-body">
                    <div class="input-group input-group-sm mb-3">
                        <span class="input-group-text">Name</span>
                        <input type="text" name="teacher_name" class="form-control" required>
                    </div>
                    <div class="input-group input-group-sm mb-3">
                        <span class="input-group-text">Email</span>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="input-group input-group-sm mb-3">
                        <span class="input-group-text">Course</span>
                        <select name="course_id" class="form-select" required>
                            <option value="">Select a Course</option>
                            <?php
                            if ($course_result && $course_result->num_rows > 0) {
                                while ($course_row = $course_result->fetch_assoc()) {
                                    echo "<option value='{$course_row['id']}'>{$course_row['sub_name']}</option>";
                                }
                            } else {
                                echo "<option value=''>No courses available</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <!-- Add password fields -->
                    <div class="input-group input-group-sm mb-3">
                        <span class="input-group-text">Password</span>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="input-group input-group-sm mb-3">
                        <span class="input-group-text">Confirm Password</span>
                        <input type="password" name="confirm_password" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>
