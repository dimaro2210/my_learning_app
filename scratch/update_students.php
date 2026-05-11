<?php
include("conn.php");

try {
    $selExmne = $conn->query("SELECT * FROM examinee_tbl");
    while ($row = $selExmne->fetch(PDO::FETCH_ASSOC)) {
        $fullname = trim($row['exmne_fullname']);
        $nameParts = explode(' ', $fullname);
        $fname = strtolower($nameParts[0] ?? '');
        $lname = strtolower($nameParts[1] ?? '');
        
        $newEmail = $fname . ($lname ? '.' . $lname : '');
        $newPass = "BOU26";
        $hashedPass = password_hash($newPass, PASSWORD_DEFAULT);
        
        $update = $conn->prepare("UPDATE examinee_tbl SET exmne_email = ?, exmne_password = ? WHERE exmne_id = ?");
        $update->execute([$newEmail, $hashedPass, $row['exmne_id']]);
        
        echo "Updated: $fullname -> $newEmail\n";
    }
    echo "\nAll students updated successfully.";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
