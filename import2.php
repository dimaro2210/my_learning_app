<?php
include("conn.php");

$queries = [
    "CREATE TABLE IF NOT EXISTS `class_tbl` (
      `class_id` int(11) NOT NULL AUTO_INCREMENT,
      `class_name` varchar(255) NOT NULL,
      PRIMARY KEY (`class_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1;",
    "INSERT INTO `class_tbl` (`class_name`) VALUES ('JSS 3'), ('SS 1'), ('SS 2'), ('SS 3');",
    "CREATE TABLE IF NOT EXISTS `department_tbl` (
      `dept_id` int(11) NOT NULL AUTO_INCREMENT,
      `dept_name` varchar(255) NOT NULL,
      PRIMARY KEY (`dept_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1;",
    "INSERT INTO `department_tbl` (`dept_name`) VALUES ('Science'), ('Art');",
    "ALTER TABLE `examinee_tbl` ADD `exmne_class_id` int(11) NOT NULL AFTER `exmne_course`;",
    "ALTER TABLE `examinee_tbl` ADD `exmne_dept_id` int(11) DEFAULT '0' AFTER `exmne_class_id`;",
    "ALTER TABLE `exam_tbl` ADD `ex_class_id` int(11) NOT NULL AFTER `cou_id`;",
    "ALTER TABLE `exam_tbl` ADD `ex_dept_id` int(11) DEFAULT '0' AFTER `ex_class_id`;"
];

foreach ($queries as $sql) {
    try {
        $conn->exec($sql);
        echo "Executed successfully!\n";
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}
?>
