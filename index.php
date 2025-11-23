<?php
session_start();
$is_logged_in = isset($_SESSION['username']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Instagram Style Homepage</title>

<style>
body {
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
    background: #000;
    color: #fff;
}

/* MAIN CONTAINER */
.container {
    display: flex;
    justify-content: center;
    width: 100%;
    margin-top: 20px;
}

/* SIDEBAR */
.sidebar {
    width: 250px;
    height: 100vh;
    position: fixed;
    left: 0;
    top: 0;
    background: #000;
    border-right: 1px solid #333;
    padding: 20px 15px;
}

.sidebar h1 {
    font-size: 26px;
    margin-bottom: 40px;
}

.sidebar a {
    display: block;
    padding: 12px 10px;
    font-size: 18px;
    color: #fff;
    text-decoration: none;
    border-radius: 8px;
    margin-bottom: 5px;
}

.sidebar a:hover {
    background: #121212;
}

/* FEED */
.feed {
    width: 550px;
    margin-left: 280px;
}

/* STORY BAR */
.story-bar {
    display: flex;
    overflow-x: auto;
    padding: 15px 0;
}

.story {
    margin-right: 10px;
    width: 70px;
    height: 70px;
    border-radius: 50%;
    background: #666;
}

/* POSTS & CRUD */
.post {
    background: #111;
    margin-top: 20px;
    padding: 15px;
    border-radius: 10px;
}

.crud-box {
    background: #111;
    padding: 25px;
    margin-top: 25px;
    border-radius: 10px;
    text-align: center;
    border: 1px solid #444;
}

.crud-box a {
    display: inline-block;
    padding: 15px 25px;
    background: #0095f6;
    border-radius: 5px;
    color: #fff;
    text-decoration: none;
    font-size: 18px;
    font-weight: bold;
}

.crud-box a:hover {
    background: #0073c8;
}

/* RIGHT SIDE SUGGESTIONS */
.right-side {
    width: 300px;
    margin-left: 30px;
    margin-top: 20px;
}

.suggestion {
    display: flex;
    align-items: center;
    margin-bottom: 15px;
}

.suggestion div {
    margin-left: 10px;
}

.follow {
    color: #0095f6;
    cursor: pointer;
}
</style>
</head>

<body>

<div class="container">

    <!-- SIDEBAR -->
    <div class="sidebar">
        
        <h1>Instagram</h1>

        <a href="index.php">Home</a>
        <a href="#">Search</a>
        <a href="#">Explore</a>
        <a href="#">Reels</a>
        <a href="#">Messages</a>
        <a href="#">Notifications</a>
        <a href="#">Create</a>
        <a href="#">Profile</a>

        <?php if($is_logged_in): ?>
            <a href="logout.php" style="color:#ff5555;">Logout</a>
        <?php else: ?>
            <a href="userLogin.php" style="color:#55ff55;">Login</a>

            <!-- SIMPLE GOOGLE LOGIN -->
            <a href="google_login.php" style="color:#4285F4;">Sign in with Google</a>
        <?php endif; ?>

    </div>

    <!-- FEED SECTION -->
    <div class="feed">

        <!-- Story bar -->
        <div class="story-bar">
            <div class="story"></div>
            <div class="story"></div>
            <div class="story"></div>
            <div class="story"></div>
            <div class="story"></div>
        </div>

        <!-- CRUD BOX -->
        <div class="crud-box">
            <?php if($is_logged_in): ?>
                <h2>Welcome <?= htmlspecialchars($_SESSION['username']) ?>!</h2>
                <p>Manage the system here:</p>
                <a href="crudOp.php">CRUD OPERATION</a>
            <?php else: ?>
                <h2>Login Required</h2>
                <p>Please login to access user management.</p>
                <a href="userLogin.php">Login</a>
            <?php endif; ?>
        </div>

    </div>

    <!-- RIGHT SIDE SUGGESTIONS -->
    <div class="right-side">
        <h3>Suggested For You</h3>

        <div class="suggestion">
            <div>harrisPro</div>
            <span class="follow">Follow</span>
        </div>

        <div class="suggestion">
            <div>blandon</div>
            <span class="follow">Follow</span>
        </div>

        <div class="suggestion">
            <div>gilbert</div>
            <span class="follow">Follow</span>
        </div>

    </div>

</div>

</body>
</html>
