<?php
$servername = "localhost";
$username = "root";
$password = "CBi@1234";
$database = "CBi";

// Create a connection
$conn = new mysqli($servername, $username, $password, $database);

// Set the SQL mode to an empty string
$sql = "SET sql_mode = ''";
$result = $conn->query($sql);

// Check for query execution errors
if (!$result) {
    die("Error setting SQL mode: " . $connection->error);
}
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set the time zone
$query = "SET time_zone = '+10:00'";
$result = $conn->query($query);

if (!$result) {
    die("Error setting time zone: " . $conn->error);
}

// Continue with your database operations
// ...

date_default_timezone_set('Australia/Melbourne');

// Now you can use PHP date/time functions with the specified time zone
$currentDateTime = date('Y-m-d H:i:s');
//echo "Current date and time in Melbourne: " . $currentDateTime;

?>
