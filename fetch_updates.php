<?php
// Include your database connection file
include "connection.php";

// Get filter parameters
$jobId = isset($_POST['jobId']) ? mysqli_real_escape_string($conn, $_POST['jobId']) : '';
$updatedBy = isset($_POST['updatedBy']) ? mysqli_real_escape_string($conn, $_POST['updatedBy']) : '';
$action = isset($_POST['action']) ? mysqli_real_escape_string($conn, $_POST['action']) : '';
$fromDate = isset($_POST['fromDate']) ? mysqli_real_escape_string($conn, $_POST['fromDate']) : '';
$toDate = isset($_POST['toDate']) ? mysqli_real_escape_string($conn, $_POST['toDate']) : '';

// Construct the SQL query based on filter parameters
$query = "SELECT * FROM psupdates WHERE 1";

if ($jobId != '') {
    $query .= " AND jobId = '$jobId'";
}

if ($updatedBy != '') {
    $query .= " AND updatedBy = '$updatedBy'";
}

if ($action != '') {
    $query .= " AND action = '$action'";
}

if ($fromDate != '') {
    $query .= " AND LastUpdated >= '$fromDate'";
}

if ($toDate != '') {
    $query .= " AND LastUpdated <= '$toDate'";
}

$query .= " ORDER BY LastUpdated DESC";

// Execute the query
$result = mysqli_query($conn, $query);

// Check for results
if ($result) {
    // Build the HTML for the table rows
    $output = '';
    while ($row = mysqli_fetch_assoc($result)) {
        $output .= "<tr>
                        <td>{$row['updatedby']}</td>
                        <td>{$row['jobId']}</td>
                        <td>{$row['feildname']}</td>
                        <td>{$row['newval']}</td>
                        <td>{$row['LastUpdated']}</td>
                        <td>{$row['action']}</td>
                    </tr>";
    }

    // Send the HTML back to the main page
    echo $output;
} else {
    echo "Error executing query: " . mysqli_error($conn);
}

// Close the database connection
mysqli_close($conn);
?>
