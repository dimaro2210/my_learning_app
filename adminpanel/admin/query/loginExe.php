<?php
session_start();
include("../../../conn.php");

$username = trim($_POST['username'] ?? '');
$pass     = $_POST['pass'] ?? '';

// Use prepared statement — no SQL injection possible
$stmt = $conn->prepare("SELECT * FROM admin_acc WHERE admin_user = ?");
$stmt->execute([$username]);
$selAccRow = $stmt->fetch(PDO::FETCH_ASSOC);

$authenticated = false;

if ($selAccRow) {
    $storedPassword = $selAccRow['admin_pass'];

    if (password_verify($pass, $storedPassword)) {
        // Modern bcrypt hash
        $authenticated = true;
    } elseif ($pass === $storedPassword) {
        // Legacy plain-text — auto-migrate on login
        $hashed = password_hash($pass, PASSWORD_DEFAULT);
        $upd = $conn->prepare("UPDATE admin_acc SET admin_pass = ? WHERE admin_id = ?");
        $upd->execute([$hashed, $selAccRow['admin_id']]);
        $authenticated = true;
    }
}

if ($authenticated) {
    $_SESSION['admin'] = [
        'admin_id'        => $selAccRow['admin_id'],
        'adminnakalogin'  => true
    ];
    $res = ["res" => "success"];
} else {
    $res = ["res" => "invalid"];
}

echo json_encode($res);
?>