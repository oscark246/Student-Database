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

// Handle action selection
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'])) {
    $action = $_POST['action'];
    switch ($action) {
        case 'search':
            header("location: search.php");
            exit;
        case 'update':
            header("location: update.php");
            exit;
        case 'delete':
            header("location: delete.php");
            exit;
        case 'add':
            header("location: add.php");
            exit;
        case 'display':
            header("location: display.php");
        default:
            // Invalid action, do nothing or handle as needed
            break;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>
    <h2>Welcome <?php echo $_SESSION['username']; ?></h2>
    <a href="logout.php">Logout</a><br><br>

    <!-- Form for action selection -->
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <button type="submit" name="action" value="search">Search</button>
        <button type="submit" name="action" value="update">Update</button>
        <button type="submit" name="action" value="delete">Delete</button>
        <button type="submit" name="action" value="add">Add course</button>
        <button type="submit" name="action" value="display">Display Database</button>
    </form>
</body>
</html>
