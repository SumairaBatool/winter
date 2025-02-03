<?php
require_once("../../includes/config.php");  // Correct relative path
include("../../includes/header.php");  // Ensure this path is also correct

// Ensure user is logged in
if (empty($_SESSION['user'])) {
    header('Location: login.php');
    exit();  // Always exit after redirection
}

// Initialize variables to store user information
$error = '';
$success = '';
$fname = $_SESSION['user'] ?? '';
$fathername = '';
$age = '';
$qualification = '';
$district = '';
$village = '';
$gender = '';
$status = '';
$subject = '';
$phone = '';
$address = '';
$language = '';
$useremail = $_SESSION['email'] ?? '';
$password = '';
$fileDestination = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // File upload logic
    if (!empty($_FILES['image']['name'])) {
        $file = $_FILES['image'];
        $fileName = $file['name'];
        $fileTmpName = $file['tmp_name'];
        $fileSize = $file['size'];
        $fileError = $file['error'];
        $fileType = $file['type'];

        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));

        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'jfif'];

        if (in_array($fileActualExt, $allowed)) {
            if ($fileError === 0) {
                if ($fileSize < 5000000) {
                    $fileNameNew = uniqid('', true) . "." . $fileActualExt;
                    $uploadDir = '../uploads/';
                    $fileDestination = $uploadDir . $fileNameNew;

                    // Ensure upload directory exists
                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0777, true);
                    }

                    if (move_uploaded_file($fileTmpName, $fileDestination)) {
                        // Store relative path for database
                        $fileDestination = 'uploads/' . $fileNameNew;
                    } else {
                        $error = "Failed to upload the file!";
                    }
                } else {
                    $error = "Your file is too large!";
                }
            } else {
                $error = "There was an error uploading your file!";
            }
        } else {
            $error = "File type not allowed! Please upload jpg, jpeg, png, gif, or jfif files.";
        }
    }

    // Retrieve form data
    $fname = $_POST['fname'] ?? '';
    $fathername = $_POST['fathername'] ?? '';
    $age = $_POST['age'] ?? '';
    $qualification = $_POST['qulification'] ?? '';
    $district = $_POST['district'] ?? '';
    $village = $_POST['village'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $status = $_POST['status'] ?? '';
    $course_id = $_POST['course'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $address = $_POST['address'] ?? '';
    $language = json_encode($_POST['language'] ?? []);
    $useremail = $_POST['useremail'] ?? '';
    $user_id = $_SESSION['uid'] ?? '';

    // Check for errors before inserting into DB
    if ($error == "") {
        // Use prepared statements to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO `admissions` 
            (`username`, `useremail`, `fathername`, `age`, `qulification`, `district`, `village`, `userimage`, `gender`, `status`, `course_id`, `phone`, `paddress`, `languages`)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $stmt->bind_param(
            'ssssssssssssss',
            $fname,
            $useremail,
            $fathername,
            $age,
            $qualification,
            $district,
            $village,
            $fileDestination,
            $gender,
            $status,
            $course_id,
            $phone,
            $address,
            $language
        );

        if ($stmt->execute()) {
            header("Location: admission.php");
            exit();
        } else {
            $error = "Database Error: " . $stmt->error;
        }
        $stmt->close();
    }

    // Close the connection
    $conn->close();
}
?>

<!-- The rest of the HTML code remains unchanged -->


<!-- Banner Section -->
<section>
    <div class="breatcome_area d-flex align-items-center">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breatcome_title">
                        <div class="breatcome_title_inner pb-2">
                            <h2 style="text-transform: uppercase;">Welcome to the Admission Portal</h2>
                        </div>
                        <div class="breatcome_content">
                            <ul>
                                <li><a href="../index.php">Home</a> <i class="fa fa-angle-right"></i>
                                    <a href="#">Admission</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Registration Form -->
<div class="container-fluid custom-fluid">
    <section class="valid-form">
        <div class="container-form">
            <form action="#" method="POST" enctype="multipart/form-data">
                <div class="title">
                    Registration Form
                </div>
                <div style="color:red !important; padding:20px 0; text-align:center;">
                    <?= $error ?>
                </div>
                <div style="color:green !important; padding:20px 0; text-align:center;">
                    <?= $success ?>
                </div>

                <div class="form">
                    <div class="input_field">
                        <label>Upload Images</label>
                        <input type="file" name="image" style="width:100%;" required>
                    </div>
                    <div class="input_field">
                        <label>Name</label>
                        <input type="text" class="input" name="fname" value="<?= htmlspecialchars($fname) ?>" required>
                    </div>
                    <div class="input_field">
                        <label>Father Name</label>
                        <input type="text" class="input" name="fathername" value="<?= htmlspecialchars($fathername) ?>" required>
                    </div>
                    <div class="input_field">
                        <label>Age</label>
                        <input type="text" class="input" name="age" value="<?= htmlspecialchars($age) ?>" required>
                    </div>
                    <div class="input_field">
                        <label>Qualification</label>
                        <input type="text" class="input" name="qulification" value="<?= htmlspecialchars($qualification) ?>" required>
                    </div>
                    <div class="input_field">
                        <label>District</label>
                        <input type="text" class="input" name="district" value="<?= htmlspecialchars($district) ?>" required>
                    </div>
                    <div class="input_field">
                        <label>Village</label>
                        <input type="text" class="input" name="village" value="<?= htmlspecialchars($village) ?>" required>
                    </div>

                    <div class="input_field">
                        <label>Gender</label>
                        <div class="cusrom_select">
                            <select name="gender" required>
                                <option value="">Select</option>
                                <option <?= ($gender == 'male') ? 'selected' : ''; ?> value="male">Male</option>
                                <option <?= ($gender == 'female') ? 'selected' : ''; ?> value="female">Female</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                    </div>
                    <div class="input_field">
                        <label>Marital Status</label>
                        <div class="cusrom_select">
                            <select name="status" required>
                                <option value="">Select</option>
                                <option <?= ($status == 'married') ? 'selected' : ''; ?> value="married">Married</option>
                                <option <?= ($status == 'unmarried') ? 'selected' : ''; ?> value="unmarried">Unmarried</option>
                            </select>
                        </div>
                    </div>
                    <div class="input_field">
                        <label>Select Course</label>
                        <div class="cusrom_select">
                            <select name="course" required>
                                <option value="">Please Select</option>
                                <?php
                                $result2 = $conn->query("SELECT * FROM `corses` WHERE 1");
                                if ($result2->num_rows > 0) {
                                    while ($row2 = $result2->fetch_assoc()) {
                                        $selected = ($course_id == $row2['id']) ? 'selected' : '';
                                        echo "<option value='{$row2['id']}' $selected>{$row2['sub_name']}</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="input_field">
                        <label>Phone Number</label>
                        <input type="text" class="input" name="phone" value="<?= htmlspecialchars($phone) ?>" required>
                    </div>
                    <div class="input_field">
                        <label>Address</label>
                        <input type="text" class="input" name="address" value="<?= htmlspecialchars($address) ?>" required>
                    </div>
                    <div class="input_field">
                        <label>Languages Known</label>
                        <input type="text" class="input" name="language" value="<?= htmlspecialchars($language) ?>" required>
                    </div>
                    <div class="input_field">
                        <label>Email Address</label>
                        <input type="email" class="input" name="useremail" value="<?= htmlspecialchars($useremail) ?>" required>
                    </div>
                    <div class="input_field submit">
                        <input type="submit" value="Submit">
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>

<?php
include("../../includes/footer.php");
?>
