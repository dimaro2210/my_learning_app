<?php
include("../../../conn.php");
$exmne_id = $_POST['exmne_id'];
$exFullname = trim($_POST['exFullname'] ?? '');
$exBdate = $_POST['exBdate'] ?? '';
$exGender = $_POST['exGender'] ?? '';
$exCourse = $_POST['exCourse'] ?? '';
$exClassId = $_POST['exClassId'] ?? '';
$exDeptId = $_POST['exDeptId'] ?? '0';

// Re-generate Username in case fullname changed
$nameParts = explode(' ', $exFullname);
$fname = strtolower($nameParts[0] ?? '');
$lname = strtolower($nameParts[1] ?? '');
$newUsername = $fname . ($lname ? '.' . $lname : '');

$stmt = $conn->prepare("UPDATE examinee_tbl SET exmne_fullname=?, exmne_course=?, exmne_gender=?, exmne_birthdate=?, exmne_class_id=?, exmne_dept_id=?, exmne_email=? WHERE exmne_id=?");
$updCourse = $stmt->execute([$exFullname, $exCourse, $exGender, $exBdate, $exClassId, $exDeptId, $newUsername, $exmne_id]);
if($updCourse)
{
	   $res = array("res" => "success", "exFullname" => $exFullname);
}
else
{
	   $res = array("res" => "failed");
}



 echo json_encode($res);	
?>