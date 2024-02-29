<?php
session_start();

$updateby = $_SESSION['Loggedinas'];

include 'connection.php';

// Retrieve the values sent from the JavaScript code
$jobID = $_POST['jobID'];


$response = array(); // Initialize the response array

try {
    if ($conn) {
        // Escape the user input to prevent SQL injection
        $jobID = mysqli_real_escape_string($conn, $jobID);

        $insertQueryJobsNew = "INSERT INTO workorders (jobid, LastUpdated, lastupdatedby) VALUES (?, NOW(), ?)";
        $insertStatementJobsNew = mysqli_prepare($conn, $insertQueryJobsNew);

        if ($insertStatementJobsNew) {
            // Bind the parameters to the insert statement
            mysqli_stmt_bind_param($insertStatementJobsNew, 'ss', $jobID, $updateby);

            // Execute the insert statement for Work Orders
            $insertResultJobsNew = mysqli_stmt_execute($insertStatementJobsNew);

            if (!$insertResultJobsNew) {
                throw new Exception("Error inserting data into Work Orders table: " . mysqli_error($conn));
            }

            // Close the insert statement for Work Orders
            mysqli_stmt_close($insertStatementJobsNew);
        } else {
            throw new Exception("Failed to prepare insert statement for Work Orders table");
        }

        // Prepare the SQL statement for inserting into psupdates
$insertQueryPSUpdates = "INSERT INTO psupdates (updatedby, jobId, feildname, newval, LastUpdated, action) VALUES (?, ?, 'Work Order', ?, NOW(), 'new work order added')";
$insertStatementPSUpdates = mysqli_prepare($conn, $insertQueryPSUpdates);

if ($insertStatementPSUpdates) {
    // Bind the parameters to the insert statement
    mysqli_stmt_bind_param($insertStatementPSUpdates, 'sss', $updateby, $jobID, $jobID);

    // Execute the insert statement for psupdates
    $insertResultPSUpdates = mysqli_stmt_execute($insertStatementPSUpdates);

    if (!$insertResultPSUpdates) {
        throw new Exception("Error inserting data into psupdates table: " . mysqli_error($conn));
    }

    // Close the insert statement for psupdates
    mysqli_stmt_close($insertStatementPSUpdates);
} else {
    throw new Exception("Failed to prepare insert statement for psupdates table");
}

        $response['status'] = 'success';
        $response['message'] = 'Record added successfully';
    } else {
        throw new Exception("Connection failed: " . mysqli_connect_error());
    }
} catch (Exception $e) {
    $response['status'] = 'error';
    $response['message'] = $e->getMessage(); // Include the error message in the response
}

// Encode the response as JSON and send it back to JavaScript
header('Content-Type: application/json');
echo json_encode($response);
?>
