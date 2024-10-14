<?php
session_start();
// Database connection
$servername = "localhost";
$username = "root";
$password = "password";
$database = "my_school";

$conn = mysqli_connect($servername, $username, $password, $database);

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Perform delete
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'], $_POST['course_id'])) {
    $id = $_POST['id'];
    $course_id=$_POST['course_id'];
    
    // Sanitize input to prevent SQL injection
    $id = mysqli_real_escape_string($conn, $id);
    $course_id = mysqli_real_escape_string($conn, $course_id);

    // Validate ID: 1 to 9 digits long and contains only numeric characters
    if (!preg_match("/^\d{1,9}$/", $id)) {
        echo "Invalid ID: Student ID must be 1 to 9 digits long and contain only numeric characters";
        exit();
    }
     
    // Validate course_id: first 2 characters as letters and the next 3 characters as numeric
     if (!preg_match("/^[a-zA-Z]{2}[0-9]{3}$/", $course_id)) {
        echo "Invalid course code";
        exit();
    } 

    // Check if student ID is registered for the provided course ID
    $check_query = "SELECT * FROM course_table WHERE student_id='$id' AND course_id='$course_id'";
    $result = mysqli_query($conn, $check_query);
    if (mysqli_num_rows($result) == 0) {
        echo "Student ID is not registered for the provided course ID";
        exit();
    }

    $sql = "DELETE FROM course_table WHERE student_id='$id' AND course_id='$course_id'";
    if ($conn->query($sql) === TRUE) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete</title>
</head>
<body>
    <h2>Delete</h2>
    <form action="delete.php" method="post">
        Student ID: <input type="text" name="id" required><br>
        Enter Course Code to Delete:<input type="text" name="course_id" required><br>
        <button type="submit">Delete</button>
    </form>
    <br>
    <a href="dashboard.php" style="display: block;">Back</a>
    <br>
    <a href="logout.php" style="display: block;">Logout</a>
</body>
</html>
