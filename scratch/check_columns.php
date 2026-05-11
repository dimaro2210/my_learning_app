<?php
include 'conn.php';
$query = $conn->query("SELECT * FROM exam_attempt LIMIT 1");
$row = $query->fetch(PDO::FETCH_ASSOC);
if ($row) {
    echo "Columns: " . implode(", ", array_keys($row));
} else {
    echo "No data in exam_attempt, describing table instead:\n";
    $res = $conn->query("DESCRIBE exam_attempt");
    while($r = $res->fetch(PDO::FETCH_ASSOC)) {
        echo $r['Field'] . " (" . $r['Type'] . ")\n";
    }
}
?>
