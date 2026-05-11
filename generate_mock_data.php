<?php
include("conn.php");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


// 1. Ensure Classes Exist
$classes = [
    'JSS 1', 'JSS 2', 'JSS 3',
    'SS 1', 'SS 2', 'SS 3'
];

foreach ($classes as $class_name) {
    $check = $conn->query("SELECT * FROM class_tbl WHERE class_name='$class_name'");
    if ($check->rowCount() == 0) {
        $conn->query("INSERT INTO class_tbl (class_name) VALUES ('$class_name')");
    }
}

// 2. Ensure Departments Exist
$depts = [
    'Science' => 'SCI',
    'Art' => 'ART'
];

foreach ($depts as $dept_name => $code) {
    $check = $conn->query("SELECT * FROM department_tbl WHERE dept_name='$dept_name'");
    if ($check->rowCount() == 0) {
        $conn->query("INSERT INTO department_tbl (dept_name) VALUES ('$dept_name')");
    }
}

// Map IDs for easier access
$class_map = [];
$selClasses = $conn->query("SELECT * FROM class_tbl");
while($row = $selClasses->fetch(PDO::FETCH_ASSOC)) {
    $class_map[$row['class_name']] = $row['class_id'];
}
echo "Class Map: " . json_encode($class_map) . "<br>";


$dept_map = [];
$selDepts = $conn->query("SELECT * FROM department_tbl");
while($row = $selDepts->fetch(PDO::FETCH_ASSOC)) {
    $dept_map[$row['dept_name']] = $row['dept_id'];
}

// 3. Generate Mock Students
echo "Generating students...<br>";
$admission_year = "26";
$school_code = "BOU";

$target_classes = ['JSS 1', 'JSS 2', 'JSS 3', 'SS 1', 'SS 2', 'SS 3'];

foreach ($target_classes as $class_name) {
    $class_id = $class_map[$class_name];
    
    // For SS classes, we split into Science and Art
    if (strpos($class_name, 'SS') !== false) {
        $sub_types = ['Science', 'Art'];
        $num_per_type = 5; // 5 Sci + 5 Art = 10 total for the class
    } else {
        $sub_types = ['None'];
        $num_per_type = 10;
    }

    foreach ($sub_types as $type) {
        $dept_id = ($type == 'None') ? 0 : $dept_map[$type];
        $dept_code = ($type == 'Science') ? 'SCI' : (($type == 'Art') ? 'ART' : '');
        
        for ($i = 1; $i <= $num_per_type; $i++) {
            $serial = str_pad($i, 3, "0", STR_PAD_LEFT);
            
            if ($type == 'None') {
                // BOU26/JSS3/001
                $class_code = str_replace(' ', '', $class_name);
                $student_id = "$school_code$admission_year/$class_code/$serial";
            } else {
                // BOU26/SCI01/001 (SS1 is 01, SS2 is 02, SS3 is 03)
                $level_num = substr($class_name, -1);
                $student_id = "$school_code$admission_year/$dept_code"."0$level_num/$serial";
            }
            
            $fullname = "Mock Student " . str_replace('/', ' ', $student_id);
            $email = $student_id; // Using student ID as login email
            $password = "password123";
            $gender = ($i % 2 == 0) ? "male" : "female";
            $bdate = "2008-05-15";
            $course = 1; // Default course ID
            
            // Check if exists
            $check = $conn->query("SELECT * FROM examinee_tbl WHERE exmne_email='$email'");
            if ($check->rowCount() == 0) {
                echo "Inserting $email...<br>";
                $conn->query("INSERT INTO examinee_tbl (exmne_fullname, exmne_course, exmne_gender, exmne_birthdate, exmne_class_id, exmne_dept_id, exmne_email, exmne_password) 
                              VALUES ('$fullname', '$course', '$gender', '$bdate', '$class_id', '$dept_id', '$email', '$password')");
            } else {
                echo "Skipping $email (exists)<br>";
            }

        }
    }
}

// 4. Extra Admin Accounts
echo "Generating admins...<br>";
$admins = [
    ['user' => 'admin2', 'pass' => 'admin123'],
    ['user' => 'supervisor', 'pass' => 'super123']
];

foreach ($admins as $ad) {
    $user = $ad['user'];
    $pass = $ad['pass'];
    $check = $conn->query("SELECT * FROM admin_acc WHERE admin_user='$user'");
    if ($check->rowCount() == 0) {
        $conn->query("INSERT INTO admin_acc (admin_user, admin_pass) VALUES ('$user', '$pass')");
    }
}

// 5. Mock Exams
echo "Generating exams...<br>";
$exam_titles = ['Mathematics Mid-Term', 'English Language Quiz', 'Basic Science Test'];
foreach ($exam_titles as $title) {
    $check = $conn->query("SELECT * FROM exam_tbl WHERE ex_title='$title'");
    if ($check->rowCount() == 0) {
        $conn->query("INSERT INTO exam_tbl (cou_id, ex_class_id, ex_title, ex_time_limit, ex_questlimit_display, ex_description, term, year) 
                      VALUES (1, 1, '$title', '60', 10, 'Mock examination data', 'First Term', '2023/2024')");
    }
}

echo "Mock data generation completed successfully!";
?>
