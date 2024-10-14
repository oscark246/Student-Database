<?php
// MySQL database connection settings
$servername = "localhost"; // Replace 'localhost' with your MySQL server address
$username = "root"; // Replace 'username' with your MySQL username
$password = "password"; // Replace 'password' with your MySQL password
$database = "my_school"; // Replace 'database' with your MySQL database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "Connected successfully";

// Example query
$sql = "SELECT * FROM name_table"; // Replace 'your_table_name' with your actual table name
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        // Print each column value of the row
        foreach ($row as $key => $value) {
            echo "$key: $value<br>";
        }
        echo "<br>";
    }
} else {
    echo "0 results";
}


$conn->close();
?>
