<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Instagram Style Login</title>
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
    .btn:hover {
        background: #007bcb;
    }
    .or {
        display: flex;
        align-items: center;
        margin: 15px 0;
        color: #8e8e8e;
        font-size: 13px;
        font-weight: bold;
    }
    .line {
        flex: 1;
        height: 1px;
        background: #dbdbdb;
    }
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
    }
    .google-btn:hover {
        background: #f5f5f5;
    }
    .footer {
        margin-top: 20px;
        font-size: 14px;
    }
    a {
        color: #0095f6;
        text-decoration: none;
    }
</style>
</head>
<body>

<div class="container">
    <div class="logo">Instagram</div>

    <form method="POST">
        <input type="text" name="email_phone" placeholder="Mobile Number or Email" required />
        <input type="password" name="password" placeholder="Password" required />
        <button class="btn" type="submit" name="submit">Login</button>
    </form>

    <div class="or">
        <div class="line"></div>
        <span style="margin: 0 10px;">OR</span>
        <div class="line"></div>
    </div>

    <button class="google-btn" onclick="window.location.href='google_login.php'">
        <img src="https://www.svgrepo.com/show/475656/google-color.svg" width="18" />
        Login with Google
    </button>

    <div class="footer">
        Don't have an account? <a href="users.php">Sign up</a>
    </div>
</div>

</body>
</html>

<?php
include "db.php";

if (isset($_POST['submit'])) {

    $email_phone = trim($_POST['email_phone']);
    $password    = trim($_POST['password']);
    $password_md5 = md5($password);

    // Email OR Phone
    $query = mysqli_query($conn,
        "SELECT * FROM users 
         WHERE (email='$email_phone' OR phone='$email_phone') 
         AND password_hash='$password_md5'"
    );

    if ($query && mysqli_num_rows($query) > 0) {

        $user = mysqli_fetch_assoc($query);

        $_SESSION['id'] = $user['id'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['phone'] = $user['phone'];
        $_SESSION['username'] = $user['username'];

        header("Location: index.php");
        exit();
    }
    else {
        echo "<script>alert('Invalid Credentials');</script>";
    }
}
?>
