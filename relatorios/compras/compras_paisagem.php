<?php
define('FPDF_FONTPATH', 'font/');
require('../../fpdf16/fpdf.php');
require('../../funcoes/funcoes.php');

class PDF extends FPDF
{
//Page header
function Header()
{
	//Logo
	//$this->Image('../../imagens/logo.jpg',15,16,30);
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
    $this->Cell(90,10,'Telefones: (55) 3242 - 1006 ',0,0,'L');
	//Line break
	$this->Ln(15);
	//assunto
	$this->SetSubject("Relatorio de Compras");


	$titulo="Relatorio de Compras";

	//escreve no pdf largura,altura,conteudo,borda,quebra de linha,alinhamento
	$this->Cell(0,5,$titulo,0,0,'L');
	$this->Cell(0,5,'www.pousadabuenavida.com.br',0,1,'R');
	$this->Cell(0,0,'',1,1,'L');
	$this->Ln(4);


	$this->Cell(40, 5, 'ID');
	$this->SetX(20);
	$this->Cell(40, 5, 'N DOC');
	$this->SetX(40);
	$this->Cell(40, 5, 'DATA COMPRA');
	$this->SetX(70);
	$this->Cell(40, 5, 'FORNECEDOR');
	$this->SetX(120);
	$this->Cell(40, 5, 'FORMA PGTO');
	$this->SetX(180);
	$this->Cell(40, 5, 'VALOR');
	$this->SetX(210);
	$this->Ln(2);
	$this->ln();
$this->Cell(0,0,'',1,1,'L');
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

if (isset($_POST['id_fornecedor']) && $_POST['id_fornecedor'] !='' && isset($_POST['data_inicial']) && $_POST['data_inicial'] !='' && isset($_POST['data_final']) && $_POST['data_final'] !='' ){
	
	$id_fornecedor = $_POST['id_fornecedor'];
	
	$data_inicial = datausa($_POST['data_inicial']);
	$data_final = datausa($_POST['data_final']);
	
	
	
	$busca = mysql_query("SELECT c.*,f.nome as fornecedor, fp.nome as formadepagamento ,cf.valortotal as valorcompra
	
	FROM compras c 
	
	LEFT JOIN fornecedores f
	ON c.id_fornecedor = f.id
	
	LEFT JOIN compras_fechamento cf
	ON cf.id_compra = c.id
	
	LEFT JOIN formasdepagamento fp
	ON cf.id_formadepagamento= fp.id
	
	WHERE c.id_fornecedor= '$id_fornecedor' AND c.datacompra >= '$data_inicial' AND c.datacompra <= '$data_final'
	ORDER BY c.datacompra
	");

}
else 
{
	
	$data_inicial = datausa($_POST['data_inicial']);
	$data_final = datausa($_POST['data_final']);
	
	$busca = mysql_query("SELECT c.*,f.nome as fornecedor, cf.valortotal as valorcompra, fp.nome as formadepagamento  FROM compras c
	
	
	LEFT JOIN fornecedores f
	ON c.id_fornecedor = f.id
	
	LEFT JOIN compras_fechamento cf
	ON cf.id_compra = c.id
	
	LEFT JOIN formasdepagamento fp
	ON cf.id_formadepagamento= fp.id
	
	
	WHERE  c.datacompra >= '$data_inicial' AND c.datacompra <= '$data_final'
	ORDER BY c.datacompra
	
	
	");

	}
//$busca = mysql_query("SELECT * FROM compras WHERE id_vendedor='$id_vendedor'");
$pdf = new PDF('L','mm','A4');
$pdf->Open();
$pdf->AddPage();
$pdf->SetFont('helvetica', 'B',8);
ob_start();

while ($resultado = mysql_fetch_array($busca)) {
$pdf->ln();

$pdf->Cell(40, 5, $resultado['id']);
$pdf->SetX(20);
$pdf->Cell(60, 5, $resultado['ndoc']);
$pdf->SetX(40);
$pdf->Cell(40, 5, databrasil($resultado['datacompra']));
$pdf->SetX(70);
$pdf->Cell(40, 5, $resultado['fornecedor']);
$pdf->SetX(120);
$pdf->Cell(40, 5, $resultado['formadepagamento']);
$pdf->SetX(180);
$pdf->Cell(40, 5, "R$ ".$resultado['valorcompra']);
$totalvalorcompra = $totalvalorcompra +  $resultado['valorcompra'];

}

$pdf->ln();
$pdf->Cell(0,0,'',1,1,'L');

$pdf->SetX(180);
$pdf->Cell(40, 5, "R$ ".$totalvalorcompra);
$pdf->SetX(210);
$pdf->Output();
?>