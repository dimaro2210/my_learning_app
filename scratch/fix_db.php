<?php
include 'conn.php';
try {
    $conn->exec("ALTER TABLE exam_attempt ADD COLUMN created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP");
    echo "Success: Column created_at added to exam_attempt.";
} catch(PDOException $e) {
    echo "Error or Already Exists: " . $e->getMessage();
}
?>
