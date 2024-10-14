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
// Register student
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'], $_POST['name'])) {
    $id = $_POST['id'];
    $name=$_POST['name'];

    
     // Sanitize input to prevent SQL injection
     $id = mysqli_real_escape_string($conn, $id);
     $name = mysqli_real_escape_string($conn, $name);
     
    // Validate ID: 1 to 9 digits long and contains only numeric characters
    if (!preg_match("/^\d{1,9}$/", $id)) {
        echo "Invalid ID: Student ID must be 1 to 9 digits long and contain only numeric characters";
        exit();
    }
    
    // Check if the student already exists in the database
    $check_query = "SELECT * FROM name_table WHERE student_id='$id'";
    $result = mysqli_query($conn, $check_query);
    if (mysqli_num_rows($result) > 0) {
        echo "Student with this ID already exists.";
        exit();
    }
    
    // SQL query to insert data into database
    $sql = "INSERT INTO name_table (student_id, name)
    VALUES ('$id', '$name')";

    if ($conn->query($sql) === TRUE) {
        echo "Registerd successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register Student</title>
</head>
<body>
    <h2>Register Student</h2>
    <form action="register.php" method="post">
        Enter Student ID:<input type="text" name="id" required><br>
        Enter Full Name:<input type="text" name="name" required><br>
        <button type="submit">Register</button>
    </form>
    <br>
    <a href="login.php" style="display: block;">Back</a>
    

</body>
</html>