<?php
session_start();
if(!isset($_SESSION['username'])){
    header("Location: userLogin.php");
    exit();
}

include 'db.php';

$id = $_GET['id'];

$sql = mysqli_query($conn, "DELETE FROM users WHERE id='$id'");
if($sql){
    header("Location: crudOp.php");
} else {
    echo "Error deleting record: " . mysqli_error($conn);
}
?>