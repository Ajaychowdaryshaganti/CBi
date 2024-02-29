<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['Loggedinas'])) {
    header("Location: index.html");
    exit();
}

// Include the database connection file
include 'connection.php';

// Retrieve the job parameter from the AJAX request
$job = isset($_POST['job']) ? $_POST['job'] : null;

// Check if the job parameter is provided
if (!$job) {
    $response = array('status' => 'error', 'message' => 'Job parameter is missing');
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}

try {
    // Escape the user input to prevent SQL injection
    $job = mysqli_real_escape_string($conn, $job);

    // Get the work order data from workorders1 table
    $selectQuery = "SELECT * FROM workorders1 WHERE jobid = ?";
    $selectStatement = mysqli_prepare($conn, $selectQuery);
    mysqli_stmt_bind_param($selectStatement, 's', $job);
    mysqli_stmt_execute($selectStatement);
    $result = mysqli_stmt_get_result($selectStatement);

    if (!$result) {
        throw new Exception("Error retrieving data for job ID: " . $job);
    }

    // Fetch the row as an associative array
    $row = mysqli_fetch_assoc($result);

    // Assign the session value to a variable
    $loggedinas = $_SESSION['Loggedinas'];

    // Get the current timestamp
    $currentTimestamp = date('Y-m-d H:i:s');

	// Assign values to variables
	$jobid = $row['jobid'];
	$date = $row['date'];
	$type = $row['type'];
	$description = $row['description'];
	$allocatedhrs = $row['allocatedhrs'];
	$etd = $row['etd'];
	$partavailability = $row['partavailability'];
	$dbavailability = $row['dbavailability'];
	$escdate = $row['escdate'];
	$fitter1 = $row['fitter1'];
	$fitter2 = $row['fitter2'];
	$fitter3 = $row['fitter3'];
	$currentstate = $row['currentstate'];
	$priority = $row['priority'];
	$builtby = $row['builtby'];
	$comments = $row['comments'];
	$comments2 = $row['comments2'];
	$loggedinas = $row['lastupdatedby'];
	
	// Insert the data into workorders table
	$insertQuery = "INSERT INTO workorders (jobid, date, type, description, allocatedhrs, etd, partavailability, dbavailability, escdate, fitter1, fitter2, fitter3, currentstate, priority, builtby, comments, comments2, LastUpdated, lastupdatedby) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, now(), ?)";
	$insertStatement = mysqli_prepare($conn, $insertQuery);
	mysqli_stmt_bind_param($insertStatement, 'sssssssssssssssssi', $jobid, $date, $type, $description, $allocatedhrs, $etd, $partavailability, $dbavailability, $escdate, $fitter1, $fitter2, $fitter3, $currentstate, $priority, $builtby, $comments, $comments2, $loggedinas);
	$insertResult = mysqli_stmt_execute($insertStatement);
	

    // Check the insertion result
    if ($insertResult) {
        // Delete the record from workorders1 table
        $deleteQuery = "DELETE FROM workorders1 WHERE jobid = ?";
        $deleteStatement = mysqli_prepare($conn, $deleteQuery);
        mysqli_stmt_bind_param($deleteStatement, 's', $job);
        $deleteResult = mysqli_stmt_execute($deleteStatement);

        // Check the deletion result
        if ($deleteResult) {
            // Insert the data into psupdates table
            $psupdateQuery = "INSERT INTO psupdates (updatedby, jobId, feildname, newval, LastUpdated, action) VALUES (?, ?, ?, 'Restored', ?, 'Restored')";
            $psupdateStatement = mysqli_prepare($conn, $psupdateQuery);
            mysqli_stmt_bind_param($psupdateStatement, 'ssss', $loggedinas, $jobid, $jobid, $currentTimestamp);
            $psupdateResult = mysqli_stmt_execute($psupdateStatement);

            // Check the psupdate insertion result
            if (!$psupdateResult) {
                throw new Exception("Error inserting into psupdates table");
            }

            // Close the statements
            mysqli_stmt_close($insertStatement);
            mysqli_stmt_close($deleteStatement);
            mysqli_stmt_close($psupdateStatement);

            // Success response
            $response = array('status' => 'success', 'message' => 'Work order restored successfully');
        } else {
            // Error response for deletion failure
            throw new Exception("Error deleting record from workorders1 table");
        }
    } else {
        // Error response for insertion failure
        throw new Exception("Error inserting work order");
    }
} catch (Exception $e) {
    // Log the exception message
    error_log($e->getMessage(), 0);

    $response = array('status' => 'error', 'message' => 'Failed to restore work order. Please try again: ' . $e->getMessage());
}

// Add debugging statements
$response['debug'] = array(
    'insertQuery' => $insertQuery,
    'deleteQuery' => $deleteQuery,
    'psupdateQuery' => $psupdateQuery,
);

// Encode the response as JSON and send it back to JavaScript
header('Content-Type: application/json');
echo json_encode($response);
?>
