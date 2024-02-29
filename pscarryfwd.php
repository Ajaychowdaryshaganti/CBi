<?php
// Include your connection.php file to establish a database connection
include('connection.php');

// Get the POST data from the AJAX request
$extrareq = $_POST['extrareq'];
$nextOption = $_POST['nextOption'];

error_log($extrareq);
// Parse the nextOption string to extract date1 and date2
list($date1, $date2) = explode(',', $nextOption);

$date1 = date("Y-m-d", strtotime($date1));
$date2 = date("Y-m-d", strtotime($date2));
// Create a prepared statement
$sql = "UPDATE jobsnew SET broughtfwd = $extrareq WHERE date1=? AND date2 = ?";
$stmt = $conn->prepare($sql);

if ($stmt) {
    // Bind the parameters
    $stmt->bind_param("ss",  $date1, $date2);

    // Execute the statement
    if ($stmt->execute()) {
        // Send a success response
        echo "Jobsnew table updated successfully.";
    } else {
        // Handle execution error
        echo "Error updating jobsnew table: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
} else {
    // Handle prepare error
    echo "Error preparing SQL statement: " . $conn->error;
}

// Close the database connection
$conn->close();
?>
