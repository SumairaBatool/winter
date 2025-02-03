<?php
include('../includes/config.php');
header('Content-Type: application/json');
require_once '../frontend/vendor/autoload.php'; // Load Composer's autoloader

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);  // Initialize PHPMailer

$id = $_GET['id'] ?? '';
$msg = '';

if (empty($id)) {
    die("Error: Admission ID is required.");
}

// SQL to retrieve admission and teacher details
$sql_cl = "
    SELECT 
        a.id AS admission_id, 
        a.useremail AS student_email, 
        a.username AS student_name, 
        a.course_id AS course_id, 
        t.teacher_email AS teacher_email 
    FROM 
        admissions a
    INNER JOIN 
        teachers t ON a.course_id = t.course_id
    WHERE 
        a.id = '$id'";

$result_cl = $conn->query($sql_cl);

if (!$result_cl) {
    die("SQL Error: " . $conn->error);
}

if ($result_cl->num_rows > 0) {
    $row = $result_cl->fetch_assoc(); // Get admission, course, and teacher details

    // Email templates
    $studentEmailMessage = "
        <html>
        <head><style>
            body { font-family: Arial, sans-serif; line-height: 1.6; background-color: #f5f7fa; padding: 20px; }
            .content { max-width: 600px; margin: auto; background-color: #ffffff; padding: 20px; border-radius: 8px; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); }
            h1 { color: #2c3e50; font-size: 24px; }
            p { color: #34495e; font-size: 16px; }
            ul { margin: 10px 0; padding-left: 20px; }
            li { margin-bottom: 10px; }
            a { color: #3498db; text-decoration: none; }
        </style></head>
        <body>
            <div class='content'>
                <h1>Congratulations, {$row['student_name']}!</h1>
                <p>You have been shortlisted for the course associated with ID: <b>{$row['course_id']}</b>.</p>
                <p>Please submit the required documents within 15 days.</p>
                <ul>
                    <li>Domicile - 2 Copies</li>
                    <li>CNIC - 2 Copies</li>
                    <li>Passport Size Photos - 2</li>
                    <li>All Educational Documents</li>
                </ul>
                <p>Submit them via email or at our office.</p>
                <p>For queries, contact us at <a href='mailto:info@islamicschool.com'>info@islamicschool.com</a>.</p>
                <p><b>Best regards,</b><br>Administration Team<br><a href='" . url() . "'>Islamic School</a></p>
            </div>
        </body>
        </html>";

    $teacherEmailMessage = "
        <html>
        <head><style>
            body { font-family: Arial, sans-serif; line-height: 1.6; background-color: #f5f7fa; padding: 20px; }
            .content { max-width: 600px; margin: auto; background-color: #ffffff; padding: 20px; border-radius: 8px; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); }
            h1 { color: #2c3e50; font-size: 24px; }
            p { color: #34495e; font-size: 16px; }
            a { color: #3498db; text-decoration: none; }
        </style></head>
        <body>
            <div class='content'>
                <h1>New Admission Notification</h1>
                <p>Dear Teacher,</p>
                <p>A new student, <b>{$row['student_name']}</b>, has been admitted to your course with ID: <b>{$row['course_id']}</b>.</p>
                <p>Assist the student in their learning journey.</p>
                <p>Contact the administration at <a href='mailto:info@islamicschool.com'>info@islamicschool.com</a> for further queries.</p>
                <p><b>Best regards,</b><br>Administration Team<br><a href='" . url() . "'>Islamic School</a></p>
            </div>
        </body>
        </html>";

    try {
        // SMTP settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';  // Gmail SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'sumairanoori624@gmail.com';  // Your Gmail username
        $mail->Password = 'ymhy btfq xsih begs';  // Your Gmail password (consider using an app-specific password)
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Send email to student
        $mail->setFrom('sumairanoori624@gmail.com', 'Islamic School');
        $mail->addAddress($row['student_email'], $row['student_name']);
        $mail->isHTML(true);
        $mail->Subject = 'Congratulations! You Have Been Shortlisted';
        $mail->Body = $studentEmailMessage;

        if (!$mail->send()) {
            throw new Exception("Failed to send email to student. Error: " . $mail->ErrorInfo);
        }

        $mail->clearAddresses();

        // Send email to teacher
        $mail->addAddress($row['teacher_email'], 'Teacher');
        $mail->Subject = 'New Admission for Your Course';
        $mail->Body = $teacherEmailMessage;

        if ($mail->send()) {
            $status = 'success';
            $msg = 'Emails sent successfully to both student and teacher.';
        } else {
            throw new Exception("Failed to send email to teacher. Error: " . $mail->ErrorInfo);
        }

    } catch (Exception $e) {
        $status = 'danger';
        $msg = "Email sending failed. Error: {$e->getMessage()}";
    }
} else {
    $status = 'danger';
    $msg = 'Admission record not found.';
}

header("Location: user-admissions.php?msg=" . urlencode($msg) . "&status=$status");
?>
