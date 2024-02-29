<?php
// Start or resume the session
session_start();

if($_SESSION['Loggedinas']){
	
}
else{
	 header("Location:index.html");
}
	
// Now you have an active session
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CBI | Work Orders</title>
    <!-- References to external basic CSS file -->
    <link rel="stylesheet" type="text/css" href="styles/style.css">
    <!-- Favicon for tab -->
    <link rel="icon" type="image/x-icon" href="images/game-fill.png">
    <!-- Reference to web icons from Remixicon.com -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <!-- Reference to web icons from Fontawesome -->
    <script src="https://kit.fontawesome.com/d7376949ab.js" crossorigin="anonymous"></script>
    <!-- References to external fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        .{
            display: flex;
			overflow:hidden !! important;
        }



        #cbi-logo img {
            width: 10.2%;
            margin-left: 88%;
            margin-top: -27.5%;
        }

        hr {
            margin-top: -2%;
            border: none;
            /* top    */ border-top: 1px solid #ccc;
            /* middle */ background-color: #ddd;
            color: #ddd;
            /* bottom */ border-bottom: 1px solid #eee;
            height: 1px;
            *height: 3px; /* IE6+7 need the total height */
        }

#top-head {
    //position: sticky;
    top: 0;
    background-color: white; /* Set the background color as needed */
    z-index: 100; /* Adjust the z-index as needed */
    /* Remove any properties related to horizontal scrolling */
    /* Remove height: 250px; if not needed */
    height: 150px;
}
hr{
	margin-top:-8.5%;
}


#contentContainer {
    display: flex;
	margin-left: 0;
    /* Add the following properties to enable horizontal and vertical scrolling */
    overflow-x: auto !important; /* Enable horizontal scrolling */
    overflow-y: auto !important; /* Enable vertical scrolling */
    //max-height: calc(100vh - 250px);
	height:auto;
    transition: margin-left 1.5s ease; /* Add transition to margin-left property */
	z-index:0;
}
		
#newJobForm {
    display: flex;
    align-items: center;
    margin-bottom: 10px;
    margin-top: 10px;
    margin-left: 42%;
}

#newJobForm input{
    width: 16%;
    border: 1px solid;
    border-radius: 4px;
    //padding: 8px 20px;
}
#addNewJobButton {
    background-color: #007BFF;
    color: #fff;
    border: none;
    padding: 10px 20px;
    border-radius: 4px;
    cursor: pointer;
    margin-left:2%;
}   
		#refresh {
            background-color: #007BFF; /* Blue color, you can change it */
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
			margin-left:85%;
			margin-right:2%;

        }

        /* Additional styles for the job rows */
        .job-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .editable {
            flex: 1;
            padding: 1px;
            border: 1px solid black;
            border-radius: 3px;
			font-size:15px;
			height:auto;
        }
#deletebutton{
		font: 400 1rem 'Jost', sans-serif;
    color: #ffeef0;
    background-color: #FF6978;
    text-decoration: none;
    border: 2px solid transparent;
    border-radius: 8px;
    padding: 8px 10px;
	 transition: margin-left 1.5s ease; 
}#recieptedbutton{
		font: 400 1rem 'Jost', sans-serif;
    color: #ffeef0;
    background-color:green;
    text-decoration: none;
    border: 2px solid transparent;
    border-radius: 8px;
    padding: 8px 10px;
	 transition: margin-left 1.5s ease; 
}#cancelledbutton{
		font: 400 1rem 'Jost', sans-serif;
    color: #ffeef0;
    background-color: red;
    text-decoration: none;
    border: 2px solid transparent;
    border-radius: 8px;
    padding: 8px 10px;
	 transition: margin-left 1.5s ease; 
}
/* Styles for the modal */

.modal {
    display: none;
	margin-top:0%;
	background-color: rgba(0, 0, 0, 0.7);
	width:100%;
	height:100%
}
.modal1 {
    display: none;
	margin-top:0%;
	background-color: rgba(0, 0, 0, 0.7);
	width:100%;
	height:100%
}
.modal2 {
    display: none;
	margin-top:-30%;

}

.modal-content {
    background-color: #f2f2f2;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    padding: 20px;
    border: 1px solid #ccc;
    width: 30%;
    height: auto;
    text-align: center;
    border-radius: 5px;
    box-shadow: 0px 0px 10px 0px #000;
    z-index: 999;
    transition: fade-in 1s ease;
}


.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}
.close1 {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover {
    color: red;
    cursor: pointer;
}
.close1:hover {
    color: red;
    cursor: pointer;
}


#confirmDelete {
    background-color: red;
    color: white;
    border: none;
    padding: 10px 20px;
    margin-top: 10px;
    cursor: pointer;
    border-radius: 3px;
    transition: background-color 0.3s;
}


#confirmDelete:hover {
    background-color: #cc0000;
}
#confirmmove {
    background-color: red;
    color: white;
    border: none;
    padding: 10px 20px;
    margin-top: 10px;
    cursor: pointer;
    border-radius: 3px;
    transition: background-color 0.3s;
}


#confirmmove:hover {
    background-color: #cc0000;
}

#confirmationModal{
	background-color:transparent;
}
#confirmationModal1{
	background-color:transparent;
}
#jobIdList li {
	list-style: none;
}
#jobIdList1 li {
	list-style: none;
}


        /* Media query to show the menu when the checkbox is checked (hamburger icon clicked) */
        @media (max-width:3000px) {
            nav {
                left: 0; /* Display the menu when checkbox is checked */
            }


        }

    </style>
</head>
<?php
// Start a PHP session
//session_start();

// Now you can store and retrieve session data
//$_SESSION['Loggedinas'] = 'Ajay'; // Store a value in the session

/*
$status = session_status();

// Check the session status
if ($status == PHP_SESSION_DISABLED) {
    echo "Sessions are disabled on the server.";
} elseif ($status == PHP_SESSION_NONE) {
    echo "Sessions are enabled, but no session exists or has started.";
} elseif ($status == PHP_SESSION_ACTIVE) {
    echo "A session has started.";
} else {
    echo "Unknown session status.";
}

echo $_SESSION['Loggedinas'];
*/
if (isset($_SESSION['defaultWeek'])) {
    $currentTime = time();
    $variableTimestamp = $_SESSION['defaultWeek_timestamp'];
    $expirationTime = 30; // 30 seconds

    if (($currentTime - $variableTimestamp) > $expirationTime) {
        // Variable has expired, unset it
        unset($_SESSION['defaultWeek']);
        unset($_SESSION['defaultWeek_timestamp']); // Optionally unset the timestamp too
    }
}
include 'common2.php'
?>
<form method="post"></form>
<body>
    <div id="top-head">
        <center>
            <h1> Work Orders </h1>
        </center>
<div id="newJobForm">
    <label>Add New Job:</label>
    <input type="text" id="newJobID" placeholder="Work Order No" required>
    <button id="addNewJobButton" onclick="addNewJob()">ADD</button>
</div>

  <button id="refresh" onclick="refresh()">Refresh</button><button class="logout" id="fill" onclick="window.location.href = 'logout.php'">Logout</button><br>
<div id="errormsgs"></div>

	<div id="contentContainer"></div>
        <br>
<button id="deletebutton" class="botbuttons1" onclick="deletejob()"> Delete </button>&nbsp;
<button id="recieptedbutton" class="botbuttons1" onclick="movejob(1)"> Receipted </button>&nbsp;
<button id="cancelledbutton" class="botbuttons1" onclick="movejob(2)"> Cancelled </button>&nbsp;

	<div id="caluculationsContainer"></div>
	<div id="check"></div>
<div id="confirmationModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Confirm Deletion</h2>
        <p>Are you sure you want to delete the following jobs?</p>
        <ul id="jobIdList"></ul>
        <button id="confirmDelete">Yes, delete</button>
    </div>
</div>
<div id="confirmationModal1" class="modal1">
    <div class="modal-content">
        <span class="close1">&times;</span>
        <h2>Confirm</h2>
        <p id="cnf"></p>
        <ul id="jobIdList1"></ul>
        <button id="confirmmove">Yes</button>
    </div>
</div>



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>

	function refresh(){
	loadData();
	}


    function loadData() {
		
        // Make an AJAX request to your PHP script
        $.ajax({
            type: 'POST',
            url: 'wodata.php', // Replace with your PHP script's URL
            success: function(response) {
                // Update the content container with the PHP-generated content
                $('#contentContainer').html(response);
				
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });

    }
	
	
	function addNewJob() {
    // Get the job ID input element
    const jobIDInput = document.getElementById("newJobID");

    // Get the entered job ID value
    const jobID = jobIDInput.value.trim(); // Trim to remove leading/trailing whitespace

    // Check if the job ID is not empty
    if (jobID !== "") {
        // Prepare data for the AJAX request
        const data = {
            jobID: jobID,
        };

        // Make an AJAX POST request to psaddnewjob.php
        $.ajax({
            type: "POST",
            url: "woaddnewjob.php",
            data: data,
            success: function(response) {
                // Handle the success response from the server
                if (response.status === 'success') {
                    // Reload the page on success
                    refresh();
                } else {
                    // Display the error message in the error div
                    document.getElementById("errormsgs").innerHTML = '<h3 style="color: red;">Error adding new job: ' + response.message + '</h3>';
                }
            }
        });
    } else {
        // Job ID is empty, display an error message
        alert("Job ID cannot be empty. Please enter a valid job ID.");
    }
}

function deletejob() {
    // Collect the selected job IDs
    const selectedJobIds = [];
    const checkboxes = document.querySelectorAll('input[name="selectedJobs[]"]:checked');
    checkboxes.forEach(function(checkbox) {
        selectedJobIds.push(checkbox.value);
    });

    // Make sure there are selected jobs
    if (selectedJobIds.length === 0) {
        alert("Please select jobs to delete.");
        return;
    }

    // Show the confirmation modal
    const modal = document.getElementById('confirmationModal');
    const contentContainer = document.getElementById('contentContainer');
    const jobIdList = document.getElementById('jobIdList');
    const confirmDeleteButton = document.getElementById('confirmDelete');
    jobIdList.innerHTML = ''; // Clear previous list items

    // Populate job IDs in the modal
    selectedJobIds.forEach(function(jobId) {
        const listItem = document.createElement('li');
        listItem.textContent = jobId;
        jobIdList.appendChild(listItem);
    });

    modal.style.display = 'block';

    // Handle confirmation or cancellation
    confirmDeleteButton.onclick = function() {
        modal.style.display = 'none'; // Hide the modal

        // AJAX request to delete jobs
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'wodeletejobs.php');
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        xhr.onload = function() {
            if (xhr.status === 200) {
                try {
                    const response = JSON.parse(xhr.responseText);
                    if (response.status === 'success') {
                        console.log("Deleted successfully");
						refresh();
                    } else {
                        console.error("Server returned an unexpected response:", response);
                        alert("Failed to delete jobs. Please try again.");
                    }
                } catch (error) {
                    console.error("Error parsing JSON response:", error);
                    alert("Failed to parse server response.");
                }
            } else {
                console.error("Server returned an error status:", xhr.status);
                alert("Failed to delete jobs. Please try again.");
            }
        };

        xhr.send('jobIds=' + JSON.stringify(selectedJobIds));
    };

    // Handle modal close button
    const closeButton = document.querySelector('.close');
    closeButton.onclick = function() {
        modal.style.display = 'none';
        modal2.style.display = 'none';
    };
}


 function movejob(x) {
    // Collect the selected job IDs
    const selectedJobIds = [];
    const checkboxes = document.querySelectorAll('input[name="selectedJobs[]"]:checked');
    checkboxes.forEach(function (checkbox) {
        selectedJobIds.push(checkbox.value);
    });

    // Make sure there are selected jobs
    if (selectedJobIds.length === 0) {
        alert("Please select jobs to move.");
        return;
    }

    // Show the confirmation modal1
    const modal1 = document.getElementById('confirmationModal1');
    const contentContainer = document.getElementById('contentContainer');
    const jobIdList1 = document.getElementById('jobIdList1');
    const confirmMoveButton = document.getElementById('confirmmove');
    const msg = document.getElementById('cnf');
    jobIdList1.innerHTML = ''; // Clear previous list items


    // Populate job IDs in the modal1
    selectedJobIds.forEach(function (jobId) {
        const listItem = document.createElement('li');
        listItem.textContent = jobId;
        jobIdList1.appendChild(listItem);
    });
	    if (x === 1) {

        msg.innerHTML = 'Are you sure that the following jobs are Receipted?'
    } else if (x === 2) {

        msg.innerHTML = 'Are you sure that the following jobs are Cancelled?'
    } else {

        msg.innerHTML = 'Something is wrong contact Administrator'
    }

    modal1.style.display = 'block';

    // Handle confirmation or cancellation
    confirmMoveButton.onclick = function () {
        modal1.style.display = 'none'; // Hide the modal1

        // AJAX request to move jobs
        $.ajax({
            type: 'POST',
            url: 'womovejobs.php',
            data: {
                jobIds: JSON.stringify(selectedJobIds),
                x: x
            },
            success: function (response) {
                // Handle the success response from the server
                if (response.status === 'success') {
                    // Reload the page or perform any other action on success
                    refresh();
                } else {
                    // Display the error message in the error div
                    document.getElementById("errormsgs").innerHTML = '<h3 style="color: red;">Error moving jobs: ' + response.message + '</h3>';
                }
            }
        });
    };

    // Handle modal1 close button
    const closeButton = document.querySelector('.close1');
    closeButton.onclick = function () {
        modal1.style.display = 'none';
    };
}

$(document).ready(function() {
    // Function to load data and handle inline editing
    // Function to handle inline editing
    $('#contentContainer').on('blur', '.editable', function() {
        // Get the job ID, column name, and new value
        var jobID = $(this).data('jobid');
        var columnName = $(this).data('columnname');
            if ($(this).find('select').length > 0) {
        newValue = $(this).find('select').val(); // Get the selected value of the dropdown
    } else {
        newValue = $(this).text(); // Get the text content if it's not a dropdown
    }
        var cell = $(this); // Store a reference to the cell element
		
if (typeof columnName !== 'undefined') {
        // Make an AJAX request to update the data
$.ajax({
            type: 'POST',
            url: 'woupdateRow.php', // Replace with your PHP script's URL for updating
            data: { jobID: jobID, columnName: columnName, newValue: newValue },
            success: function(response) {
                // Log the response to the console
                console.log(response);

                // Check if the update was successful
                if (response.status === 'success') {
                    // Update the cell background color to green
                    cell.css('background-color', '#80ff80');
                } else {
                    // Update the cell background color to red
                    cell.css('background-color', '#ffad99');
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);

			// Update the cell background color to red in case of an error
			if (typeof columnName !== 'undefined') {
				cell.css('background-color', '#ffad99');
			}

            }
        }); 
}
    }); 

});




loadData();
	


  </script>
  
 <?php 

 include 'loading.php'; 
 ?>
</body>
</html>

