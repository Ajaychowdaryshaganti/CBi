<?php
// Include your database connection file here
session_start();
include 'connection.php';
$status = session_status();

// Check the session status
if ($status == PHP_SESSION_DISABLED) {
    error_log ("Sessions are disabled on the server.");
} elseif ($status == PHP_SESSION_NONE) {
    error_log ("Sessions are enabled, but no session exists or has started.");
} elseif ($status == PHP_SESSION_ACTIVE) {
    error_log ("A session has started.");
} error_log ("Unknown session status.");

// Initialize a response array
$response = array('success' => false, 'message' => '');
error_log('POST Data: ' . print_r($_POST, true));
error_log('Loggedinas: ' . $loggedinas);

try {
    // Check if the request method is POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $elementId = $_POST['elementId'];
        $newValue = $_POST['newValue'];
        $daycap = $_POST['daycap'];
        $nooffitters = $_POST['nooffitters'];
        $startDate = $_POST['startDate'];
        $endDate = $_POST['endDate'];
        $loggedinas = $_SESSION['Loggedinas']; // Assuming you have started the session

        // Check if all required data is available
        if ($elementId && $newValue && $daycap && $nooffitters && $startDate && $endDate && $loggedinas) {
            // Update the main table
            $updateMainTableQuery = "UPDATE jobsnew SET $elementId = ? WHERE Date1 >= ? AND Date2 <= ?";
            $updateMainTableStatement = mysqli_prepare($conn, $updateMainTableQuery);

            if ($updateMainTableStatement) {
                mysqli_stmt_bind_param($updateMainTableStatement, 'sss', $newValue, $startDate, $endDate);

                if (mysqli_stmt_execute($updateMainTableStatement)) {
                    // Update the psupdates table
                    $insertHistoryQuery = "INSERT INTO psupdates (updatedby, jobId, feildname, newval, LastUpdated, action) VALUES (?, ?, ?, ?, NOW(), 'Updated')";
                    $insertHistoryStatement = mysqli_prepare($conn, $insertHistoryQuery);

                    if ($insertHistoryStatement) {
                        $fieldname = $elementId; // Field name to be updated
                        $jobID = 'week'; // Replace with the actual job ID
                        

                        // Bind the parameters to the insert statement
                        mysqli_stmt_bind_param($insertHistoryStatement, 'ssss', $loggedinas, $jobID, $fieldname, $newValue);

                        if (mysqli_stmt_execute($insertHistoryStatement)) {
                            $response['success'] = true;
                            $response['message'] = 'Value updated in the database';
                        } else {
                            $response['message'] = 'Failed to update value in the database';
                        }
                    } else {
                        $response['message'] = 'Error preparing psupdates statement';
                    }
                } else {
                    $response['message'] = 'Error executing main table update statement';
                }
            } else {
                $response['message'] = 'Error preparing main table update statement';
            }
        } else {
            $response['message'] = 'Missing or invalid data in the request';
        }
    } else {
        $response['message'] = 'Invalid request method';
    }
} catch (Exception $e) {
    $response['message'] = $e->getMessage();
}

// Return the response as JSON
echo json_encode($response);
?>
