<?php 
session_start();

if(!isset($_SESSION['admin']['adminnakalogin']) == true) header("location:index.php");


 ?>
<?php include("../../conn.php"); ?>
<!-- MAO NI ANG HEADER -->
<?php include("includes/header.php"); ?>      

<!-- UI THEME DIRI -->
<?php include("includes/ui-theme.php"); ?>

<div class="app-main">
<!-- sidebar diri  -->
<?php include("includes/sidebar.php"); ?>



<!-- Condition If unza nga page gi click -->
<?php 
    $page = $_GET['page'] ?? '';

    switch($page) {
        case 'add-course':
            include("pages/add-course.php");
            break;
        case 'manage-course':
            include("pages/manage-course.php");
            break;
        case 'manage-exam':
            include("pages/manage-exam.php");
            break;
        case 'manage-examinee':
            include("pages/manage-examinee.php");
            break;
        case 'ranking-exam':
            include("pages/ranking-exam.php");
            break;
        case 'feedbacks':
            include("pages/feedbacks.php");
            break;
        case 'examinee-result':
            include("pages/examinee-result.php");
            break;
        case 'add-result':
            include("pages/add-result.php");
            break;
        case 'add-exam':
            include("pages/add-exam.php");
            break;
        case 'exam-attendance':
            include("pages/exam-attendance.php");
            break;
        case 'review-result':
            include("pages/review-result.php");
            break;
        case 'submitted-results':
            if(file_exists("pages/submitted-results.php")) {
                include("pages/submitted-results.php");
            } else {
                include("pages/examinee-result.php"); // Fallback if not yet created
            }
            break;
        case 'settings':
            if(file_exists("pages/settings.php")) {
                include("pages/settings.php");
            } else {
                include("pages/home.php"); // Fallback
            }
            break;
        default:
            include("pages/home.php");
            break;
    }
?> 


<!-- MAO NI IYA FOOTER -->
<?php include("includes/footer.php"); ?>

<?php include("includes/modals.php"); ?>
