<?php
$exmneId = $_SESSION['examineeSession']['exmne_id'];

// Select logged-in examinee data (safe prepared statement)
$stmtExmnee = $conn->prepare("SELECT * FROM examinee_tbl WHERE exmne_id = ?");
$stmtExmnee->execute([$exmneId]);
$selExmneeData = $stmtExmnee->fetch(PDO::FETCH_ASSOC);

$exmneCourse = $selExmneeData['exmne_course'];

// Select all exams for the student's course
$stmtExam = $conn->prepare("SELECT * FROM exam_tbl WHERE cou_id = ? ORDER BY ex_id DESC");
$stmtExam->execute([$exmneCourse]);
$selExam = $stmtExam;
?>