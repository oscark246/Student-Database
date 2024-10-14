<?php
session_start();

//add course, change column

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

// Perform update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['column'], $_POST['new_value'], $_POST['id'], $_POST['course_id'])) {
    $id = $_POST['id'];
    $new_value = $_POST['new_value'];
    $column=$_POST['column'];
    $course_id=$_POST['course_id'];
    
     // Sanitize input to prevent SQL injection
     $id = mysqli_real_escape_string($conn, $id);
     $new_value = mysqli_real_escape_string($conn, $new_value);
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
    
    // Determine the column name based on user input
     $columnToUpdate = null;
     if ($column === 'test1' || $column === 'test2' || $column === 'test3' || $column === 'test4') {
         $columnToUpdate = $column;
     }else {
        echo "Invalid column name provided";
        exit();
    }

    $sql = "UPDATE course_table SET $columnToUpdate='$new_value' WHERE student_id='$id' AND course_id='$course_id'" ;
    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update</title>
</head>
<body>
    <h2>Update</h2>
    <form action="update.php" method="post">
        Enter Student ID:<input type="text" name="id" required><br>
        Enter Course Code:<input type="text" name="course_id" required><br>
        Enter column you want to change(test1, test2, test3, test4): <input type="text" name="column" required><br>
        New Value: <input type="text" name="new_value" required><br>
        <button type="submit">Update</button>
    </form>
    <br>
    <a href="dashboard.php" style="display: block;">Back</a>
    <br>
    <a href="logout.php" style="display: block;">Logout</a>
</body>
</html>
