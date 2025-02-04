<?php 
include('header.php');

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$message = htmlspecialchars($_GET['msg'] ?? '');
$status = htmlspecialchars($_GET['status'] ?? '');

?>
<div class="pagetitle">
    <h1>Admissions Cancelled</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item">Cancelled Admissions</li>
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
                    <h5 class="card-title">Cancelled Admission</h5>
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="true">All Records</button>
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                            <!-- Table with striped rows -->
                            <table class="table table-striped table-responsive datatable">
                                <thead>
                                    <tr>
                                        <th>Sr. #</th>
                                        <th>User Image</th>
                                        <th>User Email</th>
                                        <th>Subject</th>
                                        <th>Admission Status</th>
                                        <th>Joining Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // SQL query to retrieve canceled admissions
                                    $sql_cl = "SELECT * FROM admissions WHERE adm_status = 'canceled' ORDER BY id DESC";
                                    $result_cl = $conn->query($sql_cl);

                                    // Check if query executed successfully
                                    if (!$result_cl) {
                                        die("<tr><td colspan='11'>Error executing query: " . $conn->error . "</td></tr>");
                                    }
                                    
                                    // Check if rows are returned
                                    if ($result_cl->num_rows > 0) {
                                        while ($row_cl = $result_cl->fetch_assoc()) { ?>
                                            <tr>
                                                <td><?= htmlspecialchars($row_cl["id"] ?? 'Unknown'); ?></td>
                                                <td>
                                                    <img src="<?= htmlspecialchars(!empty($row_cl['userimage']) ? '../frontend/' . $row_cl['userimage'] : 'path/to/default-placeholder.png') ?>" width="50px" height="50px" alt="User Image">
                                                </td>
                                                <td><?= htmlspecialchars($row_cl['username'] ?? 'Unknown'); ?></td>
                                                <td><?= htmlspecialchars($row_cl['qulification'] ?? 'Unknown'); ?></td>
                                                <td><?= htmlspecialchars($row_cl['adm_status'] ?? 'Pending'); ?></td>
                                                <td><?= htmlspecialchars(date('Y M, d', strtotime($row_cl["created_at"])) ?? 'Unknown'); ?></td>
                                            </tr>
                                        <?php }
                                    } else {
                                        echo "<tr><td colspan='11'>No canceled admissions found.</td></tr>";
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
