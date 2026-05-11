<?php
session_start();
include("../conn.php");

// Explicit variables — no extract()
$exam_id    = $_POST['exam_id'] ?? '';
$examAction = $_POST['examAction'] ?? '';
$answers    = $_POST['answer'] ?? [];

$exmne_id = $_SESSION['examineeSession']['exmne_id'];

// Check if already attempted
$stmtAttempt = $conn->prepare("SELECT * FROM exam_attempt WHERE exmne_id = ? AND exam_id = ?");
$stmtAttempt->execute([$exmne_id, $exam_id]);

// Check if answers already exist (partial re-take)
$stmtAns = $conn->prepare("SELECT * FROM exam_answers WHERE axmne_id = ? AND exam_id = ?");
$stmtAns->execute([$exmne_id, $exam_id]);

if ($stmtAttempt->rowCount() > 0) {
    $res = ["res" => "alreadyTaken"];
} else {
    if ($stmtAns->rowCount() > 0) {
        // Mark old answers as 'old'
        $updOld = $conn->prepare("UPDATE exam_answers SET exans_status='old' WHERE axmne_id = ? AND exam_id = ?");
        $updOld->execute([$exmne_id, $exam_id]);
    }

    // Insert new answers
    $insAns = null;
    foreach ($answers as $key => $value) {
        $answerVal = $value['correct'] ?? '';
        $insAns = $conn->prepare(
            "INSERT INTO exam_answers(axmne_id, exam_id, quest_id, exans_answer)
             VALUES(?, ?, ?, ?)"
        );
        $insAns->execute([$exmne_id, $exam_id, $key, $answerVal]);
    }

    if ($insAns) {
        // Record attempt
        $insAttempt = $conn->prepare(
            "INSERT INTO exam_attempt(exmne_id, exam_id) VALUES(?, ?)"
        );
        $success = $insAttempt->execute([$exmne_id, $exam_id]);
        $res = $success ? ["res" => "success"] : ["res" => "failed"];
    } else {
        $res = ["res" => "failed"];
    }
}

echo json_encode($res);
?>