<?php
include 'common4.php';
include 'connection.php';

// Fetch sales order numbers from the database
$query = "SELECT DISTINCT jobid FROM transactions";
$result = mysqli_query($conn, $query);
$salesOrderOptions = '';
while ($row = mysqli_fetch_assoc($result)) {
  $salesOrderNo = $row['jobid'];
  $salesOrderOptions .= "<option value='$salesOrderNo'>$salesOrderNo</option>";
}
include 'loading.php';
?>

<html>
<head>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<!-- Add this to the head of your HTML file -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.5/xlsx.full.min.js"></script>

  <title>Usage Table</title>
  <style>
    /* CSS styles for the table and filters */
    table {
      border-collapse: collapse;
      width: 100%;
    }

    th, td {
      text-align: center;
      border: 1px solid black;
      padding: 8px;
    }

    th {
      background-color: #ff8a8a;
      height: 50px;
    }

    #filters {
      margin-left: 45%;
    }

    #filters label,
    #filters select,
    #filters input {
      margin: 5px;
    }
    #filters input {
      width:60%;
    }
    #filters label{
      margin-left:10%;

    }

    #print-button {
      margin-bottom: 10px;
    }
	table {
		width:98%;
		margin-left:1%;
		margin-bottom:2%;
		padding-top:15%;	
	}

	#mainh1 {
		margin-top:2%;
		margin-left:48%;
	
	}

	#fill-green {	
		margin-left:58%;
	}
	thead th {
  position: sticky;
  top: -1.7rem;
  z-index:10;

}
#content-container{
  margin-top:1%;
}

#up {
	
	margin-left: 97%;
position: sticky;
          bottom:0;

}
#down {
	margin-left: 97%;
	margin-bottom: 50%;
	z-index:1;
position: sticky;
          top:0;
}
#total_cost{
	
	margin-left:25%;
	font-size:20px;
	font-weight:bold;
	}
	
.printscrn{
	
	margin-left:75%;
	margin-top:-2%;
}

    @media print {
      table tr {
        background-color: #ff8a8a !important;
      }
    }
  </style>
</head>
<body>
<h1 id="mainh1">Usage</h1>
<div id="total_cost"></div><div class="printscrn"><button id="fill-green" onclick="printTable()" >Print Table</button></div>
<!-- Add this button where you want the user to click for exporting -->
<!--<button onclick="exportToExcel()">Export to Excel</button>-->

  <div id="filters">
  <label for="sales_order">Sales Order No:</label>
<input type="text" id="sales_order" list="salesOrderList" style="background: #eaeaea; border: solid 1px #6D435A; margin: 2px 0 17px; border-radius: 3px; display: flex; align-items: center;" oninput="applyFilters()">
<datalist id="salesOrderList">
  <option value="">All</option>
  <?php echo $salesOrderOptions; ?>
</datalist>


  </div>
  <div id="total_cost"></div>
<div id="content-container"></div>
  

  <script>
      window.onload = function() {
        applyFilters(); // Apply the initial filter
    };
var totalCost = 0; // Declare the total cost as a global variable

function applyFilters() {
      // Make an AJAX request to your PHP script
      $.ajax({
    type: 'POST',
    url: 'usagedata.php', // Replace with your PHP script's URL
    data: { jobid: document.getElementById('sales_order').value }, // Send data to PHP script if needed
    success: function(response) {
        // Update the content container with the PHP-generated content
        $('#content-container').html(response);
    },
    error: function(xhr, status, error) {
        console.error(xhr.responseText);
    }
});


}
function exportToExcel() {
    var salesOrder = document.getElementById('sales_order').value || 'exported_data';

    // Get the table data
    var table = document.getElementById("jobs_table");
    var ws_data = [['Sales Order No', 'Part No', 'Description', 'Category', 'Quantity Used', 'Cost', 'Date']];
    
    for (var i = 1; i < table.rows.length; i++) {
        var row = table.rows[i];
        var rowData = [];
        for (var j = 0; j < row.cells.length; j++) {
            rowData.push(row.cells[j].innerText);
        }
        ws_data.push(rowData);
    }

    var ws = XLSX.utils.aoa_to_sheet(ws_data);
    var wb = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');

    // Save the Excel file with the sales order as the filename
    XLSX.writeFile(wb, salesOrder + '.xlsx');
}



function printTable() {
    var content = document.getElementById("content-container").innerHTML;

    // Create a new window and open it
    var printWindow = window.open("", "_blank");

    // Write the content to the new window
    printWindow.document.open();
    printWindow.document.write("<html><head><title>Print</title>");
    printWindow.document.write("<style>");
    printWindow.document.write("table { border-collapse: collapse; width: 100%; }");
    printWindow.document.write("th, td { text-align: center; border: 1px solid black; padding: 8px; }");
    printWindow.document.write("th { background-color: #ff8a8a; height: 50px; }");
    printWindow.document.write("</style>");
    printWindow.document.write("</head><body>");

    // Append the content to the new window
    printWindow.document.body.innerHTML = content;

    // Write the closing tags to the new window
    printWindow.document.write("</body></html>");
    printWindow.document.close();

    // Print the new window
    printWindow.print();
}



  </script>
</body>
</html>