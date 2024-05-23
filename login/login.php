<?php
session_start();
require_once("db_connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    
    // Prepare SQL statement to select user
    $sql = "SELECT user_id, username, password, role FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }
    
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Verify password
        if (password_verify($password, $user['password'])) {
            session_regenerate_id();
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            // Redirect based on role
            if ($user['role'] == 'instructor') {
                header("Location: instructor.php");
                exit();
            } elseif ($user['role'] == 'student') {
                header("Location: index.php");
                exit();
            } else {
                $error_message = "Unknown role.";
            }
        } else {
            $error_message = "Username/password is incorrect.";
        }
    } else {
        $error_message = "Username/password is incorrect.";
    }
    
    // Close statement
    $stmt->close();
}
// Close connection
$conn->close();
?>

