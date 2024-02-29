<!DOCTYPE html>
<html>

<head>
    <title>Your Page Title</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            text-align: center;
            padding: 5px;
        }

        th {
            background-color: #FFA7A8;
        }

        td {
            max-height: 3em;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        span {
            font-weight: bold;
        }

        .drops1 {
            max-width: 120%;
        }

        .drops2 {
            max-width: 70%;
        }

        .drops3 {
            max-width: 120%;
        }

        .drops4 {
            max-width: 500px;
        }

        table select {
            margin: 0;
            padding: 0;
        }

        #dno {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        #lastrow {
            border-top: 1px solid #000;
            border-right: none;
            border-bottom: none;
            border-left: none;
            font-weight: bold;
            font-size: 20px;
        }

        #lastrow td {
            border: none;
        }

        #wrkhrs {
            margin-left: 15%;
        }
    </style>
</head>

<body>
    <?php
    include 'connection.php';
    try {

        if ($conn->connect_error) {
            throw new Exception("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM workorders order by jobid asc";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<table border='1' id=\"lbt\">";
            echo "<tr><th>WORK ORDER</th><th>DATE</th><th>TYPE</th><th>DESCRIPTION</th><th>HRS</th><th>REQUIRED DATE</th><th>PART AVA</th><th>DB AVA</th><th>ESC AVA</th><th>FITTER1</th><th>STATUS</th><th>PRIORITY</th><th>BUILT BY</th><th>COMMENTS1</th><th>COMMENTS2</th><th>LAST UPDATED</th><th>LAST UPDATE BY</th><th>FITTER2</th><th>FITTER3</th></tr>";

            while ($row = $result->fetch_assoc()) {
                $formattedTimestamp = date('d/m H:i', strtotime($row['LastUpdated']));
                

                // Check if the value is 'CBI' while ignoring case and trimming spaces
                $builtby = $row['builtby'];
                $isCBI = strcasecmp(trim($builtby), 'CBI') === 0;

                // Determine the color scheme for the entire row
                $rowColorStyle = $isCBI ? '' : "color: red; border-color:black; font-weight:bold;";
				
				$partavailability = trim(strtolower($row['partavailability']));
				$dbavailability = trim(strtolower($row['dbavailability']));
				$escdate = trim(strtolower($row['escdate']));
				
				if ($partavailability === 'yes' && $dbavailability === 'yes' && $escdate === 'yes') {
					$isready = true;
				} else {
					$isready = false;
				}
				if($isCBI){
				$status = $row['currentstate'];
                $color = '';
                if ($status == 'InProgress') {
                    $color = '#ffff00';
                } elseif ($status == 'Assigned') {
                    $color = '#ffc000';
                } elseif ($status == 'Completed') {
                    $color = '#04b0f0';
                } elseif ($status == 'Tested') {
                    $color = '#00ff80';
                } elseif (($status == 'NotAssigned' ) && $isready) {
                    $color = '#b3f0ff'; //b3f0ff
                }
				}

                echo "<tr style='background-color: $color; $rowColorStyle'>";
                echo "<td contenteditable='false' class='editable' data-jobid='" . $row['jobid'] . "' data-columnname='jobid'>" . $row['jobid'] . "</td>";
                echo "<td contenteditable='false' class='editable' data-jobid='" . $row['jobid'] . "' data-columnname='date' id='dno'>" . $row['date'] . "</td>";
                echo "<td contenteditable='false' class='editable' data-jobid='" . $row['jobid'] . "' data-columnname='type'>" . $row['type'] . "</td>";
                echo "<td contenteditable='false' class='editable' data-jobid='" . $row['jobid'] . "' data-columnname='description'>" . $row['description'] . "</td>";
                echo "<td contenteditable='false' class='editable' data-jobid='" . $row['jobid'] . "' data-columnname='allocatedhrs'>" . $row['allocatedhrs'] . "</td>";
                echo "<td contenteditable='false' class='editable' data-jobid='" . $row['jobid'] . "' data-columnname='etd'>" . $row['etd'] . "</td>";
                echo "<td contenteditable='false' class='editable' data-jobid='" . $row['jobid'] . "' data-columnname='partavailability'>" . $row['partavailability'] . "</td>";
                echo "<td contenteditable='false' class='editable' data-jobid='" . $row['jobid'] . "' data-columnname='dbavailability'>" . $row['dbavailability'] . "</td>";
                echo "<td contenteditable='false' class='editable' data-jobid='" . $row['jobid'] . "' data-columnname='escdate'>" . $row['escdate'] . "</td>";
					
                if ($isCBI) {
                    echo "<td contenteditable='false' class='editable' data-jobid='" . $row['jobid'] . "' data-columnname='fitter1' style='width:5%;'>" . $row['fitter1'] . "</td>";
                } else {
                    echo "<td contenteditable='false' class='editable' data-jobid='" . $row['jobid'] . "' data-columnname='builtby'>" . $row['builtby'] . "</td>";
                }

                echo "<td contenteditable='true' class='editable' data-jobid='" . $row['jobid'] . "' data-columnname='currentstate' style='width:6%;'>" . $row['currentstate'] . "</td>";

                echo "<td contenteditable='false' class='editable' data-jobid='" . $row['jobid'] . "' data-columnname='priority'>" . $row['priority'] . "</td>";
                echo "<td contenteditable='false' class='editable' data-jobid='" . $row['jobid'] . "' data-columnname='builtby'>" . $row['builtby'] . "</td>";
                echo "<td contenteditable='false' class='editable' data-jobid='" . $row['jobid'] . "' data-columnname='comments'>" . $row['comments'] . "</td>";
                echo "<td contenteditable='false' class='editable' data-jobid='" . $row['jobid'] . "' data-columnname='comments2'>" . $row['comments2'] . "</td>";
                echo "<td contenteditable='false' class='editable' data-jobid='" . $row['jobid'] . "' data-columnname='LastUpdated'>" . $formattedTimestamp . "</td>";
                echo "<td contenteditable='false' class='editable' data-jobid='" . $row['jobid'] . "' data-columnname='lastupdatedby'>" . $row['lastupdatedby'] . "</td>";

                if ($isCBI) {
                    echo "<td contenteditable='true' class='editable' data-jobid='" . $row['jobid'] . "' data-columnname='fitter2' style='width:5%;'>" . $row['fitter2'] . "</td>";
                } else {
                    echo "<td contenteditable='false' class='editable' data-jobid='" . $row['jobid'] . "' data-columnname='builtby'>" . $row['builtby'] . "</td>";
                }

                if ($isCBI) {
                    echo "<td contenteditable='false' class='editable' data-jobid='" . $row['jobid'] . "' data-columnname='fitter3' style='width:5%;'>" . $row['fitter3'] . "</td>";
                } else {
                    echo "<td contenteditable='false' class='editable' data-jobid='" . $row['jobid'] . "' data-columnname='builtby'>" . $row['builtby'] . "</td>";
                }

                echo "</tr>";
            }
        } else {
            echo '<section class="page_404">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
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

    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
    ?>
</body>

</html>
