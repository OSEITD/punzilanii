<?php
session_start();
require_once("db_connection.php");

if (isset($_POST['submit'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    
    $query = "SELECT * FROM users WHERE username=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

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
    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset='utf-8'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="styles.css" rel="stylesheet" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Login</title>
</head>
<body>
    <div class="form">
        
        <div class="container">
         
            <form class="login-form" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <h1 class="text-center"><strong><mark>Login</mark></strong></h1>
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" placeholder="Enter username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter Password" required>
                </div>
                <button type="submit" name="submit">Login</button>
                <h5 style="color:red;"><?php echo isset($error_message) ? $error_message : ''; ?></h5>
            </form>
            <div class="footer-links">
                <a href="#" style="float: left;">Forgot password?</a>
                <a href="register.php" style="float: right;">Don't have an account?</a>
                <a href="#">Login with Google account</a>
                <a href="#">Login with Facebook</a>
            </div>
        </div>
    </div>
</body>
</html>
