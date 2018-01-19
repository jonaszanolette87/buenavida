<?php
define('FPDF_FONTPATH', 'font/');
require('../../fpdf16/fpdf.php');

class PDF extends FPDF
{
//Page header
function Header()
{
	//Logo
	$this->Image('../../imagens/logo-intuitivamoda.jpg',10,8,33);
	//Arial bold 15
	$this->SetFont('Arial','i',10);
	//Move to the right
	$this->Cell(40);
	//Title
	$this->Cell(90,10,'Slink Surf',0,0,'L');
	$this->Ln(5);
	
	//Move to the right
	$this->Cell(40);
	$this->Cell(90,10,'Email: contato@brasilcastanha.com',0,0,'L');
	$this->Ln(5);

	//Move to the right
	$this->Cell(40);
    $this->Cell(90,10,'contato@brasilcastanha.com.br',0,0,'L');	
	$this->Ln(5);

	//Move to the right
	$this->Cell(40);
    $this->Cell(90,10,'Telefones: (85) 3260.473 ',0,0,'L');
	//Line break
	$this->Ln(5);
	//assunto
	$this->SetSubject("Relatorio de reservas");


	$titulo="Relatorio de reservas";

	//escreve no pdf largura,altura,conteudo,borda,quebra de linha,alinhamento
	$this->Cell(0,5,$titulo,0,0,'L');
	$this->Cell(0,5,'www.brasilcastanha.com.br',0,1,'R');
	$this->Cell(0,0,'',1,1,'L');
	$this->Ln(4);


	$this->Cell(40, 5, 'NOME');
	
	$this->SetX(90);
	$this->Cell(40, 5, 'FONE1');
	
	$this->SetX(130);
	$this->Cell(40, 5, 'E-MAIL');
	$this->Ln();
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

// bd.php deve conter as funções para se conectar no banco de dados
include("../../Connections/conn.php");
// busca os dados no banco de dados
mysql_select_db($database_conn, $conn);
$busca = mysql_query("SELECT * FROM reservas");
$pdf = new PDF('P','mm','A4');
$pdf->Open();
$pdf->AddPage();
$pdf->SetFont('helvetica', 'B',8);

while ($resultado = mysql_fetch_array($busca)) {
$pdf->ln();

$pdf->Cell(40, 5, $resultado['nome']);

$pdf->SetX(90);
$pdf->Cell(40, 5, $resultado['fone1']);

$pdf->SetX(130);
$pdf->Cell(40, 5, $resultado['email']);

}
$pdf->Output();
?>