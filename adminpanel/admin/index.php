<?php 
session_start();
if(isset($_SESSION['admin']['adminnakalogin']) == true) header("location:home.php");
?>

<?php 
include("login-ui/index.php");
?>