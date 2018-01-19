<?php
define('FPDF_FONTPATH', 'font/');
require('../fpdf16/fpdf.php');
include('../configuracoes/config.php');
include('../funcoes/funcoes.php');

class PDF extends FPDF
{
//Page header


//Page footer

}

// bd.php deve conter as funções para se conectar no banco de dados
include("../Connections/conn.php");
// busca os dados no banco de dados
mysql_select_db($database_conn, $conn);

$id_venda = $_GET['id'];

$busca = mysql_query("SELECT v.*, c.nome as cliente, c.endereco as endereco, c.telefone1 as telefone,  fp.nome as formadepagamento, vf.valortotal as valortotal FROM vendas v

LEFT JOIN vendas_fechamento vf
ON vf.id_venda = v.id

LEFT JOIN formasdepagamento fp
ON vf.id_formadepagamento = fp.id



LEFT JOIN clientes c
ON v.id_cliente = c.id

 WHERE v.id='$id_venda'");

$busca_itens = mysql_query("SELECT vi.*, vi.descontopercentual as descontopercentual, p.nome as produto FROM vendas_itens vi  

LEFT JOIN produtos p
ON vi.id_produto = p.id

WHERE vi.id_venda='$id_venda'");


$busca_fechamento = mysql_query("SELECT vi.*,fp.nome as formadepagamento,  FROM vendas_fechamento vf

LEFT JOIN formasdepagamento fp
ON vf.id_formadepagamento = fp.id

WHERE vf.id_venda='$id_venda'");




$pdf = new PDF('P','mm',array(80,150));
$pdf->SetAutoPageBreak('true','5'); 
$pdf->Open();
$pdf->AddPage();
$pdf->SetFont('times', '',8);

//Logo
	$pdf->Image('../imagens/logo.jpg',5,4,16);
	
	//Title
	$pdf->Cell(10,10,'BRASIL CASTANHA',0,0,'L');
	$pdf->Ln(3);
	
    $pdf->Cell(10,10,'Telefones: (85) 9672-8494 / 3269-9266',0,0,'L');
	$pdf->Ln(3);
	$pdf->Cell(10,10,'E-mail: brasilcastanha@hotmail.com ',0,0,'L');
	$pdf->Ln(3);
	$pdf->Cell(10,10,'Endereco: Av. Beira Mar S/N box 52A Fortaleza ',0,0,'L');
	
	//Line break
	$pdf->Ln(5);
	

$titulo="CUPOM NAO FISCAL";
//Line break
	$pdf->Ln(5);
	//escreve no pdf largura,altura,conteudo,borda,quebra de linha,alinhamento
	$pdf->Cell(0,5,$titulo,0,0,'L');
	
	$pdf->Cell(0,0,'',1,1,'L');
	
	$pdf->Ln(5);
	$pdf->Cell(40, 5, '---------------------------------------------------------------------');
	$pdf->Ln(3);

	$pdf->Cell(40, 5, 'cod.');

	$pdf->SetX(15);
	$pdf->Cell(40, 5, 'prod.');
	
	$pdf->SetX(45);
	$pdf->Cell(40, 5, 'qtd');
	
	$pdf->SetX(50);
	$pdf->Cell(40, 5, 'valor(R$)');
	
	$pdf->SetX(62);
	$pdf->Cell(40, 5, 'total(R$)');
	
	$pdf->Ln(3);
	$pdf->Cell(40, 5, '---------------------------------------------------------------------');
	

while ($resultado = mysql_fetch_array($busca_itens)) {
$pdf->ln();

$pdf->Cell(40, 3, $resultado['id_produto']);

$pdf->SetX(15);
$pdf->Cell(40, 3, $resultado['produto']);
$pdf->ln();

$pdf->SetX(45);
$pdf->Cell(40, 3, $resultado['qtd']."x");

$pdf->SetX(50);
$pdf->Cell(40, 3, $resultado['precovenda']);

$pdf->SetX(62);
$pdf->Cell(40, 3, "= R$ ".$subtotal = $resultado['valortotal']);

}
	$pdf->Ln(3);
	$pdf->Cell(40, 5, '---------------------------------------------------------------------');

while ($resultado2 = mysql_fetch_array($busca)) {

$pdf->ln();
$pdf->SetX(55);
$pdf->Cell(40, 3, "Total : R$  ".$resultado2['valortotal']);

$pdf->ln();
$pdf->SetX(55);
$pdf->Cell(40, 3, "Desc. :   ".$resultado2['descontopercentual']);

$pdf->ln();
$pdf->SetX(55);
$pdf->Cell(40, 3, "A pagar :   ".$resultado2['valortotal'] - ($resultado2['descontopercentual']*$resultado2['descontopercentual'])/100);
$pdf->ln();


$pdf->ln();
$pdf->Cell(40, 3, "Forma pgto: ".$resultado2['formadepagamento']);
$pdf->ln();
$pdf->Cell(40, 3, "Cliente: ".$resultado2['cliente']);
$pdf->ln();
$pdf->Cell(40, 3, "Endereco: ".$resultado2['endereco']);
$pdf->ln();
$pdf->Cell(40, 3, "Telefone: ".$resultado2['telefone']);
$pdf->Cell(40, 3, "Telefone: ".$resultado2['telefone2']);

$pdf->ln();

$pdf->Cell(40, 3, "Data venda :   ".databrasil($resultado2['datacadastro']));
$pdf->ln();



$pdf->ln();

}
 
$pdf->SetAutoPageBreak(true,20);
$pdf->Output();
?>