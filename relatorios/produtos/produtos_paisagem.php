<?php
define('FPDF_FONTPATH', 'font/');
require('../../fpdf16/fpdf.php');

class PDF extends FPDF
{
//Page header
function Header()
{
	//Logo
	//$this->Image('../../imagens/logo.jpg',10,8,33);
	//Arial bold 15
	$this->SetFont('Arial','i',10);
	//Move to the right
	$this->Cell(40);
	//Title
	$this->Cell(90,10,'POUSADA BUENA VIDA',0,0,'L');
	$this->Ln(5);
	
	//Move to the right
	$this->Cell(40);
	$this->Cell(90,10,'Email:  pousadabuenavida@hotmail.com',0,0,'L');
	$this->Ln(5);

	//Move to the right
	$this->Cell(40);
    $this->Cell(90,10,'reservas@pousadabuenavida.com.br',0,0,'L');	
	$this->Ln(5);

	//Move to the right
	$this->Cell(40);
    $this->Cell(90,10,'Telefones: (55) 3242 - 1006  ',0,0,'L');
	//Line break
	$this->Ln(5);
	//assunto
	$this->SetSubject("Relatorio de Produtos");


	$titulo="Relatório de Produtos";

	//escreve no pdf largura,altura,conteudo,borda,quebra de linha,alinhamento
	$this->Cell(0,5,$titulo,0,0,'L');
	$this->Cell(0,5,'www.pousadabuenavida.com.br',0,1,'R');
	$this->Cell(0,0,'',1,1,'L');
	$this->Ln(4);


	$this->Cell(40, 5, 'NOME');
	$this->SetX(90);
	//$this->Cell(60, 5, 'RUA');
	//$this->SetX(160);
	//$this->Cell(40, 5, 'NUMERO');
	//$this->SetX(190);
	$this->Cell(40, 5, 'PESO');
	
	$this->Cell(40, 5, 'PRECO DE VENDA');
	$this->SetX(210);
	$this->Ln(5);
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
if (isset($_POST['id_grupo']) && $_POST['id_grupo'] !='' ){
	$id_grupo = $_POST['id_grupo'];
	$busca = mysql_query("SELECT * FROM produtos WHERE id_grupo='$id_grupo'");

}
else 
{
	$busca = mysql_query("SELECT * FROM produtos"); 
	}
//$busca = mysql_query("SELECT * FROM Produtos WHERE id_grupo='$id_grupo'");
$pdf = new PDF('L','mm','A4');
$pdf->Open();
$pdf->AddPage();
$pdf->SetFont('helvetica', 'B',8);
ob_start();

while ($resultado = mysql_fetch_array($busca)) {
$pdf->ln();

$pdf->Cell(40, 5, $resultado['nome']);
$pdf->SetX(90);
//$pdf->Cell(60, 5, $resultado['logradouroresidencia']);
//$pdf->SetX(160);
//$pdf->Cell(40, 5, $resultado['numeroresidencia']);
//$pdf->SetX(190);
$pdf->Cell(40, 5, $resultado['peso']." g");

$pdf->Cell(40, 5, "R$ ".$resultado['precodevenda']);
}
$pdf->SetX(210);
ob_start ();
$pdf->Output();
?>