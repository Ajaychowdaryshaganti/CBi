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
    <title>CBI | Work Orders History</title>
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
            border-top: 1px solid #ccc;
			background-color: #ddd;
            color: #ddd;
            height: 1px;

        }
		table th,td {

			padding:3px 3px;
		}
		#workorder {
			
			//width:100% !! important;
		}
			#search{
	
	width:9%;
    border: 1px solid;
    border-radius: 4px;
    padding: 8px 20px;
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
include 'common3.php';
include 'connection.php';
//include 'sorry.php';
?>

<body>
    <div id="top-head">
        <center>
            <h1> Work Orders History </h1>
				  		
		<label for='search'>Search:</label><br>
    <input type='text' id='search' onkeyup='searchItem1()' placeholder='Work Order No.'>
        </center><br>
 <?php 


// Check the connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Query to retrieve all data from workorders1
$query = "SELECT * FROM workorders1  order by jobid asc";

// Execute the query
$result = mysqli_query($conn, $query);

// Check if the query was successful
if ($result) {
    // Check if there are any rows in the result
    if (mysqli_num_rows($result) > 0) {
        // Display the data in a table
        echo "<table border='1' id='workorder' style='width: 100%;'>
                <tr>
                    <th>WORK ORDER</th><th>DATE</th><th>TYPE</th><th>DESCRIPTION</th><th>HRS</th><th>REQUIRED DATE</th><th>PART AVA</th><th>DB AVA</th><th>ESC AVA</th><th>FITTER1</th><th>STATUS</th><th>PRIORITY</th><th>BUILT BY</th><th>COMMENTS1</th><th>COMMENTS2</th><th>LAST UPDATED</th><th>LAST UPDATE BY</th><th>FITTER2</th><th>FITTER3</th>
                </tr>";

        // Loop through the result set and display each row
        while ($row = mysqli_fetch_assoc($result)) {
			$status = $row['action'];
                $bgcolor = '';
                $color = '';
                if ($status == 1) {
                    $bgcolor = '#00ff80';
                    $color = 'black';
                } 
				else{
                    $bgcolor = '#FFF';
                    $color = 'red';
                } 
			$formattedTimestamp = date('d/m H:i', strtotime($row['LastUpdated']));
            echo "<tr style='background-color: $bgcolor; color: $color;'>
                    <td>{$row['jobid']}</td>
                    <td>{$row['date']}</td>
                    <td>{$row['type']}</td>
                    <td>{$row['description']}</td>
                    <td>{$row['allocatedhrs']}</td>
                    <td>{$row['etd']}</td>
                    <td>{$row['partavailability']}</td>
                    <td>{$row['dbavailability']}</td>
                    <td>{$row['escdate']}</td>
                    <td>{$row['fitter1']}</td>
					<td>{$row['currentstate']}</td>
                    <td>{$row['priority']}</td>
                    <td>{$row['builtby']}</td>
                    <td>{$row['comments']}</td>
                    <td>{$row['comments2']}</td>
                    <td>$formattedTimestamp</td>
                    <td>{$row['lastupdatedby']}</td>
                    <td>{$row['fitter2']}</td>
                    <td>{$row['fitter3']}</td>
                </tr>";
        }

        echo "</table>";
    } else {
        echo "No records found";
    }
} else {
    // Display an error message if the query fails
    echo "Error: " . mysqli_error($conn);
}
 include 'loading.php'; 
 ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>


function searchItem1() {
    var input, filter, table, tr, td, i, j, txtValue;
    input = document.getElementById("search");
    filter = input.value.toUpperCase();
    table = document.getElementById("workorder");
    tr = table.getElementsByTagName("tr");

    // Loop through all table rows
    for (i = 0; i < tr.length; i++) {
        // Skip header row
        if (tr[i].cells[0].nodeName === "TH") {
            continue;
        }

        td = tr[i].getElementsByTagName("td");
        var rowVisible = false;

        // Loop through all table cells in the row
        for (j = 0; j < td.length; j++) {
            txtValue = td[j].textContent || td[j].innerText;

            // Check if any cell contains the search filter
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                rowVisible = true;
                break; // No need to check other cells in this row
            }
        }

        // Display or hide the row based on whether any cell matched the search filter
        tr[i].style.display = rowVisible ? "" : "none";
    }
}




  </script>
</body>
</html>

