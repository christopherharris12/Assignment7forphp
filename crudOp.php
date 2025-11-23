<?php
session_start();
$is_logged_in = isset($_SESSION['username']);

include "db.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>CRUD Dashboard</title>
<style>
body {
    margin: 0;
    font-family: Arial, sans-serif;
    background-color: #f5f6fa;
}

header {
    background-color: #0095f6;
    color: white;
    padding: 15px 30px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
header .logo {
    font-size: 24px;
    font-weight: bold;
}
header nav a {
    color: white;
    text-decoration: none;
    margin-left: 20px;
    font-weight: bold;
}
header nav a:hover {
    text-decoration: underline;
}

/* Main content */
main {
    padding: 20px;
    display: flex;
    justify-content: center;
}

/* Table styling */
table {
    width: 100%;
    max-width: 900px;
    border-collapse: collapse;
    background: white;
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    border-radius: 8px;
    overflow: hidden;
}
th, td {
    padding: 12px 15px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}
th {
    background-color: #0095f6;
    color: white;
}
tr:hover {
    background-color: #f1f1f1;
}

td a {
    padding: 6px 12px;
    text-decoration: none;
    color: white;
    border-radius: 4px;
    font-weight: bold;
    margin-right: 5px;
}
td a.update {
    background-color: #28a745;
}
td a.delete {
    background-color: #dc3545;
}
td a.update:hover {
    background-color: #218838;
}
td a.delete:hover {
    background-color: #c82333;
}

/* CRUD navigation buttons */
.crud-nav {
    margin-bottom: 20px;
    text-align: center;
}
.crud-nav a {
    display: inline-block;
    margin: 0 10px;
    padding: 10px 20px;
    background-color: #0095f6;
    color: white;
    border-radius: 5px;
    text-decoration: none;
    font-weight: bold;
}
.crud-nav a:hover {
    background-color: #0073c8;
}
</style>
</head>
<body>

<header>
    <div class="logo">User Dashboard</div>
    <nav>
        <?php if($is_logged_in): ?>
            <span>Welcome, <?= htmlspecialchars($_SESSION['username']); ?></span>
            <a href="logout.php">Logout</a>
        <?php else: ?>
            <a href="userLogin.php">Login</a>
        <?php endif; ?>
    </nav>
</header>
<div style="text-align:center; margin-bottom:15px;">
    <a href="users.php" class="add-user-btn">Add New User</a>
</div>

<style>
.add-user-btn {
    display: inline-block;
    padding: 10px 20px;
    background-color: #0095f6;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    font-weight: bold;
    transition: 0.3s;
    margin-top: 10px;
}
.add-user-btn:hover {
    background-color: #0073c8;
}
</style>

<main>
    
    <table>
        <tr>
            <th>ID</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Username</th>
            <th>Full Name</th>
            <th>Actions</th>
        </tr>
        <?php
        $select = mysqli_query($conn, "SELECT * FROM users");
        while($row = mysqli_fetch_assoc($select)){
            echo "<tr>";
            echo "<td>".$row['id']."</td>";
            echo "<td>".$row['email']."</td>";
            echo "<td>".$row['phone']."</td>";
            echo "<td>".$row['username']."</td>";
            echo "<td>".$row['full_name']."</td>";
            echo "<td>
                    <a class='update' href='update.php?id=".$row['id']."'>Update</a>
                    <a class='delete' href='delete.php?id=".$row['id']."' onclick=\"return confirm('Are you sure?')\">Delete</a>
                  </td>";
            echo "</tr>";
        }
        ?>
    </table>
</main>

</body>
</html>
