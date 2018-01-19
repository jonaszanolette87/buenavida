<?php
ob_start();
define('FPDF_FONTPATH', 'font/');
require('../../fpdf16/fpdf.php');

$tipo = $_GET['t'];
switch ($tipo){
	
	case 'apagar': 
					$status =  'E';
					break; 
	case 'pagas':
					$status = 'P';
					break;
	case 'canceladas':  
					$status = 'C';
					break;
	
}


		$sql = '';
if(isset($_POST['data_inicial']) && $_POST['data_inicial'] !="" ){
		$data_inicial = substr($_POST['data_inicial'],6,4)."/".substr($_POST['data_inicial'],3,2)."/".substr($_POST['data_inicial'],0,2);

		$sql .= " c.datarecebimento >= '$data_inicial'";
		};
		
if(isset($_POST['data_final']) && $_POST['data_final'] !=""){
		$data_final= substr($_POST['data_final'],6,4)."/".substr($_POST['data_final'],3,2)."/".substr($_POST['data_final'],0,2);;

		$sql .=" AND c.datarecebimento <= '$data_final'";
		};


//echo $sql;
class PDF extends FPDF
{
	

function tirapontovirgula($valor){
	
$valor = str_replace("." , "" , $valor ); // Primeiro tira os pontos
$valor = str_replace("," , "" , $valor); // Depois tira a vírgula

return "$valor";	
}	
	
function busca($sql){
	
return $sql;
	
}

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

function virgula($valor) { 
$conta = strlen ($valor);
    switch ($conta) {
        case "1":
            $retorna = "0,0$valor";
            break;
        case "2":
            $retorna = "0,$valor";
            break;
        case "3":
            $d1 = substr("$valor",0,1);
            $d2 = substr("$valor",-2,2);
            $retorna = "$d1,$d2";
            break;
        case "4":
            $d1 = substr("$valor",0,2);
            $d2 = substr("$valor",-2,2);
            $retorna = "$d1,$d2";
            break;
        case "5":
            $d1 = substr("$valor",0,3);
            $d2 = substr("$valor",-2,2);
            $retorna = "$d1,$d2";
            break;
        case "6":
            $d1 = substr("$valor",1,3);
            $d2 = substr("$valor",-2,2);
            $d3 = substr("$valor",0,1);
            $retorna = "$d3.$d1,$d2";
            break;
        case "7":
            $d1 = substr("$valor",2,3);
            $d2 = substr("$valor",-2,2);
            $d3 = substr("$valor",0,2);
            $retorna = "$d3.$d1,$d2";
            break;
        case "8":
            $d1 = substr("$valor",3,3);
            $d2 = substr("$valor",-2,2);
            $d3 = substr("$valor",0,3);
            $retorna = "$d3.$d1,$d2";
            break;
    } 
return $retorna; 
} 


function Header()
{
	
	//Logo
	$this->Image('../../imagens/logo-brasilcastanha.jpg',10,5,30);
	//Arial bold 15
	$this->SetFont('Arial','B',16);
	//Move to the right
	$this->Cell(50);
	//Title
	
	$this->Cell(100,5,'brasilcastanha',0,0,'L');
	$this->Ln(3);
	$this->SetFont('Arial','B',7);
	//Move to the right
	$this->Cell(50);
	$this->Cell(100,10,'Av. Bezerra de Menezes, 102 - Sao Gerardo Fortaleza-CE',0,0,'L');
	$this->Ln(3);
	
	//Move to the right
	$this->Cell(50);
    $this->Cell(100,10,'Telefones: (85) 3287.7724 (85) 3243.6614',0,0,'L');
	//Line break
	$this->Ln(3);
	
	
	//Move to the right
	$this->Cell(50);
	$this->Cell(100,10,'Email: contato@brasilcastanha.com.br ',0,0,'L');
    
	$this->Ln(10);
	
	$this->SetX(210);
	$this->Cell(98,10,'PERIODO:');

	$this->Ln(10);

	
	//assunto
	$this->SetSubject("RELATORIO DE CARTOES");

	$titulo="RELATORIO DE CARTOES";

	//escreve no pdf largura,altura,conteudo,borda,quebra de linha,alinhamento
	$this->Cell(0,5,$titulo,0,0,'L');
	$this->Cell(0,5,'www.brasilcastanha.com.br',0,1,'R');
	$this->Cell(0,0,'',1,1,'L');

	$this->Ln(2);
    //Cel(largura, altura,txt ,fronteira, ln, alinhar, preencher , link  )
	$this->Cell(0, 5, 'DATA RECEBIMENTO');
	$this->SetX(60);
	$this->Cell(30, 5, 'VALOR');
	
}
//Page footer
function Footer()
{
	//Position at 1.5 cm from bottom
	$this->SetY(-15);
	//Arial italic 8
	$this->SetFont('Arial','I',8);
	//Page number
	$this->Cell(0,10,'Pagina '. $this->PageNo().'/{nb}',0,0,'C');
	
}

}
  if (
  (isset($_POST['data_inicial']) || $_POST['data_inicial'] !="") &&
  (isset($_POST['data_final']) || $_POST['data_final'] !="")){

  include("../../Connections/conn.php"); 
mysql_select_db($database_conn, $conn);
//$busca = mysql_query("SELECT c.*, date_format(datarecebimento, '%d/%m/%Y') AS datarecebimento FROM cartoes_parcelas c

//					  WHERE ".$sql." ORDER BY c.datarecebimento ASC");// 
					  
					  
	$busca = mysql_query("SELECT c.*, date_format(datarecebimento, '%d/%m/%Y') AS datarecebimento, sum(valor) as valor from cartoes_parcelas  c
		 
				  WHERE ".$sql." 	 GROUP BY c.datarecebimento 
	 ORDER BY c.datarecebimento ASC");// 
			
}else {
	
include("../../Connections/conn.php");
mysql_select_db($database_conn, $conn);
//$busca = mysql_query("SELECT c.*, date_format(datarecebimento, '%d/%m/%Y') AS datarecebimento FROM cartoes_parcelas c
//
	$busca = mysql_query("SELECT c.*, date_format(datarecebimento, '%d/%m/%Y') AS datarecebimento, sum(valor) as valor FROM cartoes_parcelas  c
		 
		 GROUP BY c.datarecebimento 
				  	
					  
	     ORDER BY c.datarecebimento ASC	 ");
}


$pdf = new PDF('L','mm','A4');
$pdf->Open();
$pdf->AddPage();
$pdf->SetFont('helvetica', 'B',7);

while ($resultado = mysql_fetch_array($busca)) {

$pdf->ln();

$pdf->Cell(0, 5, $resultado['datarecebimento']);
$pdf->SetX(60);
$pdf->Cell(30, 5, $resultado['valor']);

$totalvalor += $resultado['valor'];

}
	$pdf->SetY(35);
	$pdf->SetX(210);
	$pdf->Cell(20, 5, $pdf->databrasil($data_inicial).' a '. $pdf->databrasil($data_final) );
	
	$pdf->ln();
	
	$pdf->SetX(210);	
	$pdf->Cell(10, 5, 'TOTAL GERAL:');
	$pdf->SetX(240);
	//$pdf->Cell(10, 5, $pdf->virgula($totalvalor),0,0,'R');
	$pdf->Cell(10, 5,$totalvalor,0,0,'R');

	//$pdf->Cell(10, 5,$pdf->virgula($totalvalor),0,0,'R');

$pdf->Output();
?>