<?php
session_start();
if(!isset($_SESSION['username'])){
    header("Location: userLogin.php");
    exit();
}
include 'db.php';

$id = intval($_GET['id']);
$sql = mysqli_query($conn, "SELECT * FROM users WHERE id='$id'");
$row = mysqli_fetch_assoc($sql);

$error_msg = "";
$success_msg = "";

$current_email = $row['email'];
$current_phone = $row['phone'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email_phone = trim($_POST['email_phone']);
    $full_name   = trim($_POST['full_name']);
    $username    = trim($_POST['username']);

    $full_name = mysqli_real_escape_string($conn, $full_name);
    $username  = mysqli_real_escape_string($conn, $username);

    if (filter_var($email_phone, FILTER_VALIDATE_EMAIL)) {
        $email = mysqli_real_escape_string($conn, $email_phone);
        $phone = null;
    } else {
        $phone = mysqli_real_escape_string($conn, $email_phone);
        $email = null;
    }

    $check_needed = false;
    if (($email !== null && $email != $current_email) || ($phone !== null && $phone != $current_phone)) {
        $check_needed = true;
    }

    if ($check_needed) {
        $check_sql = "SELECT id FROM users WHERE (email=" . ($email===null?"NULL":"'".$email."'") . " OR phone=" . ($phone===null?"NULL":"'".$phone."'") . ") AND id != '$id' LIMIT 1";
        $check = mysqli_query($conn, $check_sql);
        if (mysqli_num_rows($check) > 0) {
            $error_msg = "This email or phone number is already used by another user!";
        }
    }

    if (empty($error_msg)) {
        $update_sql = "UPDATE users SET 
            email=" . ($email===null?"NULL":"'".$email."'") . ",
            phone=" . ($phone===null?"NULL":"'".$phone."'") . ",
            full_name='$full_name',
            username='$username'
            WHERE id='$id'";
        if (mysqli_query($conn, $update_sql)) {
            header("Location: crudOp.php");
            exit();
            $sql = mysqli_query($conn, "SELECT * FROM users WHERE id='$id'");
            $row = mysqli_fetch_assoc($sql);
            $current_email = $row['email'];
            $current_phone = $row['phone'];
        } else {
            $error_msg = "Failed to update user!";
        }
    }
}

$value = !empty($row['email']) ? $row['email'] : $row['phone'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Update User</title>
<style>
body {margin:0;padding:0;background:#fafafa;font-family:Arial,sans-serif;display:flex;justify-content:center;align-items:center;height:100vh;}
.container {background:#fff;border:1px solid #dbdbdb;width:350px;padding:40px 30px;text-align:center;border-radius:8px;}
.logo {font-size:32px;font-weight:bold;margin-bottom:25px;font-family:'Segoe UI',Tahoma,Geneva,Verdana,sans-serif;}
input {width:100%;padding:10px;margin:6px 0;border:1px solid #dbdbdb;background:#fafafa;border-radius:4px;font-size:14px;}
.btn {width:100%;padding:10px;background:#0095f6;border:none;border-radius:4px;color:white;font-weight:bold;cursor:pointer;margin-top:10px;}
.btn:hover {background:#007bcb;}
.success {margin:10px 0;padding:10px;background:#d4edda;color:#155724;border:1px solid #c3e6cb;border-radius:4px;}
.error {margin:10px 0;padding:10px;background:#f8d7da;color:#721c24;border:1px solid #f5c6cb;border-radius:4px;}
</style>
</head>
<body>
<div class="container">
    <div class="logo">Update User</div>

    <?php if ($success_msg): ?>
        <div class="success"><?= htmlspecialchars($success_msg) ?></div>
    <?php endif; ?>

    <?php if ($error_msg): ?>
        <div class="error"><?= htmlspecialchars($error_msg) ?></div>
    <?php endif; ?>

    <form method="POST">
        <input type="text" name="email_phone" placeholder="Mobile Number or Email" required value="<?= htmlspecialchars($value); ?>"/>
        <input type="text" name="full_name" placeholder="Full Name" required value="<?= htmlspecialchars($row['full_name']); ?>"/>
        <input type="text" name="username" placeholder="Username" required value="<?= htmlspecialchars($row['username']); ?>"/>
        <button class="btn" type="submit">Update</button>
        
    </form>
</div>
</body>
</html>
