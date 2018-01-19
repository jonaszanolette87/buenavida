<?php
require('../fpdf.php');

class PDF extends FPDF
{
//Page header
function Header()
{
	//Logo
	$this->Image('../../imagens/buenocredito_logo.jpg',10,8,33);
	//Arial bold 15
	$this->SetFont('Arial','i',15);
	//Move to the right
	$this->Cell(60);
	//Title
	$this->Cell(90,10,'Relatorio de Clientes',1,0,'C');

	//Line break
	$this->Ln(20);
}

//Page footer
function Footer()
{
	//Position at 1.5 cm from bottom
	$this->SetY(-15);
	//Arial italic 8
	$this->SetFont('Arial','I',8);
	//Page number
	$this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'C');
}
}

//Instanciation of inherited class
$pdf=new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',12);
for($i=1;$i<=40;$i++)
	$pdf->Cell(0,10,'Linha '.$i,0,1);
$pdf->Output();
?>
