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
	//$this->Image('../../imagens/ETICUS.jpg',5,4,16);
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
    $this->Cell(90,10,'Telefones: (55) 3242.1006 ',0,0,'L');
	//Line break
	$this->Ln(5);
	//assunto
	$this->SetSubject("Relatorio de Contas a Receber");


	$titulo="Relatorio de Contas a Receber";

	//escreve no pdf largura,altura,conteudo,borda,quebra de linha,alinhamento
	$this->Cell(0,5,$titulo,0,0,'L');
	$this->Cell(0,5,'www.pousadabuenavida.com.br',0,1,'R');
	$this->Cell(0,0,'',1,1,'L');
	$this->Ln(4);


	$this->Cell(40, 5, 'DATA VENCIMENTO');
	
	$this->Cell(80, 5, 'CLIENTE');
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
if ((isset($_POST['id_cliente']) && $_POST['id_cliente'] !='')   ){
	
	
	$datainicial = datausa($_POST['data_inicial']);
	$datafinal = datausa($_POST['data_final']);	
	
	
	$id_cliente = $_POST['id_cliente'];
	$busca = mysql_query("SELECT c.Nome as cliente,  crr.datavencimento as datavencimento , crr.valorparcela as valorparcela  from  

contasareceber_recebimento crr

left join contasareceber cr 
on crr.id_contasareceber = cr.id

left join clientes c
on cr.id_cliente = c.Id 

WHERE cr.id_cliente= '$id_cliente' && crr.datavencimento >= '$datainicial' && crr.datavencimento <= '$datafinal'

"   );

}
else  if (isset($_POST['data_inicial']) && $_POST['data_inicial'] !='' ){
	
	$datainicial = datausa($_POST['data_inicial']);
	$datafinal = datausa($_POST['data_final']);

	$busca = mysql_query("SELECT c.Nome as cliente,  crr.datavencimento as datavencimento , crr.valorparcela as valorparcela  from  

contasareceber_recebimento crr

left join contasareceber cr 
on crr.id_contasareceber = cr.id

left join clientes c
on cr.id_cliente = c.id

WHERE  crr.datavencimento >= '$datainicial' && crr.datavencimento <= '$datafinal'


"); 
	}
	
	else {
		
		


	$busca = mysql_query("SELECT c.Nome as cliente,  crr.datavencimento as datavencimento , crr.valorparcela as valorparcela  from  

contasareceber_recebimento crr

left join contasareceber cr 
on crr.id_contasareceber = cr.id

left join clientes c
on cr.id_cliente = c.id");
	
		
		
		
		
		}
	
//$busca = mysql_query("SELECT * FROM contasareceber WHERE id_cliente='$id_vendedor'");
$pdf = new PDF('L','mm','A4');
$pdf->Open();
$pdf->AddPage();
$pdf->SetFont('helvetica', 'B',8);
ob_start();

while ($resultado = mysql_fetch_array($busca)) {
$pdf->ln();

$pdf->Cell(40, 5, databrasil($resultado['datavencimento']));
//$pdf->SetX(90);

$pdf->Cell(80, 5, $resultado['cliente']);

$pdf->Cell(40, 5, $resultado['valorparcela']);

$pdf->Cell(40, 5, $resultado['']);
}
$pdf->SetX(210);
ob_start ();
$pdf->Output();
?>