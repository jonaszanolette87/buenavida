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
/*
if (isset($_POST['data_inicial']) && isset($_POST['data_final']) ){ 

$data_inicial = substr($_POST['data_inicial'],6,4)."/".substr($_POST['data_inicial'],3,2)."/".substr($_POST['data_inicial'],0,2);
$data_final= substr($_POST['data_final'],6,4)."/".substr($_POST['data_final'],3,2)."/".substr($_POST['data_final'],0,2);;
}
*/

		$sql = '';
if(isset($_POST['data_inicial']) && $_POST['data_inicial'] !="" ){
		$data_inicial = substr($_POST['data_inicial'],6,4)."/".substr($_POST['data_inicial'],3,2)."/".substr($_POST['data_inicial'],0,2);

		$sql .= " c.datavencimento >= '$data_inicial'";
		};
		
if(isset($_POST['data_final']) && $_POST['data_final'] !=""){
		$data_final= substr($_POST['data_final'],6,4)."/".substr($_POST['data_final'],3,2)."/".substr($_POST['data_final'],0,2);;

		$sql .=" AND c.datavencimento <= '$data_final'";
		};

if(isset($_POST['id_banco']) && $_POST['id_banco'] !=""){
		$banco=$_POST['id_banco']; 
		$sql .=" AND c.id_banco = $banco";
		};

if(isset($_POST['id_favorecido']) && $_POST['id_favorecido'] !=""){
		$favorecido=$_POST['id_favorecido']; 
		$sql .=" AND c.id_favorecido= $favorecido";
		};

if(isset($_POST['id_custodia']) && $_POST['id_custodia'] !=""){
		$custodia=$_POST['id_custodia']; 
		$sql .=" AND c.id_custodia= '$custodia'";
		};
		
if(isset($_POST['id_sacado']) && $_POST['id_sacado'] !=""){
		$sacado=$_POST['id_sacado']; 
		$sql .=" AND c.id_sacado= '$sacado'";
		};

if(isset($_POST['cpfcnpj']) && $_POST['cpfcnpj'] !=""){
		$cpfcnpj=$_POST['cpfcnpj']; 
		$sql .=" AND c.cpfcnpj= '$cpfcnpj'";
		};
//echo $sql;
class PDF extends FPDF
{
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
	
	$this->Cell(100,5,'Slink Surf',0,0,'L');
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
	$this->Cell(100,10,'Email: contato@brasilcastanha.com.br',0,0,'L');
    
	$this->Ln(10);
	$this->Cell(48,10,'FAVORECIDO:');
	$this->SetX(70);
	$this->Cell(58,10,'BANCO:');
	$this->SetX(210);
	$this->Cell(98,10,'PERIODO:');

	$this->Ln(10);

	
	//assunto
	$this->SetSubject("RELATORIO DE CHEQUES");

	$titulo="RELATORIO DE CHEQUES";

	//escreve no pdf largura,altura,conteudo,borda,quebra de linha,alinhamento
	$this->Cell(0,5,$titulo,0,0,'L');
	$this->Cell(0,5,'www.brasilcastanha.com.br',0,1,'R');
	$this->Cell(0,0,'',1,1,'L');
	$this->Ln(2);

    //Cel(largura, altura,txt ,fronteira, ln, alinhar, preencher , link  )
	$this->Cell(0, 5, 'DATA VENC.');
	$this->SetX(30);
	$this->Cell(30, 5, 'BANCO');
	$this->SetX(60);
	$this->Cell(40, 5, 'NOME');
	$this->SetX(120);
	$this->Cell(30, 5, 'CPF/CNPJ');
	$this->SetX(145);
	$this->Cell(30, 5, 'CUSTODIA.');
	$this->SetX(160);
	$this->Cell(20, 5, 'VALOR CHEQUE');
	$this->SetX(185);
	$this->Cell(20, 5, 'FAVORECIDO');
	$this->SetX(220);
	$this->Cell(20, 5, 'SACADO');
	$this->Ln(2);
}
//Page footer
function Footer()
{
	//Position at 1.5 cm from bottom
	$this->SetY(-15);
	//Arial italic 8
	$this->SetFont('Arial','I',8);
	//Page number
	$this->Cell(0,10,'Pagina '. $this->PageNo() .'/{nb}',0,0,'C');
	
}

}
	
//buscar contratos por corretor ou todos 
if((isset($_POST['id_favorecido']) || $_POST['id_favorecido'] !="") && 
   (isset($_POST['data_inicial']) || $_POST['data_inicial'] !="") &&
   (isset($_POST['data_final']) || $_POST['data_final'] !="")){


$favorecido = $_POST['id_favorecido'];

// 12/12/2011
//   0123456789
  include("../../Connections/conn.php"); 
mysql_select_db($database_conn, $conn);
$busca = mysql_query("SELECT c.*, date_format(datavencimento, '%d/%m/%Y') AS datavencimento, b.nome as banco, f.nome as favorecido, cu.nome as custodia, sa.nome as sacado FROM cheques c

					  LEFT JOIN favorecidos f
					  ON c.id_favorecido = f.id 		
					  
					  LEFT JOIN bancos b
					  ON c.id_banco= b.id
					  
					  LEFT JOIN custodias cu
					  ON c.id_custodia= cu.id
					  
					  LEFT JOIN sacados sa
					  ON c.id_sacado= sa.id 				


WHERE ".$sql." ORDER BY c.datavencimento ASC");// 

//$busca_totais = mysql_query("SELECT  sum(valordocumento) as valordocumento, sum(totalgeral) as totalgeral  FROM cheques c WHERE status = 'E' AND c.datacadastro >= '".$data_inicial."' AND c.datacadastro <= '".$data_final."' AND c.id_favorecido = ".$favorecido."");

//$busca_favorecido = mysql_query("SELECT  * FROM cheques
 								
	//							WHERE id_favorecido = ".$favorecido." ");
}else {
	
include("../../Connections/conn.php");
mysql_select_db($database_conn, $conn);
$busca = mysql_query("SELECT c.*, date_format(datavencimento, '%d/%m/%Y') AS datavencimento, b.nome as banco, f.nome as favorecido, cu.nome as custodia, sa.nome as sacado FROM cheques c

					  LEFT JOIN favorecidos f
					  ON c.id_favorecido = f.id 		
					  
					  LEFT JOIN bancos b
					  ON c.id_banco= b.id  		

  					  LEFT JOIN custodias cu
					  ON c.id_custodia= cu.id
					  
					  LEFT JOIN sacados sa
					  ON c.id_sacado= sa.id 				

					  
					  ORDER BY c.datavencimento ASC		


 ");

//$busca_totais = mysql_query("SELECT  sum(valorcontrato) as valorcontrato, sum(totalgeral) as totalgeral  FROM contratos c WHERE comissao = 'P' ");

//$busca_corretor = mysql_query("SELECT  * FROM corretores ");

	
	}




$pdf = new PDF('L','mm','A4');
$pdf->Open();
$pdf->AddPage();
$pdf->SetFont('helvetica', 'B',7);

$pdf->ln();


while ($resultado = mysql_fetch_array($busca)) {

$pdf->ln();

$pdf->Cell(0, 5, $resultado['datavencimento']);
$pdf->SetX(30);
$pdf->Cell(30, 5, $resultado['banco']);
$pdf->SetX(60);
$pdf->Cell(40, 5, $resultado['nome']);
$pdf->SetX(120);
$pdf->Cell(30, 5, $resultado['cpfcnpj']);
$pdf->SetX(145);
$pdf->Cell(20, 5, $resultado['custodia']);
$pdf->SetX(160);
$pdf->Cell(20, 5, $pdf->virgula($resultado['valordocumento']),0,0,'R');
$pdf->SetX(185);
$pdf->Cell(20, 5, $resultado['favorecido']);
$pdf->SetX(220);
$pdf->Cell(20, 5, $resultado['sacado']);
$pdf->SetX(210);


$totalgeral += $resultado['valordocumento'];

	
}

$pdf->ln();
  //  $resultado_totais = mysql_fetch_array($busca_totais);


	$pdf->SetX(250);	
	$pdf->Cell(10, 5, 'TOTAL GERAL:');
	
	$pdf->SetX(270);
	$pdf->Cell(20, 5, $pdf->virgula($totalgeral),0,0,'R');

	$pdf->SetX(10);
	$pdf->SetY(36);
	$pdf->Cell(10, 5, $resultado_corretor['favorecido']);
	
	$pdf->SetY(36);
	$pdf->SetX(70);
	$pdf->Cell(20, 5,$resultado_corretor['cpf'] );

	$pdf->SetY(36);
	
	$pdf->SetX(100);
	$pdf->Cell(20, 5,$resultado_corretor['banco'] );


	$pdf->SetX(210);
	$pdf->Cell(20, 5, $pdf->databrasil($data_inicial).' a '. $pdf->databrasil($data_final) );

$pdf->SetX(210);
$pdf->Output();
?>