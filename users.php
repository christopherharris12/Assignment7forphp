<?php
session_start();
$is_logged_in = isset($_SESSION['username']);
include "db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])){
    $email_phone = trim($_POST['email_phone']);
    $full_name = trim($_POST['full_name']);
    $username = trim($_POST['username']);
    $password = trim(md5($_POST['password']));

    $error = "";

    if (empty($email_phone)){
        $error= "Phone or Email required!";
    } else if (empty($full_name)){
        $error= "Full names Required!";
    } else if (empty($username)){
        $error= "The username is required!";
    } else if (empty($password)){
        $error= "Please enter a Password!";
    } else if (strlen($_POST['password']) < 6){
        $error = "Password must be at least 6 characters!";
    } else {
        if (filter_var($email_phone, FILTER_VALIDATE_EMAIL)){
            $email = $email_phone;
            $phone = "";
        } else {
            $phone = $email_phone;
            $email = "";
        }
        $insert = mysqli_query($conn, "INSERT INTO users (email, phone, full_name, username, password_hash) VALUES ('$email', '$phone', '$full_name', '$username', '$password')");
        if ($insert){
            header("Location: userLogin.php");
            exit();
        } else {
            $error = "Error signing up. Try again.";
        }
    }
}

// Handle fake Google login
if (isset($_GET['google_login'])){
    // Fake Google user info
    $google_user = [
        'id' => 9999,
        'username' => 'GoogleUser',
        'email' => 'googleuser@example.com'
    ];

    $_SESSION['id'] = $google_user['id'];
    $_SESSION['username'] = $google_user['username'];
    $_SESSION['email'] = $google_user['email'];

    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Instagram Style Sign Up</title>
<style>
body {
    margin: 0;
    padding: 0;
    background: #fafafa;
    font-family: Arial, sans-serif;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}
.container {
    background: #ffffff;
    border: 1px solid #dbdbdb;
    width: 350px;
    padding: 40px 40px 30px;
    text-align: center;
    border-radius: 8px;
}
.logo {
    font-size: 32px;
    font-weight: bold;
    margin-bottom: 25px;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}
input {
    width: 100%;
    padding: 10px;
    margin: 6px 0;
    border: 1px solid #dbdbdb;
    background: #fafafa;
    border-radius: 4px;
    font-size: 14px;
}
.btn {
    width: 100%;
    padding: 10px;
    background: #0095f6;
    border: none;
    border-radius: 4px;
    color: white;
    font-weight: bold;
    cursor: pointer;
    margin-top: 10px;
}
.btn:hover { background: #007bcb; }
.or {
    display: flex;
    align-items: center;
    margin: 15px 0;
    color: #8e8e8e;
    font-size: 13px;
    font-weight: bold;
}
.line { flex: 1; height: 1px; background: #dbdbdb; }
.google-btn {
    width: 100%;
    padding: 10px;
    border: 1px solid #dbdbdb;
    background: white;
    border-radius: 4px;
    cursor: pointer;
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 8px;
    margin-bottom: 10px;
    font-weight: bold;
    font-size: 14px;
    text-decoration: none;
    color: black;
}
.google-btn:hover { background: #f5f5f5; }
.footer { margin-top: 20px; font-size: 14px; }
a { color: #0095f6; text-decoration: none; }
.error-msg { color: red; margin-bottom: 10px; font-weight: bold; }
</style>
</head>
<body>
<div class="container">
    <div class="logo">Instagram</div>

    <?php if(!empty($error)) echo "<div class='error-msg'>$error</div>"; ?>

    <form method="POST">
        <input type="text" name="email_phone" placeholder="Mobile Number or Email" required />
        <input type="text" name="full_name" placeholder="Full Name" required />
        <input type="text" name="username" placeholder="Username" required />
        <input type="password" name="password" placeholder="Password" required />
        <button class="btn" type="submit" name="submit">Sign Up</button>
    </form>

    <div class="or">
        <div class="line"></div>
        <span style="margin: 0 10px;">OR</span>
        <div class="line"></div>
    </div>

    <a href="?google_login=1" class="google-btn">
        <img src="https://www.svgrepo.com/show/475656/google-color.svg" width="18" />
        Login with Google
    </a>

    <div class="footer">
        Have an account? <a href="userLogin.php">Log In</a>
    </div>
</div>
</body>
</html>
