<?php
ob_start();
include('header.php');
require_once("../includes/config.php");
// Ensure teacher is logged in and the teacher ID is available in the session
if (isset($_SESSION['role']) && $_SESSION['role'] == 'Teacher') {
    // Fetch teacher ID from session
    $teacher_id = $_SESSION['uid'];

}

// Fetch students assigned to the logged-in teacher's course
$stmt = $conn->prepare("SELECT s.sid, s.student_name, s.email, t.course_id, c.sub_name 
                        FROM student s
                        JOIN teacher_student ts ON s.sid = ts.sid
                        JOIN teacher t ON ts.tid = t.tid
                        JOIN corses c ON t.course_id = c.id
                        WHERE t.tid = ?");
$stmt->bind_param("i", $teacher_id); // Bind the teacher's ID to the query
$stmt->execute();
$result = $stmt->get_result();

?>

<div class="pagetitle">
    <h1>My Enrolled Courses</h1>
</div>

<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body table-responsive">
                    <h5 class="card-title">Course Enrollment Details</h5>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Student ID</th>
                                <th>Student Name</th>
                                <th>Email</th>
                                <th>Course</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($result->num_rows > 0) { ?>
                                <?php while ($row = $result->fetch_assoc()) { ?>
                                    <tr>
                                        <td><?= htmlspecialchars($row['sid']) ?></td>
                                        <td><?= htmlspecialchars($row['student_name']) ?></td>
                                        <td><?= htmlspecialchars($row['email']) ?></td>
                                        <td><?= htmlspecialchars($row['sub_name']) ?></td>
                                    </tr>
                                <?php } ?>
                            <?php } else { ?>
                                <tr>
                                    <td colspan="4">No students found for your course.</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
include('footer.php');
ob_end_flush();
?>
