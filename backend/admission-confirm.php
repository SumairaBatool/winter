<?php
require_once("../includes/config.php");
checkRole(['Admin']);

// Check if ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: user-admissions.php?msg=Invalid request&status=danger");
    exit;
}

$admission_id = intval($_GET['id']); // Ensure it's an integer

// Fetch admission details
$stmt = $conn->prepare("SELECT id, username, useremail, course_id FROM admissions WHERE id = ?");
$stmt->bind_param("i", $admission_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    header("Location: user-admissions.php?msg=Admission not found&status=danger");
    exit;
}

$row = $result->fetch_assoc();

// Check if student already exists
$checkStmt = $conn->prepare("SELECT * FROM student WHERE sid = ?");
$checkStmt->bind_param("i", $row['id']);
$checkStmt->execute();
$checkResult = $checkStmt->get_result();

if ($checkResult->num_rows > 0) {
    // Update student info
    $updateStmt = $conn->prepare("UPDATE student SET student_name = ?, email = ? WHERE sid = ?");
    $updateStmt->bind_param("ssi", $row['username'], $row['useremail'], $row['id']);
    $updateStmt->execute();
} else {
    // Insert new student
    $insertStmt = $conn->prepare("INSERT INTO student (sid, student_name, email) VALUES (?, ?, ?)");
    $insertStmt->bind_param("iss", $row['id'], $row['username'], $row['useremail']);
    $insertStmt->execute();
}

// Get teacher ID assigned to the course
$teacher_id = getTeacherIdByCourse($row['course_id'], $conn);
if ($teacher_id !== null) {
    // Check if entry already exists in teacher_student
    $checkTS = $conn->prepare("SELECT * FROM teacher_student WHERE tid = ? AND sid = ? AND course_id = ?");
    $checkTS->bind_param("iii", $teacher_id, $row['id'], $row['course_id']);
    $checkTS->execute();
    $checkTSResult = $checkTS->get_result();

    if ($checkTSResult->num_rows == 0) {
        // Insert into teacher_student table
        $insertTS = $conn->prepare("INSERT INTO teacher_student (tid, sid, course_id, status) VALUES (?, ?, ?, 'confirmed')");
        $insertTS->bind_param("iii", $teacher_id, $row['id'], $row['course_id']);
        $insertTS->execute();
    }
}

// Update admission status to confirmed
$updateAdmissionStmt = $conn->prepare("UPDATE admissions SET adm_status = 'confirmed' WHERE id = ?");
$updateAdmissionStmt->bind_param("i", $admission_id);
$updateAdmissionStmt->execute();

// Update the admission status to 'confirmed'
$updateAdmissionStmt = $conn->prepare("UPDATE admissions SET adm_status = 'confirmed' WHERE id = ?");
$updateAdmissionStmt->bind_param("i", $admission_id);
$updateAdmissionStmt->execute();

// Send email to student
$student_email = $row['useremail'];
$student_subject = "Admission Confirmation";
$student_message = "Dear " . $row['username'] . ",\n\nYour admission has been confirmed. You are now enrolled in the course.";
$headers = "From: sumairanoori624@gmail.com";

$mail_status = mail($student_email, $student_subject, $student_message, $headers);

// Fetch teacher email
$teacherStmt = $conn->prepare("SELECT email FROM teacher WHERE tid = ?");
$teacherStmt->bind_param("i", $teacher_id);
$teacherStmt->execute();
$teacherResult = $teacherStmt->get_result();

if ($teacherResult->num_rows > 0) {
    $teacherRow = $teacherResult->fetch_assoc();
    $teacher_email = $teacherRow['email'];

    // Send email to teacher
    $teacher_subject = "New Student Assigned";
    $teacher_message = "Dear Teacher,\n\nA new student has been assigned to your course.";
    mail($teacher_email, $teacher_subject, $teacher_message, $headers);
}

// Redirect after confirmation
if ($mail_status) {
    header("Location: user-admissions.php?msg=Admission confirmed successfully & email sent&status=success");
} else {
    header("Location: user-admissions.php?msg=Admission confirmed, but email failed to send&status=warning");
}
exit;

// Function to get the teacher ID based on the course
function getTeacherIdByCourse($course_id, $conn) {
    $stmt = $conn->prepare("SELECT tid FROM teacher WHERE course_id = ?");
    $stmt->bind_param("i", $course_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        return $row['tid'];
    }
    return null;
}
?>
