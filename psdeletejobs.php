<?php
session_start();

$updateby = $_SESSION['Loggedinas'];

include 'connection.php';

// Retrieve the values sent from the JavaScript code
$jobIDs = json_decode($_POST['jobIds']); // Assuming you receive an array of job IDs to delete

try {
    if ($conn) {
        foreach ($jobIDs as $jobID) {
            // Escape the user input to prevent SQL injection
            $jobID = mysqli_real_escape_string($conn, $jobID);

            // Get the data to be deleted for the history log
            $deleteQuery = "SELECT * FROM jobsnew WHERE jobid = ?";
            $deleteStatement = mysqli_prepare($conn, $deleteQuery);
            mysqli_stmt_bind_param($deleteStatement, 's', $jobID);
            mysqli_stmt_execute($deleteStatement);
            $deletedData = mysqli_stmt_get_result($deleteStatement);

            if (!$deletedData) {
                throw new Exception("Error retrieving data for job ID: " . $jobID);
            }

            // Fetch the row as an associative array
            $row = mysqli_fetch_assoc($deletedData);

            // Delete the record from the main table (jobsnew)
            $deleteMainQuery = "DELETE FROM jobsnew WHERE jobid = ?";
            $deleteMainStatement = mysqli_prepare($conn, $deleteMainQuery);
            mysqli_stmt_bind_param($deleteMainStatement, 's', $jobID);

            // Execute the delete statement for the main table
            if (mysqli_stmt_execute($deleteMainStatement)) {
                // Insert the deleted data into the history table
                $insertHistoryQuery = "INSERT INTO psupdates (updatedby, jobId, feildname, newval, LastUpdated, action) VALUES (?, ?, ?, ?, NOW(), 'Deleted')";
                $insertHistoryStatement = mysqli_prepare($conn, $insertHistoryQuery);

                if ($insertHistoryStatement) {
                    $fieldname = "jobid"; // Field name for the deleted job ID
                    $newval = $jobID; // New value is the job ID
                    $action = "Deleted";

                    // Bind the parameters to the insert statement
                    mysqli_stmt_bind_param($insertHistoryStatement, 'ssss', $updateby, $jobID, $fieldname, $newval);

                    // Execute the insert statement
                    $insertResult = mysqli_stmt_execute($insertHistoryStatement);

                    if (!$insertResult) {
                        throw new Exception("Error inserting data into Update History table for job ID: " . $jobID);
                    }

                    // Close the insert statement
                    mysqli_stmt_close($insertHistoryStatement);
                } else {
                    throw new Exception("Failed to prepare insert statement for Update History table for job ID: " . $jobID);
                }

                $response = array('status' => 'success', 'message' => 'Record deleted successfully');
            } else {
                throw new Exception("Error deleting record for job ID: " . $jobID);
            }

            // Close the delete statement for the main table
            mysqli_stmt_close($deleteMainStatement);
        }
    } else {
        throw new Exception("Connection failed: " . mysqli_connect_error());
    }
} catch (Exception $e) {
    // Log the exception message
    error_log($e->getMessage(), 0);

    $response = array('status' => 'error', 'message' => 'Failed to delete jobs. Please try again: ' . $e->getMessage());
}

// Encode the response as JSON and send it back to JavaScript
header('Content-Type: application/json');
echo json_encode($response);
?>
