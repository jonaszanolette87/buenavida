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
	//$this->Image('../../imagens/logo.jpg',15,12,30);
	//Arial bold 15
	$this->SetFont('Arial','i',10);
	//Move to the right
	$this->Cell(40);
	//Title
	$this->Cell(90,10,'POUSADA BUENA VIDA',0,0,'L');
	$this->Ln(5);
	
	//Move to the right
	$this->Cell(40);
	$this->Cell(90,10,'Email:pousadabuenavida@hotmail.com',0,0,'L');
	$this->Ln(5);
	
	//Move to the right
	$this->Cell(40);
    $this->Cell(90,10,'Telefones: (55) 3242 - 1006  ',0,0,'L');
	//Line break
	$this->Ln(5);
	//assunto
	$this->SetSubject("Relatorio de Movimento Diario");
	$this->Ln(5);

	$titulo="Relatorio de Movimento Diario";

	//escreve no pdf largura,altura,conteudo,borda,quebra de linha,alinhamento
	$this->Cell(0,5,$titulo,0,0,'L');
	$this->Cell(0,5,'www.pousadabuenavida.com.br',0,1,'R');
	$this->Cell(0,0,'',1,1,'L');
	
	$this->Ln(4);
	
	$this->Cell(40, 5, 'DATA');
	
	$this->SetX(30);
	$this->Cell(40, 5, 'NOME CONTA');
	
	$this->SetX(120);
	$this->Cell(40, 5, 'HISTORICO');
	
	$this->SetX(180);
	$this->Cell(40, 5, 'VALOR');
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

if (isset($_POST['id_planodecontas']) && $_POST['id_planodecontas'] !='' && $_POST['data_inicial'] !='' && $_POST['data_final'] !=''){
	
	
	$id_conta = $_POST['id_planodecontas'];
	$data_inicial = datausa($_POST['data_inicial']);
	$data_final = datausa($_POST['data_final']);
   

	$busca = mysql_query("SELECT md.*, pc.tipo as tipo, pc.descricao as nomeconta 
							
							FROM movimentodiario md
    
	
	LEFT JOIN planodecontas pc
	ON md.id_contadespesareceita = pc.id
		
	
	WHERE id_contadespesareceita='$id_conta' AND md.datacadastro >= '$data_inicial' AND md.datacadastro <= '$data_final' 
	
	ORDER BY md.datacadastro ASC  ");

}
else if (isset($_POST['tipo']) && $_POST['tipo'] != '0' )
{
	
	
	$data_inicial = datausa($_POST['data_inicial']);
	$data_final = datausa($_POST['data_final']);
	$tipo = $_POST['tipo'];
	
	
	$busca = mysql_query("SELECT md.*, pc.descricao as nomeconta, pc.tipo as tipo 
						
								FROM movimentodiario md
    
	
	LEFT JOIN planodecontas pc
	ON md.id_contadespesareceita = pc.id
	
	WHERE md.datacadastro >= '$data_inicial' AND md.datacadastro <= '$data_final'  AND pc.tipo = '$tipo'
	
	ORDER BY md.datacadastro ASC  
	 "
	); 
	}
	
	else if (isset($_POST['forma']) && $_POST['forma'] != '0' ){
		
		$data_inicial = datausa($_POST['data_inicial']);
	$data_final = datausa($_POST['data_final']);
	//$tipo = $_POST['tipo'];  AND pc.tipo = '$tipo'
	
	
	$busca = mysql_query("SELECT md.*, SUM(md.valor) as  valor, pc.descricao as nomeconta, pc.tipo as tipo 
						
								FROM movimentodiario md
    
	
	LEFT JOIN planodecontas pc
	ON md.id_contadespesareceita = pc.id
	
	WHERE md.datacadastro >= '$data_inicial' AND md.datacadastro <= '$data_final'  
	
	GROUP BY nomeconta
	
	ORDER BY md.datacadastro ASC  
	 "
	); 
		
		}
	
	else
	{
		$data_inicial = datausa($_POST['data_inicial']);
	$data_final = datausa($_POST['data_final']);
	
	
	
	$busca = mysql_query("SELECT md.*, pc.descricao as nomeconta, pc.tipo as tipo 
						
								FROM movimentodiario md
    
	
	LEFT JOIN planodecontas pc
	ON md.id_contadespesareceita = pc.id
	
	WHERE md.datacadastro >= '$data_inicial' AND md.datacadastro <= '$data_final' 
	
	ORDER BY md.datacadastro ASC  
	 "
	); 
		
		
		
		}



$pdf = new PDF('P','mm','A4');
$pdf->Open();
$pdf->AddPage();
$pdf->SetFont('helvetica', 'B',8);

while ($resultado = mysql_fetch_array($busca)) {
$pdf->ln();

if ($resultado['tipo']=='2') {$sinal = "-";} else $sinal = "+";

$pdf->Cell(40, 5, databrasil($resultado['datacadastro']));

$pdf->SetX(30);
$pdf->Cell(40, 5, $resultado['tipo']." - ".$resultado['nomeconta']);

$pdf->SetX(120);
$pdf->Cell(40, 5, $resultado['historico']);

$pdf->SetX(180);
$pdf->Cell(40, 5, "R$ ".$resultado['valor'].$sinal);

$valor = $resultado['valor'];

if ($resultado['tipo']=='2') { $totalsaidas = $totalsaidas + $valor; } 
if ($resultado['tipo']=='3') { $totalentradas = $totalentradas + $valor;} 


$total = $total + ($sinal.$valor);

}
$pdf->ln();
$pdf->Cell(0,0,'',1,1,'L');


$pdf->SetX(120);
$pdf->Cell(60, 5, "Total de Entradas(E)");
$pdf->SetX(180);
$pdf->Cell(60, 5, "R$ ".$totalentradas);

$pdf->ln();
$pdf->SetX(120);
$pdf->Cell(60, 5, "Total de Saidas(S)");
$pdf->SetX(180);
$pdf->Cell(60, 5, "R$ ".$totalsaidas);

$pdf->ln();
$pdf->Cell(0,0,'',1,1,'L');

$pdf->ln();
$pdf->SetX(120);
$pdf->Cell(60, 5, "Saldo(E-S)");
$pdf->SetX(180);
$pdf->Cell(60, 5, "R$ ".($totalentradas - $totalsaidas));
$pdf->ln();


ob_start ();
$pdf->Output();
?>