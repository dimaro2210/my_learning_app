<?php 
 include("../../../conn.php");

 extract($_POST);

 // Variables from add-exam.php: ex_class_id, term, year, cou_id, ex_title, ex_description, ex_time_limit, ex_questlimit_display

 $selExam = $conn->prepare("SELECT * FROM exam_tbl WHERE ex_title=? AND ex_class_id=? AND term=? AND year=?");
 $selExam->execute([$ex_title, $ex_class_id, $term, $year]);

 if($selExam->rowCount() > 0)
 {
 	$res = array("res" => "exist");
 }
 else
 {
	$insExam = $conn->prepare("INSERT INTO exam_tbl(cou_id, ex_class_id, term, year, ex_title, ex_time_limit, ex_questlimit_display, ex_description) VALUES(?, ?, ?, ?, ?, ?, ?, ?)");
	$success = $insExam->execute([$cou_id, $ex_class_id, $term, $year, $ex_title, $ex_time_limit, $ex_questlimit_display, $ex_description]);
    
	if($success)
	{
		$res = array("res" => "success", "ex_id" => $conn->lastInsertId());
	}
	else
	{
		$res = array("res" => "failed");
	}
 }

 echo json_encode($res);
 ?>