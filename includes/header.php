<?php
// Start the session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Include configuration file
require_once("config.php");

// Handle Logout action
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("Location: ../pages/rolelogin.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Final Project</title>
    <!-- Stylesheets -->
    <link rel="stylesheet" href="../CSS/index.css">
    <link rel="stylesheet" href="../CSS/common.css">
    <link rel="stylesheet" href="../CSS/campus.css">
    <link rel="stylesheet" href="../CSS/courses.css">
    <link rel="stylesheet" href="../CSS/nav.css">
    <link rel="stylesheet" href="../CSS/donations.css">
    <link rel="stylesheet" href="../CSS/style.css">
    <link rel="stylesheet" href="../CSS/footer.css">
    <link rel="stylesheet" href="../CSS/banner.css">
    <link rel="stylesheet" href="../CSS/admission.css">
    <link rel="stylesheet" href="../CSS/login.css">
    <link rel="stylesheet" href="../CSS/faculty.css">
    <link rel="stylesheet" href="../CSS/contact.css">
    <link rel="stylesheet" href="../CSS/gallery.css">
    <link rel="stylesheet" href="../CSS/main.css">
    <!-- Other external stylesheets -->
    <link rel="stylesheet" href="../assets/css/bootstrap-grid.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <!-- Header Section -->
    <header>
        <div class="container-fluid p-4 custom-container">
            <div class="row justify-content-center align-items-center">
                <div class="col-lg-2 order-sm-1 order-lg-1 col-sm-6 custom-col">
                    <li><a href="#">URDU</a></li><br>
                    <li><a href="#">ARABIC</a></li>
                </div>
                <div class="col-lg-8 order-sm-3 order-lg-2 col-sm-12 custom-col">
                    <li><a href="#">SATELLITE TOWN SKARDU, STREET NO-2</a></li><br>
                    <li><a href="#">+921818999872</a></li><br>
                    <li><a href="#">SATURDAY-THURSDAY: 5:00AM-3:00PM</a></li>
                </div>
                <div class="col-lg-2 order-sm-2 order-lg-3 col-sm-6 custom-col">
                    <?php 
                    if (isset($_SESSION['user']) && !empty($_SESSION['user'])) { ?>
                        <li><a href="?logout=true">Logout</a></li><br>
                    <?php } else { ?>
                        <li><a href="../pages/rolelogin.php">Admin Panel</a></li>
                    <?php } ?>
                    <li><a href="../pages/register.php">Register</a></li><br>

                </div>
            </div>
        </div>
    </header>

    <!-- Navigation -->
    <nav>
        <input type="checkbox" id="check">
        <label for="check" class="checkbtn">
            <i class="fas fa-bars"></i>
        </label>
        <img src="../imgs/logofooter.png" style="width: 200px; max-height: 100px;" alt="Logo" />
        <ul class="hidenav">
            <li><a href="../index.php">Home</a></li>
            <li><a href="../pages/admission.php">Admission</a></li>
            <li><a href="../pages/campus.php">Campus</a></li>
            <li><a href="../pages/courses.php">Course</a></li>
            <li><a href="../pages/faculty.php">Teacher</a></li>
            <li><a href="../pages/gallery.php">Gallery</a></li>
            <li><a href="../pages/donations.php">About us</a></li>
            <li><a href="../pages/contact.php">Contact us</a></li>
        </ul>
    </nav>

</body>
</html>
