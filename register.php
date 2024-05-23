<!DOCTYPE html>
<html>
<head>
   <meta charset='utf-8'>
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link href="register.css" rel="stylesheet" type="text/css">
   <title>Register</title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
   <style>
    body {
        margin: 0;
        padding: 20px;
        font-family: Calibri Light, Times New Roman, Railway;
        background: url('lo.png') no-repeat center fixed;
        background-size: 300% 300%;
        animation: gradientAnimation 70s infinite;
    }

    @keyframes gradientAnimation {
        0% {
            background-position: 0% 50%;
        }
        50% {
            background-position: 100% 50%;
        }
        100% {
            background-position: 0% 50%;
        }
    }

    .input-group {
        padding: 30px;
        background-color: lightskyblue;
        max-width: 500px;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        box-shadow: 3px 3px 3px rgba(0, 0, 0, 0.5);
    }

    h2 {
        text-align: center;
        color: white;
    }
   </style>
</head>
<body>

<div id='cssmenu'>
    <ul>
        <li><a href='login.php'><span><mark><strong>LOGIN</strong></mark></span></a></li>
    </ul>
</div>
<h2> ENTER USER NAME, EMAIL AND PASSWORD </h2>

<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$database = "db_lms";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// If the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $role = $_POST['role']; // a role field in your users table

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare SQL statement
    $sql = "INSERT INTO users (username, password, email, role) VALUES (?, ?, ?, ?)";

    // Prepare the statement
    $stmt = mysqli_prepare($conn, $sql);

    // Bind parameters to the prepared statement
    mysqli_stmt_bind_param($stmt, "ssss", $username, $hashed_password, $email, $role);

    // Execute the prepared statement
    if (mysqli_stmt_execute($stmt)) {
        $error_message = "Registration Successful";
    } else {
        $error_message = "Registration failed";
    }

    // Close statement
    mysqli_stmt_close($stmt);
}

// Close connection
mysqli_close($conn); 

?>

<div class="container">
    <div class="input-group">
        <h2>Register Here</h2>
        <pre></pre>
        <form name="registration" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <input type="text" name="username" placeholder="Username" required /><br /><br />
            <input type="email" name="email" placeholder="Email" required /><br /><br />
            <input type="password" name="password" placeholder="Password" required /><br /><br />
            <label for="role">Register As:</label>
            <select id="user_type" name="role">
                <option value="student" name="student">Student</option>
                <option value="instructor" name="instructor">Lecturer</option>
            </select><br /><br />
            <input type="submit" name="submit" value="Register" />
        </form>
        <h5 style="color:red;"><?php echo isset($error_message) ? $error_message : ''; ?></h5>
    </div>
</div>
<br /><br />

</body>
</html>
