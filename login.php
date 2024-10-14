<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "password";
$database = "my_school";

$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // SQL to fetch user from database
    $sql = "SELECT * FROM name_table WHERE name='$username' AND student_id='$password'";
    $result = mysqli_query($conn, $sql);

    // Check if user exists
    if (mysqli_num_rows($result) == 1) {
        $_SESSION['username'] = $username; // Store username in session
        header("location: dashboard.php"); // Redirect to dashboard
    } else {
        echo "Invalid username or password";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <form action="" method="post">
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username"><br>
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password"><br><br>
        <input type="submit" value="Login">
        <br>
        <a href="register.php" style="display: block;">Register</a>
    </form>
</body>
</html>