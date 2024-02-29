<?php
require('fpdf.php'); // Include the FPDF library

// Include your database connection file
include "connection.php";

// Fetch the jobid from POST
$jobid = isset($_GET['jobid']) ? $_GET['jobid'] : '';

// Fetch project manager name
$queryProjectManagerName = "SELECT projectmanager FROM jobsnew WHERE jobid='$jobid'";
$resultProjectManagerName = mysqli_query($conn, $queryProjectManagerName);

// Check if the query result is not null
if ($resultProjectManagerName && mysqli_num_rows($resultProjectManagerName) > 0) {
    $rowProjectManagerName = mysqli_fetch_assoc($resultProjectManagerName);
    $projectManagerName = $rowProjectManagerName['projectmanager'];

    // Fetch project manager email
    $queryProjectManagerEmail = "SELECT email FROM users WHERE username='$projectManagerName'";
    $resultProjectManagerEmail = mysqli_query($conn, $queryProjectManagerEmail);

    // Check if the query result is not null
    if ($resultProjectManagerEmail && mysqli_num_rows($resultProjectManagerEmail) > 0) {
        $rowProjectManagerEmail = mysqli_fetch_assoc($resultProjectManagerEmail);
        $projectManagerEmail = $rowProjectManagerEmail['email'];

        // Fetch data for the report
        $queryReportData = "SELECT partno, partname, category, SUM(CASE WHEN type = 'used' THEN quantity ELSE -quantity END) AS quantity, ROUND(SUM(quantity*PricePerUnit), 2) as Cost
                            FROM transactions
                            WHERE jobid='$jobid'
                            GROUP BY jobid, partno, category
                            HAVING quantity > 0
                            ORDER BY scandate DESC";
        $resultReportData = mysqli_query($conn, $queryReportData);

        // Check if the query result is not null
        if ($resultReportData && mysqli_num_rows($resultReportData) > 0) {
            // Initialize PDF
            $pdf = new FPDF();
            $pdf->AddPage();

            // Set font
            $pdf->SetFont('Arial', 'B', 16);

            // Add watermark
            $pdf->Image('images/cbi-logo-wm.png', 55, 100, 100); // Adjust the position and size as needed

            $pdf->Cell(0, 5, 'Job Report', 0, 1, 'C'); // Center-aligned title
            $pdf->Ln();
            $pdf->SetFont('Arial', 'I', 8);
            $pdf->Cell(0, 1, '****This Report is generated based on the parts scanned by the fitter(s) and might not include some consumables******', 0, 1, 'C'); // Center-aligned note

            // Add project manager details
            $pdf->Ln();
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->MultiCell(0, 10, 'Project Manager: ' . $projectManagerName, 0, 'C'); // Center-aligned project manager name
            $pdf->MultiCell(0, 10, 'Sales Order: ' . $jobid, 0, 'C'); // Center-aligned sales order

            // Add report data
            $pdf->Ln(15); // Add some space
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Cell(45, 10, 'Part No', 1);
            $pdf->Cell(90, 10, 'Part Name', 1);
            $pdf->Cell(20, 10, 'Category', 1);
            $pdf->Cell(20, 10, 'Quantity', 1);
            $pdf->Cell(20, 10, 'Cost', 1);

            // Fetch and add data
            while ($row = mysqli_fetch_assoc($resultReportData)) {
                $pdf->Ln();
                $pdf->SetFont('Arial', '', 12);
                $pdf->Cell(45, 10, $row['partno'], 1);
                $pdf->SetFont('Arial', '', 8);
                $pdf->Cell(90, 10, $row['partname'], 1);
                $pdf->SetFont('Arial', '', 12);
                $pdf->Cell(20, 10, $row['category'], 1);
                $pdf->Cell(20, 10, $row['quantity'], 1);
                $pdf->Cell(20, 10, $row['Cost'], 1);
                $totalcost += $row['Cost'];
            }

            // Add a new line
            $pdf->Ln();

            // Display total cost with wrapping
            $pdf->MultiCell(0, 10, 'Total Cost: $ ' . $totalcost,0,'R');

            // Save the PDF with jobid as filename
            $pdfFileName = "Projects/$jobid.pdf";
            $pdf->Output($pdfFileName, 'F');

            // Display a success message or redirect to another page
            echo "PDF Report generated and saved: <a href='$pdfFileName' target='_blank'>Download Report</a>";
        } else {
            echo "Error: No data found for the given jobid.";
        }
    } else {
        echo "Error: Project manager email not found for the given jobid.";
    }
} else {
    echo "Error: Project manager details not found for the given jobid.";
}

// Close the database connection
mysqli_close($conn);
?>
