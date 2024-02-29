<?php
include "connection.php";
$jobIdFilter = isset($_POST['jobid']) ? mysqli_real_escape_string($conn, $_POST['jobid']) : null;
$totalcost = 0;
$query = "SELECT *
FROM (
    SELECT jobid, partno, partname, category, SUM(CASE WHEN type = 'used' THEN quantity ELSE -quantity END) AS quantity, round(quantity * PricePerUnit, 2) as Cost, scandate
    FROM transactions
    " . ($jobIdFilter ? "WHERE jobid = '$jobIdFilter'" : "") . "
    GROUP BY jobid, partno, category
    ORDER BY scandate DESC
) AS subquery
WHERE quantity > 0;";

$result = mysqli_query($conn, $query);
$result1 = mysqli_query($conn, $query);
while ($row = mysqli_fetch_assoc($result1)) {
    $cost = $row['Cost'];
    $totalcost += $cost;
}


echo "<div id='total_cost' style='margin-left:45%;'>Total Cost: $$totalcost</div>";
echo "<table id='jobs_table'>
    <tr>
      <th>Sales Order No</th>
      <th>Part No</th>
      <th>Description</th>
      <th>Category</th>
	  <th>Quantity Used</th>
	  <th>Cost</th>

    </tr>";

echo "<a id='top'><a id='down' href='#bottom'><i style='font-size:24px; color:#A9A9A9' class='fas'>&#xf13a;</i></a>";

while ($row = mysqli_fetch_assoc($result)) {
    $salesOrderNo = $row['jobid'];
    $partNo = $row['partno'];
    $partName = $row['partname'];
    $category = $row['category'];
    $cost = $row['Cost'];
    $formattedTimestamp = date_format(date_create($row['scandate']), 'd/m/y H:i');
    $used = $row['quantity'];

    $rowColor = 'white';

    echo "<tr style='background-color: $rowColor;'>
              <td>$salesOrderNo</td>
              <td>$partNo</td>
              <td>$partName</td>
              <td>$category</td>
              <td>$used</td>
              <td>$cost</td>
             
            </tr>";
}

echo "</table><br><br>";
?>
