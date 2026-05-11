<?php
include("../../../conn.php");

$admin_id = $_POST['admin_id'];
$admin_user = $_POST['admin_user'];
$admin_pass = $_POST['admin_pass'];

if(!empty($admin_pass)) {
    $hashed = password_hash($admin_pass, PASSWORD_DEFAULT);
    $upd = $conn->prepare("UPDATE admin_acc SET admin_user = ?, admin_pass = ? WHERE admin_id = ?");
    $success = $upd->execute([$admin_user, $hashed, $admin_id]);
} else {
    $upd = $conn->prepare("UPDATE admin_acc SET admin_user = ? WHERE admin_id = ?");
    $success = $upd->execute([$admin_user, $admin_id]);
}

if($success) {
    $res = ["res" => "success"];
} else {
    $res = ["res" => "failed"];
}

echo json_encode($res);
?>
