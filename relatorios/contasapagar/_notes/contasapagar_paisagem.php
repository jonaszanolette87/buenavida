<?php
define('FPDF_FONTPATH', 'font/');
require('../../fpdf16/fpdf.php');
include("../../funcoes/funcoes.php");

class PDF extends FPDF
{
function databrasil($data){
	
	//2011/12/12
	//0123456789
	
	$novadata = substr($data,8,2)."/".substr($data,5,2)."/".substr($data,0,4);
	return $novadata;
}


function datausa($data){
	
	//12/12/2011
	//0123456789
	
	$novadata = substr($data,6,4)."/".substr($data,3,2)."/".substr($data,0,2);
	return $novadata;
}

//Page header
function Header()
{
	//Logo
	//$this->Image('../../imagens/ETICUS.jpg',15,16,30);
	//Arial bold 15
	$this->SetFont('Arial','i',10);
	//Move to the right
	$this->Cell(40);
	//Title
	$this->Cell(90,10,'LEDNORDESTE',0,0,'L');
	$this->Ln(5);
	
	//Move to the right
	$this->Cell(40);
	$this->Cell(90,10,'Email:  contato@lednordeste.com.br',0,0,'L');
	$this->Ln(5);


	//Move to the right
	$this->Cell(40);
    $this->Cell(90,10,'Telefones: (85) 3231.0453 ',0,0,'L');
	//Line break
	$this->Ln(15);
	//assunto
	$this->SetSubject("Relatorio de Contas a Pagar");


	$titulo="Relatorio de Contas a Pagar";

	//escreve no pdf largura,altura,conteudo,borda,quebra de linha,alinhamento
	$this->Cell(0,5,$titulo,0,0,'L');
	$this->Cell(0,5,'www.lednordeste.com.br',0,1,'R');
	$this->Cell(0,0,'',1,1,'L');
	$this->Ln(4);


	//$this->Cell(40, 5, 'DATA CADASTRO');
	//$this->SetX(90);
	//$this->Cell(60, 5, 'RUA');
	//$this->SetX(160);
	//$this->Cell(40, 5, 'NUMERO');
	//$this->SetX(190);
	$this->Cell(40, 5, 'DATA VENCIMENTO');
	
	$this->Cell(40, 5, 'FORNECEDOR');
	
	$this->Cell(40, 5, 'VALOR');
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
if (isset($_POST['id_fornecedor']) && $_POST['id_fornecedor'] !='' ){
	$id_fornecedor = $_POST['id_fornecedor'];
	
	$datainicial = datausa($_POST['data_inicial']);
	$datafinal = datausa($_POST['data_final']);
	
	$busca = mysql_query(" SELECT f.Nome as fornecedor,  crr.datavencimento as datavencimento , crr.valorparcela as valorparcela  from  

contasapagar_pagamento crr

left join contasapagar cr 
on crr.id_contasapagar = cr.id


	
	LEFT JOIN fornecedores f
	ON cr.id_fornecedor = f.id
	
	WHERE id_fornecedor= '$id_fornecedor' && datavencimento >= '$datainicial' && datavencimento <= '$datafinal' ");

}

else if (isset($_POST['data_inicial']) && $_POST['data_inicial'] !='' ){
	
	$datainicial = datausa($_POST['data_inicial']);
	$datafinal = datausa($_POST['data_final']);
	
	$busca = mysql_query("SELECT f.Nome as fornecedor,  crr.datavencimento as datavencimento , crr.valorparcela as valorparcela  from  

contasapagar_pagamento crr

left join contasapagar cr 
on crr.id_contasapagar = cr.id


	
	LEFT JOIN fornecedores f
	ON cr.id_fornecedor = f.id
	
	WHERE  datavencimento >= '$datainicial' && datavencimento <= '$datafinal' ");}
else 
{
	$busca = mysql_query("SELECT f.Nome as fornecedor,  crr.datavencimento as datavencimento , crr.valorparcela as valorparcela  from  

contasapagar_pagamento crr

left join contasapagar cr 
on crr.id_contasapagar = cr.id


	
	LEFT JOIN fornecedores f
	ON cr.id_fornecedor = f.ID"); 
	}
//$busca = mysql_query("SELECT * FROM contasapagar WHERE id_fornecedor='$id_fornecedor'");
$pdf = new PDF('L','mm','A4');
$pdf->Open();
$pdf->AddPage();
$pdf->SetFont('helvetica', 'B',8);
ob_start();

while ($resultado = mysql_fetch_array($busca)) {
$pdf->ln();

//$pdf->Cell(40, 5, $pdf->databrasil($resultado['datacadastro']));
//$pdf->SetX(90);
//$pdf->Cell(60, 5, $resultado['logradouroresidencia']);
//$pdf->SetX(160);
//$pdf->Cell(40, 5, $resultado['numeroresidencia']);
//$pdf->SetX(190);
$pdf->Cell(40, 5, $pdf->databrasil($resultado['datavencimento']));

$pdf->Cell(40, 5, $resultado['fornecedor']);


$pdf->Cell(40, 5, $resultado['valorparcela']);
}
$pdf->SetX(210);
$pdf->Output();
?>