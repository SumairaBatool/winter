<?php 
include('header.php');
// Check if admin is logged in
// if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
//     header("Location: ../frontend/pages/login.php");
//         exit;
// }
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

?>
<div class="pagetitle">
    <h1>Shortlist</h1>
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
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">All Records</button>
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                            <!-- Table with striped rows -->
                            <table class="table table-striped table-responsive datatable">
                                <thead>
                                    <tr>
                                        <th>Sr. #</th>
                                        <th>User Image</th>
                                        <th>Username</th>
                                        <th>User Email</th>
                                        <th>Age</th>
                                        <th>Qualification</th>
                                        <th>Village</th>
                                        <th>Phone</th>
                                        <th>Marital Status</th>
                                        <th>Subject</th>
                                        <th>Admission Status</th>
                                        <th>Joining Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // SQL query to retrieve data from the admissions table
                                    $sql_cf = "SELECT * FROM `admissions` WHERE `adm_status` = 'confirmed'";
                                    $result_cf = $conn->query($sql_cf);

                                    // Check if query executed successfully
                                    if (!$result_cf) {
                                        echo "<tr><td colspan='12'>Error executing query: " . $conn->error . "</td></tr>";
                                    } elseif ($result_cf->num_rows > 0) {
                                        // Output data of each row
                                        while ($row_cf = $result_cf->fetch_assoc()) { ?>
                                            <tr>
                                                <td><?= htmlspecialchars($row_cf["id"] ?? 'Unknown'); ?></td>
                                                <td>
                                                    <img src="<?= htmlspecialchars(url($row_cf["userimage"])) ?>" width="50px" height="50px" alt="User Image">
                                                </td>
                                                <td><?= htmlspecialchars($row_cf['username'] ?? 'Unknown'); ?></td>
                                                <td><?= htmlspecialchars($row_cf['useremail'] ?? 'Unknown'); ?></td>
                                                <td><?= htmlspecialchars($row_cf['age'] ?? 'Unknown'); ?></td>
                                                <td><?= htmlspecialchars($row_cf['qulification'] ?? 'Unknown'); ?></td>
                                                <td><?= htmlspecialchars($row_cf['village'] ?? 'Unknown'); ?></td>
                                                <td><?= htmlspecialchars($row_cf['phone'] ?? 'Unknown'); ?></td>
                                                <td><?= htmlspecialchars($row_cf['status'] ?? 'Unknown'); ?></td>
                                                <td><?= htmlspecialchars($row_cf['subject'] ?? 'Unknown'); ?></td>
                                                <td><?= htmlspecialchars($row_cf['adm_status'] ?? 'Pending'); ?></td>
                                                <td><?= htmlspecialchars(date('Y M, d', strtotime($row_cf["created_at"])) ?? 'Unknown'); ?></td>
                                            </tr>
                                        <?php }
                                    } else {
                                        echo "<tr><td colspan='12'>No confirmed admissions found.</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <!-- End Table with striped rows -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</main><!-- End #main -->
<?php include('footer.php'); ?>
