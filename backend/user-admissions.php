<?php include('header.php');
 require_once("../includes/config.php");
 checkRole(['Admin']);
$message = $_GET['msg'] ?? '';
?>

<div class="pagetitle">
    <h1>Admissions</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item">user-admissions</li>
            <li class="breadcrumb-item active">list</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section">
    <?php if (!empty($message)) : ?>
        <div class='alert <?= 'alert-' . ($_GET['status'] ?? 'info') ?>'><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></div>
    <?php endif; ?>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body table-responsive">
                    <h5 class="card-title">User Data</h5>
                    <table class="table table-bordered table-striped align-middle text-center datatable">
                        <thead class="table-dark">
                            <tr>
                                <th>Sr. #</th>
                                <th>User Image</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Degree</th>
                                <th>Village</th>
                                <th>Phone</th>
                                <th>Marital Status</th>
                                <th>Course</th>
                                <th>Admission Status</th>
                                <th>Joining Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // SQL query to fetch data from admissions and courses tables
                            $sql = "SELECT 
                                        a.id, 
                                        a.userimage, 
                                        a.username, 
                                        a.useremail, 
                                        a.qulification, 
                                        a.village, 
                                        a.phone, 
                                        a.status, 
                                        a.adm_status, 
                                        a.created_at, 
                                        c.sub_name 
                                    FROM 
                                        admissions a 
                                    LEFT JOIN 
                                        corses c 
                                    ON 
                                        a.course_id = c.id 
                                    ORDER BY 
                                        a.id ASC";

                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $imagePath = "../frontend/" . $row['userimage'];
                                    if (!file_exists($imagePath) || empty($row['userimage'])) {
                                        $imagePath = "../frontend/uploads/default-placeholder.png"; // Fallback image
                                    }
                            ?>
                                    <tr>
                                        <td><?= htmlspecialchars($row["id"] ?? 'unknown') ?></td>
                                        <td>
                                            <img src="<?= htmlspecialchars($imagePath, ENT_QUOTES, 'UTF-8') ?>" class="rounded-circle" alt="User Image" style="width: 60px; height: 60px; object-fit: cover;">
                                        </td>
                                        <td><?= htmlspecialchars($row['username'] ?? 'unknown') ?></td>
                                        <td><?= htmlspecialchars($row['useremail'] ?? 'unknown') ?></td>
                                        <td><?= htmlspecialchars($row['qulification'] ?? 'unknown') ?></td>
                                        <td><?= htmlspecialchars($row['village'] ?? 'unknown') ?></td>
                                        <td><?= htmlspecialchars($row['phone'] ?? 'unknown') ?></td>
                                        <td><?= htmlspecialchars($row['status'] ?? 'unknown') ?></td>
                                        <td><?= htmlspecialchars($row['sub_name'] ?? 'N/A') ?></td>
                                        <td><?= htmlspecialchars($row['adm_status'] ?? 'pending') ?></td>
                                        <td><?= htmlspecialchars(date('Y M, d', strtotime($row["created_at"] ?? 'now'))) ?></td>
                                        <td>
                                            <a href="admission-delete.php?id=<?= $row["id"] ?>" class="btn btn-sm btn-danger">Delete</a>
                                            <a href="admission-confirm.php?id=<?= $row["id"] ?>" class="btn btn-sm btn-success">Confirm</a>
                                            <a href="admission-cancel.php?id=<?= $row["id"] ?>" class="btn btn-sm btn-warning">Cancel</a>
                                        </td>
                                    </tr>
                            <?php
                                }
                            } else {
                                echo "<tr><td colspan='12'>No records found</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include('footer.php'); ?>
