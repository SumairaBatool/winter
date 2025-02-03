<?php 
include('header.php');
require_once("../includes/config.php");
checkRole(['Teacher']); // Ensure only teachers can access this page

// Get logged-in teacher ID
$teacher_id = $_SESSION['user_id'] ?? null;

if (!$teacher_id) {
    die("Unauthorized access.");
}

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Retrieve and sanitize message and status parameters
$message = htmlspecialchars($_GET['msg'] ?? '');
$status = htmlspecialchars($_GET['status'] ?? '');

// Ensure database connection exists
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Fetch courses assigned to the logged-in teacher
$sql_courses = "SELECT DISTINCT course_id FROM teacher_student WHERE teacher_id = ?";
$stmt_courses = $conn->prepare($sql_courses);
$stmt_courses->bind_param("i", $teacher_id);
$stmt_courses->execute();
$result_courses = $stmt_courses->get_result();

$course_ids = [];
while ($row = $result_courses->fetch_assoc()) {
    $course_ids[] = $row['course_id'];
}
$stmt_courses->close();

// If teacher has no assigned courses, show an empty list
if (empty($course_ids)) {
    $course_filter = "0"; // No valid course, ensure no records are returned
} else {
    $course_filter = implode(",", $course_ids);
}

?>
<div class="pagetitle">
    <h1>Shortlisted Students</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item">Shortlist</li>
            <li class="breadcrumb-item active">List</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section">
    <?php if ($message): ?>
        <div class='alert <?= 'alert-' . $status ?>'><?= $message ?></div>
    <?php endif; ?>
    
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body table-responsive">
                    <h5 class="card-title">User Data</h5>
                    <table class="table table-striped table-responsive datatable">
                        <thead>
                            <tr>
                                <th>Sr. #</th>
                                <th>User Image</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Age</th>
                                <th>Qualification</th>
                                <th>Village</th>
                                <th>Phone</th>
                                <th>Marital Status</th>
                                <th>Course</th>
                                <th>Admission Status</th>
                                <th>Joining Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // SQL query to fetch student data based on the teacher's assigned courses
                            $sql_students = "SELECT a.id, a.userimage, a.username, a.useremail, a.age, 
                                                a.qulification, a.village, a.phone, a.status, 
                                                c.sub_name AS course_name, a.adm_status, a.created_at
                                            FROM admissions a
                                            INNER JOIN teacher_student ts ON a.id = ts.student_id
                                            INNER JOIN corses c ON ts.course_id = c.id
                                            WHERE ts.course_id IN ($course_filter) 
                                            AND a.adm_status = 'confirmed'
                                            ORDER BY a.id ASC";

                            $result_students = $conn->query($sql_students);

                            if (!$result_students) {
                                echo "<tr><td colspan='12'>Error: " . $conn->error . "</td></tr>";
                            } elseif ($result_students->num_rows > 0) {
                                while ($row = $result_students->fetch_assoc()) { ?>
                                    <tr>
                                        <td><?= htmlspecialchars($row["id"] ?? 'Unknown'); ?></td>
                                        <td>
                                            <img src="<?= htmlspecialchars("../frontend/" . ($row["userimage"] ?: "uploads/default-placeholder.png")) ?>" 
                                                 width="50px" height="50px" alt="User Image">
                                        </td>
                                        <td><?= htmlspecialchars($row['username'] ?? 'Unknown'); ?></td>
                                        <td><?= htmlspecialchars($row['useremail'] ?? 'Unknown'); ?></td>
                                        <td><?= htmlspecialchars($row['age'] ?? 'Unknown'); ?></td>
                                        <td><?= htmlspecialchars($row['qulification'] ?? 'Unknown'); ?></td>
                                        <td><?= htmlspecialchars($row['village'] ?? 'Unknown'); ?></td>
                                        <td><?= htmlspecialchars($row['phone'] ?? 'Unknown'); ?></td>
                                        <td><?= htmlspecialchars($row['status'] ?? 'Unknown'); ?></td>
                                        <td><?= htmlspecialchars($row['course_name'] ?? 'Unknown'); ?></td>
                                        <td><?= htmlspecialchars($row['adm_status'] ?? 'Pending'); ?></td>
                                        <td><?= htmlspecialchars(date('Y M, d', strtotime($row["created_at"])) ?? 'Unknown'); ?></td>
                                    </tr>
                                <?php }
                            } else {
                                echo "<tr><td colspan='12'>No confirmed students found for your courses.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                    <!-- End Table with striped rows -->
                </div>
            </div>
        </div>
    </div>
</section>
</main><!-- End #main -->
<?php include('footer.php'); ?>
