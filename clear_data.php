<?php
include("conn.php");

$queries = [
    "TRUNCATE TABLE `course_tbl`",
    "TRUNCATE TABLE `examinee_tbl`",
    "TRUNCATE TABLE `exam_answers`",
    "TRUNCATE TABLE `exam_attempt`",
    "TRUNCATE TABLE `exam_question_tbl`",
    "TRUNCATE TABLE `exam_tbl`",
    "TRUNCATE TABLE `feedbacks_tbl`"
];

foreach ($queries as $sql) {
    try {
        $conn->exec($sql);
        echo "Successfully cleared table: " . $sql . "<br>";
    } catch(PDOException $e) {
        echo "Error clearing table: " . $e->getMessage() . "<br>";
    }
}

echo "<br><b>All mock data has been completely removed! You can now start fresh.</b>";
?>
