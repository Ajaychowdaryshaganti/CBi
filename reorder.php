<?php
include 'common.php';
echo " <script src=\"https://unpkg.com/xlsx/dist/xlsx.full.min.js\"></script>";
?>
<style>
* {
  //box-sizing: border-box;
}	

.wrapper {
  padding-top: 10.5%;
  width: 100%;
  margin: 0 auto;

}

.tabs {
  position: relative;
  margin: 2rem 0;
  background: #FF5E60;
  height: auto;

}
#fill-green{
 	
	margin-left:90%;
	//position: sticky;
        //z-index: 20;
	  //top: -0.0625rem;


	}
#scrollToTopButton {
  position: fixed;
  bottom: 20px;
  right: 20px;
  display: none;
}


.tabs::before,
.tabs::after {
  content: "";
  display: table;
}

.tabs::after {
  clear: both;
}
.reorder1 {
	//margin-left:-12%;
	width:10%;
}
.reorder2 {
    width: 96%;
    padding: 10%;
    margin-left: 1%;
    margin-right: 30%;
}
#tab2 {
	margin-left:-12%;
	width:100%;
}
#tab3 {
	margin-left:-18%;
width:95%;
}
#tab4 {
	margin-left:-30%;
width:100%;
}
#tab5 {
	margin-left:-40%;
width:100%;
}

.tab {
  float: left;
}

.tab-switch {
  display: none;
}
h5 {
color:red;
}

.tab-label {
  position: relative;
  display: block;
  line-height: 2.75em;
  height: 3em;
  padding: 0 1.618em;
  background: #FF5E60;
  border-right: 0.125rem solid #fff;
  color: #fff;
  cursor: pointer;
  top: 0;
  transition: all 0.5s;
}

.tab-label:hover {
  top: -0.25rem;
  transition: top 0.25s;
}
#lbt4 {
	margin-left:5% !important;
}
#lbt5 {
	margin-left:8%;
}
table {
  width: 10%;
  border-collapse: collapse;
  padding-top: 0px;
  
}

thead th {
  position: sticky;
  top: -1.7rem;
  z-index:10;

}

    #lbt2,#lbt3,#lbt4 th {
        position: sticky;
          top: -1.7rem;
  z-index:10;


    }
    .highlighted {
        background-color:#708090;
    }
tbody td {
  overflow-x: hidden;
  font-size: 15px !important;
}
#purchaseorder {
  width: auto !important;
  padding:0;
  font-size: 15px !important;
}

table tr td:last-child {
    width: 100% !important;
	 white-space: normal;
}
tbody td,
thead th {
  padding: 10px;
}
#top1 {
	  //position: sticky;
          //top:0;

	}
	
#up {
	
	margin-left: 99%;
	margin-top: 50%;
position: sticky;
          bottom:0;

}
#down {
	margin-left: 99%;
	margin-bottom: 50%;
	z-index:15;
position: sticky;
          top:0;

	
}

#refresh{
	
    color: #ffeef0;
    background-color: #FF5E60;
	color:black;
    //text-decoration: none;
    border: 2px solid transparent;
    border-radius: 10px;
    padding: 8px 20px;
	font-size:20px;
	margin-top:0.5%;
	
}

  .tab-content {
    max-height: 650px; /* Adjust the height as needed */
   overflow-y: auto;
    position: absolute;
    z-index: 1;
    margin-right: 0%;
    padding: 1.618rem;
    background: #fff;
    color: #2c3e50;
    opacity: 0;
    transition: all 0.35s;
	overflow-x:hidden;
  }
.tab-switch:checked + .tab-label {
  background: #fff;
  color: #2c3e50;
  border-bottom: 0;
  border-right: 0.125rem solid #fff;
  transition: all 0.35s;
  z-index: 1;
  top: -0.0625rem;
}

.tab-switch:checked + label + .tab-content {
  z-index: 2;
  opacity: 1;
  transition: all 0.35s;
}
#filters {
	 margin-left:-0.5%;

	}

/* Responsive Styling */
@media screen and (max-width: 768px) {
  .wrapper {
    padding-top: 20%;
  }

  .tabs {
    height: auto;
    padding-bottom: 2em;
  }

  .tab-label {
    line-height: 2em;
    height: 2.5em;
    padding: 0 1em;
  }

  .tab-content {
    position: static;
    height: auto;
    margin-right: 0;
    padding: 1em;
  }
}
  /* Add CSS for different status colors */
  .status-ToBeOrdered {
    background-color: #fff;
  }

  .status-Sent {
    background-color: #ffff00;
  }

  .status-Ordered {
    background-color: #04b0f0;
  }

  .status-PartiallyReceived {
    background-color: #00ff80;
  }
  .status-CustomQty {
    background-color:#E0FFFF;
  }
  
  .error {
	  
	  color:red;
	  text-decoration:strong;
  }
  
    .success {
	  
	  color:green;
	  text-decoration:strong;
  }

.statusselect{
	width:auto;
}
	
</style>
<!-- Add the loading animation element -->


<div class="wrapper">
  <div class="tabs">
    <div class="tab">
      <input type="radio" name="css-tabs" id="tab-1" checked class="tab-switch">
      <label for="tab-1" class="tab-label">HYMOD & TOP HAT</label>
      <div class="tab-content" id="tab-1">
<?php
include 'connection.php';

$msg = '';
$sql = "
  INSERT INTO reorderhmtp
  SELECT BinLocation, PartName, PartNo,Supplier, Category, Quantity AS Available, (Max-Quantity) AS Required, 0 AS Received, (Max-Quantity) AS BackOrder, 'To be Ordered' AS Status, '' AS PurchaseOrder, NOW() AS LastUpdated, '' AS Comments FROM tophathymod
  WHERE PartNo NOT IN (
    SELECT PartNo FROM reorderhmtp
  ) AND Quantity <= Min
";

try {
  $result = $conn->query($sql);
  if ($result === false) {
    throw new Exception('Error: ' . $conn->error);
  } else {
    $rowCount = $conn->affected_rows;
    $msg = $rowCount . ' new item/s added.';
  }
} catch (Exception $e) {
  $msg = $e->getMessage();
}


if ($conn) {
  $query = "SELECT *,
    CONCAT(
      BinLocation,
      CASE
        WHEN RIGHT(BinLocation, 2) REGEXP '^[0-9]+0$' THEN ''
        ELSE ''
      END
    ) AS ModifiedBinLocation
    FROM reorderhmtp
    ORDER BY CAST(REGEXP_REPLACE(BinLocation, '[^0-9]', '') AS UNSIGNED),
    LENGTH(BinLocation),
    BinLocation";

  $reorderResult = mysqli_query($conn, $query);

  if ($reorderResult) {
    echo "
    <center>
    <h2 id=\"lbh\">HYMOD & Top-Hat</h2>
    <br>
    <h3>" . $msg . "<br><br></h3>";

echo "<div id=\"filters\">
<label for=\"category\">Category:</label>
<select id=\"category\" onchange=\"applyFilters1()\">
<option value=\"Top Hat\">Top Hat</option></center>"; // Only include the desired category option(s) here

$categories = array();
mysqli_data_seek($reorderResult, 0); // Reset the result pointer

while ($record = mysqli_fetch_assoc($reorderResult)) {
  $category = $record['Category'];
  if (!in_array($category, $categories)) {
    $categories[] = $category;
    if ($category !== "Top Hat") { // Exclude the "TopHats" category from the dropdown
      echo "<option value=\"$category\">$category</option>";
    }
  }
}

echo "</select>
</div>";

echo "<button id=\"fill-green\" onclick=\"printTable1();\">Print</button><div id=\"filters\">
<label for=\"status\">Status:</label>
<select id=\"status\" onchange=\"applyFilters1()\">
<option value=\"\">All</option>
"; // Include the default "All" option here

$statuses = array();
mysqli_data_seek($reorderResult, 0); // Reset the result pointer

while ($record = mysqli_fetch_assoc($reorderResult)) {
  $status = $record['Status'];
  if (!in_array($status, $statuses)) {
    $statuses[] = $status;
    echo "<option value=\"$status\">$status</option>";
  }
}

echo "</select>
</div><!--<br><button id=\"fill-blue\" onclick=\"exportToExcel1()\">Export to Excel</button>-->
<button id=\"refresh\" onclick=\"refreshdata1()\">Reload</button>";

    echo "<table class=\"reorder1\" id=\"lbt1\" border='2'>
<thead>
<tr>
    <th>Bin Location</th>
    <th>Description</th>
    <th>Part Number</th>
    <th>Supplier</th>
    <th hidden>Category</th>
    <th>Available Quantity</th>
    <th>Required Quantity</th>
    <th>Received Quantity</th>
    <th>Back Order</th>
    <th>Fully Received</th>
    <th> Current Status</th>
	<th>Update Status</th>
    <th>Purchase Order</th>
    <th>Partially Received</th>
    <th>Last Updated</th>
    <th>Comments</th>
</tr>
</thead>
<tbody><a id=\"top1\"><a id=\"down\" href=\"#bottom1\"><i style='font-size:24px; color:#A9A9A9' class='fas'>&#xf13a;</i></a>";

mysqli_data_seek($reorderResult, 0); // Reset the result pointer
$PNo1 = [];
$Pname1 = [];
$BackOrder1 = [];
$i1 = 0;
while ($record = mysqli_fetch_assoc($reorderResult)) {
	 $formattedTimestamp = date('d/m/y H:i', strtotime($record['LastUpdated']));
  $PNo1[$i1] = $record['PartNo'];
  $Pname1[$i1] = $record['PartName'];
  $BackOrder1[$i1]=$record['BackOrder'];
  
  $statusClass = 'status-' . str_replace(' ', '', $record['Status']);
  echo "<tr class=\"$statusClass\">
    <td>{$record['ModifiedBinLocation']}</td>
    <td>{$record['PartName']}</td>
    <td>{$record['PartNo']}</td>
    <td>{$record['Supplier']}</td>

<td hidden>{$record['Category']}</td>
    <td>{$record['Available']}</td>
    <td>
        <form id='updateForm_$i1' onkeydown=\"disableEnterKey(event)\">
            <input type='text' id='requiredQty1_$i1' value='{$record['Required']}'/>
            <button id='no-fill' type='button' onclick=\"updateRequiredQty1('$PNo1[$i1]', $i1)\">Update</button>
        </form>
    </td>
    <td>{$record['Received']}</td>
    <td>{$record['BackOrder']}</td>
    <td>
        <button id=\"no-fill\" onclick=\"fullOrderReceived1('{$PNo1[$i1]}',$BackOrder1[$i1])\">Fully Received</button>
    </td><td>{$record['Status']}</td>
<td>
    <select id='status1_$i1' class=\"statusselect\" onfocusout=\"updateStatusUniversal(1, '$PNo1[$i1]', $i1)\">
        <option value='To be Ordered'>To be Ordered</option>
        <option value='Sent'>Sent</option>
    </select>
</td>

<td id='purchaseorder'>
    <input type='text' 
           id='purchaseOrder1_$i1' 
           value='{$record['PurchaseOrder']}' 
           onfocusout=\"updatePurchaseOrderUniversal(1, '$PNo1[$i1]', $i1)\"
    />
</td>

    <td>
        <button id=\"no-fill\" onclick=\"promptUser1('{$PNo1[$i1]}',$BackOrder1[$i1])\">Partially Received</button>
    </td>
    <td>{$formattedTimestamp}</td>
    <td id='comments'>
            <input type='text' id='comments1_$i1' value='{$record['Comments']}' onfocusout=\"updateCommentsUniversal(1, '$PNo1[$i1]', $i1)\"/>
    </td>
  </tr>";
  $i1++;
}

echo "</tbody>
</table>";
               echo "<a id=\"bottom1\"></a>
<a id=\"up\" href=\"#top1\"><i style='font-size:24px;color:#A9A9A9' class='fas'>&#xf139;</i></a>";

    echo "</center>";
  } else {
    echo "Error executing the query: " . mysqli_error($conn);
  }

  mysqli_close($conn);
} else {
  echo "Error connecting to the database.";
}
?>
</div>
    </div>
    <div class="tab">
      <input type="radio" name="css-tabs" id="tab-2" class="tab-switch">
      <label for="tab-2" class="tab-label">KANBAN STOCK</label>
      <div class="tab-content" id="tab2" >
<?php
include 'connection.php';

$msg = '';
$sql = "
  INSERT INTO reorder
  SELECT BinLocation, PartName, PartNo, Category, Quantity AS Available, (Max-Quantity) AS Required, 0 AS Received, (Max-Quantity) AS BackOrder, 'To be Ordered' AS Status, '' AS PurchaseOrder, NOW() AS LastUpdated, '' AS Comments FROM stock
  WHERE PartNo NOT IN (
    SELECT PartNo FROM reorder
  ) AND Quantity <= Min
";

try {
  $result = $conn->query($sql);
  if ($result === false) {
    throw new Exception('Error: ' . $conn->error);
  } else {
    $rowCount = $conn->affected_rows;
    $msg = $rowCount . ' new items added.';
  }
} catch (Exception $e) {
  $msg = $e->getMessage();
}

if ($conn) {
  $query = "SELECT *,
    CONCAT(
      BinLocation,
      CASE
        WHEN RIGHT(BinLocation, 2) REGEXP '^[0-9]+0$' THEN ''
        ELSE ''
      END
    ) AS ModifiedBinLocation
    FROM reorder
    ORDER BY CAST(REGEXP_REPLACE(BinLocation, '[^0-9]', '') AS UNSIGNED),
    LENGTH(BinLocation),
    BinLocation";

  $reorderResult = mysqli_query($conn, $query);

  if ($reorderResult) {
    echo "
    <center>
    <h2 id=\"lbh\">Re-Order</h2>
    <br>
    <h3>" . $msg . "<br><br>";



echo "<div id=\"filters\">
<label for=\"status\">Status:</label>
<select id=\"status\" onchange=\"applyFilters()\">
<option value=\"\">All</option>"; // Include the default "All" option here

$statuses = array();
mysqli_data_seek($reorderResult, 0); // Reset the result pointer

while ($record = mysqli_fetch_assoc($reorderResult)) {
  $status = $record['Status'];

  if (!in_array($status, $statuses)) {
    $statuses[] = $status;
    echo "<option value=\"$status\">$status</option>";
  }
}

echo "</select>
</div><button id=\"fill-green\" onclick=\"printTable();\">Print</button>
<br><button id=\"refresh\" onclick=\"refreshdata()\">Reload</button>";
echo "</center>";
    echo "<table class=\"reorder2\" id=\"lbt2\" border='2'>
<thead>
<tr>
    <th>Bin Location</th>
    <th>Description</th>
    <th>Part Number</th>
    <th hidden>Category</th>
    <th>Available Quantity</th>
    <th>Required Quantity</th>
    <th>Received Quantity</th>
    <th>Back Order</th>
    <th>Fully Received</th>
    <th>Current Status</th>
	<th>Update Status</th>
    <th>Purchase Order</th>
    <th>Partially Received</th>
    <th>Last Updated</th>
    <th>Comments</th>
</tr>
</thead>
<tbody><a id=\"top2\"><a id=\"down\" href=\"#bottom2\"><i style='font-size:24px; color:#A9A9A9' class='fas'>&#xf13a;</i></a>";

mysqli_data_seek($reorderResult, 0); // Reset the result pointer
$PNo2 = [];
$Pname2 = [];
$BackOrder2 = [];
$i2 = 0;
while ($record = mysqli_fetch_assoc($reorderResult)) {
  $PNo2[$i2] = $record['PartNo'];
  $Pname2[$i2] = $record['PartName'];
  $BackOrder2[$i2]=$record['BackOrder'];
    $formattedTimestamp = date('d/m/y H:i', strtotime($record['LastUpdated']));
  
  $statusClass = 'status-' . str_replace(' ', '', $record['Status']);
  echo "<tr class=\"$statusClass\">
    <td>{$record['ModifiedBinLocation']}</td>
    <td>{$record['PartName']}</td>
    <td>{$record['PartNo']}</td>
<td hidden>{$record['Category']}</td>
    <td>{$record['Available']}</td>
    <td>
        <form id='updateForm_$i2' onkeydown=\"disableEnterKey(event)\">
            <input type='text' id='requiredQty2_$i2' value='{$record['Required']}'/>
            <button id='no-fill' type='button' onclick=\"updateRequiredQty('$PNo2[$i2]', $i2)\">Update</button>
        </form>
    </td>
    <td>{$record['Received']}</td>
    <td>{$record['BackOrder']}</td>
    <td>
        <button id=\"no-fill\" onclick=\"fullOrderReceived('{$PNo2[$i2]}',$BackOrder2[$i2])\">Fully Received</button>
    </td><td>{$record['Status']}</td>
<td>
    <select id='status2_$i2' class=\"statusselect\" onfocusout=\"updateStatusUniversal(2, '$PNo2[$i2]', $i2)\">
        <option value='To be Ordered'>To be Ordered</option>
        <option value='Sent'>Sent</option>
    </select>
</td>
<!--   <td>
        <form id='purchaseOrderForm2_$i2' onkeydown=\"disableEnterKey(event)\">
            <input type='text' id='purchaseOrder2_$i2' value='{$record['PurchaseOrder']}'/>
            <button id='no-fill' type='button' onclick=\"updatePurchaseOrder('$PNo2[$i2]', $i2)\">Update</button>
        </form>
    </td>-->
<td id='purchaseorder'>
    <input type='text' 
           id='purchaseOrder2_$i2' 
           value='{$record['PurchaseOrder']}' 
           onfocusout=\"updatePurchaseOrderUniversal(2, '$PNo2[$i2]', $i2)\"
    />
	</td>
    <td>
        <button id=\"no-fill\" onclick=\"promptUser('{$PNo2[$i2]}',$BackOrder2[$i2])\">Partially Received</button>
    </td>
    <td>{$formattedTimestamp}</td>
    <td id='comments'>
            <input type='text' id='comments2_$i2' value='{$record['Comments']}' onfocusout=\"updateCommentsUniversal(2, '$PNo2[$i2]', $i2)\"/>
    </td>
  </tr>";
  $i2++;
}

echo "</tbody>
</table>";
 echo "<a id=\"bottom2\"></a>
<a id=\"up\" href=\"#top2\"><i style='font-size:24px;color:#A9A9A9' class='fas'>&#xf139;</i></a>";
    echo "<br>";

    
  } else {
    echo "Error executing the query: " . mysqli_error($conn);
  }

  mysqli_close($conn);
} else {
  echo "Error connecting to the database.";
}
?>
</div>
    </div>
    <div class="tab">
      <input type="radio" name="css-tabs" id="tab-3" class="tab-switch">
      <label for="tab-3" class="tab-label">CABLES</label>
      <div id="tab3" class="tab-content">
<?php
include 'connection.php';

$msg = '';

if ($conn) {
  $query = "SELECT *,
    CONCAT(
      BinLocation,
      CASE
        WHEN RIGHT(BinLocation, 2) REGEXP '^[0-9]+0$' THEN ''
        ELSE ''
      END
    ) AS ModifiedBinLocation
    FROM reordercables
    ORDER BY CAST(REGEXP_REPLACE(BinLocation, '[^0-9]', '') AS UNSIGNED),
    LENGTH(BinLocation),
    BinLocation";

  $reorderResult = mysqli_query($conn, $query);

  if ($reorderResult) {
    echo "
    <center>
    <h2 id=\"lbh\">Re-Order (Cables)</h2>
    <br>
    <h3>" . $msg . "<br><br>";



echo "<div id=\"filters\">
<label for=\"status\">Status:</label>
<select id=\"status\" onchange=\"applyFilters3()\">
<option value=\"\">All</option>"; // Include the default "All" option here

$statuses = array();
mysqli_data_seek($reorderResult, 0); // Reset the result pointer

while ($record = mysqli_fetch_assoc($reorderResult)) {
  $status = $record['Status'];
  if (!in_array($status, $statuses)) {
    $statuses[] = $status;
    echo "<option value=\"$status\">$status</option>";
  }
}

echo "</select>
</div></center>";
    echo "<br><button id=\"fill-green\" onclick=\"printTable3();\">Print</button>";

    echo "<table class=\"reorder\" id=\"lbt3\" border='2'>
<thead>
<tr>
    <th>Bin Location</th>
    <th>Description</th>
    <th>Part Number</th>
    <th>Reel Length</th>
    <th hidden>Category</th>
    <th>Required Quantity</th>
    <th>Received Quantity</th>
    <th>Back Order</th>
    <th>Fully Received</th>
    <th> Current Status</th>
	<th>Update Status</th>
    <th>Purchase Order</th>
    <th>Partially Received</th>
    <th>Last Updated</th>
    <th>Comments</th>
     <th>Delete</th>
</tr>
</thead>
<tbody><a id=\"top3\"><a id=\"down\" href=\"#bottom3\"><i style='font-size:24px; color:#A9A9A9' class='fas'>&#xf13a;</i></a>";

mysqli_data_seek($reorderResult, 0); // Reset the result pointer
$PNo3 = [];
$Pname3 = [];
$BackOrder3 = [];
$i3 = 0;
while ($record = mysqli_fetch_assoc($reorderResult)) {
  $PNo3[$i3] = $record['PartNo'];
  $Pname3[$i3] = $record['PartName'];
  $BackOrder3[$i3]=$record['BackOrder'];
  
  $statusClass = 'status-' . str_replace(' ', '', $record['Status']);
  echo "<tr class=\"$statusClass\">
    <td>{$record['ModifiedBinLocation']}</td>
    <td>{$record['PartName']}</td>
    <td>{$record['PartNo']}</td>
    <td>{$record['Length']}</td>
<td hidden>{$record['Category']}</td>
    <td>
        <form id='updateForm_$i3' onkeydown=\"disableEnterKey(event)\">
            <input type='text' id='requiredQty3_$i3' value='{$record['Required']}'/>
            <button id='no-fill' type='button' onclick=\"updateRequiredQty3('$PNo3[$i3]', $i3)\">Update</button>
        </form>
    </td>
    <td>{$record['Received']}</td>
    <td>{$record['BackOrder']}</td>
    <td>
        <button id=\"no-fill\" onclick=\"fullOrderReceived3('{$PNo3[$i3]}',$BackOrder3[$i3])\">Fully Received</button>
    </td><td>{$record['Status']}</td>
<td>
    <select id='status3_$i3' class=\"statusselect\" onfocusout=\"updateStatusUniversal(3, '$PNo3[$i3]', $i3)\">
        <option value='To be Ordered'>To be Ordered</option>
        <option value='Sent'>Sent</option>
    </select>
</td>
   <!-- <td>
        <form id='purchaseOrderForm_$i3' onkeydown=\"disableEnterKey(event)\">
            <input type='text' id='purchaseOrder3_$i3' value='{$record['PurchaseOrder']}'/>
            <button id='no-fill' type='button' onclick=\"updatePurchaseOrder3('$PNo3[$i3]', $i3)\">Update</button>
        </form>
        </td>-->
<td id='purchaseorder'>
    <input type='text' 
           id='purchaseOrder3_$i3' 
           value='{$record['PurchaseOrder']}' 
           onfocusout=\"updatePurchaseOrderUniversal(3, '$PNo3[$i3]', $i3)\"
    />
	</td>
    <td>
        <button id=\"no-fill\" onclick=\"promptUser3('{$PNo3[$i3]}',$BackOrder3[$i3])\">Partially Received</button>
    </td>
    <td>{$record['LastUpdated']}</td>
    <td id='comments'>
            <input type='text' id='comments3_$i3' value='{$record['Comments']}' onfocusout=\"updateCommentsUniversal(3, '$PNo3[$i3]', $i3)\"/>
    </td>
<td>
        <a id=\"fill-white\" onclick=\"deleteRow3('$PNo3[$i3]')\">&#10060;</a>
    </td>
  </tr>";
  $i3++;
}

echo "</tbody>
</table>";
 echo "<a id=\"bottom3\"></a>
<a id=\"up\" href=\"#top3\"><i style='font-size:24px;color:#A9A9A9' class='fas'>&#xf139;</i></a>";

  } else {
    echo "Error executing the query: " . mysqli_error($conn);
  }

  mysqli_close($conn);
} else {
  echo "Error connecting to the database.";
}
?>
	</div>
    </div>
	   <div class="tab">
      <input type="radio" name="css-tabs" id="tab-4" class="tab-switch">
      <label for="tab-4" class="tab-label">CONSUMABLES</label>
      <div id="tab4" class="tab-content">
<?php
include 'connection.php';

$msg = '';

if ($conn) {
  $query = "SELECT *,
    CONCAT(
      BinLocation,
      CASE
        WHEN RIGHT(BinLocation, 2) REGEXP '^[0-9]+0$' THEN ''
        ELSE ''
      END
    ) AS ModifiedBinLocation
    FROM reorderconsumables
    ORDER BY CAST(REGEXP_REPLACE(BinLocation, '[^0-9]', '') AS UNSIGNED),
    LENGTH(BinLocation),
    BinLocation";

  $reorderResult = mysqli_query($conn, $query);

  if ($reorderResult) {
    echo "
    <center>
    <h2 id=\"lbh\">Re-Order (Consumables)</h2>
    <br>
    <h3>" . $msg . "<br><br>";



echo "<div id=\"filters\">
<label for=\"status\">Status:</label>
<select id=\"status\" onchange=\"applyFilters4()\">
<option value=\"\">All</option>"; // Include the default "All" option here

$statuses = array();
mysqli_data_seek($reorderResult, 0); // Reset the result pointer

while ($record = mysqli_fetch_assoc($reorderResult)) {
  $status = $record['Status'];
  if (!in_array($status, $statuses)) {
    $statuses[] = $status;
    echo "<option value=\"$status\">$status</option>";
  }
}

echo "</select>
</div></center>";
    echo "<br><button id=\"fill-green\" onclick=\"printTable4();\">Print</button>";

    echo "<table class=\"reorder\" id=\"lbt4\" border='2'>
<thead>
<tr>
    <th>Bin Location</th>
    <th>Description</th>
    <th>Part Number</th>
    <th hidden>Category</th>
    <th>Required Quantity</th>
    <th>Received Quantity</th>
    <th>Back Order</th>
    <th>Fully Received</th>
    <th>Current Status</th>
	<th>Update Status</th>
    <th>Purchase Order</th>
    <th>Partially Received</th>
    <th>Last Updated</th>
    <th>Comments</th>
     <th>Delete</th>
</tr>
</thead>
<tbody><a id=\"top4\"><a id=\"down\" href=\"#bottom4\"><i style='font-size:24px; color:#A9A9A9' class='fas'>&#xf13a;</i></a>";

mysqli_data_seek($reorderResult, 0); // Reset the result pointer
$PNo4 = [];
$Pname4 = [];
$BackOrder4 = [];
$i4 = 0;
while ($record = mysqli_fetch_assoc($reorderResult)) {
  $PNo4[$i4] = $record['PartNo'];
  $Pname4[$i4] = $record['PartName'];
  $BackOrder4[$i4]=$record['BackOrder'];
  
  $statusClass = 'status-' . str_replace(' ', '', $record['Status']);
  echo "<tr class=\"$statusClass\">
    <td>{$record['ModifiedBinLocation']}</td>
    <td>{$record['PartName']}</td>
    <td>{$record['PartNo']}</td>
<td hidden>{$record['Category']}</td>
    <td>
        <form id='updateForm_$i4' onkeydown=\"disableEnterKey(event)\">
            <input type='text' id='requiredQty4_$i4' value='{$record['Required']}'/>
            <button id='no-fill' type='button' onclick=\"updateRequiredQty4('$PNo4[$i4]', $i4)\">Update</button>
        </form>
    </td>
    <td>{$record['Received']}</td>
    <td>{$record['BackOrder']}</td>
    <td>
        <button id=\"no-fill\" onclick=\"fullOrderReceived4('{$PNo4[$i4]}',$BackOrder4[$i4])\">Fully Received</button>
    </td><td>{$record['Status']}</td>
<td>
    <select id='status4_$i4' class=\"statusselect\" onfocusout=\"updateStatusUniversal(4, '$PNo4[$i4]', $i4)\">
        <option value='To be Ordered'>To be Ordered</option>
        <option value='Sent'>Sent</option>
    </select>
</td>
   <!-- <td>
        <form id='purchaseOrderForm_$i4' onkeydown=\"disableEnterKey(event)\">
            <input type='text' id='purchaseOrder4_$i4' value='{$record['PurchaseOrder']}'/>
            <button id='no-fill' type='button' onclick=\"updatePurchaseOrder4('$PNo4[$i4]', $i4)\">Update</button>
        </form>
        </td>-->
<td id='purchaseorder'>
    <input type='text' 
           id='purchaseOrder4_$i4' 
           value='{$record['PurchaseOrder']}' 
           onfocusout=\"updatePurchaseOrderUniversal(4, '$PNo4[$i4]', $i4)\"
    />
	</td>
    <td>
        <button id=\"no-fill\" onclick=\"promptUser4('{$PNo4[$i4]}',$BackOrder4[$i4])\">Partially Received</button>
    </td>
    <td>{$record['LastUpdated']}</td>
    <td id='comments'>
            <input type='text' id='comments4_$i4' value='{$record['Comments']}' onfocusout=\"updateCommentsUniversal(4, '$PNo4[$i4]', $i4)\"/>
    </td>
<td>
        <a id=\"fill-white\" onclick=\"deleteRow4('$PNo4[$i4]')\">&#10060;</a>
    </td>
  </tr>";
  $i4++;
}

echo "</tbody>
</table>";
 echo "<a id=\"bottom4\"></a>
<a id=\"up\" href=\"#top4\"><i style='font-size:24px;color:#A9A9A9' class='fas'>&#xf139;</i></a>";

  } else {
    echo "Error executing the query: " . mysqli_error($conn);
  }

  mysqli_close($conn);
} else {
  echo "Error connecting to the database.";
}
?>

	</div>
    </div>
		   <div class="tab">
      <input type="radio" name="css-tabs" id="tab-5" class="tab-switch">
      <label for="tab-5" class="tab-label">LABELS</label>
      <div id="tab5" class="tab-content">
<?php
include 'connection.php';

$msg = '';

if ($conn) {
  $query = "SELECT *,
    CONCAT(
      BinLocation,
      CASE
        WHEN RIGHT(BinLocation, 2) REGEXP '^[0-9]+0$' THEN ''
        ELSE ''
      END
    ) AS ModifiedBinLocation
    FROM reorderlabels
    ORDER BY CAST(REGEXP_REPLACE(BinLocation, '[^0-9]', '') AS UNSIGNED),
    LENGTH(BinLocation),
    BinLocation";

  $reorderResult = mysqli_query($conn, $query);

  if ($reorderResult) {
    echo "
    <center>
    <h2 id=\"lbh\">Re-Order (Labels)</h2>
    <br>
    <h3>" . $msg . "<br><br>";



echo "<div id=\"filters\">
<label for=\"status\">Status:</label>
<select id=\"status\" onchange=\"applyFilters5()\">
<option value=\"\">All</option>"; // Include the default "All" option here

$statuses = array();
mysqli_data_seek($reorderResult, 0); // Reset the result pointer

while ($record = mysqli_fetch_assoc($reorderResult)) {
  $status = $record['Status'];
  if (!in_array($status, $statuses)) {
    $statuses[] = $status;
    echo "<option value=\"$status\">$status</option>";
  }
}

echo "</select>
</div></center>";
    echo "<br><button id=\"fill-green\" onclick=\"printTable5();\">Print</button>";

    echo "<table class=\"reorder\" id=\"lbt5\" border='2'>
<thead>
<tr>
    <th>Bin Location</th>
    <th>Description</th>
    <th>Part Number</th>
    <th hidden>Category</th>
    <th>Required Quantity</th>
    <th>Received Quantity</th>
    <th>Back Order</th>
    <th>Fully Received</th>
    <th>Current Status</th>
	<th>Update Status</th>
    <th>Purchase Order</th>
    <th>Partially Received</th>
    <th>Last Updated</th>
    <th>Comments</th>
     <th>Delete</th>
</tr>
</thead>
<tbody><a id=\"top5\"><a id=\"down\" href=\"#bottom5\"><i style='font-size:25px; color:#A9A9A9' class='fas'>&#xf13a;</i></a>";

mysqli_data_seek($reorderResult, 0); // Reset the result pointer
$PNo5 = [];
$Pname5 = [];
$BackOrder5 = [];
$i5 = 0;
while ($record = mysqli_fetch_assoc($reorderResult)) {
  $PNo5[$i5] = $record['PartNo'];
  $Pname5[$i5] = $record['PartName'];
  $BackOrder5[$i5]=$record['BackOrder'];
  
  $statusClass = 'status-' . str_replace(' ', '', $record['Status']);
  echo "<tr class=\"$statusClass\">
    <td>{$record['ModifiedBinLocation']}</td>
    <td>{$record['PartName']}</td>
    <td>{$record['PartNo']}</td>
<td hidden>{$record['Category']}</td>
    <td>
        <form id='updateForm_$i5' onkeydown=\"disableEnterKey(event)\">
            <input type='text' id='requiredQty5_$i5' value='{$record['Required']}'/>
            <button id='no-fill' type='button' onclick=\"updateRequiredQty5('$PNo5[$i5]', $i5)\">Update</button>
        </form>
    </td>
    <td>{$record['Received']}</td>
    <td>{$record['BackOrder']}</td>
    <td>
        <button id=\"no-fill\" onclick=\"fullOrderReceived5('{$PNo5[$i5]}',$BackOrder5[$i5])\">Fully Received</button>
    </td><td>{$record['Status']}</td>
<td>
    <select id='status5_$i5' class=\"statusselect\" onfocusout=\"updateStatusUniversal(5, '$PNo5[$i5]', $i5)\">
        <option value='To be Ordered'>To be Ordered</option>
        <option value='Sent'>Sent</option>
    </select>
</td>
    <!--<td>
        <form id='purchaseOrderForm_$i5' onkeydown=\"disableEnterKey(event)\">
            <input type='text' id='purchaseOrder5_$i5' value='{$record['PurchaseOrder']}'/>
            <button id='no-fill' type='button' onclick=\"updatePurchaseOrder5('$PNo5[$i5]', $i5)\">Update</button>
        </form>
        </td>-->
	<td id='purchaseorder'>
    <input type='text' 
           id='purchaseOrder5_$i5' 
           value='{$record['PurchaseOrder']}' 
           onfocusout=\"updatePurchaseOrderUniversal(5, '$PNo5[$i5]', $i5)\"
    />
	</td>
    <td>
        <button id=\"no-fill\" onclick=\"promptUser5('{$PNo5[$i5]}',$BackOrder5[$i5])\">Partially Received</button>
    </td>
    <td>{$record['LastUpdated']}</td>
 <td id='comments'>
            <input type='text' id='comments5_$i5' value='{$record['Comments']}' onfocusout=\"updateCommentsUniversal(5, '$PNo5[$i5]', $i5)\"/>
    </td>
<td>
        <a id=\"fill-white\" onclick=\"deleteRow5('$PNo5[$i5]')\">&#10060;</a>
    </td>
  </tr>";
  $i5++;
}

echo "</tbody>
</table>";
 echo "<a id=\"bottom5\"></a>
<a id=\"up\" href=\"#top5\"><i style='font-size:25px;color:#A9A9A9' class='fas'>&#xf139;</i></a>";

  } else {
    echo "Error executing the query: " . mysqli_error($conn);
  }

  mysqli_close($conn);
} else {
  echo "Error connecting to the database.";
}
?>
	</div>
    </div>
  </div>
</div>


<script>
// Wait for the page to fully load
window.addEventListener('load', function() {
  // Hide the loading animation after the page has loaded
  var loadingAnimation = document.getElementById('loading-animation');
  loadingAnimation.style.display = 'none';
});



// Get all tab switches
var tabSwitches = document.querySelectorAll('.tab-switch');

// Retrieve the active tab from localStorage
var activeTab = localStorage.getItem('activeTab');

// Activate the stored active tab (if any)
if (activeTab) {
  var activeTabSwitch = document.getElementById(activeTab);
  if (activeTabSwitch) {
    activeTabSwitch.checked = true;
  }
}

// Add click event listeners to tab switches
tabSwitches.forEach(function(tabSwitch) {
  tabSwitch.addEventListener('click', function() {
    // Update the activeTab variable and store it in localStorage
    activeTab = this.getAttribute('id');
    localStorage.setItem('activeTab', activeTab);
  });
});


        function disableEnterKey(event) {
            if (event.key === "Enter") {
                event.preventDefault();
                return false;
            }
        }
		
		    window.onload = function() {
        applyFilters1();
		applyFilters(); // Apply the initial filter
		applyFilters3();
		applyFilters4();
		applyFilters5();		// Apply the initial filter
    }

function applyFilters1() {
  var category1 = document.getElementById("category").value;
  var status1 = document.getElementById("status").value;
  var rows1 = document.getElementById("lbt1").getElementsByTagName("tbody")[0].getElementsByTagName("tr");

  for (var i1 = 0; i1 < rows1.length; i1++) {
    var row1 = rows1[i1];
    var categoryCell1 = row1.getElementsByTagName("td")[4];
    var statusCell1 = row1.getElementsByTagName("td")[10];
    var categoryText1 = categoryCell1.textContent || categoryCell1.innerText;
    var statusText1 = statusCell1.textContent || statusCell1.innerText;
    var showRow1 = true;

    if (category1 && categoryText1 !== category1) {
      showRow1 = false;
    }

    if (status1 && statusText1 !== status1) {
      showRow1 = false;
    }

    if (showRow1) {
      row1.style.display = "";
    } else {
      row1.style.display = "none";
    }
  }
}

function updateRequiredQty1(partNo1, rowIndex1) {
    var requiredQtyInput1 = document.getElementById('requiredQty1_' + rowIndex1);
    var requiredQty1 = requiredQtyInput1.value;
//alert(requiredQtyInput1,requiredQty1);
    // Display a confirmation prompt with the new value
    var confirmed1 = confirm('Are you sure you want to update requiredQty to ' + requiredQty1 + '?');

    if (!confirmed1) {
        return; // Exit the function if not confirmed
    }

    // Prepare the data to send
    var data1 = 'partNo=' + encodeURIComponent(partNo1) +
               '&requiredQty=' + encodeURIComponent(requiredQty1);

    // Send the data to the PHP page
    var xhr1 = new XMLHttpRequest();
    xhr1.open('POST', 'updaterequired1.php', true);
    xhr1.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr1.onreadystatechange = function() {
        if (xhr1.readyState === 4 && xhr1.status === 200) {
            // Process the response from the PHP page
            var response1 = xhr1.responseText;
            alert(response1);

            // Refresh the page
            //location.reload();
        }
    };
    xhr1.send(data1);
}

function fullOrderReceived1(partNo1, quantity1) {
    // Display a confirmation prompt with the new value
    var confirmed = confirm('Are you sure you have received ' + quantity1 + ' of ' + partNo1 + '?');

    if (!confirmed) {
        return; // Exit the function if not confirmed
    }

    // Prepare the data to send
    var data1 = 'partNo=' + encodeURIComponent(partNo1) +
               '&quantity=' + encodeURIComponent(quantity1);

    // Send the data to the PHP page
    var xhr1 = new XMLHttpRequest();
    xhr1.open('POST', 'fullOrderReceived1.php', true);
    xhr1.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr1.onreadystatechange = function() {
        if (xhr1.readyState === 4 && xhr1.status === 200) {
            // Process the response from the PHP page
            var response1 = xhr1.responseText;
            alert(response1);

            // Refresh the page
            location.reload();
        }
    };
    xhr1.send(data1);
}


function updateStatusUniversal(tabNumber, partNo, rowIndex) {
    const statusSelect = document.getElementById('status' + tabNumber + '_' + rowIndex);
    const status = statusSelect.value;
    console.log(status);

    // Ask for confirmation if the status is 'To be Ordered'
    if (status === 'To be Ordered') {
        const confirmation = window.confirm("Are you sure you want to set the status to 'To be Ordered'?");

        // If the user cancels the confirmation, exit the function
        if (!confirmation) {
            return;
        }
    }

    // Prepare the data to send
    const data = `tabNumber=${encodeURIComponent(tabNumber)}&partNo=${encodeURIComponent(partNo)}&status=${encodeURIComponent(status)}`;

    // Send the data to the PHP page
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'updateUniversalOrderStatus.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);  // Parse the JSON string into an object
            console.log(response);  // To see the full object
            if (response.message) {
                console.log(response.message);  // Log the message property
            } else {
                console.log("The message property is not set.");
            }
            if(response.success) {
                statusSelect.style.color="green";
                statusSelect.style.fontWeight = "bold";
            } else {
                statusSelect.style.color="red";
                statusSelect.style.fontWeight = "bold";
            }
            ////location.reload();
        }
    };
    xhr.send(data);
}



function refreshdata1() {


    // Send the data to the PHP page
    var xhr1 = new XMLHttpRequest();
    xhr1.open('POST', 'refreshdatahmtp.php', true);
    xhr1.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr1.onreadystatechange = function() {
        if (xhr1.readyState === 4 && xhr1.status === 200) {
            // Process the response from the PHP page
            var response1 = xhr1.responseText;
            location.reload();
        }
    };
    xhr1.send();
}

function promptUser1(partNo1, oldQuantity1) {
    var newQuantity1 = prompt("For: " + partNo1 + "\nPartial Ordered Quantity:");
    var confirmed1 = confirm("Are you sure you want to update the Received Quantity to " + newQuantity1 + "?");

    if (!confirmed1) {
        return; // Exit the function if not confirmed
    }

    // Send the data to a PHP page
    var xhr1 = new XMLHttpRequest();
    xhr1.open("POST", "partialOrderReceived1.php", true);
    xhr1.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr1.onreadystatechange = function() {
        if (xhr1.readyState === 4 && xhr1.status === 200) {
            // Process the response from the PHP page
            var response1 = xhr1.responseText;
            alert(response1);
            // Refresh the page
            location.reload();
        }
    };

    // Prepare the data to send
    var data1 = 'partNo=' + encodeURIComponent(partNo1) +
                '&newQuantity=' + encodeURIComponent(newQuantity1) +
                '&oldQuantity=' + encodeURIComponent(oldQuantity1);
    xhr1.send(data1);
}

function updatePurchaseOrderUniversal(tabNumber, partNo, rowIndex) {
    var purchaseOrderInput = document.getElementById('purchaseOrder' + tabNumber + '_' + rowIndex);
    var purchaseOrder = purchaseOrderInput.value;
	//var cell=document.getElementById(

    // Prepare the data to send
    var data = 'tabNumber=' + encodeURIComponent(tabNumber) +
               '&partNo=' + encodeURIComponent(partNo) +
               '&purchaseOrder=' + encodeURIComponent(purchaseOrder);
			   

    // Send the data to the PHP page
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'updateUniversalPurchaseOrder.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);  // Parse the JSON string into an object
            console.log(response);  // To see the full object
            if (response.message) {
                console.log(response.message);  // Log the message property
            } else {
                console.log("The message property is not set.");
            }
			//alert(purchaseOrder);
			if((purchaseOrder!='')&&(purchaseOrder!='na'))
			{
            if(response.success) {
              purchaseOrderInput.style.color="green";
              purchaseOrderInput.style.fontWeight = "bold";

              
            } else {
              purchaseOrderInput.style.color="red";
              purchaseOrderInput.style.fontWeight = "bold";
            }
			}
            ////location.reload();
        }
    };
    xhr.send(data);
}

function updateCommentsUniversal(tabNumber, partNo, rowIndex) {
    const commentsInput = document.getElementById('comments' + tabNumber + '_' + rowIndex);
    const comments = commentsInput.value;

    // Prepare the data to send
    const data = `tabNumber=${encodeURIComponent(tabNumber)}&partNo=${encodeURIComponent(partNo)}&comments=${encodeURIComponent(comments)}`;

    // Send the data to the PHP page
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'updateUniversalComments.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);  // Parse the JSON string into an object
            console.log(response);  // To see the full object
            if (response.message) {
                console.log(response.message);  // Log the message property
            } else {
                console.log("The message property is not set.");
            }
			if((comments!='')&&(comments!='na'))
			{
            if(response.success) {
              commentsInput.style.color="green";
              commentsInput.style.fontWeight = "bold";

              
            } else {
              commentsInput.style.color="red";
              commentsInput.style.fontWeight = "bold";
            }
			}
            ////location.reload();
        }
    };
    xhr.send(data);
}

function printTable1() {
  var table = document.getElementById("lbt1");
  var windowContent = '<html><head><title>Print Table</title>';
  windowContent += '<style>' + getComputedStyle(table).cssText + '</style>';
  windowContent += '<style>table { width: 100%; border-collapse: collapse; } input { text-align: center; border: none !important; padding-top:20px; font-size: 15px; font-family:Jost;	width:50%;	} th, td { text-align: center; border: 1px solid black; } th {background-color: #ff8a8a;height: 50px;} .no-print,#no-fill { display: none; } #purchaseorder { width:15%;}</style>';
  windowContent += '</head><body>';

  // Retrieve the table rows
  var rows = table.rows;
  for (var i = 0; i < rows.length; i++) {
    var cells = rows[i].cells;
    for (var j = cells.length - 1; j >= 0; j--) {
      // Check if the current cell index is 8 or 10
      if (j === 9 || j === 11 || j===13) {
        // Add a class to exempt the column from printing
        cells[j].classList.add('no-print');
      }
    }
  }

  windowContent += table.outerHTML;
  windowContent += '</body></html>';

  var printWindow = window.open('', '', '');
  printWindow.document.open();
  printWindow.document.write(windowContent);
  printWindow.document.close();
  printWindow.print();
}

    function exportToExcel1() {
      var table = document.getElementById("lbt1");

      // Clone the table and remove unwanted columns and buttons
      var clonedTable = table.cloneNode(true);
      var columnsToRemove = [8, 10,12]; // Indices of the columns to remove

      var rows = clonedTable.getElementsByTagName("tr");
      for (var i = 0; i < rows.length; i++) {
        var cells = rows[i].getElementsByTagName("td");
        for (var j = columnsToRemove.length - 1; j >= 0; j--) {
          var columnIndex = columnsToRemove[j];
          cells[columnIndex].remove();
        }

        var buttons = rows[i].getElementsByTagName("button");
        for (var k = buttons.length - 1; k >= 0; k--) {
          var button = buttons[k];
          button.parentNode.removeChild(button);
        }
      }

      var workbook = XLSX.utils.table_to_book(clonedTable);
      var sheetName = workbook.SheetNames[0];
      var worksheet = workbook.Sheets[sheetName];

      // Generate a Blob object
      var wbout = XLSX.write(workbook, { bookType: 'xlsx', type: 'array' });
      var blob = new Blob([wbout], { type: 'application/octet-stream' });

      // Create a download link
      var a = document.createElement('a');
      var url = URL.createObjectURL(blob);
      a.href = url;
      a.download = 'HYMODTOPHAT.xlsx';

      // Append the link to the body and click it
      document.body.appendChild(a);
      a.click();

      // Clean up resources
      document.body.removeChild(a);
      URL.revokeObjectURL(url);
    
    }

function applyFilters() {
  var category = document.getElementById("category").value;
  var status = document.getElementById("status").value;
  var rows = document.getElementById("lbt2").getElementsByTagName("tbody")[0].getElementsByTagName("tr");

  for (var i = 0; i < rows.length; i++) {
    var row = rows[i];
    //var categoryCell = row.getElementsByTagName("td")[3];
    var statusCell = row.getElementsByTagName("td")[9];
    //var categoryText = categoryCell.textContent || categoryCell.innerText;
    var statusText = statusCell.textContent || statusCell.innerText;
    var showRow = true;
  //console.log(statusText);

    if (status && statusText !== status) {
      showRow = false;
    }

    if (showRow) {
      row.style.display = "";
    } else {
      row.style.display = "none";
    }
  }
}


function fullOrderReceived(partNo, quantity) {


    // Display a confirmation prompt with the new value
    var confirmed = confirm('Are you sure you have recieved '+quantity+' of '+partNo+ '?');

    if (!confirmed) {
        return; // Exit the function if not confirmed
    }

    // Prepare the data to send
    var data = 'partNo=' + encodeURIComponent(partNo) +
               '&quantity=' + encodeURIComponent(quantity);

    // Send the data to the PHP page
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'fullOrderReceived.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // Process the response from the PHP page
            var response = xhr.responseText;
            alert(response);

            // Refresh the page
            location.reload();
        }
    };
    xhr.send(data);
}

function promptUser(partNo, oldQuantity) {
    var newQuantity = prompt("For: " + partNo + "\nPartial Ordered Quantity:");
    var confirmed = confirm("Are you sure you want to update the Received Quantity to " + newQuantity + "?");

    if (!confirmed) {
        return; // Exit the function if not confirmed
    }

    // Send the data to a PHP page
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "partialOrderReceived.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // Process the response from the PHP page
            var response = xhr.responseText;
            alert(response);
            // Refresh the page
            location.reload();
        }
    };

    // Prepare the data to send
    var data = 'partNo=' + encodeURIComponent(partNo) +
               '&newQuantity=' + encodeURIComponent(newQuantity) +
			   '&oldQuantity=' + encodeURIComponent(oldQuantity) ; 
    xhr.send(data);
}

function updateRequiredQty(partNo, rowIndex) {
    var requiredQtyInput = document.getElementById('requiredQty2_' + rowIndex);
    var requiredQty = requiredQtyInput.value;

    // Display a confirmation prompt with the new value
    var confirmed = confirm('Are you sure you want to update requiredQty to ' + requiredQty + '?');

    if (!confirmed) {
        return; // Exit the function if not confirmed
    }

    // Prepare the data to send
    var data = 'partNo=' + encodeURIComponent(partNo) +
               '&requiredQty=' + encodeURIComponent(requiredQty);

    // Send the data to the PHP page
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'updaterequired.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // Process the response from the PHP page
            var response = xhr.responseText;
            alert(response);

            // Refresh the page
            //location.reload();
        }
    };
    xhr.send(data);
}


function refreshdata() {


    // Send the data to the PHP page
    var xhr1 = new XMLHttpRequest();
    xhr1.open('POST', 'refreshdatakanban.php', true);
    xhr1.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr1.onreadystatechange = function() {
        if (xhr1.readyState === 4 && xhr1.status === 200) {
            // Process the response from the PHP page
            var response1 = xhr1.responseText;
            location.reload();
        }
    };
    xhr1.send();
}


function printTable() {
  var table = document.getElementById("lbt2");
  var windowContent = '<html><head><title>Print Table</title>';
  windowContent += '<style>' + getComputedStyle(table).cssText + '</style>';
  windowContent += '<style>table { width: 100%; border-collapse: collapse; } input { text-align: center; border: none !important; padding-top:20px; font-size: 15px; font-family:Jost;	width:50%;	} th, td { text-align: center; border: 1px solid black; } th {background-color: #ff8a8a;height: 50px;} .no-print,#no-fill { display: none; } #purchaseorder { width:15%;}</style>';
  windowContent += '</head><body>';

  // Retrieve the table rows
  var rows = table.rows;
  for (var i = 0; i < rows.length; i++) {
    var cells = rows[i].cells;
    for (var j = cells.length - 1; j >= 0; j--) {
      // Check if the current cell index is 8 or 10
      if (j === 8 || j === 10 || j===12) {
        // Add a class to exempt the column from printing
        cells[j].classList.add('no-print');
      }
    }
  }

  windowContent += table.outerHTML;
  windowContent += '</body></html>';

  var printWindow = window.open('', '', '');
  printWindow.document.open();
  printWindow.document.write(windowContent);
  printWindow.document.close();
  printWindow.print();
}

function applyFilters3() {
  var category3 = document.getElementById("category").value;
  var status3 = document.getElementById("status").value;
  var rows3 = document.getElementById("lbt3").getElementsByTagName("tbody")[0].getElementsByTagName("tr");

  for (var i = 0; i < rows3.length; i++) {
    var row3 = rows3[i];
    var statusCell3 = row3.getElementsByTagName("td")[8];
    var statusText3 = statusCell3.textContent || statusCell3.innerText;
    var showRow3 = true;

    if (status3 && statusText3 !== status3) {
      showRow3 = false;
    }

    if (showRow3) {
      row3.style.display = "";
    } else {
      row3.style.display = "none";
    }
  }
}

function deleteRow3(partNo3) {
  var confirmed3 = confirm('Are you sure you want to delete this row?');

  if (!confirmed3) {
    return; // Exit the function if not confirmed
  }

  // Send the data to the PHP page
  var xhr3 = new XMLHttpRequest();
  xhr3.open('POST', 'deleterowcables.php', true);
  xhr3.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  xhr3.onreadystatechange = function() {
    if (xhr3.readyState === 4 && xhr3.status === 200) {
      // Process the response from the PHP page
      var response3 = xhr3.responseText;
      alert(response3);
      location.reload();
    }
  };

  // Prepare the data to send
  var data3 = 'partNo=' + encodeURIComponent(partNo3);
  xhr3.send(data3);
}

function fullOrderReceived3(partNo3, quantity3) {
  // Display a confirmation prompt with the new value
  var confirmed3 = confirm('Are you sure you have received ' + quantity3 + ' of ' + partNo3 + '?');

  if (!confirmed3) {
    return; // Exit the function if not confirmed
  }

  // Prepare the data to send
  var data3 = 'partNo=' + encodeURIComponent(partNo3) +
    '&quantity=' + encodeURIComponent(quantity3);

  // Send the data to the PHP page
  var xhr3 = new XMLHttpRequest();
  xhr3.open('POST', 'fullOrderReceivedcables.php', true);
  xhr3.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  xhr3.onreadystatechange = function() {
    if (xhr3.readyState === 4 && xhr3.status === 200) {
      // Process the response from the PHP page
      var response3 = xhr3.responseText;
      alert(response3);

      // Refresh the page
      location.reload();
    }
  };
  xhr3.send(data3);
}

function promptUser3(partNo3, oldQuantity3) {
  var newQuantity3 = prompt("For: " + partNo3 + "\nPartial Ordered Quantity:");
  var confirmed3 = confirm("Are you sure that you have received " + newQuantity3 + "?");

  if (!confirmed3) {
    return; // Exit the function if not confirmed
  }

  // Send the data to a PHP page
  var xhr3 = new XMLHttpRequest();
  xhr3.open("POST", "partialOrderReceivedcables.php", true);
  xhr3.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr3.onreadystatechange = function() {
    if (xhr3.readyState === 4 && xhr3.status === 200) {
      // Process the response from the PHP page
      var response3 = xhr3.responseText;
      alert(response3);
      // Refresh the page
      location.reload();
    }
  };

  // Prepare the data to send
  var data3 = 'partNo=' + encodeURIComponent(partNo3) +
    '&newQuantity=' + encodeURIComponent(newQuantity3) +
    '&oldQuantity=' + encodeURIComponent(oldQuantity3);
  xhr3.send(data3);
}

function updateRequiredQty3(partNo3, rowIndex3) {
	 //alert(partNo3);
  var requiredQtyInput3 = document.getElementById('requiredQty3_' + rowIndex3);
  var requiredQty3 = requiredQtyInput3.value;

  // Display a confirmation prompt with the new value
  var confirmed3 = confirm('Are you sure you want to update the Required Quantity to ' + requiredQty3 + '?');

  if (!confirmed3) {
    return; // Exit the function if not confirmed
  }

  // Prepare the data to send
  var data3 = 'partNo=' + encodeURIComponent(partNo3) +
    '&requiredQty=' + encodeURIComponent(requiredQty3);

  // Send the data to the PHP page
  var xhr3 = new XMLHttpRequest();
  xhr3.open('POST', 'updaterequiredcables.php', true);
  xhr3.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  xhr3.onreadystatechange = function() {
    if (xhr3.readyState === 4 && xhr3.status === 200) {
      // Process the response from the PHP page
      var response3 = xhr3.responseText;
      alert(response3);

      // Refresh the page
      //location.reload();
    }
  };
  xhr3.send(data3);
}


function printTable3() {
  var table3 = document.getElementById("lbt3");
  var windowContent3 = '<html><head><title>Print Table</title>';
  windowContent3 += '<style>' + getComputedStyle(table3).cssText + '</style>';
  windowContent3 += '<style>table { width: 100%; border-collapse: collapse; } input { text-align: center; border: none !important; padding-top:20px; font-size: 15px; font-family:Jost; width:50%;		} th, td { text-align: center; border: 1px solid black; } th {background-color: #ff8a8a;height: 50px;} .no-print,#no-fill { display: none; }#purchaseorder { width:15%;}</style>';
  windowContent3 += '</head><body>';

  // Retrieve the table rows
  var rows3 = table3.rows;
  for (var i3 = 0; i3 < rows3.length; i3++) {
    var cells3 = rows3[i3].cells;
    for (var j3 = cells3.length - 1; j3 >= 0; j3--) {
      // Check if the current cell index is 8 or 10
      if (j3 === 8 || j3 === 10|| j3===12 || j3===15) {
        // Add a class to exempt the column from printing
        cells3[j3].classList.add('no-print');
      }
    }
  }

  windowContent3 += table3.outerHTML;
  windowContent3 += '</body></html>';

  var printWindow3 = window.open('', '', '');
  printWindow3.document.open();
  printWindow3.document.write(windowContent3);
  printWindow3.document.close();
  printWindow3.print();
}


function applyFilters4() {
  var category4 = document.getElementById("category").value;
  var status4 = document.getElementById("status").value;
  var rows4 = document.getElementById("lbt4").getElementsByTagName("tbody")[0].getElementsByTagName("tr");

  for (var i = 0; i < rows4.length; i++) {
    var row4 = rows4[i];
    var statusCell4 = row4.getElementsByTagName("td")[8];
    var statusText4 = statusCell4.textContent || statusCell4.innerText;
    var showRow4 = true;

    if (status4 && statusText4 !== status4) {
      showRow4 = false;
    }

    if (showRow4) {
      row4.style.display = "";
    } else {
      row4.style.display = "none";
    }
  }
}

function deleteRow4(partNo4) {
  var confirmed4 = confirm('Are you sure you want to delete this row?');

  if (!confirmed4) {
    return; // Exit the function if not confirmed
  }

  // Send the data to the PHP page
  var xhr4 = new XMLHttpRequest();
  xhr4.open('POST', 'deleterowconsumables.php', true);
  xhr4.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  xhr4.onreadystatechange = function() {
    if (xhr4.readyState === 4 && xhr4.status === 200) {
      // Process the response from the PHP page
      var response4 = xhr4.responseText;
      alert(response4);
      location.reload();
    }
  };

  // Prepare the data to send
  var data4 = 'partNo=' + encodeURIComponent(partNo4);
  xhr4.send(data4);
}

function fullOrderReceived4(partNo4, quantity4) {
  // Display a confirmation prompt with the new value
  var confirmed4 = confirm('Are you sure you have received ' + quantity4 + ' of ' + partNo4 + '?');

  if (!confirmed4) {
    return; // Exit the function if not confirmed
  }

  // Prepare the data to send
  var data4 = 'partNo=' + encodeURIComponent(partNo4) +
    '&quantity=' + encodeURIComponent(quantity4);

  // Send the data to the PHP page
  var xhr4 = new XMLHttpRequest();
  xhr4.open('POST', 'fullOrderReceivedconsumables.php', true);
  xhr4.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  xhr4.onreadystatechange = function() {
    if (xhr4.readyState === 4 && xhr4.status === 200) {
      // Process the response from the PHP page
      var response4 = xhr4.responseText;
      alert(response4);

      // Refresh the page
      location.reload();
    }
  };
  xhr4.send(data4);
}

function promptUser4(partNo4, oldQuantity4) {
  var newQuantity4 = prompt("For: " + partNo4 + "\nPartial Ordered Quantity:");
  var confirmed4 = confirm("Are you sure that you have received " + newQuantity4 + "?");

  if (!confirmed4) {
    return; // Exit the function if not confirmed
  }

  // Send the data to a PHP page
  var xhr4 = new XMLHttpRequest();
  xhr4.open("POST", "partialOrderReceivedconsumables.php", true);
  xhr4.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr4.onreadystatechange = function() {
    if (xhr4.readyState === 4 && xhr4.status === 200) {
      // Process the response from the PHP page
      var response4 = xhr4.responseText;
      alert(response4);
      // Refresh the page
      location.reload();
    }
  };

  // Prepare the data to send
  var data4 = 'partNo=' + encodeURIComponent(partNo4) +
    '&newQuantity=' + encodeURIComponent(newQuantity4) +
    '&oldQuantity=' + encodeURIComponent(oldQuantity4);
  xhr4.send(data4);
}

function updateRequiredQty4(partNo4, rowIndex4) {
	 //alert(partNo4);
  var requiredQtyInput4 = document.getElementById('requiredQty4_' + rowIndex4);
  var requiredQty4 = requiredQtyInput4.value;

  // Display a confirmation prompt with the new value
  var confirmed4 = confirm('Are you sure you want to update the Required Quantity to ' + requiredQty4 + '?');

  if (!confirmed4) {
    return; // Exit the function if not confirmed
  }

  // Prepare the data to send
  var data4 = 'partNo=' + encodeURIComponent(partNo4) +
    '&requiredQty=' + encodeURIComponent(requiredQty4);

  // Send the data to the PHP page
  var xhr4 = new XMLHttpRequest();
  xhr4.open('POST', 'updaterequiredconsumables.php', true);
  xhr4.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  xhr4.onreadystatechange = function() {
    if (xhr4.readyState === 4 && xhr4.status === 200) {
      // Process the response from the PHP page
      var response4 = xhr4.responseText;
      alert(response4);

      // Refresh the page
      //location.reload();
    }
  };
  xhr4.send(data4);
}



function printTable4() {
  var table4 = document.getElementById("lbt4");
  var windowContent4 = '<html><head><title>Print Table</title>';
  windowContent4 += '<style>' + getComputedStyle(table4).cssText + '</style>';
  windowContent4 += '<style>table { width: 100%; border-collapse: collapse; } input { text-align: center; border: none !important; padding-top:20px; font-size: 15px; font-family:Jost; width:50%;	} th, td { text-align: center; border: 1px solid black; } th {background-color: #ff8a8a;height: 50px;} .no-print,#no-fill { display: none; }#purchaseorder { width:15%;}</style>';
  windowContent4 += '</head><body>';

  // Retrieve the table rows
  var rows4 = table4.rows;
  for (var i4 = 0; i4 < rows4.length; i4++) {
    var cells4 = rows4[i4].cells;
    for (var j4 = cells4.length - 1; j4 >= 0; j4--) {
      // Check if the current cell index is 8 or 10
      if (j4 === 7 || j4 === 9 || j4===11 || j4===14) {
        // Add a class to exempt the column from printing
        cells4[j4].classList.add('no-print');
      }
    }
  }

  windowContent4 += table4.outerHTML;
  windowContent4 += '</body></html>';

  var printWindow4 = window.open('', '', '');
  printWindow4.document.open();
  printWindow4.document.write(windowContent4);
  printWindow4.document.close();
  printWindow4.print();
}

function applyFilters5() {
  var category5 = document.getElementById("category").value;
  var status5 = document.getElementById("status").value;
  var rows5 = document.getElementById("lbt5").getElementsByTagName("tbody")[0].getElementsByTagName("tr");

  for (var i = 0; i < rows5.length; i++) {
    var row5 = rows5[i];
    var statusCell5 = row5.getElementsByTagName("td")[8];
    var statusText5 = statusCell5.textContent || statusCell5.innerText;
    var showRow5 = true;

    if (status5 && statusText5 !== status5) {
      showRow5 = false;
    }

    if (showRow5) {
      row5.style.display = "";
    } else {
      row5.style.display = "none";
    }
  }
}

function deleteRow5(partNo5) {
  var confirmed5 = confirm('Are you sure you want to delete this row?');

  if (!confirmed5) {
    return; // Exit the function if not confirmed
  }

  // Send the data to the PHP page
  var xhr5 = new XMLHttpRequest();
  xhr5.open('POST', 'deleterowlabels.php', true);
  xhr5.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  xhr5.onreadystatechange = function() {
    if (xhr5.readyState === 4 && xhr5.status === 200) {
      // Process the response from the PHP page
      var response5 = xhr5.responseText;
      alert(response5);
      location.reload();
    }
  };

  // Prepare the data to send
  var data5 = 'partNo=' + encodeURIComponent(partNo5);
  xhr5.send(data5);
}

function fullOrderReceived5(partNo5, quantity5) {
  // Display a confirmation prompt with the new value
  var confirmed5 = confirm('Are you sure you have received ' + quantity5 + ' of ' + partNo5 + '?');

  if (!confirmed5) {
    return; // Exit the function if not confirmed
  }

  // Prepare the data to send
  var data5 = 'partNo=' + encodeURIComponent(partNo5) +
    '&quantity=' + encodeURIComponent(quantity5);

  // Send the data to the PHP page
  var xhr5 = new XMLHttpRequest();
  xhr5.open('POST', 'fullOrderReceivedlabels.php', true);
  xhr5.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  xhr5.onreadystatechange = function() {
    if (xhr5.readyState === 4 && xhr5.status === 200) {
      // Process the response from the PHP page
      var response5 = xhr5.responseText;
      alert(response5);

      // Refresh the page
      location.reload();
    }
  };
  xhr5.send(data5);
}

function promptUser5(partNo5, oldQuantity5) {
  var newQuantity5 = prompt("For: " + partNo5 + "\nPartial Ordered Quantity:");
  var confirmed5 = confirm("Are you sure that you have received " + newQuantity5 + "?");

  if (!confirmed5) {
    return; // Exit the function if not confirmed
  }

  // Send the data to a PHP page
  var xhr5 = new XMLHttpRequest();
  xhr5.open("POST", "partialOrderReceivedlabels.php", true);
  xhr5.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr5.onreadystatechange = function() {
    if (xhr5.readyState === 4 && xhr5.status === 200) {
      // Process the response from the PHP page
      var response5 = xhr5.responseText;
      alert(response5);
      // Refresh the page
      location.reload();
    }
  };

  // Prepare the data to send
  var data5 = 'partNo=' + encodeURIComponent(partNo5) +
    '&newQuantity=' + encodeURIComponent(newQuantity5) +
    '&oldQuantity=' + encodeURIComponent(oldQuantity5);
  xhr5.send(data5);
}

function updateRequiredQty5(partNo5, rowIndex5) {
	 //alert(partNo5);
  var requiredQtyInput5 = document.getElementById('requiredQty5_' + rowIndex5);
  var requiredQty5 = requiredQtyInput5.value;

  // Display a confirmation prompt with the new value
  var confirmed5 = confirm('Are you sure you want to update the Required Quantity to ' + requiredQty5 + '?');

  if (!confirmed5) {
    return; // Exit the function if not confirmed
  }

  // Prepare the data to send
  var data5 = 'partNo=' + encodeURIComponent(partNo5) +
    '&requiredQty=' + encodeURIComponent(requiredQty5);

  // Send the data to the PHP page
  var xhr5 = new XMLHttpRequest();
  xhr5.open('POST', 'updaterequiredlabels.php', true);
  xhr5.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

  xhr5.onreadystatechange = function() {
    if (xhr5.readyState === 4 && xhr5.status === 200) {
      // Process the response from the PHP page
      var response5 = xhr5.responseText;
      alert(response5);

      // Refresh the page
      //location.reload();
    }
  };
  xhr5.send(data5);
}



function printTable5() {
  var table5 = document.getElementById("lbt5");
  var windowContent5 = '<html><head><title>Print Table</title>';
  windowContent5 += '<style>' + getComputedStyle(table5).cssText + '</style>';
  windowContent5 += '<style>table { width: 100%; border-collapse: collapse; } input { text-align: center; border: none !important; padding-top:20px; font-size: 15px; font-family:Jost;	width:50%;	} th, td { text-align: center; border: 1px solid black; } th {background-color: #ff8a8a;height: 50px;} .no-print,#no-fill { display: none; }#purchaseorder { width:15%;}</style>';
  windowContent5 += '</head><body>';

  // Retrieve the table rows
  var rows5 = table5.rows;
  for (var i5 = 0; i5 < rows5.length; i5++) {
    var cells5 = rows5[i5].cells;
    for (var j5 = cells5.length - 1; j5 >= 0; j5--) {
      // Check if the current cell index is 8 or 10
      if (j5 === 7 || j5 === 9 || j5===11 || j5===14) {
        // Add a class to exempt the column from printing
        cells5[j5].classList.add('no-print');
      }
    }
  }

  windowContent5 += table5.outerHTML;
  windowContent5 += '</body></html>';

  var printWindow5 = window.open('', '', '');
  printWindow5.document.open();
  printWindow5.document.write(windowContent5);
  printWindow5.document.close();
  printWindow5.print();
}

</script>