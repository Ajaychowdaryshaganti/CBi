<?php
session_start();

$updateby = $_SESSION['Loggedinas'];

include 'connection.php';

$jsonData = file_get_contents('php://input');

// Decode the JSON data into a PHP array or object
$data = json_decode($jsonData, true); // Set the second parameter to true for an associative array

// Check if the decoding was successful
if ($data !== null) {
    // Access the data as needed
    $selectedJobIds = $data['selectedJobIds'];
    $selectedWeek = $data['selectedWeek'];
    
    try {
        if ($conn) {
            foreach ($selectedJobIds as $jobID) {
                // Escape the user input to prevent SQL injection
                $jobID = mysqli_real_escape_string($conn, $jobID);

                // Update the date1 and date2 columns in the main table (jobsnew)
                $updateQuery = "UPDATE jobsnew SET date1 = ?, date2 = ?, LastUpdated = NOW(), lastupdatedby = ? WHERE jobid = ?";
                $updateStatement = mysqli_prepare($conn, $updateQuery);
                $dates = explode(',', $selectedWeek);
                  $date1 = date('Y-m-d', strtotime(trim($dates[0])));
                $date2 = date('Y-m-d', strtotime(trim($dates[1])));
                mysqli_stmt_bind_param($updateStatement, 'ssss', $date1, $date2, $updateby, $jobID);

                // Execute the update statement for the main table
                if (mysqli_stmt_execute($updateStatement)) {
                    // Insert the updated data into the history table
                    $insertHistoryQuery = "INSERT INTO psupdates (updatedby, jobId, feildname, newval, LastUpdated, action) VALUES (?, ?, ?, ?, NOW(), 'Moved')";
                    $insertHistoryStatement = mysqli_prepare($conn, $insertHistoryQuery);

                    if ($insertHistoryStatement) {
                        $fieldname = "All"; // Field name for the updated dates
                        $newval = $selectedWeek; // New values are the updated dates
                        $action = "Moved";

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

                    $response = array('success' => true, 'message' => 'Record updated successfully');
                } else {
                    throw new Exception("Error updating record for job ID: " . $jobID);
                }

                // Close the update statement for the main table
                mysqli_stmt_close($updateStatement);
            }
        } else {
            throw new Exception("Connection failed: " . mysqli_connect_error());
        }
    } catch (Exception $e) {
        // Log the exception message
        error_log($e->getMessage(), 0);

        $response = array('success' => false, 'message' => 'Failed to update jobs. Please try again: ' . $e->getMessage());
    }
} else {
    $response = array('success' => false, 'message' => 'Data not found');
}

// Encode the response as JSON and send it back to JavaScript
header('Content-Type: application/json');
echo json_encode($response);
?>
