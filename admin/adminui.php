<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Interface</title>
</head>
<body>
    <h1>Admin Interface</h1>

    <h2>Add Admin</h2>
    <form action="admin_interface.php" method="post">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required><br>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required><br>
        <input type="submit" name="add_admin" value="Add Admin">
    </form>

    <h2>Delete Admin</h2>
    <form action="admin_interface.php" method="post">
        <label for="admin_id">Admin ID:</label>
        <input type="text" name="admin_id" id="admin_id" required><br>
        <input type="submit" name="delete_admin" value="Delete Admin">
    </form>

    <h2>Update Admin Password</h2>
    <form action="admin_interface.php" method="post">
        <label for="admin_id_update">Admin ID:</label>
        <input type="text" name="admin_id_update" id="admin_id_update" required><br>
        <label for="new_password">New Password:</label>
        <input type="password" name="new_password" id="new_password" required><br>
        <input type="submit" name="update_password" value="Update Password">
    </form>

    <?php
    // Handle form submissions
    if (isset($_POST['add_admin'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        if (addAdmin($username, $password)) {
            echo "<p>Admin added successfully.</p>";
        } else {
            echo "<p>Error adding admin.</p>";
        }
    }

    if (isset($_POST['delete_admin'])) {
        $admin_id = $_POST['admin_id'];
        if (deleteAdmin($admin_id)) {
            echo "<p>Admin deleted successfully.</p>";
        } else {
            echo "<p>Error deleting admin.</p>";
        }
    }

    if (isset($_POST['update_password'])) {
        $admin_id = $_POST['admin_id_update'];
        $newPassword = $_POST['new_password'];
        if (updateAdminPassword($admin_id, $newPassword)) {
            echo "<p>Admin password updated successfully.</p>";
        } else {
            echo "<p>Error updating admin password.</p>";
        }
    }
    ?>
</body>
</html>
