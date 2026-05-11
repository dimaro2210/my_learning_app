<?php
include("../../../conn.php");

// Explicit variable assignment — no extract()
$fullname = trim($_POST['fullname'] ?? '');
$bdate    = $_POST['bdate']    ?? '';
$gender   = $_POST['gender']   ?? '0';
$course   = $_POST['course']   ?? '0';
$class_id = $_POST['class_id'] ?? '0';
$dept_id  = $_POST['dept_id']  ?? '0';
if ($gender === '0') {
    $res = ["res" => "noGender"];
} elseif ($course === '0') {
    $res = ["res" => "noCourse"];
} elseif ($class_id === '0') {
    $res = ["res" => "noLevel"];
} else {
    // Check for duplicate fullname
    $chkName = $conn->prepare("SELECT exmne_id FROM examinee_tbl WHERE exmne_fullname = ?");
    $chkName->execute([$fullname]);

    if ($chkName->rowCount() > 0) {
        $res = ["res" => "fullnameExist", "msg" => $fullname];
    } else {
        // Generate Username: firstname.surname
        $nameParts = explode(' ', trim($fullname));
        $fname = strtolower($nameParts[0] ?? '');
        $lname = strtolower($nameParts[1] ?? '');
        $email = $fname . ($lname ? '.' . $lname : '');
        
        // Use default password
        $password = "BOU26";
        $hashed = password_hash($password, PASSWORD_DEFAULT);

        $ins = $conn->prepare(
            "INSERT INTO examinee_tbl
             (exmne_fullname, exmne_course, exmne_gender, exmne_birthdate,
              exmne_class_id, exmne_dept_id, exmne_email, exmne_password)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
        );
        $success = $ins->execute([
            $fullname, $course, $gender, $bdate,
            $class_id, $dept_id, $email, $hashed
        ]);

        if ($success) {
            $res = ["res" => "success", "msg" => $email];
        } else {
            $res = ["res" => "failed"];
        }
    }
}

echo json_encode($res);
?>