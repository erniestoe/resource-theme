<?php
ob_start();
require ('libraries/fpdf.php');
require ('libraries/makefont.php');

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    die("No resources selected. <a href='index.php'>Go Back</a>");
}

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(40, 10, 'Community Resources');
$pdf->Ln(10); // Line break

foreach ($_SESSION['cart'] as $resource) {
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, $resource["title"], 0, 1);
    
    $pdf->SetFont('Arial', '', 10);
    $pdf->MultiCell(0, 6, "Description: " . $resource["description"]);
    if (!empty($resource["phone"])) $pdf->Cell(0, 6, "Phone: " . $resource["phone"], 0, 1);
    if (!empty($resource["address"])) $pdf->Cell(0, 6, "Address: " . $resource["address"], 0, 1);
    if (!empty($resource["website"])) $pdf->Cell(0, 6, "Website: " . $resource["website"], 0, 1, '', false, $resource["website"]);
    
    $pdf->Ln(10);
}

$pdf->Output("resources.pdf", "D");

unset($_SESSION['cart']);
ob_end_flush(); 
?>