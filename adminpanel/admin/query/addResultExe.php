<?php 
 include("../../../conn.php");
 extract($_POST);

 // Check if result already exists
 $sel = $conn->prepare("SELECT * FROM result_summary WHERE exmne_id=? AND term=? AND year=?");
 $sel->execute([$exmne_id, $term, $year]);

 if($sel->rowCount() > 0) {
    $res = array("res" => "exist");
 } else {
    // Insert into result_summary
    $insSummary = $conn->prepare("INSERT INTO result_summary (exmne_id, class_id, term, year, school_name, location, attendance, performance_remark, attitude_remark, teachers_name, position_or_average) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $insSummary->execute([$exmne_id, $class_id, $term, $year, $school_name, $location, $attendance, $performance_remark, $attitude_remark, $teachers_name, $position_or_average]);
    
    $summary_id = $conn->lastInsertId();

    // Insert subject details
    $limit = count($subject_ids);
    for($i = 0; $i < $limit; $i++) {
        $subjId = $subject_ids[$i];
        $ca = $ca_scores[$i];
        $exam = $exam_scores[$i];

        // Only insert if at least one score is provided
        if($ca !== "" || $exam !== "") {
            $ca = ($ca === "") ? 0 : floatval($ca);
            $exam = ($exam === "") ? 0 : floatval($exam);
            $total = $ca + $exam;

            $insDet = $conn->prepare("INSERT INTO result_details (summary_id, subject_id, ca_score, exam_score, total_score) VALUES (?, ?, ?, ?, ?)");
            $insDet->execute([$summary_id, $subjId, $ca, $exam, $total]);
        }
    }

    $res = array("res" => "success");
 }

 echo json_encode($res);
?>
