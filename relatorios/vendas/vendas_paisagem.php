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
    $this->Cell(90,10,'Telefones: (55) 3242 - 1006',0,0,'L');
	//Line break
	$this->Ln(15);
	//assunto
	$this->SetSubject("Relatorio de Vendas");


	$titulo="Relatorio de Vendas";

	//escreve no pdf largura,altura,conteudo,borda,quebra de linha,alinhamento
	$this->Cell(0,5,$titulo,0,0,'L');
	$this->Cell(0,5,'www.pousadabuenavida.com.br',0,1,'R');
	$this->Cell(0,0,'',1,1,'L');
	$this->Ln(4);

    $this->SetX(10);
	
	$this->Cell(60, 5, 'ID');
	$this->SetX(20);
	
	$this->Cell(60, 5, 'DATA');
	$this->SetX(50);
	
	$this->Cell(40, 5, 'CLIENTE');
	$this->SetX(90);
	//$this->Cell(60, 5, 'RUA');
	//$this->SetX(160);
	//$this->Cell(40, 5, 'NUMERO');
	
	$this->SetX(120);
	$this->Cell(40, 5, 'VALOR');
	
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
if (isset($_POST['id_cliente']) && $_POST['id_cliente'] !='' && isset($_POST['data_inicial']) && $_POST['data_inicial'] !='' && isset($_POST['data_final']) && $_POST['data_final'] !='' ){
	
	$id_cliente = $_POST['id_cliente'];
	
	$data_inicial = datausa($_POST['data_inicial']);
	$data_final = datausa($_POST['data_final']);
	 
	$busca = mysql_query("SELECT v.*, c.nome as cliente, vf.valortotal as valortotal
	
	FROM vendas v
	
	
	LEFT JOIN clientes c
	ON v.id_cliente = c.id
	
	LEFT JOIN vendas_fechamento vf
	ON vf.id_venda = v.id
	
	
	WHERE v.id_cliente='$id_cliente' AND v.datavenda >= '$data_inicial' AND v.datavenda <= '$data_final'
	
	
	");

}

else if ($_POST['data_inicial'] !='' && isset($_POST['data_final']) && $_POST['data_final'] !='' ){
	
	
	
	$data_inicial = datausa($_POST['data_inicial']);
	$data_final = datausa($_POST['data_final']);
	
	$busca = mysql_query("SELECT v.*, c.nome as cliente,  vf.valortotal as valortotal
	
	FROM vendas v
	
	
	LEFT JOIN clientes c
	ON v.id_cliente = c.id
	
	LEFT JOIN vendas_fechamento vf
	ON vf.id_venda = v.id
	
	
	WHERE v.datavenda >= '$data_inicial' AND v.datavenda <= '$data_final'
	
	
	");

}


else 
{
	$busca = mysql_query("SELECT v.*, c.nome as cliente, vf.valortotal as valortotal FROM vendas v
	
	
	LEFT JOIN clientes c
	ON v.id_cliente = c.id
	
	LEFT JOIN vendas_itens vi
	ON vi.id_venda = v.id
	
	LEFT JOIN vendas_fechamento vf
	ON vf.id_venda = v.id
	
	WHERE  v.datavenda >= '$data_inicial' AND v.datavenda <= '$data_final'
	
	
	 
	
	"); 
	}
//$busca = mysql_query("SELECT * FROM clientes WHERE id_cliente='$id_cliente'");
$pdf = new PDF('L','mm','A4');
$pdf->Open();
$pdf->AddPage();
$pdf->SetFont('helvetica', 'B',8);
ob_start();

while ($resultado = mysql_fetch_array($busca)) {
$pdf->ln();
$pdf->SetX(10);
$pdf->Cell(40, 5, $resultado['id']);
$pdf->SetX(20);
$pdf->Cell(40, 5, databrasil($resultado['datavenda']));
$pdf->SetX(50);
$pdf->Cell(40, 5, $resultado['cliente']);

$pdf->SetX(120);
$pdf->Cell(40, 5, "R$ ".$resultado['valortotal']);


$totalvalor = $totalvalor +  $resultado['valortotal'];

}


$pdf->ln();
$pdf->Cell(0,0,'',1,1,'L');

$pdf->SetX(120);
$pdf->Cell(40, 5, "R$ ".$totalvalor);


$pdf->SetX(210);
$pdf->Output();
?>