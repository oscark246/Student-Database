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

// Perform search
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['student_id'])) {
    $student_id = $_GET['student_id'];
    
    // Sanitize input to prevent SQL injection
    $student_id = mysqli_real_escape_string($conn, $student_id);

    // Validate ID: 9 digits long and contains only numeric characters
    if (!preg_match("/^[0-9]{9}$/", $student_id)) {
        echo "Invalid ID: Student ID must be 1 to 9 digits long and contain only numeric characters";
        exit();
    }

    $sql = "SELECT course_table.*, name_table.name 
            FROM course_table 
            INNER JOIN name_table 
            ON course_table.student_id = name_table.student_id 
            WHERE course_table.student_id='$student_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Display search results in a table
        echo "<table border='1'>";
        echo "<tr><th>Student ID</th><th>Student Name</th><th>Course</th><th>Test 1</th><th>Test 2</th><th>Test 3</th><th>Test 4</th><th>Final Grade</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['student_id'] . "</td>"; // Display Student ID
            echo "<td>" . $row['name'] . "</td>"; // Display Student Name
            echo "<td>" . $row['course_id'] . "</td>";
            echo "<td>" . $row['test1'] . "</td>";
            echo "<td>" . $row['test2'] . "</td>";
            echo "<td>" . $row['test3'] . "</td>";
            echo "<td>" . $row['test4'] . "</td>";
            // Calculate final grade by summing up values from four columns
            $final_grade = 20*($row['test1']/100) + 20*($row['test2']/100) + 20*($row['test3']/100) + 40*($row['test4']/100);
            echo "<td>" . $final_grade . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No results found.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search</title>
</head>
<body>
    <h2>Search Registered Courses by Student ID</h2>
    <form action="search.php" method="get">
        Student ID: <input type="text" name="student_id" placeholder="Enter Student ID" required>
        <button type="submit">Search</button>
    </form>
    <br>
    <a href="dashboard.php" style="display: block;">Back</a>
    <br>
    <a href="logout.php" style="display: block;">Logout</a>
</body>
</html>
