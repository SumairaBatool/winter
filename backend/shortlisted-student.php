<?php 
include('header.php');
require_once("../includes/config.php");
checkRole(['Admin']); // Only Admin can access this page

// Fetch confirmed students
$sql_students = "SELECT a.id, a.userimage, a.username, a.qulification, c.sub_name AS course_name, a.adm_status, a.created_at
                 FROM admissions a
                 INNER JOIN corses c ON a.course_id = c.id
                 WHERE a.adm_status = 'confirmed'
                 ORDER BY a.id ASC";

$result_students = $conn->query($sql_students);
?>

<div class="pagetitle">
    <h1>Confirmed Students</h1>
</div>

<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body table-responsive">
                    <h5 class="card-title">List of Confirmed Students</h5>
                    <table class="table table-striped datatable">
                        <thead>
                            <tr>
                                <th>Sr. #</th>
                                <th>User Image</th>
                                <th>Username</th>
                                <th>Qualification</th>
                                <th>Course</th>
                                <th>Admission Status</th>
                                <th>Joining Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result_students->num_rows > 0) {
                                $counter = 1; // For Sr. # column
                                while ($row = $result_students->fetch_assoc()) {
                                    $userimage = !empty($row['userimage']) ? "../frontend/{$row['userimage']}" : "../frontend/uploads/default-placeholder.png";
                                    $formatted_date = date('Y M, d', strtotime($row["created_at"]));
                                    echo "<tr>
                                        <td>{$counter}</td>
                                        <td><img src='{$userimage}' width='50px' alt='User Image'></td>
                                        <td>{$row['username']}</td>
                                        <td>{$row['qulification']}</td>
                                        <td>{$row['course_name']}</td>
                                        <td><span class='badge bg-success'>{$row['adm_status']}</span></td>
                                        <td>{$formatted_date}</td>
                                      </tr>";
                                    $counter++;
                                }
                            } else {
                                echo "<tr><td colspan='7' class='text-center'>No confirmed students found.</td></tr>";
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
