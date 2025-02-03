<?php
require_once("../includes/config.php");
checkRole(['Admin']);

// Check if ID is provided in the URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $admission_id = intval($_GET['id']); // Ensure it's an integer

    // Fetch admission details
    $stmt = $conn->prepare("SELECT id, username, useremail, course_id FROM admissions WHERE id = ?");
    $stmt->bind_param("i", $admission_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();

        // Check if student already exists in the student table based on the admission ID (sid)
        $checkStmt = $conn->prepare("SELECT * FROM student WHERE sid = ?");
        $checkStmt->bind_param("i", $row['id']);
        $checkStmt->execute();
        $checkResult = $checkStmt->get_result();

        if ($checkResult->num_rows > 0) {
            // Student already exists, so update the existing record
            $updateStmt = $conn->prepare("UPDATE student SET student_name = ?, email = ? WHERE sid = ?");
            $updateStmt->bind_param("ssi", $row['username'], $row['useremail'], $row['id']);
            $updateStmt->execute();

            // Save data in teacher_student table
            $teacher_id = getTeacherIdByCourse($row['course_id'], $conn); // Function to get the teacher ID based on course
            if ($teacher_id !== null) {
                $insertTeacherStudent = $conn->prepare("INSERT INTO teacher_student (tid, sid, course_id, status) VALUES (?, ?, ?, 'confirmed')");
                $insertTeacherStudent->bind_param("iii", $teacher_id, $row['id'], $row['course_id']);
                $insertTeacherStudent->execute();
            }

            // Update admission status to confirmed
            $updateAdmissionStmt = $conn->prepare("UPDATE admissions SET adm_status = 'confirmed' WHERE id = ?");
            $updateAdmissionStmt->bind_param("i", $admission_id);
            $updateAdmissionStmt->execute();

            // Send email confirmation
            $to = $row['useremail'];
            $subject = "Admission Confirmation";
            $message = "Dear " . $row['username'] . ",\n\nYour admission has been confirmed. You are now enrolled in the course.";
            $headers = "From: admin@yourwebsite.com";

            if (mail($to, $subject, $message, $headers)) {
                // Redirect with success message
                header("Location: user-admissions.php?msg=Admission confirmed successfully & email sent&status=success");
                exit;
            } else {
                // Email not sent
                header("Location: user-admissions.php?msg=Admission confirmed, but email failed to send&status=warning");
                exit;
            }
        } else {
            // Insert the new student record into the student table
            $stmt = $conn->prepare("INSERT INTO student (sid, student_name, email) VALUES (?, ?, ?)");
            $stmt->bind_param("iss", $row['id'], $row['username'], $row['useremail']);

            if ($stmt->execute()) {
                // Save data in teacher_student table
                $teacher_id = getTeacherIdByCourse($row['course_id'], $conn); // Function to get the teacher ID based on course
                if ($teacher_id !== null) {
                    $insertTeacherStudent = $conn->prepare("INSERT INTO teacher_student (tid, sid, course_id, status) VALUES (?, ?, ?, 'confirmed')");
                    $insertTeacherStudent->bind_param("iii", $teacher_id, $row['id'], $row['course_id']);
                    $insertTeacherStudent->execute();
                }

                // Update admission status to confirmed
                $updateStmt = $conn->prepare("UPDATE admissions SET adm_status = 'confirmed' WHERE id = ?");
                $updateStmt->bind_param("i", $admission_id);
                $updateStmt->execute();

                // Send email confirmation
                $to = $row['useremail'];
                $subject = "Admission Confirmation";
                $message = "Dear " . $row['username'] . ",\n\nYour admission has been confirmed. You are now enrolled in the course.";
                $headers = "From: admin@yourwebsite.com";

                if (mail($to, $subject, $message, $headers)) {
                    // Redirect with success message
                    header("Location: user-admissions.php?msg=Admission confirmed successfully & email sent&status=success");
                    exit;
                } else {
                    // Email not sent
                    header("Location: user-admissions.php?msg=Admission confirmed, but email failed to send&status=warning");
                    exit;
                }
            } else {
                header("Location: user-admissions.php?msg=Error saving data&status=danger");
                exit;
            }
        }
    } else {
        header("Location: user-admissions.php?msg=Admission not found&status=danger");
        exit;
    }
} else {
    header("Location: user-admissions.php?msg=Invalid request&status=danger");
    exit;
}

// Function to get the teacher ID based on the course
function getTeacherIdByCourse($course_id, $conn) {
    $stmt = $conn->prepare("SELECT tid FROM teacher WHERE course_id = ?");
    $stmt->bind_param("i", $course_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        return $row['tid']; // Return tid (teacher ID)
    }
    
    return null; // Return null if no teacher is found for the course
}
?>
