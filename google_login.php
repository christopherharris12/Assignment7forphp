<?php
session_start();

$_SESSION['username'] = "User";
$_SESSION['email'] = "google_user@gmail.com";

header("Location: index.php");
exit();
?>
