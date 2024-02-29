<?php
session_start();

$updateby = $_SESSION['Loggedinas'];

include 'connection.php';

// Retrieve the values sent from the JavaScript code
$jobIDs = json_decode($_POST['jobIds']);
$x = $_POST['x'];

try {
    if ($conn) {
        foreach ($jobIDs as $jobID) {
            // Escape the user input to prevent SQL injection
            $jobID = mysqli_real_escape_string($conn, $jobID);

            // Get details from workorders table
            $selectQuery = "SELECT * FROM workorders WHERE jobid = ?";
            $selectStatement = mysqli_prepare($conn, $selectQuery);
            mysqli_stmt_bind_param($selectStatement, 's', $jobID);
            mysqli_stmt_execute($selectStatement);
            $selectedData = mysqli_stmt_get_result($selectStatement);

            if (!$selectedData) {
                throw new Exception("Error retrieving data for job ID: " . $jobID);
            }

            // Fetch the row as an associative array
            $row = mysqli_fetch_assoc($selectedData);

			$insertQuery = "INSERT INTO workorders1 SELECT *, ? as action FROM workorders WHERE jobid = ?";
			$insertStatement = mysqli_prepare($conn, $insertQuery);
			mysqli_stmt_bind_param($insertStatement, 'ss', $x, $jobID);
			mysqli_stmt_execute($insertStatement);

            if (!$insertStatement) {
                throw new Exception("Error inserting data into workorders1 table for job ID: " . $jobID);
            }

            // Delete the record from the main table (workorders)
            $deleteQuery = "DELETE FROM workorders WHERE jobid = ?";
            $deleteStatement = mysqli_prepare($conn, $deleteQuery);
            mysqli_stmt_bind_param($deleteStatement, 's', $jobID);

            // Execute the delete statement for the main table
            if (mysqli_stmt_execute($deleteStatement)) {
			// Insert the deleted data into the history table
			$insertHistoryQuery = "INSERT INTO psupdates (updatedby, jobId, feildname, newval, LastUpdated, action) VALUES (?, ?, ?, ?, NOW(), ?)";
			$insertHistoryStatement = mysqli_prepare($conn, $insertHistoryQuery);
			
			if ($insertHistoryStatement) {
				$action = ($x == 1) ? 'Receipted' : 'Cancelled';
			
				// Bind the parameters to the insert statement
				mysqli_stmt_bind_param($insertHistoryStatement, 'sssss', $updateby, $jobID, $jobID, $action, $action);
			
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


                $response = array('status' => 'success', 'message' => 'Record moved successfully');
            } else {
                throw new Exception("Error deleting record for job ID: " . $jobID);
            }

            // Close the delete statement for the main table
            mysqli_stmt_close($deleteStatement);
        }
    } else {
        throw new Exception("Connection failed: " . mysqli_connect_error());
    }
} catch (Exception $e) {
    // Log the exception message
    error_log($e->getMessage(), 0);

    $response = array('status' => 'error', 'message' => 'Failed to move jobs. Please try again: ' . $e->getMessage());
}

// Encode the response as JSON and send it back to JavaScript
header('Content-Type: application/json');
echo json_encode($response);
?>
