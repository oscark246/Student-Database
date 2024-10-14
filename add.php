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

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Add course
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'], $_POST['course_id'], $_POST['test1'], $_POST['test2'], $_POST['test3'], $_POST['test4'])) {
    $id = $_POST['id'];
    $course_id=$_POST['course_id'];
    $test1=$_POST['test1'];
    $test2=$_POST['test2'];
    $test3=$_POST['test3'];
    $test4=$_POST['test4'];

    
     // Sanitize input to prevent SQL injection
     $id = mysqli_real_escape_string($conn, $id);
     $course_id = mysqli_real_escape_string($conn, $course_id);
     $test1 = mysqli_real_escape_string($conn, $test1);
     $test2 = mysqli_real_escape_string($conn, $test2);
     $test3 = mysqli_real_escape_string($conn, $test3);
     $test4 = mysqli_real_escape_string($conn, $test4);
    
    // Validate ID: 1 to 9 digits long and contains only numeric characters
    if (!preg_match("/^\d{1,9}$/", $id)) {
        echo "Invalid ID: Student ID must be 1 to 9 digits long and contain only numeric characters";
        exit();
    }
     
    // Validate course_id: first 2 characters as letters and the next 3 characters as numeric
     if (!preg_match("/^[a-zA-Z]{2}[0-9]{3}$/", $course_id)) {
        echo "Invalid course code: Course code must have first 2 characters as letters and the next 3 characters as numeric ";
        exit();
    } 
    
    // SQL query to insert data into database
    $sql = "INSERT INTO course_table (student_id, course_id, test1, test2, test3, test4)
    VALUES ('$id', '$course_id', '$test1', '$test2', '$test3', '$test4')";

    if ($conn->query($sql) === TRUE) {
        echo "Course added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Course</title>
</head>
<body>
    <h2>Add Course</h2>
    <form action="add.php" method="post">
        Enter Student ID:<input type="text" name="id" required><br>
        Enter Course Code:<input type="text" name="course_id" required><br>
        Enter test1 score: <input type="text" name="test1" required><br>
        Enter test2 score: <input type="text" name="test2" required><br>
        Enter test3 score: <input type="text" name="test3" required><br>
        Enter test4 score: <input type="text" name="test4" required><br>
        <button type="submit">Add</button>
    </form>
    <br>
    <a href="dashboard.php" style="display: block;">Back</a>
    <br>
    <a href="logout.php" style="display: block;">Logout</a>
</body>
</html>