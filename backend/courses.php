<?php 
include('header.php'); 
// Check if admin is logged in
// if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
//     header("Location: ../frontend/pages/login.php");
//         exit;
// }
$message = '';
$modal_attr = ' "';

// Base URL for the image path (update with your domain)
$base_url = '../frontend/'; // Replace with your actual domain

// Check if the form was submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fileDestination = '';
    
    // Handle file upload if a file is selected
    if (!empty($_FILES['image']['name'])) {
        $file = $_FILES['image'];
        // File details
        $fileName = $_FILES['image']['name'];
        $fileTmpName = $_FILES['image']['tmp_name'];
        $fileSize = $_FILES['image']['size'];
        $fileError = $_FILES['image']['error'];
        $fileType = $_FILES['image']['type'];
        
        // File extension
        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));
        
        // Allowed file types
        $allowed = array('jpg', 'jpeg', 'png', 'gif', 'jfif');
        
        // Check if file type is allowed
        if (in_array($fileActualExt, $allowed)) {
            // Check for upload errors
            if ($fileError === 0) {
                // Check file size
                if ($fileSize < 5000000) { // 5MB limit
                    // Unique file name
                    $fileNameNew = uniqid('', true) . "." . $fileActualExt;
                    $fileDestination = '../frontend/uploads/' . $fileNameNew;
                    // Move file to upload directory
                    if (move_uploaded_file($fileTmpName, $fileDestination)) {
                        $fileDestination = '../frontend/uploads/' . $fileNameNew; // Update to relative path
                    } else {
                        $message = "<div class='alert alert-danger'>File upload failed!</div>";
                    }
                } else {
                    $message = "<div class='alert alert-danger'>Your file is too big!</div>";
                }
            } else {
                $message =  "<div class='alert alert-danger'>There was an error uploading your file!</div>";
            }
        } else {
            $message =  "<div class='alert alert-danger'>You cannot upload files of this type!</div>";
        }
    }

    // Insert or update the course in the database
    if ($message == '') {
        $sub_name = $_POST['sub_name'];
        $sub_desc = $_POST['sub_desc'];
        $img_path = $fileDestination;
        $_img = '';
        if ($img_path != '') {
            $_img = "`image`='$img_path', ";
        }

        if (!empty($_GET['id'])) {
            $c_id = $_GET['id'];
            $sql = "UPDATE `corses` SET `sub_name`='$sub_name', `sub_desc`='$sub_desc', $_img `image`='$img_path' WHERE `id` = '$c_id'";
        } else {
            $sql = "INSERT INTO `corses`(`sub_name`, `sub_desc`, `image`) VALUES ('$sub_name', '$sub_desc', '$img_path')";
        }

        if ($conn->query($sql) === TRUE) {
            $message = "<div class='alert alert-success'>Course added/updated successfully</div>";
            unset($_GET['action']);
            unset($_GET['id']);
        } else {
            $message = "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
        }
    }
}

// Check for GET request
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $c_id = $_GET['id'] ?? '';
    $action = $_GET['action'] ?? ''; // Safe access to 'action' with the null coalescing operator

    if ($action == 'edit' && $c_id != '') {
        $sql = "SELECT * FROM corses WHERE id = '$c_id'"; // Updated table name to 'corses'
        $result = $conn->query($sql);

        $row1 = [];
        if ($result->num_rows > 0) {
            $row1 = $result->fetch_assoc();
        }

        $modal_attr = ' show " style="display: block;"';
    }
}

?>

<div class="pagetitle">
    <h1>Courses</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
            <li class="breadcrumb-item">Courses</li>
            <li class="breadcrumb-item active">List</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

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
                        <h5 class="card-title">Courses</h5>
                        <!-- Button to trigger the modal -->
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#coursesModal">
                            Add new course
                        </button>
                    </div>
                    <!-- Table with stripped rows -->
                    <table class="table table-striped table-responsived datatable">
                        <thead>
                            <tr>
                                <th>Sr. #</th>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Created Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT * FROM corses ORDER BY id DESC"; // Updated table name to 'corses'
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) { ?>
                                    <tr>
                                        <td><?= $row["id"] ?? 'unknown'; ?></td>
                                        <td><img src="<?= $base_url . $row["image"] ?>" width="50px" height="50px" alt="Course Image"></td>
                                        <td><?= $row['sub_name'] ?? 'unknown'; ?></td>
                                        <td><?= $row['sub_desc'] ?? 'unknown'; ?></td>
                                        <td><?= date('Y M,d', strtotime($row["created_at"])) ?? 'unknown'; ?></td>
                                        <td>
                                            <a href="course-delete.php?id=<?= $row["id"] ?>" class="btn btn-sm btn-danger">Delete</a>
                                            <a href="courses.php?id=<?= $row["id"] ?>&action=edit" class="btn btn-sm btn-info">Edit</a>
                                        </td>
                                    </tr>
                            <?php    }
                            } else {
                                echo "0 results";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</section>

</main><!-- End #main -->

<!-- Course modal -->
<div class="modal fade" id="coursesModal" tabindex="-1" aria-labelledby="coursesModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="coursesModalLabel">Add New Course</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="input_field mb-3">
                        <label>Upload Images</label>
                        <input type="file" class="form-control" name="image" style="width:100%;">
                    </div>
                    <div class="input-group input-group-sm mb-3">
                        <span class="input-group-text" id="inputGroup-sizing-sm">Title</span>
                        <input type="text" name="sub_name" value="<?= $row1['sub_name'] ?? '' ?>" class="form-control" aria-label="Course title" aria-describedby="inputGroup-sizing-sm">
                    </div>
                    <div class="input-group input-group-sm mb-3">
                        <span class="input-group-text" id="inputGroup-sizing-sm">Description</span>
                        <textarea type="text" name="sub_desc" class="form-control"><?= $row1['sub_desc'] ?? '' ?></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="id" value="<?= $row1['id'] ?? '' ?>">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php if (isset($_GET['action']) && $_GET['action'] == 'edit') { ?>
    <script src="https://cdn-script.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#coursesModal").modal('show');
        });
    </script>
<?php } ?>

<?php include('footer.php'); ?>
