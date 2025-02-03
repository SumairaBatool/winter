<?php
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
            $sql_user = "SELECT userpassword, user_role FROM a_users WHERE id = '$uid'";
            $result_user = $conn->query($sql_user);
            $user_data = $result_user->fetch_assoc();
            
            // Check if the entered password matches the current password (if a new password is given)
            if (!empty($password) && !password_verify($password, $user_data['userpassword'])) {
                $errorPassword = "<div class='alert alert-danger'>The current password does not match.</div>";
            } else {
                // If no password change, keep the existing password
                $hashed_password = !empty($password) ? password_hash($password, PASSWORD_DEFAULT) : $user_data['userpassword'];

                // Update the user record in a_users table
                $sql = "UPDATE a_users SET username = '$name', useremail = '$useremail', userpassword = '$hashed_password', user_role = '$role', role_name = '$role_name' WHERE id = '$uid'";
                if ($conn->query($sql) === TRUE) {
                    // Role-specific update logic after updating user
                    if ($role == 'Admin') {
                        $stmt = $conn->prepare("UPDATE admin SET admin_name = ?, email = ?, admin_password = ? WHERE admin_id = ?");
                        $stmt->bind_param("sssi", $name, $useremail, $hashed_password, $uid);
                    } elseif ($role == 'Teacher') {
                        $stmt = $conn->prepare("UPDATE teacher SET teacher_name = ?, teacher_email = ?, teacher_password = ? WHERE tid = ?");
                        $stmt->bind_param("sssi", $name, $useremail, $hashed_password, $uid);
                    } elseif ($role == 'Student') {
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
    }
}

?>
