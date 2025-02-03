<?php
include('../includes/config.php');
header('Content-Type: application/json');

// SQL query to fetch admission data, grouped by district with counts for male and female
$sql = "SELECT district, 
               SUM(CASE WHEN gender = 'male' THEN 1 ELSE 0 END) AS male,
               SUM(CASE WHEN gender = 'female' THEN 1 ELSE 0 END) AS female
        FROM admissions
        GROUP BY district";

$result = $conn->query($sql);

$data = array();

// Check if the query was successful and fetch the results
if ($result) {
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    } else {
        // No data found
        $data = array("message" => "No data available for the requested query.");
    }
} else {
    // Query failed
    $data = array("error" => "Error executing the query.");
}

$conn->close();

// Return the result as JSON
echo json_encode($data);
?>
