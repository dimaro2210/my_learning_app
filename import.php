<?php
include("conn.php");

$sql = file_get_contents("update_db.sql");

try {
    $conn->exec($sql);
    echo "SQL script imported successfully!";
} catch(PDOException $e) {
    echo "Error importing SQL script: " . $e->getMessage();
}
?>
