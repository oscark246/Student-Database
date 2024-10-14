<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("location: login.html");
    exit;
}

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

// Handle table selection
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['table'])) {
    $table = $_POST['table'];
    switch ($table) {
        case 'name_table':
            $sql = "SELECT * FROM name_table";
            $column1 = "student_id";
            $column2 = "name";
            break;
        case 'course_table':
            $sql = "SELECT * FROM course_table";
            $column1 = "student_id";
            $column2 = "course_id";
            $column3 = "test1";
            $column4 = "test2";
            $column5 = "test3";
            $column6 = "test4";
            break;
        default:
            // Invalid table, do nothing or handle as needed
            break;
    }

    $result = mysqli_query($conn, $sql);
    if ($result) {
        // Display table data
        echo "<h2>Displaying $table</h2>";
        echo "<table border='1'>";
        echo "<tr><th>$column1</th><th>$column2</th>";
        if(isset($column3)) echo "<th>$column3</th>";
        if(isset($column4)) echo "<th>$column4</th>";
        if(isset($column5)) echo "<th>$column5</th>";
        if(isset($column6)) echo "<th>$column6</th>";
        echo "</tr>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>".$row['student_id']."</td>";
            if(isset($row['name'])) echo "<td>".$row['name']."</td>";
            if(isset($row['course_id'])) echo "<td>".$row['course_id']."</td>";
            if(isset($row['test1'])) echo "<td>".$row['test1']."</td>";
            if(isset($row['test2'])) echo "<td>".$row['test2']."</td>";
            if(isset($row['test3'])) echo "<td>".$row['test3']."</td>";
            if(isset($row['test4'])) echo "<td>".$row['test4']."</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Display Database</title>
</head>
<body>
    <h2>Select table to display:</h2>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <label for="name_table">Name Table</label>
        <input type="radio" id="name_table" name="table" value="name_table" required>
        <label for="course_table">Course Table</label>
        <input type="radio" id="course_table" name="table" value="course_table" required><br><br>
        <button type="submit">Display Table</button>
    </form>
    <br>
    <a href="dashboard.php" style="display: block;">Back</a>
    <br>
    <a href="logout.php" style="display: block;">Logout</a>
</body>
</html>
