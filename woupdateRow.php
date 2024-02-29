<?php
session_start();

$updateby = $_SESSION['Loggedinas'];

include 'connection.php';

// Retrieve the values sent from the JavaScript code
$jobID = $_POST['jobID'];
$columnName = $_POST['columnName'];
$newValue = $_POST['newValue'];

try {
    if ($conn) {

// Prepare the SQL statement with placeholders for updating the main table (jobsnew)
$updateQuery = "UPDATE workorders SET $columnName = ?, lastupdated = NOW(), lastupdatedby = ?";


$updateQuery .= " WHERE jobid = ?";
$statement = mysqli_prepare($conn, $updateQuery);

if ($statement) {

        mysqli_stmt_bind_param($statement, 'sss', $newValue, $updateby, $jobID);
    

    // Execute the statement
    $result = mysqli_stmt_execute($statement);

    if ($result) {
        // Record updated successfully, now insert into psupdates table
        $insertQuery = "INSERT INTO psupdates (updatedby, jobId, feildname, newval, LastUpdated, action) VALUES (?, ?, ?, ?, NOW(), 'Edited (Work Orders)')";
        $insertStatement = mysqli_prepare($conn, $insertQuery);

        if ($insertStatement) {
            // Bind the parameters to the insert statement
            mysqli_stmt_bind_param($insertStatement, 'ssss', $updateby, $jobID, $columnName, $newValue);

            // Execute the insert statement
            $insertResult = mysqli_stmt_execute($insertStatement);

                    // Execute the insert statement
                    $insertResult = mysqli_stmt_execute($insertStatement);

                    if (!$insertResult) {
                        // Capture and log the MySQL error for debugging
                        $error_message = mysqli_error($conn);
                        throw new Exception("Error inserting data into Update History table: " . $error_message);
                    }

                    // Close the insert statement
                    mysqli_stmt_close($insertStatement);
                } else {
                    throw new Exception("Failed to prepare insert statement for Update History table: " . mysqli_error($conn));
                }

                $response = array('status' => 'success', 'message' => 'Record updated successfully');
            } else {
                throw new Exception("Error updating record: " . mysqli_error($conn));
            }

            // Close the main update statement
            mysqli_stmt_close($statement);
        } else {
            throw new Exception("Failed to prepare statement for main table update: " . mysqli_error($conn));
        }
    } else {
        throw new Exception("Connection failed: " . mysqli_connect_error());
    }
} catch (Exception $e) {
    // Log the exception message
    error_log($e->getMessage(), 0);

    $response = array('status' => 'error', 'message' => 'Something went wrong! Please try again.');
}

// Encode the response as JSON and send it back to JavaScript
header('Content-Type: application/json');
echo json_encode($response);
?>
