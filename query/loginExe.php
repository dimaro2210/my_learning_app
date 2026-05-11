<?php
session_start();
include("../conn.php");

$username = trim($_POST['username'] ?? '');
$pass     = $_POST['pass'] ?? '';

// Use prepared statement — no SQL injection possible
$stmt = $conn->prepare("SELECT * FROM examinee_tbl WHERE exmne_email = ?");
$stmt->execute([$username]);
$selAccRow = $stmt->fetch(PDO::FETCH_ASSOC);

$authenticated = false;

if ($selAccRow) {
    $storedPassword = $selAccRow['exmne_password'];

    if (password_verify($pass, $storedPassword)) {
        // Modern bcrypt hash — direct match
        $authenticated = true;
    } elseif ($pass === $storedPassword) {
        // Legacy plain-text password — auto-migrate to hash on login
        $hashed = password_hash($pass, PASSWORD_DEFAULT);
        $upd = $conn->prepare("UPDATE examinee_tbl SET exmne_password = ? WHERE exmne_id = ?");
        $upd->execute([$hashed, $selAccRow['exmne_id']]);
        $authenticated = true;
    }
}

if ($authenticated) {
    $_SESSION['examineeSession'] = [
        'exmne_id'          => $selAccRow['exmne_id'],
        'examineenakalogin' => true
    ];
    $res = ["res" => "success"];
} else {
    $res = ["res" => "invalid"];
}

echo json_encode($res);
?>