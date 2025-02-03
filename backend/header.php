<?php 
require_once("../includes/config.php");
checkRole(['Admin', 'Student','Teacher']);

 ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Islamic School</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: NiceAdmin
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Updated: Apr 20 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center" >

    <div class="d-flex align-items-center justify-content-between">
      <a href="index.php" class="logo d-flex align-items-center">
       
        <span class="d-none d-lg-block">Islamic School</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->
    <nav class="header-nav ms-auto" >
      <ul class="d-flex align-items-center">
        <li class="nav-item dropdown pe-3">
          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="../frontend/imgs/kaneez-fatima.jpeg" alt="Profile" class="rounded-circle">
            <span class="d-none d-md-block dropdown-toggle ps-2"><?= $_SESSION['userInfo']['username'] ?? '' ?></span>
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6><?= $_SESSION['userInfo']['username'] ?? '' ?></h6>
              <span><?= $_SESSION['userInfo']['options']->role_name ?? '' ?></span>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <!-- <li>
              <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                <i class="bi bi-person"></i>
                <span>My Profile</span>
              </a>
            </li> -->
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="../frontend/pages/logout.php">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
              </a>
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar" style="background-color:rgb(128, 128, 128);">
    <ul class="sidebar-nav" id="sidebar-nav">
        <li class="nav-item">
            <a class="nav-link" href="index.php">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <?php if ($_SESSION['role'] === 'Admin'): ?>
            <li class="nav-item">
                <a class="nav-link" href="users.php">
                    <i class="bi bi-person"></i>
                    <span>Registered Users</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="user-admissions.php">
                    <i class="bi bi-person"></i>
                    <span>Admissions</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="shortlisted-student.php">
                    <i class="bi bi-person"></i>
                    <span>Shortlisted</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="teachers.php">
                    <i class="bi bi-person"></i>
                    <span>Teachers</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="cancelled-admission-student.php">
                    <i class="bi bi-person"></i>
                    <span>Cancelled</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="courses.php">
                    <i class="bi bi-card-list"></i>
                    <span>Courses</span>
                </a>
            </li>
        <?php endif; ?>

        <?php if ($_SESSION['role'] === 'Student'): ?>
            <li class="nav-item">
                <a class="nav-link" href="shortlisted-student.php">
                    <i class="bi bi-person"></i>
                    <span>Shortlisted</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="cancelled-admission-student.php">
                    <i class="bi bi-person"></i>
                    <span>Cancelled</span>
                </a>
            </li>
        <?php endif; ?>

        <?php if ($_SESSION['role'] === 'Teacher'): ?>
            <li class="nav-item">
                <a class="nav-link" href="teacher_students.php">
                    <i class="bi bi-person"></i>
                    <span>My Students</span>
                </a>
            </li>
        <?php endif; ?>

    </ul>
</aside>

  <main id="main" class="main">
