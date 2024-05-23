<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Include database connection and admin operations
include_once 'db_connection.php';
include_once 'admin_operations.php';

// Check admin permissions and role if necessary

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Home</title>
</head>
<body>
    <h1>Welcome, Admin!</h1>
    <p>Manage the database:</p>
    <ul>
        <li><a href="add_admin.php">Add Admin</a></li>
        <li><a href="delete_admin.php">Delete Admin</a></li>
        <li><a href="update_password.php">Update Admin Password</a></li>
        <!-- Add more links for database management -->
    </ul>
    <br>
    <form action="logout.php" method="post">
        <input type="submit" name="logout" value="Logout">
    </form>
</body>
</html>
