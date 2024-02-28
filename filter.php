<?php
include 'connection.php';

$salesOrder = $_POST['salesOrder'];
$partNo = $_POST['partNo'];
$category = $_POST['category'];
$startDate = $_POST['startDate'];
$endDate = $_POST['endDate'];

// Use these variables to construct your SQL query for filtering data
// Ensure proper validation and sanitation to prevent SQL injection

$query = "SELECT jobid, partno, partname, category, 
            SUM(CASE WHEN type = 'used' THEN quantity ELSE -quantity END) AS quantity,
            ROUND(SUM(CASE WHEN type = 'used' THEN quantity ELSE -quantity END) * PricePerUnit, 2) as cost,
            scandate
            FROM transactions
            WHERE jobid LIKE '%$salesOrder%' AND partno LIKE '%$partNo%' AND category LIKE '%$category%'
            AND scandate BETWEEN '$startDate' AND '$endDate'
            GROUP BY jobid, partno, category
            ORDER BY scandate DESC";

$result = mysqli_query($conn, $query);

$response = array();

if ($result) {
    $data = array();
    $totalCost = 0;

    while ($row = mysqli_fetch_assoc($result)) {
        $salesOrderNo = $row['jobid'];
        $partNo = $row['partno'];
        $partName = $row['partname'];
        $category = $row['category'];
        $cost = $row['cost'];
        $formattedTimestamp = date_format(date_create($row['scandate']), 'd/m/y H:i');
        $used = $row['quantity'];

        // Add the row data to the response
        $data[] = array(
            'salesOrderNo' => $salesOrderNo,
            'partNo' => $partNo,
            'partName' => $partName,
            'category' => $category,
            'used' => $used,
            'cost' => $cost,
            'formattedTimestamp' => $formattedTimestamp
        );

        // Update total cost
        $totalCost += $cost;
    }

    $response['success'] = true;
    $response['data'] = $data;
    $response['totalCost'] = $totalCost;
} else {
    $response['success'] = false;
    $response['error'] = mysqli_error($conn);
}

// Return the JSON response
echo json_encode($response);

mysqli_close($conn);
?>

