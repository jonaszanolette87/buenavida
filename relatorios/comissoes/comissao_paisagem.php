<?php
ob_start();
define('FPDF_FONTPATH', 'font/');
require('../../fpdf16/fpdf.php');
//include('../../funcoes/funcoes.php');

$tipo = $_GET['t'];
switch ($tipo){
	
	case 'apagar': 
					$statusdacomissao =  'A';
					break; 
	case 'pagas':
					$statusdacomissao = 'P';
					break;
	case 'canceladas':  
					$statusdacomissao = 'C';
					break;
	
}

if (isset($_POST['data_inicial']) && isset($_POST['data_final']) ){ 

$data_inicial = substr($_POST['data_inicial'],6,4)."/".substr($_POST['data_inicial'],3,2)."/".substr($_POST['data_inicial'],0,2);
$data_final= substr($_POST['data_final'],6,4)."/".substr($_POST['data_final'],3,2)."/".substr($_POST['data_final'],0,2);;
}



	
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
	$this->Image('../../imagens/logo_buenocredito.jpg',5,5,55);
	//Arial bold 15
	$this->SetFont('Arial','B',16);
	//Move to the right
	$this->Cell(50);
	//Title
	
	$this->Cell(100,5,'Bueno Credito',0,0,'L');
	$this->Ln(3);
	$this->SetFont('Arial','B',7);
	//Move to the right
	$this->Cell(50);
	$this->Cell(100,10,'Rua Antonio Facanha de Abreu, 102 - Timbu Eusebio-CE',0,0,'L');
	$this->Ln(3);
	
	//Move to the right
	$this->Cell(50);
    $this->Cell(100,10,'Telefones: (85) 3260.4733 / 8770.0325',0,0,'L');
	//Line break
	$this->Ln(3);
	
	
	//Move to the right
	$this->Cell(50);
	$this->Cell(100,10,'Email: georgia@buenocredito.com.br / buenocredito@hotmail.com',0,0,'L');
    
	$this->Ln(10);


	$this->Cell(48,10,'CORRETOR:');
	$this->SetX(70);
	$this->Cell(58,10,'CPF:');
	$this->SetX(100);
	$this->Cell(68,10,'BANCO:');
	$this->SetX(130);
	$this->Cell(78,10,'AGENCIA:');
	$this->SetX(160);
	$this->Cell(88,10,'T CONTA:');   
	$this->SetX(190);
	$this->Cell(98,10,'N. CONTA:');
	$this->SetX(210);
	$this->Cell(98,10,'PERIODO:');

	$this->Ln(15);

	
	//assunto
	$this->SetSubject("Relatorio de Comissão");


	$titulo="Relatorio de Comissao";

	//escreve no pdf largura,altura,conteudo,borda,quebra de linha,alinhamento
	$this->Cell(0,5,$titulo,0,0,'L');
	$this->Cell(0,5,'www.buenocredito.com.br',0,1,'R');
	$this->Cell(0,0,'',1,1,'L');
	$this->Ln(2);

    //Cel(largura, altura,txt ,fronteira, ln, alinhar, preencher , link  )
	$this->Cell(0, 5, 'BANCO');
	$this->SetX(34);
	$this->Cell(30, 5, 'CADASTRO');
	$this->SetX(50);
	$this->Cell(40, 5, 'CLIENTE');
	$this->SetX(120);
	$this->Cell(30, 5, 'CPF');
	$this->SetX(140);
	$this->Cell(30, 5, 'APROVACAO');
	$this->SetX(160);
	$this->Cell(20, 5, 'PAGAMENTO');
	$this->SetX(180);
	$this->Cell(20, 5, 'VL. CONTRATO');
	$this->SetX(210);
	$this->Cell(10, 5, '%');
	$this->SetX(220);
	$this->Cell(20, 5, 'TIPO CONTRATO');
	$this->SetX(250);
	$this->Cell(10, 5, 'QTD. PARC.');
	$this->SetX(270);
	$this->Cell(10, 5, 'VALOR TOTAL');
	
	
	
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
	
// bd.php deve conter as funções para se conectar no banco de dados
//include("../../Connections/conn.php");
// busca os dados no banco de dados

//buscar contratos por corretor ou todos 
if((isset($_POST['id_corretor']) && $_POST['id_corretor'] !="") && 
   (isset($_POST['data_inicial']) && $_POST['data_inicial'] !="") &&
   (isset($_POST['data_final']) && $_POST['data_final'] !="")){


$corretor = $_POST['id_corretor'];

// 12/12/2011
//   0123456789
  include("../../Connections/conn.php"); 
mysql_select_db($database_conn, $conn);
$busca = mysql_query("SELECT c.*, cl.*, date_format(dataaprovacao, '%d/%m/%Y') AS dataaprovacao,date_format(datapago, '%d/%m/%Y') AS datapago, date_format(datacadastro, '%d/%m/%Y') AS datacadastro  ,b.nome as banco FROM contratos c

					  LEFT JOIN clientes cl
					  ON c.id_cliente = cl.id 		
					  
					  LEFT JOIN bancos b
					  ON c.id_banco= b.id 				


WHERE statusdacomissao = '".$statusdacomissao."'  AND c.datacadastro >='".$data_inicial."' AND c.datacadastro <= '".$data_final."' AND c.id_corretor =".$corretor."");// 

$busca_totais = mysql_query("SELECT  sum(valorcontrato) as valorcontrato, sum(totalgeral) as totalgeral  FROM contratos c WHERE comissao = 'P' AND c.datacadastro >= '".$data_inicial."' AND c.datacadastro <= '".$data_final."' AND c.id_corretor = ".$corretor."");

$busca_corretor = mysql_query("SELECT  * FROM corretores 
 								
								WHERE id = ".$corretor." ");
}else {
	
include("../../Connections/conn.php");
$busca = mysql_query("SELECT c.*, cl.*, date_format(dataaprovacao, '%d/%m/%Y') AS dataaprovacao,date_format(datapago, '%d/%m/%Y') AS datapago, date_format(datacadastro, '%d/%m/%Y') AS datacadastro, b.nome as banco FROM contratos c

					  LEFT JOIN clientes cl
					  ON c.id_cliente = cl.id 	
					  
					   LEFT JOIN bancos b
					  ON c.id_banco= b.id 				


WHERE comissao = 'P' ");

$busca_totais = mysql_query("SELECT  sum(valorcontrato) as valorcontrato, sum(totalgeral) as totalgeral  FROM contratos c WHERE comissao = 'P' ");

$busca_corretor = mysql_query("SELECT  * FROM corretores ");

	
	}




$pdf = new PDF('L','mm','A4');
$pdf->Open();
$pdf->AddPage();
$pdf->SetFont('helvetica', 'B',7);



while ($resultado = mysql_fetch_array($busca)) {
$pdf->ln();

$pdf->Cell(0, 5, $resultado['banco']);
$pdf->SetX(34);
$pdf->Cell(30, 5, $resultado['datacadastro']);
$pdf->SetX(50);
$pdf->Cell(40, 5, $resultado['nome']);
$pdf->SetX(120);
$pdf->Cell(30, 5, $resultado['cpf']);
$pdf->SetX(140);
$pdf->Cell(20, 5, $resultado['dataaprovacao']);
$pdf->SetX(160);
$pdf->Cell(20, 5, $resultado['datapago']);
$pdf->SetX(180);
$pdf->Cell(20, 5, $pdf->virgula($resultado['valorcontrato']),0,0,'R');
$pdf->SetX(210);
$pdf->Cell(10, 5, $resultado['comissao_corretor']);
$pdf->SetX(220);
$pdf->Cell(20, 5, $resultado['tipocontrato']);
$pdf->SetX(250);
$pdf->Cell(10, 5, $resultado['qtdmeses']);
$pdf->SetX(270);
$pdf->Cell(20, 5, $pdf->virgula($resultado['valorcontrato'] * ($resultado['comissao_corretor']/100)),0,0,'R');

$totalgeral += $resultado['valorcontrato'] * ($resultado['comissao_corretor']/100);

	
}
    $resultado_totais = mysql_fetch_array($busca_totais);


	$pdf->ln();
	
	
	
	$pdf->SetX(150);
	
	$pdf->Cell(10, 5, 'Vl. CONTRATO:' );
	
	$pdf->SetX(180);
	$pdf->Cell(20, 5, $pdf->virgula($resultado_totais['valorcontrato']),0,0,'R' );

	
	$pdf->SetX(250);	
	$pdf->Cell(10, 5, 'TOTAL GERAL:');
	
	$pdf->SetX(270);
	$pdf->Cell(20, 5, $pdf->virgula($totalgeral),0,0,'R');
	
	//$resultado_totais['totalgeral']),0,0,'R');

//corretor
   // if (isset($busca_corretor) && $busca_corretor != ""){
		$resultado_corretor = mysql_fetch_array($busca_corretor);
	//}

	
	$pdf->SetX(10);
	$pdf->SetY(36);
	$pdf->Cell(10, 5, $resultado_corretor['nome']);
	
	//$pdf->SetY(36);
	$pdf->SetX(70);
	$pdf->Cell(20, 5,$resultado_corretor['cpf'] );

	//$pdf->SetY(36);
	
	$pdf->SetX(100);
	$pdf->Cell(20, 5,$resultado_corretor['banco'] );
	
	//$pdf->SetY(36);
	
	$pdf->SetX(130);
	$pdf->Cell(20, 5,$resultado_corretor['agencia'] );

	//$pdf->SetY(36);
	
	$pdf->SetX(160);
	$pdf->Cell(20, 5,$resultado_corretor['tipoconta'] );


	$pdf->SetX(190);
	$pdf->Cell(20, 5,$resultado_corretor['nconta'] );
	
	$pdf->SetX(210);
	$pdf->Cell(20, 5, $pdf->databrasil($data_inicial).' a '. $pdf->databrasil($data_final) );

$pdf->SetX(210);
$pdf->Output();
?>