<?php
include("../../../conn.php");

$id = $_POST['id'];
$status = $_POST['status'];

$upd = $conn->prepare("UPDATE exam_tbl SET ex_status=? WHERE ex_id=?");
$success = $upd->execute([$status, $id]);

if($success) {
    $res = ["res" => "success"];
} else {
    $res = ["res" => "failed"];
}

echo json_encode($res);
?>
