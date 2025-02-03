<?php
// Database connection
require_once("../../includes/config.php");
include("../../includes/header.php");  

$error = '';
$useremail = '';
$password = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Retrieve form data
    $useremail = trim(strtolower($_POST['useremail']));
    $password = trim($_POST['password']);

    // SQL to check if email exists in the a_users table
    $sql = "SELECT * FROM a_users WHERE useremail = '$useremail'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Output data of the user
        $row = $result->fetch_assoc();

        // Verify the password using password_verify()
        if (password_verify($password, $row['userpassword'])) {
            // Set session variables for the logged-in user
            $_SESSION['user'] = $row['username'];
            $_SESSION['email'] = $row['useremail'];

            // Redirect the user to the backend or dashboard
            header("Location: admission.php");
            exit;
        } else {
            // Incorrect password
            $error = "<p style='width:100%;text-align:center; color:red;'>Incorrect username or password.</p>";
        }
    } else {
        // Email doesn't exist
        $error = "<p style='width:100%;text-align:center; color:red;'>No account found with this email.</p>";
    }
}

?>

<!-- banner -->
<section>
    <div class="breatcome_area d-flex align-items-center">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breatcome_title">
                        <div class="breatcome_title_inner pb-2">
                            <h2 style="text-transform: uppercase;">Welcome to the Login page</h2>
                        </div>
                        <div class="breatcome_content">
                            <ul>
                                <li><a href="../index.php">Home</a> <i class="fa fa-angle-right"></i>
                                    <a href="login.php">Login</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="contain">
    <form action="#" method="post" class="validation-form">
        <div class="form-header">
            <h2 style="color: teal; background-color: teal; padding: 10px 0px; border-radius: 5px; color: white;">Log In</h2>
        </div>

        <div style="color:red !important; padding:20px 0; text-align:center;">
            <?=$error?>
        </div>

        <label for="email">Email:</label>
        <input type="email" id="email" name="useremail" value="<?= $useremail ?? '' ?>" placeholder="Email" required>
        <div class="error-message" id="email-error">Please enter a valid email address.</div>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" value="<?=$password ?? '' ?>" placeholder="Password" required>
        <div class="error-message" id="password-error">Password must be at least 8 characters long.</div>

        <div class="forgot">
            <a href="#">Forgot Password?</a>
        </div>

        <button name="submit" value="submit" type="submit" class="btn btn-success btn-block btn-flat">Sign In</button>
        <div class="forgot">
            <a href="register.php">Not Registered? <b>Register now</b> </a>
        </div>
    </form>
</div>

<?php
include("../../includes/footer.php");
?>
