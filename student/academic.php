<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Academic Office - Welcome</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fira+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="/assets/favicon.ico">
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style.css">
    <script src="https://kit.fontawesome.com/fe96d845ef.js" crossorigin="anonymous"></script>
    <script src="../node_modules/jquery/dist/jquery.min.js"></script>
    <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="wrapper">
        <?php
            $office_name = "Academic Office";
            //include "../conn.php";
            include "../navbar.php"
        ?>
        <div class="container-fluid academicbanner header">
            <a href="/student/generate_inquiry.php" class="header-btn btn btn-primary position-absolute p-3 m-2 bottom-0 start-0">Generate Inquiry</a>
            <a href="/student/transactions.php" class="header-btn btn btn-primary position-absolute p-3 m-2 bottom-0 end-0">Transactions</a>
            <nav class="breadcrumb-nav breadcrumb-container" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="home.php">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Academic Office</li>
                </ol>
            </nav>
            
            <h1 class="display-1 header-text text-center text-light">Academic Office</h1>
            <p class="header-text text-center text-light">Choose from one of the services below to get started</p>
        </div>
        <div class="container-fluid p-2 d-flex flex-wrap flex-column justify-content-center gap-2 text-center">
            <a href="academic/subject_overload.php" class="btn btn-primary d-block text-decoration-none bg-maroon text-light p-4 rounded-0">
                <h2>Subject Overload</h2>
                <p>Add additional subject/s more than the prescribed number of units</p>
            </a>
            <a href="academic/grade_accreditation.php" class="btn btn-primary d-block text-decoration-none bg-maroon text-light p-4 rounded-0">
            <h2>Grade Accreditation</h2>
                <p>For Correction of Grade Entry, Late Reporting of Grades, and Removal of Incomplete Mark</p>
            </a>
            <a href="academic/cross_enrollment.php" class="btn btn-primary d-block text-decoration-none bg-maroon text-light p-4 rounded-0">
            <h2>Cross-Enrollment</h2>
                <p>Enrollment of subject/s at another college or university</p>
            </a>
            <a href="academic/shifting.php" class="btn btn-primary d-block text-decoration-none bg-maroon text-light p-4 rounded-0">
            <h2>Shifting</h2>
                <p>Shift to another program offered in PUP Santa Rosa</p>
            </a>
            <a href="academic/manual_enrollment.php" class="btn btn-primary d-block text-decoration-none bg-maroon text-light p-4 rounded-0">
            <h2>Manual Enrollment</h2>
                <p>Failed to enroll during the online registration period set by the University</p>
            </a>
            <a href="academic/servicesinsistools.php" class="btn btn-primary d-block text-decoration-none bg-maroon text-light p-4 rounded-0">
            <h2>Services in SIS Tools</h2>
                <p>(a) ACE Form - Add subjects or change your officially enrolled subjects, (b) Subject Petition/Tutorial - Request for subject not offered in current semester</p>
            </a>
        </div>
        <div class="push"></div>
    </div>
    <footer class="footer container-fluid w-100 text-md-left text-center d-md-flex align-items-center justify-content-center bg-light flex-nowrap">
        <div>
            <small>PUP Santa Rosa - Online Transaction Management System Beta 0.1.0</small>
        </div>
        <div>
            <small><a href="https://www.pup.edu.ph/terms/" target="_blank" class="btn btn-link">Terms of Use</a>|</small>
            <small><a href="https://www.pup.edu.ph/privacy/" target="_blank" class="btn btn-link">Privacy Statement</a></small>
        </div>
    </footer>
    <script>
        $(document).ready(function(){
            $('.dropdown-submenu a.dropdown-toggle').on("click", function(e){
            $(this).next('ul').toggle();
            e.stopPropagation();
            e.preventDefault();
            });
        });
    </script>
</body>
</html>