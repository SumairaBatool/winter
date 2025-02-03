<?php

if(session_id() == false){
    session_start();
}

$conn = new  mysqli("localhost","root","","gik_db");
if ($conn->connect_error) {
    printf("Connection Error: ", mysqli_connect_error());
    exit();
}

if( !function_exists('url')){
    function url($path = null) {
        return "http://localhost/winter/". $path;
    }
}

?>


<?php
// Function to check role and redirect if the role is not allowed
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function checkRole($allowed_roles) {
    // Check if the user is logged in and has a role
    if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], $allowed_roles)) {
        // Redirect to a "No access" page or login page
        header("Location: ../frontend/pages/rolelogin.php");
        exit;
    }
}
?>

<!-- role based checking -->
<?php
