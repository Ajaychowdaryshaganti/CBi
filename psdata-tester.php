	<!DOCTYPE html>
<html>
<head>
    <title>Your Page Title</title>
    <style>
	table {
		//overflow-x: auto !important;
		border-bottom: none;
	}
        td, th {
            vertical-align: middle;
            text-align: center;
            padding: 2px;
        }

        th {
            background-color: #FFA7A8;
			height:0.8vh !important;
        }
		    /* Limit to 2 lines of text in td */
    td {
        max-height: 3em; /* 2 lines of text with some extra space */
        overflow: hidden;
        text-overflow: ellipsis;
    }
	
		
		span {
		font-weight: bold;}
		.drops1{
			
			max-width:90%;
	}		.drops2{
			
			max-width:70%;
	}		.drops3{
			
			max-width:90%;
	}		.drops4{
			
			max-width:130%;
	}
	table select{
		margin:0px !important;
		padding:0px !important;
	}
		.page_404{ padding:40px 0; background:#fff; font-family: 'Arvo', serif;
}

.page_404  img{ width:100%;}

.four_zero_four_bg{
 
 background-image: url(https://cdn.dribbble.com/users/285475/screenshots/2083086/dribbble_1.gif);
    height: 900px;
	width:1000px;
    background-position: center;
	margin-left:47%;
 }
 
 
 .four_zero_four_bg h1{
 font-size:40px;
 margin-left:35%;
 }
 
  .four_zero_four_bg h3{
       font-size:80px;
       }
       
       .link_404{      
  color: #fff!important;
    padding: 10px 20px;
    background: #39ac31;
    margin: 20px 0;
    display: inline-block;}
  .contant_box_404{ margin-top:-50px;}
      #dno {
        white-space: nowrap; /* Prevent text from wrapping */
        overflow: hidden; /* Hide overflowing text */
        text-overflow: ellipsis; /* Show ellipsis for overflowing text */
    }



		
    </style>
</head>
<body>
    <?php
    include 'connection.php';
try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $selectedOption = $_POST['option'];

        $result = explode(",", $selectedOption);
        $startDate = $result[0];
        $endDate = $result[1];
		$totalremhrs=0;
		$totalworkhrs=0;
		

        $startDate = date('Y-m-d', strtotime($startDate));
        $endDate = date('Y-m-d', strtotime($endDate));
        if ($conn->connect_error) {
            throw new Exception("Connection failed: " . $conn->connect_error);
        }

        // Prepare and execute an SQL query to filter data based on $startDate and $endDate
        $sql = "SELECT * FROM jobsnew WHERE Date1 >= '$startDate' AND Date2 <= '$endDate' order by LastUpdated desc";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Output data of each row
            echo "<table border='1' id=\"lbt\" cellspacing='0'>";
            echo "<tr><strong><th>SALES ORDER</th><th>DRAWING NO</th><th>CUSTOMER</th><th>DESCRIPTION</th><th>HRS</th><th>ESC
DATE</th><th>ENC DATE</th><th>PART AVA</th><th>ETD</th><th>COMP %</th><th>REM HRS</th><th>FITTER1</th><th>MANAGER</th><th>STATUS</th><th>TYPE</th><th>COMMENTS1</th><th>COMMENTS2</th><th>LAST UPDATED</th><th>LAST UPDATE BY</th><th>FITTER2</th><th>FITTER3</th></strong></tr>";

            while ($row = $result->fetch_assoc()) {
                $formattedTimestamp = date('d/m 	H:i', strtotime($row['LastUpdated']));
				$status = $row['currentstate'];
				$color = ''; // Initialize color variable
				if ($status == 'InProgress') {
              $color = '#ffff00'; // Yellow color for InProgress
				} elseif ($status == 'Assigned') {
				$color = '#ffc000'; // Orange color for Assigned
				} elseif ($status == 'Completed') {
				$color = '#04b0f0'; // Cyan color for Completed
				} elseif ($status == 'Tested') {
				$color = '#00ff80'; // Green color for Tested
				} elseif ($status == 'Not Assigned') {
				$color = '#ffffff'; // White color for Not Assigneds
				}
                echo "<tr style='background-color: $color;'>";
				
                echo "<td contenteditable='false' class='editable' data-jobid='" . $row['jobid'] . "' data-columnname='jobid'>" . $row['jobid'] . "</td>";
                echo "<td contenteditable='false' class='editable' data-jobid='" . $row['jobid'] . "' data-columnname='drawingno' id='dno'>" . $row['drawingno'] . "</td>";
                echo "<td contenteditable='false' class='editable' data-jobid='" . $row['jobid'] . "' data-columnname='customer'>" . $row['customer'] . "</td>";
                echo "<td contenteditable='false' class='editable' data-jobid='" . $row['jobid'] . "' data-columnname='description'>" . $row['description'] . "</td>";
                echo "<td contenteditable='false' class='editable' data-jobid='" . $row['jobid'] . "' data-columnname='allocatedhrs'>" . $row['allocatedhrs'] . "</td>";
                echo "<td contenteditable='false' class='editable' data-jobid='" . $row['jobid'] . "' data-columnname='escdate'>" . $row['escdate'] . "</td>";
                echo "<td contenteditable='false' class='editable' data-jobid='" . $row['jobid'] . "' data-columnname='encdate'>" . $row['encdate'] . "</td>";
                echo "<td contenteditable='false' class='editable' data-jobid='" . $row['jobid'] . "' data-columnname='partavailability'>" . $row['partavailability'] . "</td>";
                echo "<td contenteditable='false' class='editable' data-jobid='" . $row['jobid'] . "' data-columnname='etd'>" . $row['etd'] . "</td>";
                echo "<td contenteditable='false' class='editable' data-jobid='" . $row['jobid'] . "' data-columnname='completionrate'>" . $row['completionrate'] . "%</td>";
                echo "<td contenteditable='false' class='editable' data-jobid='" . $row['jobid'] . "' data-columnname='remaininghrs'>" . $row['remaininghrs'] . "</td>";
				echo "<td contenteditable='false' class='editable' data-jobid='" . $row['jobid'] . "' data-columnname='fitter1'>" . $row['fitter1'] . "</td>";
				echo "<td contenteditable='false' class='editable' data-jobid='" . $row['jobid'] . "' data-columnname='projectmanager'>" . $row['projectmanager'] . "</td>";

				
								// For the "currentstate" column
				echo "<td contenteditable='true' class='editable' data-jobid='" . $row['jobid'] . "' data-columnname='currentstate'>";
				echo "<select class=\"drops3\" id=\"currentstate" . $row['jobid'] . "\" name=\"currentstate\">";
				$statusOptions = ["NotAssigned", "InProgress", "Assigned", "Completed", "Tested"];
				foreach ($statusOptions as $option) {
					$selected = ($option == $row['currentstate']) ? "selected" : "";
					echo "<option value=\"$option\" $selected>$option</option>";
				}
				echo "</select>";
				echo "</td>";

				echo "<td contenteditable='false' class='editable' data-jobid='" . $row['jobid'] . "' data-columnname='type'>" . $row['type'] . "</td>";

                echo "<td contenteditable='true' class='editable' data-jobid='" . $row['jobid'] . "' data-columnname='comments'>" . $row['comments'] . "</td>";
                echo "<td contenteditable='true' class='editable' data-jobid='" . $row['jobid'] . "' data-columnname='comments2'>" . $row['comments2'] . "</td>";
							echo "<td contenteditable='false' class='editable' data-jobid='" . $row['jobid'] . "' data-columnname='LastUpdated'>" . $formattedTimestamp . "</td>";
            echo "<td contenteditable='false' class='editable' data-jobid='" . $row['jobid'] . "' data-columnname='lastupdatedby'>" . $row['lastupdatedby'] . "</td>";


				echo "<td contenteditable='false' class='editable' data-jobid='" . $row['jobid'] . "' data-columnname='fitter2'>" . $row['fitter1'] . "</td>";
				echo "<td contenteditable='false' class='editable' data-jobid='" . $row['jobid'] . "' data-columnname='fitter3'>" . $row['fitter1'] . "</td>";

                echo "</tr>";

            }

			
        } else {
                echo '<section class="page_404">
        <div class="container">
            <div class="row"> 
                <div class="col-sm-12 ">
                    <div class="col-sm-10 col-sm-offset-1 text-center">
                        <div class="four_zero_four_bg">
                            <h1 class="text-center">No Jobs found</h1>
                        </div>
                        <div class="contant_box_404">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>';
        }


        $conn->close();
    }
} catch (Exception $e) {
    // Handle the exception by displaying the error message
    echo "Error: " . $e->getMessage();
}

?>

