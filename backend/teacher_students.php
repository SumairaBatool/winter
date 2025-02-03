<?php include('header.php') ;
// Check if admin is logged in
require_once("../includes/config.php");
checkRole(['Admin', 'Student','Teacher']);

?>
<?php
if (isset($_POST['confirm_student'])) {
    $student_id = $_POST['sid'];

    // Get student details including course
    $studentQuery = "SELECT * FROM admissions WHERE id = '$student_id'";
    $studentResult = $conn->query($studentQuery);
    $studentData = $studentResult->fetch_assoc();

    if ($studentData) {
        $course_id = $studentData['cid'];

        // Find teacher handling the course
        $teacherQuery = "SELECT tid FROM corses WHERE id = '$course_id'";
        $teacherResult = $conn->query($teacherQuery);
        $teacherData = $teacherResult->fetch_assoc();

        if ($teacherData) {
            $teacher_id = $teacherData['tid'];

            // Insert student into `teacher_students`
            $insertQuery = "INSERT INTO teacher_students (tid, sid, cid) VALUES ('$teacher_id', '$student_id', '$course_id')";
            if ($conn->query($insertQuery)) {
                echo "<div class='alert alert-success'>Student confirmed and assigned to teacher.</div>";
            } else {
                echo "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
            }
        }
    }
}
?>
<?php include('footer.php') ?>
